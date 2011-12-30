<?php

  /**
  * ProjectLink class
  *
  * @http://www.activeingredient.com.au
  */
  class ProjectLink extends BaseProjectLink {

    /**
    * This type of object is taggable
    *
    * @var boolean
    */
    protected $is_taggable = true;
    
    /**
    * This type of object is searchable
    *
    * @var boolean
    */
    protected $is_searchable = true;
    
    /**
    * Array of searchable columns
    *
    * @var array
    */
    protected $searchable_columns = array('title', 'description');
    
    /**
    * This type of object is commentable
    *
    * @var boolean
    */
    protected $is_commentable = false;
    
    /**
    * This type of object is a file container
    *
    * @var boolean
    */
    protected $is_file_container = false;
    
    /**
    * This type of object is subscribable
    *
    * @var boolean
    */
    protected $is_subscribable = false;
    
    /**
    * asUrl
    *
    * @param void
    * @return null
    */
    function asUrl() {
      $url = trim($this->getUrl());
      if (strlen($url)>0) {
        if (substr($url, 0, 1) == '/') return $url;
        if (strlen($url)>1) {
          if (substr($url, 1, 1) == ':') return "file://$url";
        }
        $i = strpos($url, '://');
        if ($i === false ) {
          $url = "http://$url";
        }
      } 
      return $url;
    }

    /**
    * Return parent project instance
    *
    * @param void
    * @return Project
    */
    function getProject() {
      if (is_null($this->project)) {
        $this->project = Projects::findById($this->getProjectId());
      } // if
      return $this->project;
    } // getProject
    
    /**
    * Add new link
    *
    * @param void
    * @return null
    */
    function canAdd(User $user, Project $project) {
      return $user->isAdministrator() || $user->isMemberOfOwnerCompany() || $user->isProjectUser(active_project());
    }
    
    /**
    * Edit link
    *
    * @param void
    * @return null
    */
    function canEdit(User $user) {
      return $user->isAdministrator() || $user->isMemberOfOwnerCompany() || $user->isProjectUser(active_project());
    }
    
    /**
    * Delete link
    *
    * @param void
    * @return null
    */
    function canDelete(User $user) {
      return $user->isAdministrator() || $user->isMemberOfOwnerCompany() || $user->isProjectUser(active_project());
    }
    
    /**
    * Does user have view access
    *
    * @param void
    * @return boolean
    */
    function canView(User $user) {
      if ($user->isAdministrator() || $user->isMemberOfOwnerCompany()) {
        return true;
      } // if
      if ($user->isProjectUser($this->getProject())) {
        return true;
      } // if
      return false;
    } // canView

    // ---------------------------------------------------
    //  Logo
    // ---------------------------------------------------
    
    /**
    * Set logo value
    *
    * @param string $source Source file
    * @param integer $max_width
    * @param integer $max_height
    * @param boolean $save Save object when done
    * @return null
    */
    function setLogo($source, $max_width = 50, $max_height = 50, $save = true) {
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
          $this->setLogoFile($public_filename);
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
    } // setLogo
    
    /**
    * Delete logo
    *
    * @param void
    * @return null
    */
    function deleteLogo() {
      if ($this->hasLogo()) {
        PublicFiles::deleteFile($this->getLogoFile());
        $this->setLogoFile('');
      } // if
    } // deleteLogo
    
    /**
    * Returns path of company logo. This function will not check if file really exists
    *
    * @access public
    * @param void
    * @return string
    */
    function getLogoPath() {
      return PublicFiles::getFilePath($this->getLogoFile());
    } // getLogoPath
    
    /**
    * description
    *
    * @access public
    * @param void
    * @return string
    */
    function getLogoUrl() {
      return $this->hasLogo() ? PublicFiles::getFileUrl($this->getLogoFile()) : get_image_url('logo.gif');
    } // getLogoUrl
    
    /**
    * Returns true if this company have logo file value and logo file exists
    *
    * @access public
    * @param void
    * @return boolean
    */
    function hasLogo() {
      return trim($this->getLogoFile()) && is_file($this->getLogoPath());
    } // hasLogo
    
    /**
    * Return edit link URL
    *
    * @param void
    * @return string
    */
    function getEditUrl() {
      return get_url('links', 'edit_link', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getEditUrl

    /**
    * Return edit link logo URL
    *
    * @param void
    * @return string
    */
    function getEditLogoUrl() {
      return get_url('links', 'edit_logo', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getEditLogoUrl
        
    /**
    * Return delete link URL
    *
    * @param void
    * @return string
    */
    function getDeleteUrl() {
      return get_url('links', 'delete_link', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getEditUrl
    
    /**
    * Return object name
    *
    * @param void
    * @return string
    */
    function getObjectName() {
      return $this->getTitle();
    }
    
    /**
    * Return object type name
    *
    * @param void
    * @return string
    */
    function getObjectTypeName() {
      return lang('link');
    } // getObjectTypeName

    /**
    * Return object URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getObjectUrl() {
      return get_url('links', 'index', array('active_project' => $this->getProjectId()));
    } // getObjectUrl
    
  } // ProjectLink 

?>