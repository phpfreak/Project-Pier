<?php

  function filenamecmp($a, $b) { return strcmp($a->getFileName(), $b->getFileName()); }

  /**
  * User class
  *
  * @http://www.projectpier.org/
  */
  class User extends BaseUser {

    /**
    * LDAP secure connection values 
    */
    const LDAP_SECURE_CONNECTION_NO  = 'no';
    const LDAP_SECURE_CONNECTION_TLS = 'tls';
    
    /**
    * Cached project permission values. Two level array. First level are projects (project ID) and
    * second are permissions associated with permission name
    *
    * @var array
    */
    private $project_permissions_cache = array();
    
    /**
    * Associative array. Key is project ID and value is true if user has access to that project
    *
    * @var array
    */
    private $is_project_user_cache = array();
    
    /**
    * True if user is member of owner company. This value is read on first request and cached
    *
    * @var boolean
    */
    private $is_member_of_owner_company = null;
    
    /**
    * Cached is_administrator value. First time value is requested it will be checked and cached. 
    * After that every request will return cached value
    *
    * @var boolean
    */
    private $is_administrator = null;
    
    /**
    * Cached is_account_owner value. Value is retrieved on first requests
    *
    * @var boolean
    */
    private $is_account_owner = null;
    
    /**
    * Cached value of all projects
    *
    * @var array
    */
    private $projects;
    
    /**
    * Cached value of active projects
    *
    * @var array
    */
    private $active_projects;
    
    /**
    * Cached value of active main projects
    *
    * @var array
    */
    private $active_main_projects;

    /**
    * Cached value of finished projects
    *
    * @var array
    */
    private $finished_projects;
    
    /**
    * Array of all active milestons
    *
    * @var array
    */
    private $all_active_milestons;
    
    /**
    * Cached late milestones
    *
    * @var array
    */
    private $late_milestones;
    
    /**
    * Cached today milestones
    *
    * @var array
    */
    private $today_milestones;
    
    /**
    * Cached array of new objects
    *
    * @var array
    */
    private $whats_new;
    
    /**
    * canSeeCompany() method will cache its result here (company_id => visible as bool)
    *
    * @var array
    */
    private $visible_companies = array();
    
    /**
    * Cached array of new files
    *
    * @var array
    */
    private $files;

    /**
    * Cached array of new files
    *
    * @var array
    */
    private $importantfiles;

    /**
    * Contact reference. This value is read on first request and cached
    *
    * @var boolean
    */
    private $contact = null;

    /**
    * Construct user object
    *
    * @param void
    * @return User
    */
    function __construct() {
      parent::__construct();
      $this->addProtectedAttribute('password', 'salt', 'session_lifetime', 'token', 'twister', 'last_login', 'last_visit', 'last_activity');
      $this->active_projects = array();
    } // __construct
    
    /**
    * Check if this user is member of specific company
    *
    * @access public
    * @param Company $company
    * @return boolean
    */
    function isMemberOf(Company $company) {
      trace(__FILE__,'isMemberOf()');
      return $this->getContact()->getCompanyId() == $company->getId();
    } // isMemberOf
    
    /**
    * Usualy we check if user is member of owner company so this is the shortcut method
    *
    * @param void
    * @return boolean
    */
    function isMemberOfOwnerCompany() {
      trace(__FILE__,'isMemberOfOwnerCompany()');
      if (is_null($this->is_member_of_owner_company)) {
        $this->is_member_of_owner_company = $this->isMemberOf(owner_company());
      }
      return $this->is_member_of_owner_company;
    } // isMemberOfOwnerCompany
    
    /**
    * Check if this user is part of specific project
    *
    * @param Project $project
    * @return boolean
    */
    function isProjectUser(Project $project) {
      if (is_null($project)) {
        return false;
      }
      if ($project->getCreatedById() == $this->getId()) {
        return true;
      }
      if (!isset($this->is_project_user_cache[$project->getId()])) {
        $project_user = ProjectUsers::findById(array(
          'project_id' => $project->getId(), 
          'user_id' => $this->getId())
        ); // findById
        $this->is_project_user_cache[$project->getId()] = $project_user instanceof ProjectUser;
      } // if
      return $this->is_project_user_cache[$project->getId()];
    } // isProjectUser

    /**
    * Set the project specific note for this user
    *
    * @param Project $project
    * @param string $data
    * @return boolean
    */
    function setProjectNote(Project $project, $data) {
      if (is_null($project)) {
        return false;
      }
      if (!$this->isProjectUser($project)) {
        return false;
      }
      $project_user = ProjectUsers::findById(array(
        'project_id' => $project->getId(), 
        'user_id' => $this->getId())
      ); // findById
      if ($project_user instanceof ProjectUser) {
        $project_user->setNote($data);
        return $project_user->save();
      } // if
      return false;
    } // setProjectNote

    /**
    * Set the project specific note for this user
    *
    * @param Project $project
    * @param string $data
    * @return boolean
    */
    function getProjectNote(Project $project) {
      if (is_null($project)) {
        return false;
      }
      if (!$this->isProjectUser($project)) {
        return false;
      }
      $project_user = ProjectUsers::findById(array(
        'project_id' => $project->getId(), 
        'user_id' => $this->getId())
      ); // findById
      if ($project_user instanceof ProjectUser) {
        return $project_user->getNote();
      } // if
      return false;
    } // getProjectNote
    
    
    /**
    * Check if this of specific company website. If must be member of that company and is_admin flag set to true
    *
    * @param void
    * @return boolean
    */
    function isAdministrator() {
      trace(__FILE__,'isAdministrator():begin');
      if (is_null($this->is_administrator)) {
        trace(__FILE__,'isAdministrator():init is_administrator');
        //$this->is_administrator = $this->isAccountOwner() || ($this->isMemberOfOwnerCompany() && $this->getIsAdmin());
        $this->is_administrator = ($this->isMemberOfOwnerCompany() && $this->getIsAdmin());
      } // if
      trace(__FILE__,'isAdministrator():end');
      return $this->is_administrator;
    } // isAdministrator
    
    /**
    * Account owner is user account that was created when company website is created
    *
    * @param void
    * @return boolean
    */
    function isAccountOwner() {
      //if (is_null($this->is_account_owner)) {
      //  $this->is_account_owner = $this->isMemberOfOwnerCompany() && (owner_company()->getCreatedById() == $this->getId());
      //} // if
      //return $this->is_account_owner;
      return false;
    } // isAccountOwner
    
    /**
    * Return project permission for specific user if he is on project. In case of any error $default is returned
    *
    * @access public
    * @param Project $project
    * @param string $permission Permission name
    * @param boolean $default Default value
    * @return boolean
    */
    function getProjectPermission(Project $project, $permission, $default = false) {
      trace(__FILE__,"getProjectPermission($permission, $default)");
      if (is_null($project)) return false;
      static $valid_permissions;
      if (!isset($valid_permissions)) {
        trace(__FILE__,"getProjectPermission($permission, $default):getPermissionsText()");
        $valid_permissions = array_keys(permission_manager()->getPermissionsText());
      } // if
      
      if (!in_array($permission, $valid_permissions)) {
        return $default;
      } // if
      
      trace(__FILE__,"getProjectPermission($permission, $default):findById project={$project->getId()}");
      $project_user = ProjectUsers::findById(array(
        'project_id' => $project->getId(),
        'user_id' => $this->getId()
      )); // findById
      if (!($project_user instanceof ProjectUser)) {
        return $default;
      } // if

      trace(__FILE__,"getProjectPermission($permission, $default):getPermissions()");
      $value = in_array($permission,$project_user->getPermissions()) ? true : false;
      return $value;
    } // getProjectPermission
    
    /**
    * Return if user can manage projects
    *
    * @access public
    * @return boolean
    */
    function canManageProjects() {
      trace(__FILE__,'canManageProjects()');

      $permission = PermissionManager::CAN_MANAGE_PROJECTS;
      
      $project_user = new ProjectUser();
      $project_user->setUserId($this->getId());
      $project_user->setProjectId(0);

      $value = in_array($permission,$project_user->getPermissions()) ? true : false;
      return $value;
    } // canManageProjects

    /***
    * Set a permission for this user
    *
    * @param string $permissionString Name of the permission. There are set of constants
    *   in ProjectUser that hold permission names (PermissionManager::CAN_MANAGE_MESSAGES ...)
    * @param int $value 1 if the user should be granted the permission, any other value is a denial
    * @return boolean
    */
    function setPermission($permission_name, $value) {
      $permission_id = Permissions::getPermissionId($permission_name);
      if (!isset($permission_id) || !$permission_id) {
        return false;
      }
      // delete permission
      ProjectUserPermissions::delete( array(
           '`user_id` = ? AND `project_id` = ? AND `permission_id` = ?', 
           $this->getId(),
           0,
           $permission_id
      ));
      // add if $value == 1
      if ($value == 1) {
        $pup = new ProjectUserPermission();
        $pup->setProjectId(0);
        $pup->setUserId($this->getId());
        $pup->setPermissionId($permission_id);
        $pup->save();
      } // if
    } // setPermission
    
    /***
    * Set a permission for this user
    *
    * @param Project $project
    * @param string $permissionString Name of the permission. There are set of constants
    *   in ProjectUser that hold permission names (PermissionManager::CAN_MANAGE_MESSAGES ...)
    * @param boolean $granted true=granted, false=denied
    * @return boolean
    */
    function setProjectPermission(Project $project, $permission_name, $granted) {
      trace(__FILE__, "setProjectPermission(project, $permission_name, $granted):begin");
      $permission_id = Permissions::getPermissionId($permission_name);
      if (!isset($permission_id) || !$permission_id) {
        return false;
      }
      if ($granted) {
        trace(__FILE__, "setProjectPermission(project, $permission_name, $granted):granted");
        $pup = new ProjectUserPermission();
        $pup->setProjectId($project->getId());
        $pup->setUserId($this->getId());
        $pup->setPermissionId($permission_id);
        $pup->save();
      } else {
        $pup = ProjectUserPermissions::findOne(array('conditions' => '`project_id` = '.$project->getId().' and `user_id` = '.$this->getId().' and `permission_id` = '.$permission_id));
        if (isset($pup) && ($pup instanceOf ProjectUserPermission)) {
          $pup->delete();
        } // if
      } // if
    } // setProjectPermission
    
    /**
    * This function will check if this user has all project permissions
    *
    * @param Project $project
    * @param boolean $use_cache
    * @return boolean
    */
    function hasAllProjectPermissions(Project $project, $use_cache = true) {
      $permissions = array_keys(PermissionManager::getPermissionsText());
      if (is_array($permissions)) {
        foreach ($permissions as $permission) {
          if (!$this->getProjectPermission($project, $permission)) {
            return false;
          }
        } // foreach
      } // if
      return true;
    } // hasAllProjectPermissions
    
    // ---------------------------------------------------
    //  Retrieve
    // ---------------------------------------------------
    
    /**
    * Return owner company
    *
    * @access public
    * @param void
    * @return Company
    */
    function getCompany() {
      return $this->getContact()->getCompany();
    } // getCompany

    /**
    * Return owner company
    *
    * @access public
    * @param void
    * @return Company
    */
    function getCompanyId() {
      return $this->getContact()->getCompanyId();
    } // getCompany

    /**
    * Return display name for company of this user.
    *
    * @access public
    * @param void
    * @return string
    */
    function getCompanyDisplayName() {
      $company = self::getCompany();
      return is_null($company) ? '' : $company->getName();
    } // getDisplayName

    /**
    * Return associated contact
    *
    * @param void
    * @return Contact
    */
    function getContact() {
      if (!isset($this->contact)) {
        $contact = Contacts::findOne(array('conditions' => array('`user_id` = ? ', $this->getId())));
        if ($contact instanceof Contact) {
          $this->contact = $contact;
        } else {
          $this->contact = new Contact;
          $this->contact->setDisplayName(lang('missing contact'));
          $this->contact->setCompanyId(owner_company()->getId());
        }
      }
      return $this->contact;
    } // getContact
    
    /**
    * Return time zone
    *
    * @access public
    * @param void
    * @return Company
    */
    function getTimezone() {
      return $this->getContact()->getTimezone();
    } // getTimezone

    /**
    * Return all projects that this user is member of
    *
    * @access public
    * @param void
    * @return array
    */
    function getProjects() {
      if (is_null($this->projects)) {
        $this->projects = ProjectUsers::getProjectsByUser($this);
      } // if
      return $this->projects;
    } // getProjects
 
    /**
    * Return array of active main projects that this user have access
    *
    * @access public
    * @param void
    * @return array
    */
    function getActiveMainProjects($sort = 'name') {
      trace(__FILE__, "getActiveMainProjects($sort)");
      if (is_null($this->active_main_projects)) {
        trace(__FILE__, '- initialize cache: active_main_projects');
        $this->active_main_projects = array();
      } // if
      if (!isset($this->active_main_projects[$sort])) {
        $projects_table = Projects::instance()->getTableName(true);
        $empty_datetime = DB::escape(EMPTY_DATETIME);
        $this->active_main_projects[$sort] = ProjectUsers::getProjectsByUser($this, "$projects_table.`completed_on` = $empty_datetime AND $projects_table.`parent_id` = 0", $sort);
      } // if
      return $this->active_main_projects[$sort];
    } // getActiveMainProjects
   
    /**
    * Return array of active projects that this user have access
    *
    * @access public
    * @param void
    * @return array
    */
    function getActiveProjects($sort = 'name') {
      trace(__FILE__, 'getActiveProjects()');
      if (is_null($this->active_projects)) {
        trace(__FILE__, '- initialize cache: active_projects');
        $this->active_projects = array();
      } // if
      if (!isset($this->active_projects[$sort])) {
        $projects_table = Projects::instance()->getTableName(true);
        $empty_datetime = DB::escape(EMPTY_DATETIME);
        $this->active_projects[$sort] = ProjectUsers::getProjectsByUser($this, "$projects_table.`completed_on` = $empty_datetime", $sort);
      } // if
      return $this->active_projects[$sort];
    } // getActiveProjects
    
    /**
    * Return array of finished projects
    *
    * @access public
    * @param void
    * @return array
    */
    function getFinishedProjects() {
      if (is_null($this->finished_projects)) {
        $projects_table = Projects::instance()->getTableName(true);
        $this->finished_projects = ProjectUsers::getProjectsByUser($this, "$projects_table.`completed_on` > " . DB::escape(EMPTY_DATETIME));
      } // if
      return $this->finished_projects;
    } // getFinishedProjects
    
    /**
    * Return all active milestones assigned to this user
    *
    * @param void
    * @return array
    */
    function getActiveMilestones() {
      if (is_null($this->all_active_milestons)) {
        $this->all_active_milestons = ProjectMilestones::getActiveMilestonesByUser($this);
      } // if
      return $this->all_active_milestons;
    } // getActiveMilestones
    
    /**
    * Return late milestones that this user have access to
    *
    * @access public
    * @param void
    * @return array
    */
    function getLateMilestones() {
      if (is_null($this->late_milestones)) {
        $this->late_milestones = ProjectMilestones::getLateMilestonesByUser($this);
      } // if
      return $this->late_milestones;
    } // getLateMilestones
    
    /**
    * Return today milestones that this user have access to
    *
    * @access public
    * @param void
    * @return array
    */
    function getTodayMilestones() {
      if (is_null($this->today_milestones)) {
        $this->today_milestones = ProjectMilestones::getTodayMilestonesByUser($this);
      } // if
      return $this->today_milestones;
    } // getTodayMilestones
    
    /**
    * Return array of active projects that this user have access
    *
    * @access public
    * @param void
    * @return array
    */
    function getFiles($sort = 'name') {
      trace(__FILE__, 'getFiles()');
      if (is_null($this->files)) {
        trace(__FILE__, '- initialize cache: files');
        $this->files = array();
      } // if
      if (!isset($this->files[$sort])) {
        $files = array();
        $projects = $this->getActiveProjects();
        foreach($projects as $project) {
          $projectfiles = ProjectFiles::getAllFilesByProject($project);
          $i=0;
          while (isset($projectfiles[$i])){
            $files[] = $projectfiles[$i];
            unset($projectfiles[$i]);
            $i++;
          }
        }
        usort($files, "filenamecmp");
        $this->files[$sort] = $files;
      } // if
      return $this->files[$sort];
    } // getFiles

    /**
    * Return array of active projects that this user have access
    *
    * @access public
    * @param void
    * @return array
    */
    function getImportantFiles($sort = 'name') {
      trace(__FILE__, 'getImportantFiles()');
      if (is_null($this->importantfiles)) {
        trace(__FILE__, '- initialize cache: files');
        $this->importantfiles = array();
      } // if
      if (!isset($this->importantfiles[$sort])) {
        $files = array();
        $projects = $this->getActiveProjects();
        if (is_array($projects)) {
          foreach($projects as $project) {
            $projectfiles = ProjectFiles::getImportantProjectFiles($project);
            $i=0;
            while (isset($projectfiles[$i])){
              $files[] = $projectfiles[$i];
              unset($projectfiles[$i]);
              $i++;
            }
          }
        }
        usort($files, "filenamecmp");
        $this->importantfiles[$sort] = $files;
      } // if
      return $this->importantfiles[$sort];
    } // getImportantFiles
    
    /**
    * Return display name for this account. If there is no display name set username will be used
    *
    * @access public
    * @param void
    * @return string
    */
    function getDisplayName() {
      $display = parent::getDisplayName();
      return trim($display) == '' ? $this->getUsername() : $display;
    } // getDisplayName
    
    // ---------------------------------------------------
    //  Utils
    // ---------------------------------------------------
    
    /**
    * This function will generate new user password, set it and return it
    *
    * @param boolean $save Save object after the update
    * @return string
    */
    function resetPassword($save = true) {
      $new_password = substr(sha1(uniqid(rand(), true)), rand(0, 25), 13);
      $this->setPassword($new_password);
      if ($save) {
        $this->save();
      } // if
      return $new_password;
    } // resetPassword
    
    /**
    * Set password value
    *
    * @param string $value
    * @return boolean
    */
    function setPassword($value) {
      do {
        $salt = substr(sha1(uniqid(rand(), true)), rand(0, 25), 13);
        $token = sha1($salt . $value);
      } while (Users::tokenExists($token));
      
      $this->setToken($token);
      $this->setSalt($salt);
      $this->setTwister(StringTwister::getTwister());
    } // setPassword
    
    /**
    * Return twisted token
    *
    * @param void
    * @return string
    */
    function getTwistedToken() {
      return StringTwister::twistHash($this->getToken(), $this->getTwister());
    } // getTwistedToken
    
    /**
    * Check if $check_password is valid user password
    *
    * @param string $check_password
    * @return boolean
    */
    function isValidPassword($check_password) {
      if ($this->getUseLDAP()) {
        return $this->doLDAP($check_password);
      }
      return sha1($this->getSalt() . $check_password) == $this->getToken();
    } // isValidPassword
    
    /**
    * Check if $twisted_token is valid for this user account
    *
    * @param string $twisted_token
    * @return boolean
    */
    function isValidToken($twisted_token) {
      return StringTwister::untwistHash($twisted_token, $this->getTwister()) == $this->getToken();
    } // isValidToken

    /**
    * Authenticate using LDAP.
    *
    * @param string $pass
    * @param string config_option('ldap_domain')
    * @param string config_option('ldap_host')
    * @param string config_option('ldap_secure_connection')
    * @return boolean
    */
    function doLDAP($pass) {
      if (!function_exists('ldap_connect')) {
        return false;
      }
      $username = $this->getUsername();
      if (strlen(config_option('ldap_domain', '')) != 0) {
        //$username = $username . '@' . config_option('ldap_domain');
        $username = sprintf(config_option('ldap_domain'), $username);
      }	

      $ldapconn = ldap_connect('ldap://' . config_option('ldap_host', ''));
      if (!$ldapconn) {
        return false;
      }
      ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
      $ldap_secure_connection = config_option('ldap_secure_connection', self::LDAP_SECURE_CONNECTION_NO);
      if ($ldap_secure_connection == self::LDAP_SECURE_CONNECTION_TLS) {
        if (!ldap_start_tls($ldapconn)) {
          ldap_close($ldapconn);
          return false;
	}
      }

      $ldapbind = ldap_bind($ldapconn, $username, $pass);
      ldap_close($ldapconn);
      return $ldapbind;
    } // doLDAP
    
    // ---------------------------------------------------
    //  Permissions
    // ---------------------------------------------------
    
    /**
    * Can specific user add user to specific company
    *
    * @access public
    * @param User $user
    * @param Company $to Can user add user to this company
    * @return boolean
    */
    function canAdd(User $user, Company $to) {
      if ($user->isAccountOwner()) {
        return true;
      } // if
      return $user->isAdministrator();
    } // canAdd
    
    /**
    * Check if specific user can update this user account
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canEdit(User $user) {
      if ($user->getId() == $this->getId()) {
        return true; // account owner
      } // if
      if ($user->isAccountOwner()) {
        return true;
      } // if
      return $user->isAdministrator();
    } // canEdit
    
    /**
    * Check if specific user can delete specific account
    *
    * @param User $user
    * @return boolean
    */
    function canDelete(User $user) {
      if ($this->isAccountOwner()) {
        return false; // can't delete accountowner
      } // if
      
      if ($this->getId() == $user->getId()) {
        return false; // can't delete self
      } // if
      
      return $user->isAdministrator();
    } // canDelete
    
    /**
    * Returns true if this user can see $user
    *
    * @param User $user
    * @return boolean
    */
    function canSeeUser(User $user) {
      if ($this->isMemberOfOwnerCompany()) {
        return true; // see all
      } // if
      if ($user->getCompanyId() == $this->getCompanyId()) {
        return true; // see members of your own company
      } // if
      if ($user->isMemberOfOwnerCompany()) {
        return true; // see members of owner company
      } // if
      return false;
    } // canSeeUser

    /**
    * Returns true if this user can see $contact
    * TODO shouldn't it be in the Contact model?
    *
    * @param Contact $contact
    * @return boolean
    */
    function canSeeContact(Contact $contact) {
      if ($this->isMemberOfOwnerCompany()) {
        return true; // see all
      } // if
      if ($contact->getCompanyId() == $this->getCompanyId()) {
        return true; // see members of your own company
      } // if
      if ($contact->isMemberOfOwnerCompany()) {
        return true; // see members of owner company
      } // if
      return false;
    } // canSeeContact
    

    
    /**
    * Returns true if this user can see $company. Members of owener company and
    * coworkers are visible without project check! Also, members of owner company
    * can see all clients without any prior check!
    *
    * @param Company $company
    * @return boolean
    */
    function canSeeCompany(Company $company) {
      if ($this->isMemberOfOwnerCompany()) {
        return true;
      } // if
            
      if ($company->isOwner()) {
        $this->visible_companies[$company->getId()] = true;
        return true;
      } // if

      if (isset($this->visible_companies[$company->getId()])) {
        return $this->visible_companies[$company->getId()];
      } // if

      if ($this->getCompanyId() == $company->getId()) {
        $this->visible_companies[$company->getId()] = true;
        return true;
      } // if
      
      // Lets company projects for company of this user and for $company and 
      // compare if we have projects where both companies work together
      $projects_1 = DB::executeAll("SELECT `project_id` FROM " . ProjectCompanies::instance()->getTableName(true) . " WHERE `company_id` = ?", $this->getCompanyId());
      $projects_2 = DB::executeAll("SELECT `project_id` FROM " . ProjectCompanies::instance()->getTableName(true) . " WHERE `company_id` = ?", $company->getId());
      
      if (!is_array($projects_1) || !is_array($projects_2)) {
        $this->visible_companies[$company->getId()] = false;
        return false;
      } // if
      
      foreach ($projects_1 as $project_id) {
        if (in_array($project_id, $projects_2)) {
          $this->visible_companies[$company->getId()] = true;
          return true;
        } // if
      } // foreach
      
      $this->visible_companies[$company->getId()] = false;
      return false;
    } // canSeeCompany
    
    /**
    * Check if specific user can update this profile
    *
    * @param User $user
    * @return boolean
    */
    function canUpdateProfile(User $user) {
      if ($this->getId() == $user->getId()) {
        return true;
      } // if
      if ($user->isAdministrator()) {
        return true;
      } // if
      return false;
    } // canUpdateProfile
    
    /**
    * Check if this user can update this users permissions
    *
    * @param User $user
    * @return boolean
    */
    function canUpdatePermissions(User $user) {
      if ($this->isAccountOwner()) {
        return false; // noone will touch this
      } // if
      return $user->isAdministrator();
    } // canUpdatePermissions
    
    /**
    * Check if this user is company administration (used to check many other permissions). User must
    * be part of the company and have is_admin stamp set to true
    *
    * @access public
    * @param Company $company
    * @return boolean
    */
    function isCompanyAdmin(Company $company) {
      return ($this->getCompanyId() == $company->getId()) && $this->getIsAdmin();
    } // isCompanyAdmin
    
   
    // ---------------------------------------------------
    //  URLs
    // ---------------------------------------------------
    
    /**
    * Return view account URL of this user
    *
    * @access public
    * @param void
    * @return string
    */
    function getAccountUrl() {
      return get_url('account', 'index');
    } // getAccountUrl
    
    /**
    * Show company card page
    *
    * @access public
    * @param void
    * @return null
    */
    function getCardUrl() {
      return get_url('contacts', 'card', $this->getContact()->getId());
    } // getCardUrl
    
    /**
    * Return edit user URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getEditUrl() {
      return get_url('contacts', 'edit_user_account', $this->getContact()->getId());
    } // getEditUrl
    
    /**
    * Return delete user URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getDeleteUrl() {
      return get_url('user', 'delete', $this->getId());
    } // getDeleteUrl
    
    /**
    * Return edit profile URL
    *
    * @param string $redirect_to URL where we need to redirect user when he updates profile
    * @return string
    */
    function getEditProfileUrl($redirect_to = null) {
      $attributes = array('id' => $this->getContact()->getId());
      if (trim($redirect_to) <> '') {
        $attributes['redirect_to'] = str_replace('&amp;', '&', trim($redirect_to));
      } // if
      
      return get_url('contacts', 'edit', $attributes);
    } // getEditProfileUrl
    
    /**
    * Edit users password
    *
    * @param string $redirect_to URL where we need to redirect user when he updates password
    * @return null
    */
    function getEditPasswordUrl($redirect_to = null) {
      $attributes = array('id' => $this->getId());
      if (trim($redirect_to) <> '') {
        $attributes['redirect_to'] = str_replace('&amp;', '&', trim($redirect_to));
      } // if
      
      return get_url('account', 'edit_password', $attributes);
    } // getEditPasswordUrl

    /**
    * Return update user permissions page URL
    *
    * @param string $redirect_to
    * @return string
    */
    function getUpdatePermissionsUrl($redirect_to = null) {
      $attributes = array('id' => $this->getId());
      if (trim($redirect_to) <> '') {
        $attributes['redirect_to'] = str_replace('&amp;', '&', trim($redirect_to));
      } // if
      
      return get_url('account', 'update_permissions', $attributes);
    } // getUpdatePermissionsUrl
    
    /**
    * Return recent activities feed URL
    * 
    * If $project is valid project instance URL will be limited for that project only, else it will be returned for 
    * overal feed
    *
    * @param Project $project
    * @return string
    */
    function getRecentActivitiesFeedUrl($project = null) {
      $params = array(
        'id' => $this->getId(),
        'token' => $this->getTwistedToken(),
      ); // array
      
      if ($project instanceof Project) {
        $params['project'] = $project->getId();
        return get_url('feed', 'project_activities', $params, null, false);
      } else {
        return get_url('feed', 'recent_activities', $params, null, false);
      } // if
    } // getRecentActivitiesFeedUrl
    
    /**
    * Return iCalendar URL
    * 
    * If $project is valid project instance calendar will be rendered just for that project, else it will be rendered 
    * for all active projects this user is involved with
    *
    * @param Project $project
    * @return string
    */
    function getICalendarUrl($project = null) {
      $params = array(
        'id' => $this->getId(),
        'token' => $this->getTwistedToken(),
      ); // array
      
      if ($project instanceof Project) {
        $params['project'] = $project->getId();
        return get_url('feed', 'project_ical', $params, null, false);
      } else {
        return get_url('feed', 'user_ical', $params, null, false);
      } // if
    } // getICalendarUrl
    
    // ---------------------------------------------------
    //  System functions
    // ---------------------------------------------------
    
    /**
    * Validate data before save
    *
    * @access public
    * @param array $errors
    * @return void
    */
    function validate(&$errors) {
      
      // Validate username if present
      if ($this->validatePresenceOf('username')) {
        if (!$this->validateUniquenessOf('username')) {
          $errors[] = lang('username must be unique');
        }
      } else {
        $errors[] = lang('username value required');
      } // if
      
      if (!$this->validatePresenceOf('token')) {
        $errors[] = lang('password value required');
      }
      
      // Validate email if present
      if ($this->validatePresenceOf('email')) {
        if (!$this->validateFormatOf('email', EMAIL_FORMAT)) {
          $errors[] = lang('invalid email address');
        }
      } else {
        $errors[] = lang('email value is required');
      } // if
            
    } // validate
    
    /**
    * Delete this object
    *
    * @param void
    * @return boolean
    */
    function delete() {
      if ($this->isAccountOwner()) {
        return false;
      } // if
      
      ProjectUsers::clearByUser($this);
      MessageSubscriptions::clearByUser($this);
      return parent::delete();
    } // delete
    
    // ---------------------------------------------------
    //  ApplicationDataObject implementation
    // ---------------------------------------------------
    
    /**
    * Return object name
    *
    * @access public
    * @param void
    * @return string
    */
    function getObjectName() {
      return $this->getDisplayName();
    } // getObjectName
    
    /**
    * Return object type name
    *
    * @param void
    * @return string
    */
    function getObjectTypeName() {
      return lang('user');
    } // getObjectTypeName
    
    /**
    * Return object URl
    *
    * @access public
    * @param void
    * @return string
    */
    function getObjectUrl() {
      return $this->getCardUrl();
    } // getObjectUrl
  
  } // User 

?>