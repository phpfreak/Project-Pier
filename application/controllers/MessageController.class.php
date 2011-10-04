<?php

  /**
  * Message controller
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class MessageController extends ApplicationController {
  
    /**
    * Construct the MessageController
    *
    * @access public
    * @param void
    * @return MessageController
    */
    function __construct() {
      parent::__construct();
      prepare_company_website_controller($this, 'project_website');
    } // __construct
    
    /**
    * Return project messages
    *
    * @access public
    * @param void
    * @return array
    */
    function index() {
      $this->addHelper('textile');
      
      $page = (integer) array_var($_GET, 'page', 1);
      if ($page < 0) {
        $page = 1;
      }
      
      $this->canGoOn();
      // Gets desired view 'detail' or 'list'
      // $view_type is from URL, Cookie or set to default: 'list'
      $view_type = array_var($_GET, 'view', Cookie::getValue('messagesViewType', 'list'));
      $expiration = Cookie::getValue('remember'.TOKEN_COOKIE_NAME) ? REMEMBER_LOGIN_LIFETIME : null;
      Cookie::setValue('messagesViewType', $view_type, $expiration);
      $period_type = array_var($_GET, 'period', Cookie::getValue('messagesPeriodType', 'fresh'));
      $expiration = Cookie::getValue('remember'.TOKEN_COOKIE_NAME) ? REMEMBER_LOGIN_LIFETIME : null;
      Cookie::setValue('messagesPeriodType', $period_type, $expiration);

      $archive_condition = ' AND `updated_on` >= (now() - interval 7 day)';
      if ($period_type == 'archive') {
        $archive_condition = ' AND `updated_on` < (now() - interval 7 day)';
      }

      $conditions = logged_user()->isMemberOfOwnerCompany() ? 
        array('`project_id` = ?' . $archive_condition , active_project()->getId()) :
        array('`project_id` = ? AND `is_private` = ?' . $archive_condition, active_project()->getId(), 0);

      list($messages, $pagination) = ProjectMessages::paginate(
        array(
          'conditions' => $conditions,
          'order' => '`created_on` DESC'
        ),
        config_option('messages_per_page', 10), 
        $page
      ); // paginate
      
      tpl_assign('view_type', $view_type);
      tpl_assign('period_type', $period_type);
      tpl_assign('messages', $messages);
      tpl_assign('messages_pagination', $pagination);
      tpl_assign('important_messages', active_project()->getImportantMessages());
      
      $this->setSidebar(get_template_path('index_sidebar', 'message'));
    } // index
    
    /**
    * View single message
    *
    * @access public
    * @param void
    * @return null
    */
    function view() {
      $this->addHelper('textile');
      
      $message = ProjectMessages::findById(get_id());
      if (!($message instanceof ProjectMessage)) {
        flash_error(lang('message dnx'));
        $this->redirectTo('message');
      } // if
      
      if (!$message->canView(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('message'));
      } // if
      
      tpl_assign('message', $message);
      tpl_assign('subscribers', $message->getSubscribers());
      
      $this->setSidebar(get_template_path('view_sidebar', 'message'));
    } // view
    
    /**
    * Add message
    *
    * @access public
    * @param void
    * @return null
    */
    function add() {
      $this->addHelper('textile');
      $this->setTemplate('add_message');
      $this->setSidebar(get_template_path('textile_help_sidebar'));
      
      if (!ProjectMessage::canAdd(logged_user(), active_project())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('message'));
      } // if
      
      $message = new ProjectMessage();
      $message->setProjectId(active_project()->getId());

      tpl_assign('message', $message);
      
      $message_data = array_var($_POST, 'message');
      if (!is_array($message_data)) {
        $message_data = array(
          'milestone_id' => array_var($_GET, 'milestone_id'),
          'is_private' => config_option('default_private', false),
        ); // array
      } // if
      tpl_assign('message_data', $message_data);
      
      if (is_array(array_var($_POST, 'message'))) {
        try {
          $uploaded_files = ProjectFiles::handleHelperUploads(active_project());
        } catch(Exception $e) {
          $uploaded_files = null;
        } // try
        
        try {
          $message->setFromAttributes($message_data);
          
          // Options are reserved only for members of owner company
          if (!logged_user()->isMemberOfOwnerCompany()) {
            $message->setIsPrivate(false); 
            $message->setIsImportant(false);
            $message->setCommentsEnabled(true);
            $message->setAnonymousCommentsEnabled(false);
          } // if
          
          DB::beginWork();
          $message->save();
          $message->subscribeUser(logged_user());
          if (plugin_active('tags')) {
            $message->setTagsFromCSV(array_var($message_data, 'tags'));
          }
          
          if (is_array($uploaded_files)) {
            foreach ($uploaded_files as $uploaded_file) {
              $message->attachFile($uploaded_file);
              $uploaded_file->setIsPrivate($message->isPrivate());
              $uploaded_file->setIsVisible(true);
              $uploaded_file->setExpirationTime(EMPTY_DATETIME);
              $uploaded_file->save();
            } // if
          } // if
          
          ApplicationLogs::createLog($message, active_project(), ApplicationLogs::ACTION_ADD);
          DB::commit();
          
          // Try to send notifications but don't break submission in case of an error
          try {
            $notify_people = array();
            $project_companies = active_project()->getCompanies();
            foreach ($project_companies as $project_company) {
              $company_users = $project_company->getUsersOnProject(active_project());
              if (is_array($company_users)) {
                foreach ($company_users as $company_user) {
                  if ((array_var($message_data, 'notify_company_' . $project_company->getId()) == 'checked') || (array_var($message_data, 'notify_user_' . $company_user->getId()))) {
                    $message->subscribeUser($company_user); // subscribe
                    $notify_people[] = $company_user;
                  } // if
                } // if
              } // if
            } // if
            
            Notifier::newMessage($message, $notify_people); // send notification email...
          } catch(Exception $e) {
          
          } // try
          
          flash_success(lang('success add message', $message->getTitle()));
          $this->redirectTo('message');
          
        // Error...
        } catch(Exception $e) {
          DB::rollback();
          
          if (is_array($uploaded_files)) {
            foreach ($uploaded_files as $uploaded_file) {
              $uploaded_file->delete();
            } // foreach
          } // if
          
          $message->setNew(true);
          tpl_assign('error', $e);
        } // try
        
      } // if
    } // add
    
    /**
    * Edit specific message
    *
    * @access public
    * @param void
    * @return null
    */
    function edit() {
      $this->addHelper('textile');
      $this->setTemplate('add_message');
      
      $message = ProjectMessages::findById(get_id());
      if (!($message instanceof ProjectMessage)) {
        flash_error(lang('message dnx'));
        $this->redirectTo('message');
      } // if
      
      if (!$message->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('message');
      } // if
      
      $message_data = array_var($_POST, 'message');

      $this->setSidebar(get_template_path('textile_help_sidebar'));
      if (!is_array($message_data)) {
        $tag_names = plugin_active('tags') ? $message->getTagNames() : '';
        $message_data = array(
          'milestone_id' => $message->getMilestoneId(),
          'title' => $message->getTitle(),
          'text' => $message->getText(),
          'additional_text' => $message->getAdditionalText(),
          'tags' => is_array($tag_names) ? implode(', ', $tag_names) : '',
          'is_private' => $message->isPrivate(),
          'is_important' => $message->getIsImportant(),
          'comments_enabled' => $message->getCommentsEnabled(),
          'anonymous_comments_enabled' => $message->getAnonymousCommentsEnabled(),
        ); // array
      } // if
      
      $this->setSidebar(get_template_path('textile_help_sidebar'));
      tpl_assign('message', $message);
      tpl_assign('message_data', $message_data);
      
      if (is_array(array_var($_POST, 'message'))) {
        try {
          $old_is_private = $message->isPrivate();
          $old_is_important = $message->getIsImportant();
          $old_comments_enabled = $message->getCommentsEnabled();
          $old_anonymous_comments_enabled = $message->getAnonymousCommentsEnabled();
          
          $message->setFromAttributes($message_data);
          
          // Options are reserved only for members of owner company
          if (!logged_user()->isMemberOfOwnerCompany()) {
            $message->setIsPrivate($old_is_private);
            $message->setIsImportant($old_is_important);
            $message->setCommentsEnabled($old_comments_enabled);
            $message->setAnonymousCommentsEnabled($old_anonymous_comments_enabled);
          } // if
          
          DB::beginWork();
          $message->save();
          if (plugin_active('tags')) {
            $message->setTagsFromCSV(array_var($message_data, 'tags'));
          }
          
          ApplicationLogs::createLog($message, $message->getProject(), ApplicationLogs::ACTION_EDIT);
          DB::commit();
          
          flash_success(lang('success edit message', $message->getTitle()));
          $this->redirectToUrl($message->getViewUrl());
          
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      } // if
    } // edit
    
    /**
    * Update message options. This is execute only function and if we don't have 
    * options in post it will redirect back to the message
    *
    * @param void
    * @return null
    */
    function update_options() {
      $message = ProjectMessages::findById(get_id());
      if (!($message instanceof ProjectMessage)) {
        flash_error(lang('message dnx'));
        $this->redirectTo('message');
      } // if
      
      if (!$message->canUpdateOptions(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('message');
      } // if
      
      $message_data = array_var($_POST, 'message');
      if (is_array(array_var($_POST, 'message'))) {
        try {
          $message->setIsPrivate((boolean) array_var($message_data, 'is_private', $message->isPrivate()));
          $message->setIsImportant((boolean) array_var($message_data, 'is_important', $message->getIsImportant()));
          $message->setCommentsEnabled((boolean) array_var($message_data, 'comments_enabled', $message->getCommentsEnabled()));
          $message->setAnonymousCommentsEnabled((boolean) array_var($message_data, 'anonymous_comments_enabled', $message->getAnonymousCommentsEnabled()));
          
          DB::beginWork();
          $message->save();
          ApplicationLogs::createLog($message, $message->getProject(), ApplicationLogs::ACTION_EDIT);
          DB::commit();
          
          flash_success(lang('success edit message', $message->getTitle()));
        } catch(Exception $e) {
          flash_error(lang('error update message options'), $message->getTitle());
        } // try
      } // if
      $this->redirectToUrl($message->getViewUrl());
    } // update_options

    /**
    * Move message
    *
    * @access public
    * @param void
    * @return null
    */
    function move() {
      $this->setTemplate('move_message');
      
      $message = ProjectMessages::findById(get_id());
      if (!($message instanceof ProjectMessage)) {
        flash_error(lang('message dnx'));
        $this->redirectTo('message', 'index');
      } // if
      
      if (!$message->canDelete(logged_user(), active_project())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('message', 'index');
      } // if

      if (($message->getMilestoneId()>0)) {
        flash_error(lang('unlink from milestone first'));
        $this->redirectTo('message', 'index');
      } // if
      
      $move_data = array_var($_POST, 'move_data');
      tpl_assign('message', $message);
      tpl_assign('move_data', $move_data);

      if (is_array($move_data)) {
        $target_project_id = $move_data['target_project_id'];
        $target_project = Projects::findById($target_project_id);
        if (!($target_project instanceof Project)) {
          flash_error(lang('project dnx'));
          $this->redirectToUrl($message->getMoveUrl());
        } // if
        if (!$message->canAdd(logged_user(), $target_project)) {
          flash_error(lang('no access permissions'));
          $this->redirectToUrl($message->getMoveUrl());
        } // if
        try {
          DB::beginWork();
          $message->setProjectId($target_project_id);
          $message->save();
          ApplicationLogs::createLog($message, active_project(), ApplicationLogs::ACTION_DELETE);
          ApplicationLogs::createLog($message, $target_project, ApplicationLogs::ACTION_ADD);
          DB::commit();

          flash_success(lang('success move message', $message->getTitle(), active_project()->getName(), $target_project->getName() ));
        } catch(Exception $e) {
          DB::rollback();
          flash_error(lang('error move message', $e->getMessage()));
        } // try

        $this->redirectToUrl($message->getViewUrl());
      }
    } // move_message
    
    /**
    * Delete specific message
    *
    * @access public
    * @param void
    * @return null
    */
    function delete() {
      $this->setTemplate('del_message');

      $message = ProjectMessages::findById(get_id());
      if (!($message instanceof ProjectMessage)) {
        flash_error(lang('message dnx'));
        $this->redirectTo('message');
      } // if
      
      if (!$message->canDelete(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('message');
      } // if
      
      $delete_data = array_var($_POST, 'deleteMessage');
      tpl_assign('message', $message);
      tpl_assign('delete_data', $delete_data);

      if (!is_array($delete_data)) {
        $delete_data = array(
          'really' => 0,
          'password' => '',
          ); // array
        tpl_assign('delete_data', $delete_data);
      } else if ($delete_data['really'] == 1) {
        $password = $delete_data['password'];
        if (trim($password) == '') {
          tpl_assign('error', new Error(lang('password value missing')));
          return $this->render();
        }
        if (!logged_user()->isValidPassword($password)) {
          tpl_assign('error', new Error(lang('invalid login data')));
          return $this->render();
        }
        try {

          DB::beginWork();
          $message->delete();
          ApplicationLogs::createLog($message, $message->getProject(), ApplicationLogs::ACTION_DELETE);
          DB::commit();

          flash_success(lang('success deleted message', $message->getTitle()));
        } catch(Exception $e) {
          DB::rollback();
          flash_error(lang('error delete message'));
        } // try

        $this->redirectTo('message');
      } else {
        flash_error(lang('error delete message'));
        $this->redirectTo('message');
      }

    } // delete
    
    // ---------------------------------------------------
    //  Subscriptions
    // ---------------------------------------------------
    
    /**
    * Subscribe to message
    *
    * @param void
    * @return null
    */
    function subscribe() {
      $message = ProjectMessages::findById(get_id());
      if (!($message instanceof ProjectMessage)) {
        flash_error(lang('message dnx'));
        $this->redirectTo('message');
      } // if
      
      if (!$message->canView(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('message');
      } // if
      
      if ($message->subscribeUser(logged_user())) {
        flash_success(lang('success subscribe to message'));
      } else {
        flash_error(lang('error subscribe to message'));
      } // if
      $this->redirectToUrl($message->getViewUrl());
    } // subscribe
    
    /**
    * Unsubscribe from message
    *
    * @param void
    * @return null
    */
    function unsubscribe() {
      $message = ProjectMessages::findById(get_id());
      if (!($message instanceof ProjectMessage)) {
        flash_error(lang('message dnx'));
        $this->redirectTo('message');
      } // if
      
      if (!$message->canView(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('message');
      } // if
      
      if ($message->unsubscribeUser(logged_user())) {
        flash_success(lang('success unsubscribe to message'));
      } else {
        flash_error(lang('error unsubscribe to message'));
      } // if
      $this->redirectToUrl($message->getViewUrl());
    } // unsubscribe
    
    // ---------------------------------------------------
    //  Comments
    // ---------------------------------------------------
    
    /**
    * Add comment
    *
    * @access public
    * @param void
    * @return null
    */
    function add_comment() {
      $message = ProjectMessages::findById(get_id());
      if (!($message instanceof ProjectMessage)) {
        flash_error(lang('message dnx'));
        $this->redirectTo('message');
      } // if
      
      if (!$message->canAddComment(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToUrl($message->getViewUrl());
      } // if
      
      $comment = new MessageComment();
      $comment_data = array_var($_POST, 'comment');
      tpl_assign('message', $message);
      tpl_assign('comment', $comment);
      tpl_assign('comment_data', $comment_data);
      
      if (is_array($comment_data)) {
        $comment->setFromAttributes($comment_data);
        $comment->setMessageId($message->getId());
        if (!logged_user()->isMemberOfOwnerCompany()) {
          $comment->setIsPrivate(false);
        }
        
        try {
          
          DB::beginWork();
          $comment->save();
          ApplicationLogs::createLog($comment, active_project(), ApplicationLogs::ACTION_ADD);
          DB::commit();
          
          // Try to send notification but don't break
          try {
            Notifier::newMessageComment($comment);
          } catch(Exception $e) {
          
          } // try
          
          flash_success(lang('success add comment'));
          $this->redirectToUrl($message->getViewUrl());
          
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
        
      } // if
      
    } // add_comment
    
    /**
    * Edit specific comment
    *
    * @access public
    * @param void
    * @return null
    */
    function edit_comment() {
      $this->setTemplate('add_comment');
      
      $comment = MessageComments::findById(get_id());
      if (!($comment instanceof MessageComment)) {
        flash_error(lang('comment dnx'));
        $this->redirectTo('message');
      } // if
      
      $message = $comment->getMessage();
      if (!($message instanceof ProjectMessage)) {
        flash_error(lang('message dnx'));
        $this->redirectTo('message');
      } // if
      
      if (!$comment->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToUrl($message->getViewUrl());
      } // if
      
      $comment_data = array_var($_POST, 'comment');
      if (!is_array($comment_data)) {
        $comment_data = array(
          'text' => $comment->getText(),
          'is_private' => $comment->isPrivate(),
        ); // array
      } // if
      tpl_assign('message', $message);
      tpl_assign('comment', $comment);
      tpl_assign('comment_data', $comment_data);
      
      if (is_array(array_var($_POST, 'comment'))) {
        $old_is_private = $comment->isPrivate();
        $comment->setFromAttributes($comment_data);
        $comment->setMessageId($message->getId());
        if (!logged_user()->isMemberOfOwnerCompany()) {
          $comment->setIsPrivate($old_is_private);
        }
        
        try {
          
          DB::beginWork();
          $comment->save();
          ApplicationLogs::createLog($comment, active_project(), ApplicationLogs::ACTION_EDIT);
          DB::commit();
          
          flash_success(lang('success edit comment'));
          $this->redirectToUrl($message->getViewUrl());
          
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      } // if
      
    } // edit_comment
    
    /**
    * Delete comment
    *
    * @access public
    * @param void
    * @return null
    */
    function delete_comment() {
      $comment = MessageComments::findById(get_id());
      if (!($comment instanceof MessageComment)) {
        flash_error(lang('comment dnx'));
        $this->redirectTo('message');
      } // if
      
      $message = $comment->getMessage();
      if (!($message instanceof ProjectMessage)) {
        flash_error(lang('message dnx'));
        $this->redirectTo('message');
      } // if
      
      if (!$comment->canDelete(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToUrl($message->getViewUrl());
      } // if
      
      try {
        
        DB::beginWork();
        $comment->delete();
        ApplicationLogs::createLog($comment, active_project(), ApplicationLogs::ACTION_DELETE);
        DB::commit();
        
        flash_success(lang('success delete comment'));
        
      } catch(Exception $e) {
        DB::rollback();
        flash_error(lang('error delete comment'));
      } // try
      
      $this->redirectToUrl($message->getViewUrl());
    } // delete_comment
  
  } // MessageController

?>