<?php

  /**
  * Access login, used for handling login / logout requests
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class AccessController extends ApplicationController {
  
    /**
    * Construct controller
    *
    * @param void
    * @return null
    */
    function __construct() {
      parent::__construct();
      
      $this->setLayout('dialog');
      $this->addHelper('form');
      $this->addHelper('breadcrumbs');
      $this->addHelper('pageactions');
      $this->addHelper('tabbednavigation');
      $this->addHelper('company_website');
      $this->addHelper('project_website');
    } // __construct



    /**
    * Support login with url parameters (single sign on)
    *
    * @param void
    * @return null
    */
    function sso() {
      trace(__FILE__,'sso() - begin');
      $this->setTemplate('login', 'access');
      //$GLOBALS['$_POST']=array();
      $_POST['login']['username']=@$_GET['username'];
      $_POST['login']['password']=@$_GET['password'];
      $_POST['login']['remember']=@$_GET['remember'];
      $this->login();
      trace(__FILE__,'sso() - end');
    }
    
    /**
    * Show and process login form
    *
    * @param void
    * @return null
    */
    function login() {
      trace(__FILE__,'login()');

      if (function_exists('logged_user') && (logged_user() instanceof User)) {
        trace(__FILE__, 'login() - redirectTo(dashboard) because already logged in' );
        $this->redirectTo('dashboard');
      } // if
      
      $login_data = array_var($_POST, 'login');
      if (!is_array($login_data)) {
        $login_data = array();
        foreach ($_GET as $k => $v) {
          if (str_starts_with($k, 'ref_')) {
            $login_data[htmlentities($k)] = $v;
          }
        } // foreach
      } // if
      
      tpl_assign('login_data', $login_data);
      
      if (is_array(array_var($_POST, 'login'))) {
        $username = array_var($login_data, 'username');
        $password = array_var($login_data, 'password');
        $remember = array_var($login_data, 'remember') == 'checked';
        
        if (trim($username == '')) {
          tpl_assign('error', new Error(lang('username value missing')));
          $this->render();
        } // if
        
        if (trim($password) == '') {
          tpl_assign('error', new Error(lang('password value missing')));
          $this->render();
        } // if
        
        $user = Users::getByUsername($username, owner_company());
        if (!($user instanceof User)) {
          tpl_assign('error', new Error(lang('invalid login data')));
          $this->render();
        } // if
        
        if (!$user->isValidPassword($password)) {
          tpl_assign('error', new Error(lang('invalid login data')));
          $this->render();
        } // if
        
        try {
          trace(__FILE__,"login() - logUserIn($username, $remember)");
          CompanyWebsite::instance()->logUserIn($user, $remember);
          if (isset($_POST['loginLanguage'])) $_SESSION['language'] = $_POST['loginLanguage'];
        } catch(Exception $e) {
          trace(__FILE__,"login() - exception " . $e->getTraceAsString() );
          tpl_assign('error', new Error(lang('invalid login data')));
          $this->render();
        } // try

        $ref_controller = null;
        $ref_action = null;
        $ref_params = array();
        
        foreach ($login_data as $k => $v) {
          if (str_starts_with($k, 'ref_')) {
            $ref_var_name = trim(substr($k, 4, strlen($k)));
            switch ($ref_var_name) {
              case 'c':
                $ref_controller = $v;
                break;
              case 'a':
                $ref_action = $v;
                break;
              default:
                $ref_params[$ref_var_name] = $v;
            } // switch
          } // if
        } // if
        if (!count($ref_params)) {
          $ref_params = null;
        }
        if ($ref_controller && $ref_action) {
          trace(__FILE__, "login() - redirectTo($ref_controller, $ref_action, $ref_params)" );
          $this->redirectTo($ref_controller, $ref_action, $ref_params);
        } else {
          trace(__FILE__, 'login() - redirectTo(dashboard)' );
          $this->redirectTo('dashboard');
        } // if
      } // if
    } // login
    
    /**
    * Log user out
    *
    * @access public
    * @param void
    * @return null
    */
    function logout() {
      CompanyWebsite::instance()->logUserOut();
      if(($lrp = config_option('logout_redirect_page')) != false && $lrp != 'default') {
        $this->redirectToUrl($lrp);
      } else {
        $this->redirectTo('access', 'login');	
      } 
    } // logout
    
    /**
    * Render and process forgot password form
    *
    * @param void
    * @return null
    */
    function forgot_password() {
      $your_email = trim(array_var($_POST, 'your_email'));
      tpl_assign('your_email', $your_email);
      
      if (array_var($_POST, 'submitted') == 'submitted') {
        if (!is_valid_email($your_email)) {
          tpl_assign('error', new InvalidEmailAddressError($your_email, lang('invalid email address')));
          $this->render();
        } // if
        
        $user = Users::getByEmail($your_email);
        if (!($user instanceof User)) {
          flash_error(lang('email address not in use', $your_email));
          $this->redirectTo('access', 'forgot_password');
        } // if
        
        try {
          Notifier::forgotPassword($user);
          flash_success(lang('success forgot password'));
        } catch(Exception $e) {
          flash_error(lang('error forgot password'));
        } // try
        
        $this->redirectTo('access', 'forgot_password');
      } // if
    } // forgot_password
    
    /**
    * Clear cookies
    *
    * @access public
    * @param void
    * @return null
    */
    function clear_cookies() {
      CompanyWebsite::instance()->logUserOut();
      $this->redirectTo('access', 'login');	
    } // logout
    
    /**
    * Finish the installation - create owner company and administrator
    *
    * @param void
    * @return null
    */
    function complete_installation() {
      if (Companies::getOwnerCompany() instanceof Company) {
        die('Owner company already exists'); // Somebody is trying to access this method even if the user already exists
      } // if
      $this->setLayout('complete_install');
      $form_data = array_var($_POST, 'form');
      tpl_assign('form_data', $form_data);
      
      if (array_var($form_data, 'submitted') == 'submitted') {
        try {
          $admin_password = trim(array_var($form_data, 'admin_password'));
          $admin_password_a = trim(array_var($form_data, 'admin_password_a'));
          
          if (trim($admin_password) == '') {
            throw new Error(lang('password value required'));
          } // if
          
          if ($admin_password <> $admin_password_a) {
            throw new Error(lang('passwords dont match'));
          } // if
          
          DB::beginWork();
          
          Users::delete(); // clear users table
          Companies::delete(); // clear companies table
          
          // Create the administrator user
          $administrator = new User();
          $administrator->setId(1);
          $administrator->setUsername(array_var($form_data, 'admin_username'));
          $administrator->setEmail(array_var($form_data, 'admin_email'));
          $administrator->setPassword($admin_password);
          $administrator->setIsAdmin(true);
          $administrator->setAutoAssign(true);
          
          $administrator->save();
          
          // Create the contact for administrator
          $administrator_contact = new Contact();
          $administrator_contact->setId(1);
          $administrator_contact->setCompanyId(1);
          $administrator_contact->setEmail(array_var($form_data, 'admin_email'));
          $administrator_contact->setUserId($administrator->getId());
          $administrator_contact->setDisplayName($administrator->getUsername());
          $administrator_contact->save();
          
          // Create a company
          $company = new Company();
          $company->setId(1);
          $company->setClientOfId(0);
          $company->setName(array_var($form_data, 'company_name'));
          $company->setCreatedById(1);
          
          $company->save();
          
          DB::commit();
          
          $this->redirectTo('access', 'login');
        } catch(Exception $e) {
          tpl_assign('error', $e);
          DB::rollback();
        } // try
      } // if
    } // complete_installation
  
  } // AccessController

?>