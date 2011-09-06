<?php

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
      return $this->getCompanyId() == $company->getId();
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

      $value = in_array($permission,$project_user->getPermissions()) ? true : $this->isAdministrator();
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
      return Companies::findById($this->getCompanyId());
    } // getCompany
    
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
        $this->finished_projects = ProjectUsers::getProjectsByUser($this, '`completed_on` > ' . DB::escape(EMPTY_DATETIME));
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
    
    /**
    * Returns true if we have title value set
    *
    * @access public
    * @param void
    * @return boolean
    */
    function hasTitle() {
      return trim($this->getTitle()) <> '';
    } // hasTitle

    /**
    * Check if this user has valid homepage address set
    *
    * @access public
    * @param void
    * @return boolean
    */
    function hasHomepage() {
      return trim($this->getHomepage()) <> '' && is_valid_url($this->getHomepage());
    } // hasHomepage
    
    /**
    * Set homepage URL
    * 
    * This function is simple setter but it will check if protocol is specified for given URL. If it is not then 
    * http will be used. Supported protocols are http and https for this type or URL
    *
    * @param string $value
    * @return null
    */
    function setHomepage($value) {
      if (trim($value) == '') {
        return parent::setHomepage('');
      } // if
      
      $check_value = strtolower($value);
      if (!str_starts_with($check_value, 'http://') && !str_starts_with($check_value, 'https://')) {
        return parent::setHomepage('http://' . $value);
      } else {
        return parent::setHomepage($value);
      } // if
    } // setHomepage
    
    // ---------------------------------------------------
    //  IMs
    // ---------------------------------------------------
    
    /**
    * Return true if this user have at least one IM address
    *
    * @access public
    * @param void
    * @return boolean
    */
    function hasImValue() {
      return UserImValues::count('`user_id` = ' . DB::escape($this->getId()));
    } // hasImValue
    
    /**
    * Return all IM values
    *
    * @access public
    * @param void
    * @return array
    */
    function getImValues() {
      return UserImValues::getByUser($this);
    } // getImValues
    
    /**
    * Return value of specific IM. This function will return null if IM is not found
    *
    * @access public
    * @param ImType $im_type
    * @return string
    */
    function getImValue(ImType $im_type) {
      $im_value = UserImValues::findById(array('user_id' => $this->getId(), 'im_type_id' => $im_type->getId()));
      return $im_value instanceof UserImValue && (trim($im_value->getValue()) <> '') ? $im_value->getValue() : null;
    } // getImValue
    
    /**
    * Return default IM value. If value was not found NULL is returned
    *
    * @access public
    * @param void
    * @return string
    */
    function getDefaultImValue() {
      $default_im_type = $this->getDefaultImType();
      return $this->getImValue($default_im_type);
    } // getDefaultImValue
    
    /**
    * Return default user IM type. If there is no default user IM type NULL is returned
    *
    * @access public
    * @param void
    * @return ImType
    */
    function getDefaultImType() {
      return UserImValues::getDefaultUserImType($this);
    } // getDefaultImType
    
    /**
    * Clear all IM values
    *
    * @access public
    * @param void
    * @return boolean
    */
    function clearImValues() {
      return UserImValues::instance()->clearByUser($this);
    } // clearImValues
    
    // ---------------------------------------------------
    //  Avatars
    // ---------------------------------------------------
    
    /**
    * Set user avatar from $source file
    *
    * @param string $source Source file
    * @param integer $max_width Max avatar widht
    * @param integer $max_height Max avatar height
    * @param boolean $save Save user object when done
    * @return string
    */
    function setAvatar($source, $max_width = 50, $max_height = 50, $save = true) {
      if (!is_readable($source)) {
        return false;
      }
      
      do {
        $temp_file = ROOT . '/cache/' . sha1(uniqid(rand(), true));
      } while (is_file($temp_file));
      
      try {
        Env::useLibrary('simplegd');
        
        $image = new SimpleGdImage($source);
        $thumb = $image->scale($max_width, $max_height, SimpleGdImage::BOUNDARY_DECREASE_ONLY, false);
        $thumb->saveAs($temp_file, IMAGETYPE_PNG);
        
        $public_filename = PublicFiles::addFile($temp_file, 'png');
        if ($public_filename) {
          $this->setAvatarFile($public_filename);
          if ($save) {
            $this->save();
          } // if
        } // if
        
        $result = true;
      } catch(Exception $e) {
        $result = false;
      } // try
      
      // Cleanup
      if (!$result && $public_filename) {
        PublicFiles::deleteFile($public_filename);
      } // if
      @unlink($temp_file);
      
      return $result;
    } // setAvatar
    
    /**
    * Delete avatar
    *
    * @param void
    * @return null
    */
    function deleteAvatar() {
      if ($this->hasAvatar()) {
        PublicFiles::deleteFile($this->getAvatarFile());
        $this->setAvatarFile('');
      } // if
    } // deleteAvatar
    
    /**
    * Return path to the avatar file. This function just generates the path, does not check if file really exists
    *
    * @access public
    * @param void
    * @return string
    */
    function getAvatarPath() {
      return PublicFiles::getFilePath($this->getAvatarFile());
    } // getAvatarPath
    
    /**
    * Return URL of avatar
    *
    * @access public
    * @param void
    * @return string
    */
    function getAvatarUrl() {
      if ($this->getUseGravatar()) return 'http://www.gravatar.com/avatar/' . md5( strtolower( trim( $this->getEmail() ))) . '?s=50'; 
      return $this->hasAvatar() ? PublicFiles::getFileUrl($this->getAvatarFile()) : get_image_url('avatar.gif');
    } // getAvatarUrl
    
    /**
    * Check if this user has uploaded avatar
    *
    * @access public
    * @param void
    * @return boolean
    */
    function hasAvatar() {
      if ($this->getUseGravatar()) return true;
      return (trim($this->getAvatarFile()) <> '') && is_file($this->getAvatarPath());
    } // hasAvatar
    
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
        $username = $username . '@' . config_option('ldap_domain');
      }	

      $ldapconn = ldap_connect('ldap://' . config_option('ldap_host', ''));
      if (!$ldapconn) {
        return false;
      }
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
      
      if (isset($this->visible_companies[$company->getId()])) {
        return $this->visible_companies[$company->getId()];
      } // if
      
      if ($company->isOwner()) {
        $this->visible_companies[$company->getId()] = true;
        return true;
      } // if
      
      if ($this->getCompanyId() == $company->getId()) {
        $this->visible_companies[$company->getId()] = true;
        return true;
      } // if
      
      // Lets companye projects for company of this user and for $company and 
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
      return get_url('user', 'card', $this->getId());
    } // getCardUrl
    
    /**
    * Return edit user URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getEditUrl() {
      return get_url('user', 'edit', $this->getId());
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
      $attributes = array('id' => $this->getId());
      if (trim($redirect_to) <> '') {
        $attributes['redirect_to'] = str_replace('&amp;', '&', trim($redirect_to));
      } // if
      
      return get_url('account', 'edit_profile', $attributes);
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
    * Return update avatar URL
    *
    * @param string
    * @return string
    */
    function getUpdateAvatarUrl($redirect_to = null) {
      $attributes = array('id' => $this->getId());
      if (trim($redirect_to) <> '') {
        $attributes['redirect_to'] = str_replace('&amp;', '&', trim($redirect_to));
      } // if
      
      return get_url('account', 'edit_avatar', $attributes);
    } // getUpdateAvatarUrl
    
    /**
    * Return delete avatar URL
    *
    * @param void
    * @return string
    */
    function getDeleteAvatarUrl($redirect_to = null) {
      $attributes = array('id' => $this->getId());
      if (trim($redirect_to) <> '') {
        $attributes['redirect_to'] = str_replace('&amp;', '&', trim($redirect_to));
      } // if
      
      return get_url('account', 'delete_avatar', $attributes);
    } // getDeleteAvatarUrl
    
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
      
      // Validate homepage if present
      if ($this->validatePresenceOf('homepage')) {
        if (!is_valid_url($this->getHomepage())) {
          $errors[] = lang('user homepage invalid');
        } // if
      } // if
      
      // Company ID
      if (!$this->validatePresenceOf('company_id')) {
        $errors[] = lang('company value required');
      }
      
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
      
      $this->deleteAvatar();
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
