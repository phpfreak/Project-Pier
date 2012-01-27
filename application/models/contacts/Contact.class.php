<?php

  /**
  * Contact class
  *
  * @http://www.projectpier.org/
  */
  class Contact extends BaseContact {
    
    /**
    * Cached associated user
    *
    * @var User
    */
    private $user = null;
    
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
    * If true this object will not throw object not taggable exception and will make tag methods available
    *
    * @var boolean
    */
    protected $is_taggable = true;
    
    /**
    * Check if this contact is member of specific company
    *
    * @access public
    * @param Company $company
    * @return boolean
    */
    function isMemberOf(Company $company) {
      return $this->getCompanyId() == $company->getId();
    } // isMemberOf
    
    /**
    * Usually we check if user is member of owner company so this is the shortcut method
    *
    * @param void
    * @return boolean
    */
    function isMemberOfOwnerCompany() {
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
      if ($this->getUserAccount()) {
        return $this->getUserAccount()->isAdministrator();
      }
      return false;
    } // isAdministrator
    
    /**
    * Account owner is user account that was created when company website is created
    *
    * @param void
    * @return boolean
    */
    function isAccountOwner() {
      if ($this->getUserAccount()) {
        return $this->getUserAccount()->isAccountOwner();
      }
      return false;
    } // isAccountOwner
    
    /**
    * Returns if contact is a favorite
    *
    * @param void
    * @return boolean
    */
    function isFavorite() {
      return $this->getIsFavorite();
    } // isFavorite

    /**
    * Returns true. Functions to accommodate tags on Contacts
    *
    * @param void
    * @return boolean
    */
    function isPrivate() {
      return false;
    } // isPrivate
    

        
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
      $company = Companies::findById($this->getCompanyId());
      if ($company) return $company;
      return new Company();
    } // getCompany
    
    /**
    * Return associated user account
    * 
    * @param void
    * @return User
    */
    function getUserAccount() {
      if (is_null($this->user)) {
        $this->user = Users::findById($this->getUserId());
      } // if
      return $this->user;
    } // getUser

    /**
    * True if contact has an associated user account
    *
    * @param void
    * @return boolean
    */
    function hasUserAccount() {
      return ($this->getUserAccount() ? true : false);
    } // hasUserAccount

    /**
    * Return display name for this account. If there is no display name associated username will be used
    *
    * @access public
    * @param void
    * @return string
    */
    function getDisplayName() {
      $display = parent::getDisplayName();
      return trim($display) == '' ? $this->getUserAccount()->getUsername() : $display;
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
    
    // ---------------------------------------------------
    //  IMs
    // ---------------------------------------------------
    
    /**
    * Return true if this contact have at least one IM address
    *
    * @access public
    * @param void
    * @return boolean
    */
    function hasImValue() {
      return ContactImValues::count('`contact_id` = ' . DB::escape($this->getId()));
    } // hasImValue
    
    /**
    * Return all IM values
    *
    * @access public
    * @param void
    * @return array
    */
    function getImValues() {
      return ContactImValues::getByContact($this);
    } // getImValues
    
    /**
    * Return value of specific IM. This function will return null if IM is not found
    *
    * @access public
    * @param ImType $im_type
    * @return string
    */
    function getImValue(ImType $im_type) {
      $im_value = ContactImValues::findById(array('contact_id' => $this->getId(), 'im_type_id' => $im_type->getId()));
      return $im_value instanceof ContactImValue && (trim($im_value->getValue()) <> '') ? $im_value->getValue() : null;
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
    * Return default contact IM type. If there is no default contact IM type NULL is returned
    *
    * @access public
    * @param void
    * @return ImType
    */
    function getDefaultImType() {
      return ContactImValues::getDefaultContactImType($this);
    } // getDefaultImType
    
    /**
    * Clear all IM values
    *
    * @access public
    * @param void
    * @return boolean
    */
    function clearImValues() {
      return ContactImValues::instance()->clearByContact($this);
    } // clearImValues
    
    // ---------------------------------------------------
    //  Avatars
    // ---------------------------------------------------
    
    /**
    * Set contact avatar from $source file
    *
    * @param string $source Source file
    * @param integer $max_width Max avatar width
    * @param integer $max_height Max avatar height
    * @param boolean $save Save contact object when done
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
      } catch (Exception $e) {
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
    * Check if this contact has uploaded an avatar
    *
    * @access public
    * @param void
    * @return boolean
    */
    function hasAvatar() {
      return (trim($this->getAvatarFile()) <> '') && is_file($this->getAvatarPath());
    } // hasAvatar
        
    // ---------------------------------------------------
    //  Permissions
    // ---------------------------------------------------
    
    /**
    * Can specific user add contact to specific company
    *
    * @access public
    * @param User $user
    * @param Company $to Can user add user to this company
    * @return boolean
    */
    function canAdd(User $user, Company $to = null) {
      if ($user->isAccountOwner()) {
        return true;
      } // if
      return $user->isAdministrator();
    } // canAdd
    
    /**
    * Check if specific user can update this contact
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canEdit(User $user) {
      if ($this->hasUserAccount() && $user->getId() == $this->getUserId()) {
        return true; // own profile
      } // if
      if ($user->isAccountOwner()) {
        return true;
      } // if
      return $user->isAdministrator();
    } // canEdit
    
    /**
    * Check if specific user can delete specific contact
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
    * Returns if this user can add a user account to that contact
    *
    * @param User $user
    * @return boolean
    */
    function canAddUserAccount(User $user) {
      if ($user->isAccountOwner()) {
        return true; // account owner can manage users
      } // if
      
      return $user->isAdministrator();
    } // canAddUserAccount
    
    /**
    * Returns if this user can edit the user account linked to that contact
    *
    * @param User $user
    * @return boolean
    */
    function canEditUserAccount(User $user) {
      if ($user->isAccountOwner()) {
        return true;
      } // if
      
      if ($this->getUserId() == $user->getId()) {
        return true;
      } // can edit your own user account
      
      return $user->isAdministrator();
    } // canEditUserAccount

    /**
    * Returns if this user can delete the user account linked to that contact
    *
    * @param User $user
    * @return boolean
    */
    function canDeleteUserAccount(User $user) {
      if ($this->isAccountOwner()) {
        return false; // can't delete accountowner
      } // if
      
      if ($this->getUserId() == $user->getId()) {
        return false;
      } // can not delete your own user account
      
      return $user->isAdministrator();
    } // canEditUserAccount
    
    /**
    * Check if specific user can update this profile
    *
    * @param User $user
    * @return boolean
    */
    function canUpdateProfile(User $user) {
      if ($this->hasUserAccount() && $this->getUserId() == $user->getId()) {
        return true;
      } // if
      if ($user->isAdministrator()) {
        return true;
      } // if
      return false;
    } // canUpdateProfile

    // ---------------------------------------------------
    //  URLs
    // ---------------------------------------------------
    
    // /**
    // * Return view account URL of this user
    // *
    // * @access public
    // * @param void
    // * @return string
    // */
    // function getAccountUrl() {
    //   return get_url('account', 'index');
    // } // getAccountUrl
    
    /**
    * Show contact card page
    *
    * @access public
    * @param void
    * @return null
    */
    function getCardUrl() {
      return get_url('contacts', 'card', $this->getId());
    } // getCardUrl
    
    /**
    * Return edit contact URL
    *
    * @access public
    * @param string $redirect_to URL where we need to redirect user when he updates contact
    * @return string
    */
    function getEditUrl($redirect_to = null) {
      $attributes = array('id' => $this->getId());
      if (trim($redirect_to) <> '') {
        $attributes['redirect_to'] = str_replace('&amp;', '&', trim($redirect_to));
      } // if

      return get_url('contacts', 'edit', $attributes);
    } // getEditUrl

    /**
    * Return edit contact URL
    *
    * @access public
    * @param string $redirect_to URL where we need to redirect user when he updates contact avatar
    * @return string
    */
    function getUpdateAvatarUrl($redirect_to = null) {
      $attributes = array('id' => $this->getId());
      if (trim($redirect_to) <> '') {
        $attributes['redirect_to'] = str_replace('&amp;', '&', trim($redirect_to));
      } // if

      return get_url('contacts', 'edit_avatar', $attributes);
    } // getEditUrl
    
    /**
    * Return delete contact URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getDeleteUrl() {
      return get_url('contacts', 'delete', $this->getId());
    } // getDeleteUrl
    
    /**
    * Returns URL to attach a User account to that contact
    *
    * @param void
    * @return string
    */
    function getAddUserAccountUrl() {
      return get_url('contacts', 'add_user_account', $this->getId());
    } // getAddUserUrl
    
    /**
    * Returns URL to edit User account linked to that contact
    *
    * @param void
    * @return string
    */
    function getEditUserAccountUrl() {
      return get_url('contacts', 'edit_user_account', $this->getId());
    } // getEditUserAccountUrl
    
    /**
    * Returns URL to delete User account linked to that contact
    *
    * @param void
    * @return string
    */
    function getDeleteUserAccountUrl() {
      return get_url('contacts', 'delete_user_account', $this->getId());
    } // getDeleteUserAccountUrl

    /**
    * Return toggle favorite URL
    *
    * @param void
    * @return string
    */
    function getToggleFavoriteUrl($redirect_to = null) {
      $attributes = array('id' => $this->getId());
      if (trim($redirect_to) <> '') {
        $attributes['redirect_to'] = str_replace('&amp;', '&', trim($redirect_to));
      } // if
      
      return get_url('contacts', 'toggle_favorite', $attributes);
    } // getToggleFavoriteUrl

    /**
    * Reserve parking space URL
    *
    * @access public
    * @param void
    * @return null
    */
    function getReserveParkingSpaceUrl() {
      return config_option('parking space reservation url', '').'?license_plate='.$this->getLicensePlate();
    } // getReserveParkingSpaceUrl

    /**
    * Show map page
    *
    * @access public
    * @param void
    * @return null
    */
    function getShowMapUrl() {
      $location = urlencode($this->getLocationDetails());
      $map_url = config_option('map url', 'http://maps.google.com?q=$location');
      $map_url = str_replace('$location', $location, $map_url);
      return $map_url;
    } // getShowMapUrl

    /**
    * Show route page
    *
    * @access public
    * @param void
    * @return null
    */
    function getShowRouteUrl($contact) {
      $to = '';
      if ($contact instanceof Contact) {
        $to = urlencode($contact->getLocationDetails());
      }
      $route_url = config_option('route url', 'http://maps.google.com?saddr=$from&daddr=$to');
      $route_url = str_replace('$to', $to, $route_url);
      $from = urlencode($this->getLocationDetails());
      $route_url = str_replace('$from', $from, $route_url);
      return $route_url;
    } // getShowRouteUrl
    
    // ---------------------------------------------------
    //  Tags
    // ---------------------------------------------------
    
    /**
    * Returns true if this project is taggable
    *
    * @param void
    * @return boolean
    */
    function isTaggable() {
      return $this->is_taggable;
    } // isTaggable
    
    /**
    * Return tags for this object
    *
    * @param void
    * @return array
    */
    function getTags() {
      if (plugin_active('tags')) {
        if (!$this->isTaggable()) {
          throw new Error('Object not taggable');
        }
        return Tags::getTagsByObject($this, get_class($this->manager()));
      }
      return array();
    } // getTags
    
    /**
    * Return tag names for this object
    *
    * @access public
    * @param void
    * @return array
    */
    function getTagNames() {
      if (plugin_active('tags')) {
        if (!$this->isTaggable()) {
          throw new Error('Object not taggable');
        } // if
        return Tags::getTagNamesByObject($this, get_class($this->manager()));
      }
      return array();
    } // getTagNames
    
    /**
    * Explode input string and set array of tags
    *
    * @param string $input
    * @return boolean
    */
    function setTagsFromCSV($input) {
      $tag_names = array();
      if (trim($input)) {
        $tag_names = explode(',', $input);
        foreach ($tag_names as $k => $v) {
          if (trim($v) <> '') {
            $tag_names[$k] = trim($v);
          } // if
        } // foreach
      } // if
      return $this->setTags($tag_names);
    } // setTagsFromCSV
    
    /**
    * Set object tags. This function accepts tags as params
    *
    * @access public
    * @param void
    * @return boolean
    */
    function setTags() {
      if (plugin_active('tags')) {
        if (!$this->isTaggable()) {
          throw new Error('Object not taggable');
        }
        $args = array_flat(func_get_args());
        return Tags::setObjectTags($args, $this, get_class($this->manager()), null);
      }
      return array();
    } // setTags
    
    /**
    * Clear object tags
    *
    * @access public
    * @param void
    * @return boolean
    */
    function clearTags() {
      if (plugin_active('tags')) {
        if (!$this->isTaggable()) {
          throw new Error('Object not taggable');
        }
        return Tags::clearObjectTags($this, get_class($this->manager()));
      }
      return array();
    } // clearTags
    
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
      
      // Validate display_name if present
      if (!$this->validatePresenceOf('display_name')) {
        $errors[] = lang('name value required');
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

      if ($this->isTaggable()) {
        $this->clearTags();
      } // if
      
      // TODO check all things that need to be deleted
      // ticket subscriptions
      // message subscriptions
      // project-user association

      $this->deleteAvatar();
      $this->clearImValues();
      if ($this->hasUserAccount()) {
        ProjectUsers::clearByUser($this->getUserAccount());
        MessageSubscriptions::clearByUser($this->getUserAccount());
        $this->getUserAccount()->delete();
      } // if
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
      return lang('contact');
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
  
  } // Contact 

?>