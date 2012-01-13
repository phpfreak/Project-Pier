<?php

  /**
  * I18nLocale class
  *
  */
  class I18nLocale extends BaseI18nLocale {

    /**
    * This type of object is taggable
    *
    * @var boolean
    */
    protected $is_taggable = false;
    
    /**
    * This type of object is searchable
    *
    * @var boolean
    */
    protected $is_searchable = false;
    
    /**
    * Array of searchable columns
    *
    * @var array
    */
    protected $searchable_columns = array('name', 'description');
    
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
    * Can add new locale
    *
    * @param void
    * @return null
    */
    function canAdd(User $user) {
      return $user->isAdministrator();
    }
    
    /**
    * Can edit locale
    *
    * @param void
    * @return null
    */
    function canEdit(User $user) {
      return $user->isAdministrator() || $user->getId() == $this->getEditor();
    }
    
    /**
    * Can delete locale
    *
    * @param void
    * @return null
    */
    function canDelete(User $user) {
      return $user->isAdministrator() || $user->getId() == $this->getEditor();
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
      if ($user->getId() == $this->getEditor()) {
        return true;
      } // if
      return false;
    } // canView

    // ---------------------------------------------------
    //  Loading
    // ---------------------------------------------------
    /**
    * copyValues
    *
    * @param boolean $replace Replace all values with the new values
    * @param integer $id Id of the locale to copy the values from
    * @return boolean
    */
    function copyValues($id, $replace) {
      return I18nLocaleValues::instance()->copy($id, $this->getId(), $replace);
    }

    /**
    * loadValues
    *
    * @param boolean $replace Replace all values with the new values
    * @param integer $locale Locale to use
    * @return boolean
    */
    function loadValues($locale, $replace) {
      return I18nLocaleValues::instance()->import($this->getId(), $locale, $replace);
    }

    /**
    * Return locale value identified by name
    *
    * @param string name
    * @return string
    */
    function getValue($name) {
      return I18nLocaleValues::instance()->getLocaleValue($this->getId(), $name);
    } // getEditUrl


    // ---------------------------------------------------
    //  Logo
    // ---------------------------------------------------
    
    /**
    * Set logo
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
    * Returns path of image. This function will not check if file really exists
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
    * Returns true if logo specified and logo file exists
    *
    * @access public
    * @param void
    * @return boolean
    */
    function hasLogo() {
      return trim($this->getLogoFile()) && is_file($this->getLogoPath());
    } // hasLogo
    
    /**
    * Return edit locale URL
    *
    * @param void
    * @return string
    */
    function getEditUrl() {
      return get_url('i18n', 'edit_locale', array('id' => $this->getId()));
    } // getEditUrl

    /**
    * Return edit locale logo URL
    *
    * @param void
    * @return string
    */
    function getEditLogoUrl() {
      return get_url('i18n', 'edit_logo', array('id' => $this->getId()));
    } // getEditLogoUrl

    /**
    * Return edit locale values URL
    *
    * @param void
    * @return string
    */
    function getEditValuesUrl() {
      return get_url('i18n', 'edit_values', array('id' => $this->getId()));
    } // getEditValuesUrl
        
    /**
    * Return load locale values URL
    *
    * @param void
    * @return string
    */
    function getLoadValuesUrl() {
      return get_url('i18n', 'load_values', array('id' => $this->getId()));
    } // getLoadValuesUrl
        
    /**
    * Return delete locale URL
    *
    * @param void
    * @return string
    */
    function getDeleteUrl() {
      return get_url('i18n', 'delete_locale', array('id' => $this->getId()));
    } // getEditUrl
    
    /**
    * Return delete locale logo URL
    *
    * @param void
    * @return string
    */
    function getDeleteLogoUrl() {
      return get_url('i18n', 'delete_logo', array('id' => $this->getId()));
    } // getDeleteLogoUrl

    /**
    * Return object name
    *
    * @param void
    * @return string
    */
    function getObjectName() {
      return $this->getName();
    }
    
    /**
    * Return object type name
    *
    * @param void
    * @return string
    */
    function getObjectTypeName() {
      return lang('i18n');
    } // getObjectTypeName

    /**
    * Return object URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getObjectUrl() {
      return get_url('i18n', 'index', array());
    } // getObjectUrl
    
  } // I18nLocale

?>	