<?php

  /**
  * User controller
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class UserController extends ApplicationController {
  
    /**
    * Construct the UserController
    *
    * @access public
    * @param void
    * @return UserController
    */
    function __construct() {
      parent::__construct();
      prepare_company_website_controller($this, 'administration');
    } // __construct
    
    /**
    * User management index
    *
    * @access public
    * @param void
    * @return null
    */
    function index() {
      
    } // index
    
    /**
    * Add user
    *
    * @access public
    * @param void
    * @return null
    */
    function add() {
      $this->setTemplate('add_user');
      
      $company = Companies::findById(get_id('company_id'));
      if (!($company instanceof Company)) {
        flash_error(lang('company dnx'));
        $this->redirectTo('administration');
      } // if
      
      if (!User::canAdd(logged_user(), $company)) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('dashboard'));
      } // if
      
      $user = new User();
      
      $user_data = array_var($_POST, 'user');
      if (!is_array($user_data)) {
        $user_data = array(
          'password_generator' => 'random',
          'company_id' => $company->getId(),
          'timezone' => $company->getTimezone(),
        ); // array
      } // if
      
      $projects = $company->getProjects();
      $permissions = PermissionManager::getPermissionsText();      

      tpl_assign('user', $user);
      tpl_assign('company', $company);
      tpl_assign('projects', $projects);
      tpl_assign('permissions', $permissions);
      tpl_assign('user_data', $user_data);
      
      if (is_array(array_var($_POST, 'user'))) {
        $user->setFromAttributes($user_data);
        $user->setCompanyId($company->getId());
        
        try {
          // Generate random password
          if (array_var($user_data, 'password_generator') == 'random') {
            $password = substr(sha1(uniqid(rand(), true)), rand(0, 25), 13);
            
          // Validate user input
          } else {
            $password = array_var($user_data, 'password');
            if (trim($password) == '') {
              throw new Error(lang('password value required'));
            } // if
            if ($password <> array_var($user_data, 'password_a')) {
              throw new Error(lang('passwords dont match'));
            } // if
          } // if
          $user->setPassword($password);

          if (config_option('check_email_unique', '1')=='1') {
            if (!$user->validateUniquenessOf('email')) {
              throw new Error(lang('email address is already used'));
            }
          }
          DB::beginWork();
          $user->save();
          ApplicationLogs::createLog($user, null, ApplicationLogs::ACTION_ADD);
          
          if (is_array($projects)) {
            foreach ($projects as $project) {
              if (array_var($user_data, 'project_permissions_' . $project->getId()) == 'checked') {
                $relation = new ProjectUser();
                $relation->setProjectId($project->getId());
                $relation->setUserId($user->getId());
                
                foreach ($permissions as $permission => $permission_text) {
                  $permission_value = array_var($user_data, 'project_permission_' . $project->getId() . '_' . $permission) == 'checked';
                  
                  $user->setProjectPermission($project,$permission,$permission_value);
                } // foreach
                
                $relation->save();
              } // if
            } // foreach
          } // if
          
          DB::commit();
          
          // Send notification...
          try {
            if (array_var($user_data, 'send_email_notification')) {
              Notifier::newUserAccount($user, $password);
            } // if
          } catch(Exception $e) {
          
          } // try

          // Add task to Welcome project...
          try {
            if (array_var($user_data, 'add welcome task')) {
              $task_data = array(
                'text' => lang('welcome task text', $user->getName(), get_url('account', 'edit') ),
                'due date' => DateTimeValueLib::now() + (7 * 24 * 60 * 60), 
                'assigned_to_company_id' => $user->getCompanyId(),
                'assigned_to_user_id' => $user->getId(),
              );
              $task_list = ProjectTaskLists::instance()->findById(2, true);
              DB::beginWork();
              $task = new ProjectTask();
              $task->setFromAttributes($task_data);
              $task_list->attachTask($task);
              $task->save();
              DB::commit();
            } // if
          } catch(Exception $e) {
            DB::rollback();         
          } // try
          
          flash_success(lang('success add user', $user->getDisplayName()));

          $projects = $company->getProjects();
          if (is_array($projects) || count($projects)) {
            $this->redirectToUrl( get_url('account', 'update_permissions', $user->getId() )); // Continue to permissions page
          } // if
          $this->redirectToUrl($company->getViewUrl());
          
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
        
      } // if
      
    } // add
    
    /**
    * Delete specific user
    *
    * @access public
    * @param void
    * @return null
    */
    function delete() {
      $this->setTemplate('del_user');

      $user = Users::findById(get_id());
      if (!($user instanceof User)) {
        flash_error(lang('user dnx'));
        $this->redirectTo('administration');
      } // if
      
      if (!$user->canDelete(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('dashboard'));
      } // if
      
      $delete_data = array_var($_POST, 'deleteUser');
      tpl_assign('user', $user);
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
          $user->delete();
          ApplicationLogs::createLog($user, null, ApplicationLogs::ACTION_DELETE);
          DB::commit();

          flash_success(lang('success delete user', $user->getDisplayName()));

        } catch(Exception $e) {
          DB::rollback();
          flash_error(lang('error delete user'));
        } // try

        $this->redirectToUrl($user->getCompany()->getViewUrl());
      } else {
        flash_error(lang('error delete client'));
        $this->redirectToUrl($user->getCompany()->getViewUrl());
      }

    } // delete
    
    /**
    * Show user card
    *
    * @access public
    * @param void
    * @return null
    */
    function card() {
      $this->setLayout('dashboard');
      
      $user = Users::findById(get_id());
      if (!($user instanceof User)) {
        flash_error(lang('user dnx'));
        $this->redirectToReferer(ROOT_URL);
      } // if
      
      if (!logged_user()->canSeeUser($user)) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(ROOT_URL);
      } // if
      
      tpl_assign('user', $user);
    } // card
  
    /**
    * Show user time
    *
    * @access public
    * @param void
    * @return null
    */
    function time() {
      if (!logged_user()->isAdministrator(owner_company())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard');
      } // if

      $this->setLayout('dashboard');
      tpl_assign('users', owner_company()->getUsers());
    } // time

  } // UserController

?>
