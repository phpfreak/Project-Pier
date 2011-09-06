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
        flash_error(lang('error delete user'));
        $this->redirectToUrl($user->getCompany()->getViewUrl());
      }

    } // delete
  
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
    
    /*
     * save note about project
     */
    function saveprojectnote(){
      if (isset($_POST['data']) && $_POST['data'] != ''){
        $action = logged_user()->setProjectNote(active_project(), $_POST['data']);
        $message = lang('saveprojectnote ok');
        if (!$action) $message = lang('error during saveprojectnote');
        die(make_json_for_ajax_return($action,$message));
      }
      die;
    } 

  } // UserController

?>