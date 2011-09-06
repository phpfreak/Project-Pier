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
      $permissions = ProjectUsers::getNameTextArray();
      
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
                  
                  $setter = 'set' . Inflector::camelize($permission);
                  $relation->$setter($permission_value);
                } // foreach
                
                $relation->save();
              } // if
            } // forech
          } // if
          
          DB::commit();
          
          // Send notification...
          try {
            if (array_var($user_data, 'send_email_notification')) {
              Notifier::newUserAccount($user, $password);
            } // if
          } catch(Exception $e) {
          
          } // try
          
          flash_success(lang('success add user', $user->getDisplayName()));
          $this->redirectToUrl($company->getViewUrl()); // Translate to profile page
          
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
  
  } // UserController

?>
