<?php

  /**
  * Contacts controller
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class ContactsController extends ApplicationController {
  
    /**
    * Construct the ContactsController
    *
    * @access public
    * @param void
    * @return ContactController
    */
    function __construct() {
      parent::__construct();
      prepare_company_website_controller($this, 'administration');
    } // __construct
    
    /**
    * Contact management index
    *
    * @access public
    * @param void
    * @return null
    */
    function index() {
      
    } // index
    
    /**
    * Add contact
    *
    * @access public
    * @param void
    * @return null
    */
    function add() {
      $this->setTemplate('add_contact');
      
      $company_id = get_id('company_id', null, 0);
      $company = Companies::findById($company_id);
      
      if (!Contact::canAdd(logged_user(), $company)) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('dashboard', 'index'));
      } // if
      
      $contact = new Contact();
      
      $im_types = ImTypes::findAll(array('order' => '`id`'));

      $contact_data = array_var($_POST, 'contact');
      if (!is_array($contact_data)) {
        $contact_data = array(
          'company_id' => $company_id,
        ); // array
      } // if

      $user_data = array_var($contact_data, 'user');
      if (!is_array($user_data)) {
        $user_data = array(
          'password_generator' => 'random'
        ); // array
      } // if

      tpl_assign('contact', $contact);
      tpl_assign('company', $company);
      tpl_assign('contact_data', $contact_data);
      tpl_assign('user_data', $user_data);
      tpl_assign('im_types', $im_types);

      $avatar = array_var($_FILES, 'new_avatar');
      if (is_array($avatar) && isset($avatar['size']) && $avatar['size'] != 0) {
        try {
          if (!isset($avatar['name']) || !isset($avatar['type']) || !isset($avatar['size']) || !isset($avatar['tmp_name']) || !is_readable($avatar['tmp_name'])) {
            throw new InvalidUploadError($avatar, lang('error upload file'));
          } // if
          
          $valid_types = array('image/jpg', 'image/jpeg', 'image/pjpeg', 'image/gif', 'image/png');
          $max_width   = config_option('max_avatar_width', 50);
          $max_height  = config_option('max_avatar_height', 50);
          
          if ($avatar['size']) {
            if (!in_array($avatar['type'], $valid_types) || !($image = getimagesize($avatar['tmp_name']))) {
              throw new InvalidUploadError($avatar, lang('invalid upload type', 'JPG, GIF, PNG'));
            } elseif (!$contact->setAvatar($avatar['tmp_name'], $max_width, $max_height, false)) {
              throw new Error($avatar, lang('error edit avatar'));
              $contact->setAvatarFile('');
            } // if
          } // if
        } catch (Exception $e) {
          flash_error($e->getMessage());
        }
      } else {
        $contact->setAvatarFile('');
      } // if

      if (is_array(array_var($_POST, 'contact'))) {
        $contact->setFromAttributes($contact_data);

        try {          
          // Company info
          if ($_POST['contact']['company']['what'] == 'existing') {
            $company_id = $_POST['contact']['company_id'];
          } else {
            $company = new Company();
            $company->setName($_POST['contact']['company']['name']);
            $company->setTimezone($_POST['contact']['company']['timezone']);
            $company->setClientOfId(owner_company()->getId());
            $company->save();
            $company_id = $company->getId();
          } // if
          
          $contact->setCompanyId($company_id);
          $contact->setUserId(0);
          $contact->save();
          if (plugin_active('tags')) {
            $contact->setTagsFromCSV(array_var($contact_data, 'tags'));
          }
          
          $contact->clearImValues();
          foreach ($im_types as $im_type) {
            $value = trim(array_var($contact_data, 'im_' . $im_type->getId()));
            if ($value <> '') {
              
              $contact_im_value = new ContactImValue();
              
              $contact_im_value->setContactId($contact->getId());
              $contact_im_value->setImTypeId($im_type->getId());
              $contact_im_value->setValue($value);
              $contact_im_value->setIsDefault(array_var($contact_data, 'default_im') == $im_type->getId());
              
              $contact_im_value->save();
            } // if
          } // foreach
          
          ApplicationLogs::createLog($contact, null, ApplicationLogs::ACTION_ADD);
          DB::commit();

          flash_success(lang('success add contact', $contact->getDisplayName()));
          $this->redirectToUrl($contact->getCardUrl()); // Translate to profile page
          
        } catch (Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
        
      } // if
      
    } // add
    
    /**
    *
    * @access public
    * @param void
    * @return null
    */
    function edit() {
      $this->setTemplate('add_contact');
      
      $contact = Contacts::findById(get_id());
      if (!($contact instanceof Contact)) {
        flash_error(lang('contact dnx'));
        $this->redirectTo('dashboard', 'contacts');
      } // if
      
      if (!$contact->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard', 'contacts');
      } // if
      
      $im_types = ImTypes::findAll(array('order' => '`id`'));
      
      $contact_data = array_var($_POST, 'contact');
      $company = $contact->getCompany();
      if (!is_array($contact_data)) {
        $tag_names = null;
        if (plugin_active('tags')) {
          $tag_names = $contact->getTagNames();
        }
        $contact_data = array(
          'display_name' => $contact->getDisplayName(),
          'first_name' => $contact->getFirstName(),
          'middle_name' => $contact->getMiddleName(),
          'last_name' => $contact->getLastName(),
          'company_id' => $contact->getCompanyId(),
          'title' => $contact->getTitle(),
          'email' => $contact->getEmail(),
          'office_number' => $contact->getOfficeNumber(),
          'fax_number' => $contact->getFaxNumber(),
          'mobile_number' => $contact->getMobileNumber(),
          'home_number' => $contact->getHomeNumber(),
          'food_preferences'  => $contact->getFoodPreferences(),
          'license_plate'  => $contact->getLicensePlate(),
          'location_details'  => $contact->getLocationDetails(),
          'department_details'  => $contact->getDepartmentDetails(),
          'use_gravatar'  => $contact->getUseGravatar(),
          'tags' => is_array($tag_names) ? implode(', ', $tag_names) : '',
        ); // array
        
        if (is_array($im_types)) {
          foreach ($im_types as $im_type) {
            $contact_data['im_' . $im_type->getId()] = $contact->getImValue($im_type);
          } // forech
        } // if
        
        $default_im = $contact->getDefaultImType();
        $contact_data['default_im'] = $default_im instanceof ImType ? $default_im->getId() : '';
        
      } // if
      
      tpl_assign('contact', $contact);
      tpl_assign('company', $company);
      tpl_assign('contact_data', $contact_data);
      tpl_assign('im_types', $im_types);

      
      $avatar = array_var($_FILES, 'new_avatar');
      if (is_array($avatar) && isset($avatar['size']) && $avatar['size'] != 0) {
        try {
          $old_file = $contact->getAvatarPath();
          if (!isset($avatar['name']) || !isset($avatar['type']) || !isset($avatar['size']) || !isset($avatar['tmp_name']) || !is_readable($avatar['tmp_name'])) {
            throw new InvalidUploadError($avatar, lang('error upload file'));
          } // if
          

          $valid_types = array('image/jpg', 'image/jpeg', 'image/pjpeg', 'image/gif', 'image/png');
          $max_width   = config_option('max_avatar_width', 50);
          $max_height  = config_option('max_avatar_height', 50);
          
          if ($avatar['size']) {
            if (!in_array($avatar['type'], $valid_types) || !($image = getimagesize($avatar['tmp_name']))) {
              throw new InvalidUploadError($avatar, lang('invalid upload type', 'JPG, GIF, PNG'));
            } elseif (!$contact->setAvatar($avatar['tmp_name'], $max_width, $max_height, false)) {
              throw new Error($avatar, lang('error edit avatar'));
              $contact->setAvatarFile('');
            } // if
            if (is_file($old_file)) {
              @unlink($old_file);
            } // if
          } // if
        } catch (Exception $e) {
          flash_error($e->getMessage());
        } // try
      } else if (array_var($contact_data, 'delete_avatar') == "checked") {
        $old_file = $contact->getAvatarPath();
        if (is_file($old_file)) {
          @unlink($old_file);
        } // if
        $contact->setAvatarFile('');
      } // if

      if (is_array(array_var($_POST, 'contact'))) {
        try {
          DB::beginWork();
          
          $contact->setFromAttributes($contact_data);
          $contact->save();
          if (plugin_active('tags')) {
            $contact->setTagsFromCSV(array_var($contact_data, 'tags'));
          }
          
          $contact->clearImValues();
          foreach ($im_types as $im_type) {
            $value = trim(array_var($contact_data, 'im_' . $im_type->getId()));
            if ($value <> '') {
              
              $contact_im_value = new ContactImValue();
              
              $contact_im_value->setContactId($contact->getId());
              $contact_im_value->setImTypeId($im_type->getId());
              $contact_im_value->setValue($value);
              $contact_im_value->setIsDefault(array_var($contact_data, 'default_im') == $im_type->getId());
              
              $contact_im_value->save();
            } // if
          } // foreach
          
          ApplicationLogs::createLog($contact, null, ApplicationLogs::ACTION_ADD);
          DB::commit();
          
          
          flash_success(lang('success edit contact', $contact->getDisplayName()));
          if (!logged_user()->isMemberOfOwnerCompany()) {
            $this->redirectToUrl(logged_user()->getAccountUrl());
          } else {
            $this->redirectToUrl($contact->getCompany()->getViewUrl()); // Translate to profile page
          } // if
          
        } catch (Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
        
      } // if
      
    } // edit
    
    
    /**
    * Delete specific contact
    *
    * @access public
    * @param void
    * @return null
    */
    function delete() {
      $this->setTemplate('del_contact');

      $contact = Contacts::findById(get_id());
      if (!($contact instanceof Contact)) {
        flash_error(lang('contact dnx'));
        $this->redirectTo('administration', 'contacts');
      } // if
      
      if (!$contact->canDelete(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('dashboard', 'contacts'));
      } // if
      
      $delete_data = array_var($_POST, 'deleteContact');
      tpl_assign('contact', $contact);
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
          tpl_assign('error', new Error(lang('invalid password')));
          return $this->render();
        }
        try {

          DB::beginWork();
          $contact->delete();
          ApplicationLogs::createLog($contact, null, ApplicationLogs::ACTION_DELETE);
          DB::commit();

          flash_success(lang('success delete contact', $contact->getDisplayName()));

        } catch (Exception $e) {
          DB::rollback();
          flash_error(lang('error delete contact'));
        } // try

        $this->redirectToUrl($contact->getCompany()->getViewUrl());
      } else {
        flash_error(lang('error delete contact'));
        $this->redirectToUrl($contact->getCompany()->getViewUrl());
      }

    } // delete
    
    /**
    * Show contact card
    *
    * @access public
    * @param void
    * @return null
    */
    function card() {
      $this->setLayout('dashboard');
      
      $contact = Contacts::findById(get_id());
      if (!($contact instanceof Contact)) {
        flash_error(lang('contact dnx'));
        $this->redirectToReferer(get_url('dashboard', 'contacts'));
      } // if
      
      if (!logged_user()->canSeeContact($contact)) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('dashboard', 'contacts'));
      } // if
      
      tpl_assign('contact', $contact);
    } // card
  
    /**
    * Create and attach a user account to the contact
    * 
    * @access public
    * @param void
    * @return null
    */
    function add_user_account() {
      $this->setTemplate('add_user_to_contact');
      
      $contact = Contacts::findById(get_id());
      if (!($contact instanceof Contact)) {
        flash_error(lang('contact dnx'));
        $this->redirectTo('dashboard', 'contacts');
      } // if
      
      if (!$contact->canAddUserAccount(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard','contacts');
      } // if
      
      if ($contact->hasUserAccount()) {
        flash_error(lang('contact already has user'));
        $this->redirectToUrl($contact->getCardUrl());
      }
      
      $user = new User();
      $company = $contact->getCompany();
            
      $user_data = array_var($_POST, 'user');
      if (!is_array($user_data)) {
        $user_data = array(
          'email' => $contact->getEmail(),
          'password_generator' => 'random',
          'timezone' => $company->getTimezone(),
        ); // array
      } // if
      
      $projects = $company->getProjects();
      $permissions = PermissionManager::getPermissionsText();  
      
      tpl_assign('contact', $contact);
      tpl_assign('user', $user);
      tpl_assign('company', $company);
      tpl_assign('projects', $projects);
      tpl_assign('permissions', $permissions);
      tpl_assign('user_data', $user_data);
      
      if (is_array(array_var($_POST, 'user'))) {
        $user->setFromAttributes($user_data);
        
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
          $contact->setUserId($user->getId());
          $contact->save();
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
      
    } // add_user_account
    
    /**
    * Edit the contact's user account
    * 
    * @access public
    * @param void
    * @return null
    */
    function edit_user_account() {
      $this->setTemplate('add_user_to_contact');
      
      $contact = Contacts::findById(get_id());
      if (!($contact instanceof Contact)) {
        flash_error(lang('contact dnx'));
        $this->redirectTo('dashboard', 'contacts');
      } // if
      
      if (!$contact->canEditUserAccount(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard', 'contacts');
      } // if
      
      if (!$contact->hasUserAccount()) {
        flash_error(lang('user dnx'));
        $this->redirectToUrl($contact->getCompany()->getViewUrl());
      }
      
      $user = $contact->getUserAccount();
      $company = $contact->getCompany();
            
      $user_data = array_var($_POST, 'user');
      if (!is_array($user_data)) {
        $user_data = array(
          'username'     => $user->getUsername(),
          'email'        => $user->getEmail(),
          'timezone'     => $user->getTimezone(),
          'is_admin'     => $user->isAdministrator(),
          'auto_assign'  => $user->getAutoAssign(),
          'use_LDAP'     => $user->getUseLDAP(),
          'can_manage_projects' => $user->canManageProjects() ? '1' : '0'
        ); // array
      } // if
      
      tpl_assign('contact', $contact);
      tpl_assign('user', $user);
      tpl_assign('company', $company);
      tpl_assign('user_data', $user_data);
      
      if (is_array(array_var($_POST, 'user'))) {
        $user->setFromAttributes($user_data);
        
        try {
          $password = ''; 
          // Generate random password
          if (array_var($user_data, 'password_generator') == 'random') {
            $password = substr(sha1(uniqid(rand(), true)), rand(0, 25), 13);
            $user->setPassword($password);
            
          // Validate user input
          } else if (array_var($user_data, 'password_generator') == 'specify') {
            $password = array_var($user_data, 'password');
            if (trim($password) == '') {
              throw new Error(lang('password value required'));
            } // if
            if ($password <> array_var($user_data, 'password_a')) {
              throw new Error(lang('passwords dont match'));
            } // if
            $user->setPassword($password);
          } // if

          $granted = 0;
          if (logged_user()->isAdministrator()) {
            $user->setIsAdmin( array_var($user_data, 'is_admin') );
            $user->setAutoAssign( array_var($user_data, 'auto_assign') );
            $granted = (trim(array_var($user_data, 'can_manage_projects')) == '1') ? 1 : 0;
          } else {
            $user->setIsAdmin( 0 );
            $user->setAutoAssign( 0 );
          }
          
          DB::beginWork();
          $user->save();

          $user->setPermission(PermissionManager::CAN_MANAGE_PROJECTS, $granted);

          ApplicationLogs::createLog($user, null, ApplicationLogs::ACTION_EDIT);
          
          DB::commit();
          
          // Send notification...
          try {
            if (array_var($user_data, 'send_email_notification')) {
              Notifier::updatedUserAccount($user, $password);
            } // if
          } catch(Exception $e) {
          
          } // try
          
          flash_success(lang('success edit user', $user->getDisplayName()));
          $this->redirectToUrl($company->getViewUrl()); // Translate to profile page
          
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
        
      } // if
      
    } // edit_user_account
    
    /**
    * Delete the user account associated with that contact
    *
    * @param void
    * @return null
    */
    function delete_user_account() {
      $this->setTemplate('del_user_account');

      $contact = Contacts::findById(get_id());
      if (!($contact instanceof Contact)) {
        flash_error(lang('contact dnx'));
        $this->redirectTo('administration', 'contacts');
      } // if
      
      $user = $contact->getUserAccount();
      if (!($user instanceof User)) {
        flash_error(lang('user dnx'));
        $this->redirectTo('administration', 'contacts');
      } // if
      
      if (!$contact->canDeleteUserAccount(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('dashboard', 'contacts'));
      } // if
      
      $company = $contact->getCompany();
      
      $delete_data = array_var($_POST, 'deleteUser');
      tpl_assign('contact', $contact);
      tpl_assign('company', $company);
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
          tpl_assign('error', new Error(lang('invalid password')));
          return $this->render();
        }
        try {

          DB::beginWork();
          $user->delete();
          $contact->setUserId('0');
          $contact->save();
          ApplicationLogs::createLog($user, null, ApplicationLogs::ACTION_DELETE);
          DB::commit();

          flash_success(lang('success delete user', $user->getDisplayName()));

        } catch (Exception $e) {
          DB::rollback();
          flash_error(lang('error delete user'));
        } // try

        $this->redirectToUrl($company->getViewUrl());
      } else {
        flash_error(lang('error delete user'));
        $this->redirectToUrl($company->getViewUrl());
      }

    } // delete_user_account
    
    /**
    * Toggle favorite status
    *
    * @param void
    * @return null
    */
    function toggle_favorite() {
      if (!logged_user()->isAdministrator()) {
        flash_error('no access permisssions');
        $this->redirectToReferer(get_url('dashboard', 'index'));
      }

      $contact = Contacts::findById(get_id());
      if (!($contact instanceof Contact)) {
        flash_error(lang('contact dnx'));
        $this->redirectToReferer(get_url('administration', 'contacts'));
      } // if

      $contact->setIsFavorite(!$contact->isFavorite());

      if (!$contact->save()) {
        flash_error(lang('could not save info'));
      }
      
      $redirect_to = urldecode(array_var($_GET, 'redirect_to'));
      //if ((trim($redirect_to)) == '' || !is_valid_url($redirect_to)) {
      if (trim($redirect_to) == '') {
        $redirect_to = $contact->getCompany()->getViewUrl();
      } // if
      
      $this->redirectToUrl($redirect_to);
    } // toggleFavorite
    
  } // ContactsController

?>