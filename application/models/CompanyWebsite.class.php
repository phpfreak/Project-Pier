<?php

  /**
  * Company website class
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  final class CompanyWebsite {
    
    /** Name of the cookie / session var where we save session_id **/
    const USER_SESSION_ID_VAR = 'user_session_id';
    
    /**
    * Owner company
    *
    * @var Company
    */
    private $company;
    
    /**
    * Logged user
    *
    * @var User
    */
    private $logged_user;
    
    /**
    * Selected project
    *
    * @var Project
    */
    private $selected_project;
    
    /**
    * Init company website environment
    *
    * @access public
    * @param void
    * @return null
    * @throws Error
    */
    function init() {
      trace(__FILE__, 'init()');
      if (isset($this) && ($this instanceof CompanyWebsite)) {
        $this->initCompany();
        $this->initActiveProject();
        $controller = array_var($_GET, 'c');
        //Feed users do not need to be logged in here
        if ($controller != 'feed') {
          $this->initLoggedUser();
        }
      } else {
        CompanyWebsite::instance()->init();
      } // if
    } // init
    
    /**
    * Init company based on subdomain
    *
    * @access public
    * @param string
    * @return null
    * @throws Error
    */
    private function initCompany() {
      trace(__FILE__, 'initCompany()');
      $company = Companies::getOwnerCompany();
      trace(__FILE__, 'initCompany() - company check');
      if (!($company instanceof Company)) {
        throw new OwnerCompanyDnxError();
      } // if
      trace(__FILE__, 'initCompany() - admin check');
      if (!($company->getCreatedBy() instanceof User)) {
        throw new AdministratorDnxError();
      } // if     
      trace(__FILE__, 'initCompany() - setCompany()');
      $this->setCompany($company);
    } // initCompany
    
    /**
    * Init active project, if we have active_project $_GET var
    *
    * @access public
    * @param void
    * @return null
    * @throws Error
    */
    private function initActiveProject() {
      trace(__FILE__, 'initActiveProject()');
      $project_id = array_var($_GET, 'active_project');
      if (!empty($project_id)) {
        $project = Projects::findById($project_id);
        if ($project instanceof Project) {
          $this->setProject($project);
        } else {
          $project = new Project;
          $project->setId($project_id);
          $project->setName(lang('deleted or unknown'));
          //flash_error(lang('failed to load project'));
          $this->setProject($project);
          //throw new Error(lang('failed to load project'));
        } // if
      } // if
    } // initActiveProject
    
    /**
    * This function will use session ID from session or cookie and if presend log user
    * with that ID. If not it will simply break.
    * 
    * When this function uses session ID from cookie the whole process will be treated
    * as new login and users last login time will be set to current time.
    *
    * @access public
    * @param void
    * @return boolean
    */
    private function initLoggedUser() {
      trace(__FILE__, 'initLoggedUser()');
      $user_id       = Cookie::getValue('id'.TOKEN_COOKIE_NAME);
      $twisted_token = Cookie::getValue(TOKEN_COOKIE_NAME);
      $remember      = (boolean) Cookie::getValue('remember'.TOKEN_COOKIE_NAME, false);
      $controller    = array_var($_GET, 'c'); // needed to check for RSS feed
      
      if (empty($user_id) || empty($twisted_token)) {
        trace(__FILE__, "initLoggedUser():end, user_id=$user_id, twisted_token=$twisted_token session_lifetime=".SESSION_LIFETIME);
        return false; // we don't have a user
      } // if
      
      $user = Users::findById($user_id);
      if (!($user instanceof User)) {
        trace(__FILE__, "initLoggedUser():end, user_id=$user_id, not found in database");
        return false; // failed to find user
      } // if
      if (!$user->isValidToken($twisted_token)) {
        trace(__FILE__, "initLoggedUser():end, user_id=$user_id, twisted_token=$twisted_token invalid token");
        return false; // failed to validate token
      } // if
      
      if ($controller == 'feed') {
        $this->setLoggedUser($user, $remember, false);
      } else {
        $session_expires = $user->getLastActivity()->advance(SESSION_LIFETIME, false);
        if (DateTimeValueLib::now()->getTimestamp() < $session_expires->getTimestamp()) {
          trace(__FILE__, 'initLoggedUser(): session not expired');
          $this->setLoggedUser($user, $remember, true);
        } else {
          trace(__FILE__, 'initLoggedUser(): session expired');
          $this->logUserIn($user, $remember);
        } // if
      } // if
    } // initLoggedUser
    
    // ---------------------------------------------------
    //  Utils
    // ---------------------------------------------------
    
    /**
    * Log user in
    *
    * @access public
    * @param User $user
    * @param boolean $remember
    * @return null
    */
    function logUserIn(User $user, $remember = false) {
      trace(__FILE__, 'logUserIn():begin');
      $user->setLastLogin(DateTimeValueLib::now());
      
      if (is_null($user->getLastActivity())) {
        $user->setLastVisit(DateTimeValueLib::now());
      } else {
        $user->setLastVisit($user->getLastActivity());
      } // if
      trace(__FILE__, 'logUserIn():setLoggedUser()');
      $this->setLoggedUser($user, $remember, true);
      trace(__FILE__, 'logUserIn():end');
    } // logUserIn
    
    /**
    * Log out user
    *
    * @access public
    * @param void
    * @return null
    */
    function logUserOut() {
      $this->logged_user = null;
      Cookie::unsetValue('id'.TOKEN_COOKIE_NAME);
      Cookie::unsetValue(TOKEN_COOKIE_NAME);
      Cookie::unsetValue('remember'.TOKEN_COOKIE_NAME);
      setcookie(session_name(),'',time()-3600,'/');
      session_unset();
      session_destroy();
      session_write_close();
      session_regenerate_id(true);
    } // logUserOut
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get company
    *
    * @access public
    * @param null
    * @return Company
    */
    function getCompany() {
      return $this->company;
    } // getCompany
    
    /**
    * Set company value
    *
    * @access public
    * @param Company $value
    * @return null
    */
    function setCompany(Company $value) {
      $this->company = $value;
    } // setCompany
    
    /**
    * Get logged_user
    *
    * @access public
    * @param null
    * @return User
    */
    function getLoggedUser() {
      return $this->logged_user;
    } // getLoggedUser
    
    /**
    * Set logged_user value
    *
    * @access public
    * @param User $value
    * @param boolean $remember Remember this user 
    * @param boolean $set_last_activity_time Turned off in case of feed login
    * @return null
    * @throws DBQueryError
    */
    function setLoggedUser(User $user, $remember = false, $set_last_activity_time = true, $set_cookies = true) {
      trace(__FILE__, 'setLoggedUser():begin');
      if ($set_last_activity_time) {
        $user->setLastActivity(DateTimeValueLib::now());
        trace(__FILE__, 'setLoggedUser():user->save()');
        $user->save();
      } // if

      if ($set_cookies) {
        $expiration = $remember ? config_option('remember_login_lifetime', 3600) : 3600;
      
        Cookie::setValue('id'.TOKEN_COOKIE_NAME, $user->getId(), $expiration);
        Cookie::setValue(TOKEN_COOKIE_NAME, $user->getTwistedToken(), $expiration);
      
        if ($remember) {
          Cookie::setValue('remember'.TOKEN_COOKIE_NAME, 1, $expiration);
        } else {
          Cookie::unsetValue('remember'.TOKEN_COOKIE_NAME);
        } // if
      } // if

      trace(__FILE__, 'setLoggedUser():end');
      $this->logged_user = $user;
    } // setLoggedUser
    
    /**
    * Get project
    *
    * @access public
    * @param null
    * @return Project
    */
    function getProject() {
      return $this->selected_project;
    } // getProject
    
    /**
    * Set project value
    *
    * @access public
    * @param Project $value
    * @return null
    */
    function setProject($value) {
      if (is_null($value) || ($value instanceof Project)) {
        $this->selected_project = $value;
      }
    } // setProject
    
    /**
    * Return single CompanyWebsite instance
    *
    * @access public
    * @param void
    * @return CompanyWebsite
    */
    static function instance() {
      static $instance;
      if (!($instance instanceof CompanyWebsite)) {
        $instance = new CompanyWebsite();
      } // if
      return $instance;
    } // instance
  
  } // CompanyWebsite

?>