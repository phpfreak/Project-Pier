<?php

  /**
  * Tickets controller
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class TicketsController extends ApplicationController {
    
    /**
    * Prepare this controller
    *
    * @access public
    * @param void
    * @return ProjectController
    */
    function __construct() {
      parent::__construct();
      prepare_company_website_controller($this, 'project_website');
      $this->addHelper('textile');
    } // __construct
    
    function categories() {
      $page = (integer) array_var($_GET, 'page', 1);
      if($page < 0) $page = 1;
      
      $conditions = array('`project_id` = ?', active_project()->getId());
      
      list($categories, $pagination) = ProjectCategories::paginate(
        array(
          'conditions' => $conditions,
          'order' => '`name`'
        ),
        config_option('categories_per_page', 25), 
        $page
      ); // paginate
      
      tpl_assign('categories', $categories);
      tpl_assign('categories_pagination', $pagination);
      
      $this->setSidebar(get_template_path('tickets_sidebar', 'tickets'));
    } // categories

    /**
    * Return project tickets
    *
    * @access public
    * @param void
    * @return array
    */
    function index() {

      $page = (integer) array_var($_GET, 'page', 1);
      if ($page < 0) {
        $page = 1;
      }
      
      $this->canGoOn();

      $params = array();
      
      $params['sort_by'] = array_var($_GET, 'sort_by', Cookie::getValue('ticketsSortBy', 'id'));
      $expiration = Cookie::getValue('remember'.TOKEN_COOKIE_NAME) ? REMEMBER_LOGIN_LIFETIME : null;
      Cookie::setValue('ticketsSortBy', $params['sort_by'], $expiration);
      
      $conditions = DB::prepareString('`project_id` = ?', array(active_project()->getId()));
      if ($params['status'] = array_var($_GET, 'status')) {
        $conditions .= DB::prepareString(' AND `state` IN (?)', array(explode(',', $params['status'])));
      } // if
      if ($params['priority'] = array_var($_GET, 'priority')) {
        $conditions .= DB::prepareString(' AND `priority` IN (?)', array(explode(',', $params['priority'])));
      } // if
      if ($params['type'] = array_var($_GET, 'type')) {
        $conditions .= DB::prepareString(' AND `type` IN (?)', array(explode(',', $params['type'])));
      } // if
      if ($params['category_id'] = array_var($_GET, 'category_id')) {
        $conditions .= DB::prepareString(' AND `category_id` IN (?)', array(explode(',', $params['category_id'])));
      } // if
      if ($params['assigned_to_user_id'] = array_var($_GET, 'assigned_to_user_id')) {
        $conditions .= DB::prepareString(' AND `assigned_to_user_id` IN (?)', array(explode(',', $params['assigned_to_user_id'])));
      } // if
      if ($params['created_by_id'] = array_var($_GET, 'created_by_id')) {
        $conditions .= DB::prepareString(' AND `created_by_id` IN (?)', array(explode(',', $params['created_by_id'])));
      } // if
      $params['order'] = (array_var($_GET, 'order') != 'DESC' ? 'ASC' : 'DESC');
      
      $filtered = $params['status']!="" || $params['priority']!="" || $params['type']!="" || $params['category_id']!="" || $params['assigned_to_user_id']!="" || $params['created_by_id']!="";

      // Clean up empty and malformed parameters
      foreach ($params as $key => $value) {
        $value = preg_replace("/,+/", ",", $value); // removes multiple commas
        $value = preg_replace("/^,?(.*),?$/", "$1", $value); // removes commas at both ends
        $params[$key] = $value;
        if ($value=="") {
          unset($params[$key]); // deletes empty keys
        } // if
      } // foreach
      
      $order = '`'.$params['sort_by'].'` '.$params['order'].'';
      if (!logged_user()->isMemberOfOwnerCompany()) {
        $conditions .= DB::prepareString(' AND `is_private` = ?', array(0));
      } // if

      list($tickets, $pagination) = ProjectTickets::paginate(
        array(
          'conditions' => $conditions,
          'order' => $order
        ),
        config_option('tickets_per_page', 25), 
        $page
      ); // paginate
      
      tpl_assign('filtered', $filtered);
      tpl_assign('params', $params);
      tpl_assign('grouped_users', active_project()->getUsers(true));
      tpl_assign('categories', ProjectCategories::getProjectCategories(active_project()));
      tpl_assign('tickets', $tickets);
      tpl_assign('tickets_pagination', $pagination);
      
      $this->setSidebar(get_template_path('index_sidebar', 'tickets'));
    } // index
    
    /**
    * Add ticket
    *
    * @access public
    * @param void
    * @return null
    */
    function add_ticket() {
      $this->setTemplate('add_ticket');
      
      if(!ProjectTicket::canAdd(logged_user(), active_project())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('tickets'));
      } // if
      
      $ticket = new ProjectTicket();
      $ticket->setProjectId(active_project()->getId());
      $ticket_data = array_var($_POST, 'ticket');
      if (!is_array($ticket_data)) {
        $ticket_data = array (
          'is_private' => config_option('default_private', false),
        ); // array
      }
      
      tpl_assign('ticket', $ticket);
      tpl_assign('ticket_data', $ticket_data);
      
      if(is_array(array_var($_POST, 'ticket'))) {
        try {
          $uploaded_files = ProjectFiles::handleHelperUploads(active_project());
        } catch(Exception $e) {
          $uploaded_files = null;
        } // try
        
        try {
          $ticket->setFromAttributes($ticket_data);
        
          $assigned_to = explode(':', array_var($ticket_data, 'assigned_to', ''));
          $ticket->setAssignedToCompanyId(array_var($assigned_to, 0, 0));
          $ticket->setAssignedToUserId(array_var($assigned_to, 1, 0));
          
          // Options are reserved only for members of owner company
          if(!logged_user()->isMemberOfOwnerCompany()) {
            $ticket->setIsPrivate(false); 
          } // if
          
          DB::beginWork();
          $ticket->save();
          
          if(is_array($uploaded_files)) {
            foreach($uploaded_files as $uploaded_file) {
              $ticket->attachFile($uploaded_file);
              $uploaded_file->setIsPrivate($ticket->isPrivate());
              $uploaded_file->setIsVisible(true);
              $uploaded_file->setExpirationTime(EMPTY_DATETIME);
              $uploaded_file->save();
            } // if
          } // if
          
          ApplicationLogs::createLog($ticket, active_project(), ApplicationLogs::ACTION_ADD);
          DB::commit();
          
          // Try to send notifications but don't break submission in case of an error
          try {
            if ($ticket->getAssignedToUserId()) {
              $ticket_data['notify_user_' . $ticket->getAssignedToUserId()] = 'checked';
            }
            
            $notify_people = array();
            $project_companies = active_project()->getCompanies();
            foreach($project_companies as $project_company) {
              $company_users = $project_company->getUsersOnProject(active_project());
              if(is_array($company_users)) {
                foreach($company_users as $company_user) {
                  if((array_var($ticket_data, 'notify_company_' . $project_company->getId()) == 'checked') || (array_var($ticket_data, 'notify_user_' . $company_user->getId()))) {
                    $ticket->subscribeUser($company_user); // subscribe
                    $notify_people[] = $company_user;
                  } // if
                } // if
              } // if
            } // if
            
            Notifier::ticket($ticket, $notify_people, 'new_ticket', $ticket->getCreatedBy());
          } catch(Exception $e) {
          
          } // try
          
          flash_success(lang('success add ticket', $ticket->getSummary()));
          $this->redirectTo('tickets');
          
        // Error...
        } catch(Exception $e) {
          DB::rollback();
          
          if(is_array($uploaded_files)) {
            foreach($uploaded_files as $uploaded_file) {
              $uploaded_file->delete();
            } // foreach
          } // if
          
          $ticket->setNew(true);
          tpl_assign('error', $e);
        } // try
        
      } // if
    } // add
    
    /**
    * Edit specific ticket
    *
    * @access public
    * @param void
    * @return null
    */
    function edit_ticket() {
      $this->setTemplate('edit_ticket');
      
      $ticket = ProjectTickets::findById(get_id());
      if(!($ticket instanceof ProjectTicket)) {
        flash_error(lang('ticket dnx'));
        $this->redirectTo('tickets');
      } // if
      
      if(!$ticket->canView(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('tickets'));
      } // if
      
      $ticket_data = array_var($_POST, 'ticket');
      if(!is_array($ticket_data)) {
        $ticket_data = array(
          'is_private' => $ticket->isPrivate(),
          'summary' => $ticket->getSummary(),
          'priority' => $ticket->getPriority(),
          'state' => $ticket->getState(),
          'type' => $ticket->getType(),
          'category_id' => $ticket->getCategoryId(),
          'assigned_to' => $ticket->getAssignedToCompanyId() . ':' . $ticket->getAssignedToUserId(),
          'milestone_id' => $ticket->getMilestoneId(),
        ); // array
      } // if
      
      tpl_assign('ticket', $ticket);
      tpl_assign('ticket_data', $ticket_data);
      tpl_assign('subscribers', $ticket->getSubscribers());
      tpl_assign('changes', $ticket->getChanges());
      
      $this->setSidebar(get_template_path('edit_sidebar', 'tickets'));
      
      if(is_array(array_var($_POST, 'ticket'))) {
        if(!$ticket->canEdit(logged_user())) {
          flash_error(lang('no access permissions'));
          $this->redirectTo('tickets');
        } else {
          $old_fields = array(
            'summary' => $ticket->getSummary(),
            'priority' => $ticket->getPriority(),
            'status' => $ticket->getState(),
            'type' => $ticket->getType(),
            'category' => $ticket->getCategory(),
            'assigned to' => $ticket->getAssignedTo(),
            'milestone' => $ticket->getMilestone()
          );
          $old_private = $ticket->isPrivate();
          
          try {
            $ticket->setFromAttributes($ticket_data);
            $ticket->setUpdated('settings');
            
            // Options are reserved only for members of owner company
            if(!logged_user()->isMemberOfOwnerCompany()) {
              $ticket->setIsPrivate($old_private);
            } // if
            
            $old_assigned_user_id = $ticket->getAssignedToUserId();
            $assigned_to = explode(':', array_var($ticket_data, 'assigned_to', ''));
            $ticket->setAssignedToCompanyId(array_var($assigned_to, 0, 0));
            $ticket->setAssignedToUserId(array_var($assigned_to, 1, 0));
            
            DB::beginWork();
            $ticket->save();
            
            ApplicationLogs::createLog($ticket, $ticket->getProject(), ApplicationLogs::ACTION_EDIT);
            DB::commit();
            
            $user = $ticket->getAssignedToUser();
            if ($user instanceof User && $user->getId() != $old_assigned_user_id) {
              if(!$ticket->isSubscriber($user)) {
                $ticket->subscribeUser($user);
              } // if
            } // if
            
            $new_fields = array(
              'summary' => $ticket->getSummary(),
              'priority' => $ticket->getPriority(),
              'type' => $ticket->getType(),
              'status' => $ticket->getState(),
              'category' => $ticket->getCategory(),
              'assigned to' => $ticket->getAssignedTo(),
              'milestone' => $ticket->getMilestone()
            );
        
            foreach ($old_fields as $type => $old_field) {
              $new_field = $new_fields[$type];
              if ($old_field === $new_field) {
                continue;
              }
              $from_data = ($old_field instanceof ApplicationDataObject) ? $old_field->getObjectName() : $old_field;
              $to_data = ($new_field instanceof ApplicationDataObject) ? $new_field->getObjectName() : $new_field;
              
              $change = new ProjectTicketChange();
              $change->setTicketId($ticket->getId());
              $change->setType($type);
              $change->setFromData($from_data);
              $change->setToData($to_data);
              $change->save();
            } // foreach
            
            try {
              Notifier::ticket($ticket, $ticket->getSubscribers(), 'edit_ticket', $ticket->getUpdatedBy());
            } catch(Exception $e) {
              // nothing here, just suppress error...
            } // try
            
            flash_success(lang('success edit ticket', $ticket->getSummary()));
            $this->redirectToUrl($ticket->getViewUrl());
            
          } catch(Exception $e) {
            DB::rollback();
            tpl_assign('error', $e);
          } // try
        } // if
      } // if
    } // edit
    
    /**
    * Update ticket options. This is execute only function and if we don't have 
    * options in post it will redirect back to the ticket
    *
    * @param void
    * @return null
    */
    function update_options() {
      $ticket = ProjectTickets::findById(get_id());
      if(!($ticket instanceof ProjectTicket)) {
        flash_error(lang('ticket dnx'));
        $this->redirectTo('tickets');
      } // if
      
      if(!$ticket->canUpdateOptions(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('tickets'));
      } // if
      
      $ticket_data = array_var($_POST, 'ticket');
      if(is_array(array_var($_POST, 'ticket'))) {
        try {
          $old_private = $ticket->isPrivate();
          $ticket->setIsPrivate((boolean) array_var($ticket_data, 'is_private', $ticket->isPrivate()));
          
          DB::beginWork();
          $ticket->save();
          ApplicationLogs::createLog($ticket, $ticket->getProject(), ApplicationLogs::ACTION_EDIT);
          DB::commit();
          
          if ($old_private != $ticket->isPrivate()) {
            $change = new ProjectTicketChange();
            $change->setTicketId($ticket->getId());
            $change->setType('private');
            $change->setFromData($old_private ? 'yes' : 'no');
            $change->setToData($ticket->isPrivate() ? 'yes' : 'no');
            $change->save();
          }
          
          flash_success(lang('success edit ticket', $ticket->getSummary()));
        } catch(Exception $e) {
          flash_error(lang('error update ticket options'), $ticket->getSummary());
        } // try
      } // if
      $this->redirectToUrl($ticket->getViewUrl());
    } // update_options
    
    /**
    * Close specific ticket
    *
    * @access public
    * @param void
    * @return null
    */
    function close() {
      $ticket = ProjectTickets::findById(get_id());
      if(!($ticket instanceof ProjectTicket)) {
        flash_error(lang('ticket dnx'));
        $this->redirectTo('tickets');
      } // if
      
      if(!$ticket->canChangeStatus(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('tickets'));
      } // if
      
      $status = $ticket->isClosed() ? 'closed' : 'open';
      
      try {
        DB::beginWork();
        $ticket->closeTicket();
        ApplicationLogs::createLog($ticket, active_project(), ApplicationLogs::ACTION_CLOSE);
        DB::commit();
        
        if ($status != 'closed') {
          $change = new ProjectTicketChange();
          $change->setTicketId($ticket->getId());
          $change->setType('status');
          $change->setFromData($status);
          $change->setToData('closed');
          $change->save();
        }
        
        try {
          Notifier::ticket($ticket, $ticket->getSubscribers(), 'close_ticket', $ticket->getClosedBy());
        } catch(Exception $e) {
          // nothing here, just suppress error...
        } // try
        
        flash_success(lang('success close ticket'));
      } catch(Exception $e) {
        flash_error(lang('error close ticket'));
        DB::rollback();
      } // try
      
      $this->redirectToUrl(ProjectTickets::getIndexUrl(true));
    } // close
    
    /**
    * Open specific ticket
    *
    * @access public
    * @param void
    * @return null
    */
    function open() {
      $ticket = ProjectTickets::findById(get_id());
      if(!($ticket instanceof ProjectTicket)) {
        flash_error(lang('ticket dnx'));
        $this->redirectTo('tickets');
      } // if
      
      if(!$ticket->canChangeStatus(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('tickets'));
      } // if
      
      $status = $ticket->isClosed() ? 'closed' : 'open';
      
      try {
        DB::beginWork();
        $ticket->openTicket();
        ApplicationLogs::createLog($ticket, active_project(), ApplicationLogs::ACTION_OPEN);
        DB::commit();
        
        if ($status != 'open') {
          $change = new ProjectTicketChange();
          $change->setTicketId($ticket->getId());
          $change->setType('status');
          $change->setFromData($status);
          $change->setToData('open');
          $change->save();
        }
        
        try {
          Notifier::ticket($ticket, $ticket->getSubscribers(), 'open_ticket', logged_user());
        } catch(Exception $e) {
          // nothing here, just suppress error...
        } // try
        
        flash_success(lang('success open ticket'));
      } catch(Exception $e) {
        flash_error(lang('error open ticket'));
        DB::rollback();
      } // try
      
      $this->redirectToUrl(ProjectTickets::getIndexUrl());
    } // open
    
    /**
    * Delete specific ticket
    *
    * @access public
    * @param void
    * @return null
    */
    function delete_ticket() {
      $ticket = ProjectTickets::findById(get_id());
      if(!($ticket instanceof ProjectTicket)) {
        flash_error(lang('ticket dnx'));
        $this->redirectTo('tickets');
      } // if
      
      if(!$ticket->canDelete(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('tickets');
      } // if
      
      try {
        
        DB::beginWork();
        $ticket->delete();
        ApplicationLogs::createLog($ticket, $ticket->getProject(), ApplicationLogs::ACTION_DELETE);
        DB::commit();
        
        flash_success(lang('success deleted ticket', $ticket->getSummary()));
      } catch(Exception $e) {
        DB::rollback();
        flash_error(lang('error delete ticket'));
      } // try
      
      $this->redirectTo('tickets');
    } // delete
    
    /**
    * Add a new category
    *
    * @access public
    * @param void
    * @return null
    */
    function add_category() {
      $this->setTemplate('add_category');

      if(!ProjectCategory::canAdd(logged_user(), active_project())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('tickets', 'categories'));
      } // if
      
      $category = new ProjectCategory();
      $category_data = array_var($_POST, 'category');
      
      tpl_assign('category', $category);
      tpl_assign('category_data', $category_data);
      
      if(is_array(array_var($_POST, 'category'))) {
        try {
          $category->setFromAttributes($category_data);
          $category->setProjectId(active_project()->getId());
          
          DB::beginWork();
          $category->save();
          
          ApplicationLogs::createLog($category, active_project(), ApplicationLogs::ACTION_ADD);
          DB::commit();
          
          flash_success(lang('success add category', $category->getName()));
          $this->redirectTo('tickets', 'categories');
          
        // Error...
        } catch(Exception $e) {
          DB::rollback();
          
          $category->setNew(true);
          tpl_assign('error', $e);
        } // try
        
      } // if
    } // add_category

    /**
    * Add default categories to the project
    *
    * @access public
    * @param void
    * @return null
    */
    function add_default_categories() {
      if(!ProjectCategory::canAdd(logged_user(), active_project())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('tickets', 'categories'));
      } // if

      $default_categories_config = str_replace(array("\r\n", "\r"), array("\n", "\n"), config_option('tickets_default_categories', ''));
      if (trim($default_categories_config) == '') {
        $default_categories = array();
      } else {
        $default_categories = explode("\n", $default_categories_config);
      } // if

      if (count($default_categories)) {

        $category_names = '';
        $added_categories = array();
        $categories = ProjectCategories::getProjectCategories(active_project());
        foreach ($categories as $category) {
          $added_categories[] = $category->getName();
        }
        try {
          DB::beginWork();
          foreach ($default_categories as $default_category) {
            $category_name = trim($default_category);
            if ($category_name == '') {
              continue;
            } // if
            
            if (in_array($category_name, $added_categories)) {
              continue;
            } // if
              
            $category = new ProjectCategory();
            $category->setProjectId(active_project()->getId());
            $category->setName($category_name);
            $category->save();
            ApplicationLogs::createLog($category, active_project(), ApplicationLogs::ACTION_ADD);
              
            $category_names .= $category_name.', ';
            $added_categories[] = $category_name;
          } // foreach
          DB::commit();
        // Error...
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      } // if
          
      flash_success(lang('success add category', $category_names));
      $this->redirectTo('tickets', 'categories');
          
    } // add_default_categories
    
    /**
    * Edit specific category
    *
    * @access public
    * @param void
    * @return null
    */
    function edit_category() {
      $this->setTemplate('add_category');
      
      $category = ProjectCategories::findById(get_id());
      if(!($category instanceof ProjectCategory)) {
        flash_error(lang('category dnx'));
        $this->redirectTo('tickets', 'categories');
      } // if
      
      if(!$category->canView(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('tickets', 'categories'));
      } // if
      
      $category_data = array_var($_POST, 'category');
      if(!is_array($category_data)) {
        $category_data = array(
          'name' => $category->getName(),
          'description' => $category->getDescription()
        ); // array
      } // if
      
      tpl_assign('category', $category);
      tpl_assign('category_data', $category_data);
      
      if(is_array(array_var($_POST, 'category'))) {
        if(!$category->canEdit(logged_user())) {
          flash_error(lang('no access permissions'));
          $this->redirectTo('tickets', 'categories');
        } else {
          try {
            $category->setFromAttributes($category_data);
            
            DB::beginWork();
            $category->save();
            
            ApplicationLogs::createLog($category, $category->getProject(), ApplicationLogs::ACTION_EDIT);
            DB::commit();
            
            flash_success(lang('success edit category', $category->getName()));
            $this->redirectToUrl($category->getViewUrl());
            
          } catch(Exception $e) {
            DB::rollback();
            tpl_assign('error', $e);
          } // try
        } // if
      } // if
    } // edit_category
    
    /**
    * Delete specific category
    *
    * @access public
    * @param void
    * @return null
    */
    function delete_category() {
      $category = ProjectCategories::findById(get_id());
      if(!($category instanceof ProjectCategory)) {
        flash_error(lang('category dnx'));
        $this->redirectTo('tickets', 'categories');
      } // if
      
      if(!$category->canDelete(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('tickets', 'categories'));
      } // if
      
      try {
        
        DB::beginWork();
        $category->delete();
        ApplicationLogs::createLog($category, $category->getProject(), ApplicationLogs::ACTION_DELETE);
        DB::commit();
        
        flash_success(lang('success deleted category', $category->getName()));
      } catch(Exception $e) {
        DB::rollback();
        flash_error(lang('error delete category'));
      } // try
      
      $this->redirectTo('tickets', 'categories');
    } // delete
    
    // ---------------------------------------------------
    //  Subscriptions
    // ---------------------------------------------------
    
    /**
    * Subscribe to ticket
    *
    * @param void
    * @return null
    */
    function subscribe() {
      $ticket = ProjectTickets::findById(get_id());
      if(!($ticket instanceof ProjectTicket)) {
        flash_error(lang('ticket dnx'));
        $this->redirectTo('tickets');
      } // if
      
      if(!$ticket->canView(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('tickets');
      } // if
      
      if($ticket->subscribeUser(logged_user())) {
        flash_success(lang('success subscribe to ticket'));
      } else {
        flash_error(lang('error subscribe to ticket'));
      } // if
      $this->redirectToUrl($ticket->getViewUrl());
    } // subscribe
    
    /**
    * Unsubscribe from message
    *
    * @param void
    * @return null
    */
    function unsubscribe() {
      $ticket = ProjectTickets::findById(get_id());
      if(!($ticket instanceof ProjectTicket)) {
        flash_error(lang('ticket dnx'));
        $this->redirectTo('tickets');
      } // if
      
      if(!$ticket->canView(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('tickets');
      } // if
      
      if($ticket->unsubscribeUser(logged_user())) {
        flash_success(lang('success unsubscribe to ticket'));
      } else {
        flash_error(lang('error unsubscribe to ticket'));
      } // if
      $this->redirectToUrl($ticket->getViewUrl());
    } // unsubscribe

    function print_overview() {
      flash_success(lang('success printed', $category_names));
      $this->redirectTo('tickets', 'index');
    }

    /**
    * Display all tickets assigned to this user
    *
    * @layout dashboard
    * @param void
    * @return array
    */
    function my_tickets() {
      $this->setLayout('dashboard');
      $this->setTemplate('my_tickets');
      $this->addHelper('textile');

      $page = (integer) array_var($_GET, 'page', 1);
      $category = (integer) array_var($_GET, 'category', 0);
      $priority = array_var($_GET, 'priority', FALSE);
      $type = array_var($_GET, 'type', FALSE);
      if($page < 0) $page = 1;
      
      $closed = (boolean) array_var($_GET, 'closed', false);
      $conditions = DB::prepareString('`closed_on` '.($closed ? '>' : '=').' ?', array(EMPTY_DATETIME));
      if(!logged_user()->isMemberOfOwnerCompany()) {
        $conditions .= DB::prepareString(' AND `is_private` = ?', array(0) );
      } // if
      if ($category>0) $conditions .= DB::prepareString(' AND `category_id` = ?', array($category));
      if ($priority) $conditions .= DB::prepareString(' AND `priority` = ?', array($priority));
      if ($type) $conditions .= DB::prepareString(' AND `type` = ?', array($type));
    
      if ($closed) {
        $order = '`project_id`, `closed_on` DESC';
      } else {
        $order = '`project_id`, `created_on` DESC';
      } // if

      list($tickets, $pagination) = ProjectTickets::paginate(
        array(
          'conditions' => $conditions,
          'order' => $order
        ),
        config_option('tickets_per_page', 25), 
        $page
      ); // paginate
      
      tpl_assign('closed', $closed);
      tpl_assign('tickets', $tickets);
      tpl_assign('tickets_pagination', $pagination);
      tpl_assign('active_projects', logged_user()->getActiveProjects());
      
      $this->setSidebar(get_template_path('index_sidebar', 'tickets'));
//      tpl_assign('active_projects', logged_user()->getActiveProjects());

      //$this->setSidebar(get_template_path('index_sidebar', 'tickets'));
    } // my_tickets
  
    /**
    * Download tickets as attachment
    *
    * @access public
    * @param void
    * @return null
    */
    function download() {
      $this->canGoOn();
     
      $download_type = isset($_REQUEST['content_type']) ? $_REQUEST['content_type'] : 'text/csv';
      $download = ProjectTickets::getDownload(active_project(), $download_type);
      download_contents($download['content'], $download['type'], $download['name'], strlen($download['content']));
      die();
    }

  
  } // TicketsController

?>