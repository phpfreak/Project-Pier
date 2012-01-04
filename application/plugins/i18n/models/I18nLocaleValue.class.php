<?php

  /**
  * I18NLocaleValue class
  *
  */
  class I18nLocaleValue extends BaseI18nLocaleValue {

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
    * Can add new locale value
    *
    * @param void
    * @return null
    */
    function canAdd(User $user) {
      return $user->isAdministrator() || $user->getId() == $this->getEditor();
    }
    
    /**
    * Can edit locale value
    *
    * @param void
    * @return null
    */
    function canEdit(User $user) {
      return $user->isAdministrator() || $user->getId() == $this->getEditor();
    }
    
    /**
    * Can delete locale value
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

    /**
    * Return edit locale value URL
    *
    * @param void
    * @return string
    */
    function getEditUrl() {
      return get_url('i18n', 'edit_values', array('id' => $this->getId()));
    } // getEditUrl

    /**
    * Return delete locale URL
    *
    * @param void
    * @return string
    */
    function getDeleteUrl() {
      return get_url('i18n', 'delete_value', array('id' => $this->getId()));
    } // getDeleteUrl
    
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
      return lang('i18n locale value');
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
    
  } // I18nLocaleValue

?>