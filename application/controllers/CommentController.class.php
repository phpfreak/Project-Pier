<?php

  /**
  * Handle all comment related requests
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class CommentController extends ApplicationController {
  
    /**
    * Construct the CommentController
    *
    * @access public
    * @param void
    * @return FilesController
    */
    function __construct() {
      parent::__construct();
      prepare_company_website_controller($this, 'project_website');
    } // __construct
    
    /**
    * Add comment
    * 
    * Through this controller only logged users can post (no anonymous comments here)
    *
    * @param void
    * @return null
    */
    function add() {
      $this->setTemplate('add_comment');
      
      $object_id = get_id('object_id');
      $object_manager = array_var($_GET, 'object_manager');
      
      if (!is_valid_function_name($object_manager)) {
        flash_error(lang('invalid request'));
        $this->redirectToUrl(active_project()->getOverviewUrl());
      } // if
      
      $object = get_object_by_manager_and_id($object_id, $object_manager);
      if (!($object instanceof ProjectDataObject) || !($object->canComment(logged_user()))) {
        flash_error(lang('no access permissions'));
        $this->redirectToUrl(active_project()->getOverviewUrl());
      } // if
      
      $comment = new Comment();
      $comment_data = array_var($_POST, 'comment');
      if (!is_array($comment_data)) {
        $comment_data = array(
          'text' => '',
          'is_private' => config_option('default_private', false),
        ); // array
      } // if
      
      tpl_assign('comment_form_object', $object);
      tpl_assign('comment', $comment);
      tpl_assign('comment_data', $comment_data);
      
      if (is_array($comment_data)) {
        try {
          try {
            $attached_files = ProjectFiles::handleHelperUploads(active_project());
          } catch(Exception $e) {
            $attached_files = null;
          } // try
          
          $comment->setFromAttributes($comment_data);
          $comment->setRelObjectId($object_id);
          $comment->setRelObjectManager($object_manager);
          if (!logged_user()->isMemberOfOwnerCompany()) {
            $comment->setIsPrivate(false);
          } // if
        
          if($object instanceof ProjectMessage || $object instanceof ProjectFile) {
            if($object->getIsPrivate()) {
              $comment->setIsPrivate(true);
	    } // if
          } // if
	  
          DB::beginWork();
          $comment->save();
          
          if (is_array($attached_files)) {
            foreach ($attached_files as $attached_file) {
              $comment->attachFile($attached_file);
            } // foreach
          } // if
          
          ApplicationLogs::createLog($comment, active_project(), ApplicationLogs::ACTION_ADD);
          
          // Subscribe user to object (if $object is subscribible)
          if($object->isSubscribable()) {
            if (!$object->isSubscriber(logged_user())) {
              $object->subscribeUser(logged_user());
            } // if
          } // if
          
          DB::commit();

          // Try to send notification on comments other than Messages (messages already managed by subscription)          
          if (!($comment->getObject() instanceof ProjectMessage)) {
            // Try to send notifications but don't break submission in case of an error
            // define all the users to be notified - here all project users, from all companies.
            // Restrictions if comment is private is taken into account in newOtherComment()
            try {
              $notify_people = array();
              $project_companies = active_project()->getCompanies();
              foreach ($project_companies as $project_company) {
                $company_users = $project_company->getUsersOnProject(active_project());
                if (is_array($company_users)) {
                  foreach ($company_users as $company_user) {
                    if ((array_var($comment_data, 'notify_company_' . $project_company->getId()) == 'checked') || (array_var($comment_data, 'notify_user_' . $company_user->getId()))) {
                      $notify_people[] = $company_user;
                    } // if
                  } // if
                } // if
              } // if

              Notifier::newOtherComment($comment, $notify_people); // send notification email...
            } catch(Exception $e) {                  
              Logger::log("Error: Notification failed, " . $e->getMessage(), Logger::ERROR);
            } // try
          } // if
          
          flash_success(lang('success add comment'));
          
          $redirect_to = $comment->getViewUrl();
          if (!is_valid_url($redirect_to)) {
            $redirect_to = $object->getObjectUrl();
          } // if
          
          $this->redirectToUrl($redirect_to);
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      } // if
    } // add
    
    /**
    * Edit comment
    *
    * @param void
    * @return null
    */
    function edit() {
      $this->setTemplate('add_comment');
      
      $redirect_to = active_project() instanceof Project ? active_project()->getOverviewUrl() : get_url('dashboard');
      
      $comment = Comments::findById(get_id());
      if (!($comment instanceof Comment)) {
        flash_error(lang('comment dnx'));
        $this->redirectToUrl($redirect_to);
      } // if
      
      $object = $comment->getObject();
      if (!($object instanceof ProjectDataObject)) {
        flash_error(lang('object dnx'));
        $this->redirectToUrl($redirect_to);
      } // if
      
      if (trim($comment->getViewUrl())) {
        $redirect_to = $comment->getViewUrl();
      } elseif (trim($object->getObjectUrl())) {
        $redirect_to = $object->getObjectUrl();
      } // if
      
      if (!$comment->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToUrl($redirect_to);
      } // if
      
      $comment_data = array_var($_POST, 'comment');
      if (!is_array($comment_data)) {
        $comment_data = array(
          'text' => $comment->getText(),
          'is_private' => $comment->isPrivate(),
        ); // array
      } // if
      
      tpl_assign('comment_form_object', $object);
      tpl_assign('comment', $comment);
      tpl_assign('comment_data', $comment_data);
      
      if (is_array(array_var($_POST, 'comment'))) {
        try {
          $old_is_private = $comment->isPrivate();
          
          $comment->setFromAttributes($comment_data);
          $comment->setRelObjectId($object->getObjectId());
          $comment->setRelObjectManager(get_class($object->manager()));
          if (!logged_user()->isMemberOfOwnerCompany()) {
            $comment->setIsPrivate($old_is_private);
          }
        
          if($object instanceof ProjectMessage || $object instanceof ProjectFile) {
            if($object->getIsPrivate()) {
              $comment->setIsPrivate(true);
	    } // if
          } // if

          DB::beginWork();
          $comment->save();
          ApplicationLogs::createLog($comment, active_project(), ApplicationLogs::ACTION_EDIT);
          $object->onEditComment($comment);
          DB::commit();
          
          flash_success(lang('success edit comment'));
          $this->redirectToUrl($redirect_to);
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      } // if
    } // edit
    
    /**
    * Delete specific comment
    *
    * @param void
    * @return null
    */
    function delete() {
      $redirect_to = active_project() instanceof Project ? active_project()->getOverviewUrl() : get_url('dashboard');
      
      $comment = Comments::findById(get_id());
      if (!($comment instanceof Comment)) {
        flash_error(lang('comment dnx'));
        $this->redirectToUrl($redirect_to);
      } // if
      
      $object = $comment->getObject();
      if (!($object instanceof ProjectDataObject)) {
        flash_error(lang('object dnx'));
        $this->redirectToUrl($redirect_to);
      } // if
      
      if (trim($object->getObjectUrl())) {
        $redirect_to = $object->getObjectUrl();
      }
      
      if (!$comment->canDelete(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToUrl($redirect_to);
      } // if
      
      try {
        DB::beginWork();
        $comment->delete();
        ApplicationLogs::createLog($comment, active_project(), ApplicationLogs::ACTION_DELETE);
        $object->onDeleteComment($comment);
        DB::commit();
        
        flash_success(lang('success delete comment'));
      } catch(Exception $e) {
        DB::rollback();
        flash_error(lang('error delete comment'));
      } // try
      
      $this->redirectToUrl($redirect_to);
    } // delete
    
  } // CommentController

?>