<?php

  /**
  * BaseProjectFile class
  *
  * @http://www.projectpier.org/
  */
  abstract class BaseProjectFile extends ProjectDataObject {
  
    // -------------------------------------------------------
    //  Access methods
    // -------------------------------------------------------
  
    /**
    * Return value of 'id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getId() {
      return $this->getColumnValue('id');
    } // getId()
    
    /**
    * Set value of 'id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setId($value) {
      return $this->setColumnValue('id', $value);
    } // setId() 
    
    /**
    * Return value of 'project_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getProjectId() {
      return $this->getColumnValue('project_id');
    } // getProjectId()
    
    /**
    * Set value of 'project_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setProjectId($value) {
      return $this->setColumnValue('project_id', $value);
    } // setProjectId() 
    
    /**
    * Return value of 'folder_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getFolderId() {
      return $this->getColumnValue('folder_id');
    } // getFolderId()
    
    /**
    * Set value of 'folder_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setFolderId($value) {
      return $this->setColumnValue('folder_id', $value);
    } // setFolderId() 
    
    /**
    * Return value of 'filename' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getFilename() {
      return $this->getColumnValue('filename');
    } // getFilename()
    
    /**
    * Set value of 'filename' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setFilename($value) {
      return $this->setColumnValue('filename', $value);
    } // setFilename() 
    
    /**
    * Return value of 'description' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getDescription() {
      return $this->getColumnValue('description');
    } // getDescription()
    
    /**
    * Set value of 'description' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setDescription($value) {
      return $this->setColumnValue('description', $value);
    } // setDescription() 
    
    /**
    * Return value of 'is_private' field
    *
    * @access public
    * @param void
    * @return boolean 
    */
    function getIsPrivate() {
      return $this->getColumnValue('is_private');
    } // getIsPrivate()
    
    /**
    * Set value of 'is_private' field
    *
    * @access public   
    * @param boolean $value
    * @return boolean
    */
    function setIsPrivate($value) {
      return $this->setColumnValue('is_private', $value);
    } // setIsPrivate() 
    
    /**
    * Return value of 'is_important' field
    *
    * @access public
    * @param void
    * @return boolean 
    */
    function getIsImportant() {
      return $this->getColumnValue('is_important');
    } // getIsImportant()
    
    /**
    * Set value of 'is_important' field
    *
    * @access public   
    * @param boolean $value
    * @return boolean
    */
    function setIsImportant($value) {
      return $this->setColumnValue('is_important', $value);
    } // setIsImportant() 
    
    /**
    * Return value of 'is_locked' field
    *
    * @access public
    * @param void
    * @return boolean 
    */
    function getIsLocked() {
      return $this->getColumnValue('is_locked');
    } // getIsLocked()
    
    /**
    * Set value of 'is_locked' field
    *
    * @access public   
    * @param boolean $value
    * @return boolean
    */
    function setIsLocked($value) {
      return $this->setColumnValue('is_locked', $value);
    } // setIsLocked() 
    
    /**
    * Return value of 'is_visible' field
    *
    * @access public
    * @param void
    * @return boolean 
    */
    function getIsVisible() {
      return $this->getColumnValue('is_visible');
    } // getIsVisible()
    
    /**
    * Set value of 'is_visible' field
    *
    * @access public   
    * @param boolean $value
    * @return boolean
    */
    function setIsVisible($value) {
      return $this->setColumnValue('is_visible', $value);
    } // setIsVisible() 
    
    /**
    * Return value of 'expiration_time' field
    *
    * @access public
    * @param void
    * @return DateTimeValue 
    */
    function getExpirationTime() {
      return $this->getColumnValue('expiration_time');
    } // getExpirationTime()
    
    /**
    * Set value of 'expiration_time' field
    *
    * @access public   
    * @param DateTimeValue $value
    * @return boolean
    */
    function setExpirationTime($value) {
      return $this->setColumnValue('expiration_time', $value);
    } // setExpirationTime() 
    
    /**
    * Return value of 'comments_enabled' field
    *
    * @access public
    * @param void
    * @return boolean 
    */
    function getCommentsEnabled() {
      return $this->getColumnValue('comments_enabled');
    } // getCommentsEnabled()
    
    /**
    * Set value of 'comments_enabled' field
    *
    * @access public   
    * @param boolean $value
    * @return boolean
    */
    function setCommentsEnabled($value) {
      return $this->setColumnValue('comments_enabled', $value);
    } // setCommentsEnabled() 
    
    /**
    * Return value of 'anonymous_comments_enabled' field
    *
    * @access public
    * @param void
    * @return boolean 
    */
    function getAnonymousCommentsEnabled() {
      return $this->getColumnValue('anonymous_comments_enabled');
    } // getAnonymousCommentsEnabled()
    
    /**
    * Set value of 'anonymous_comments_enabled' field
    *
    * @access public   
    * @param boolean $value
    * @return boolean
    */
    function setAnonymousCommentsEnabled($value) {
      return $this->setColumnValue('anonymous_comments_enabled', $value);
    } // setAnonymousCommentsEnabled() 
    
    /**
    * Return value of 'created_on' field
    *
    * @access public
    * @param void
    * @return DateTimeValue 
    */
    function getCreatedOn() {
      return $this->getColumnValue('created_on');
    } // getCreatedOn()
    
    /**
    * Set value of 'created_on' field
    *
    * @access public   
    * @param DateTimeValue $value
    * @return boolean
    */
    function setCreatedOn($value) {
      return $this->setColumnValue('created_on', $value);
    } // setCreatedOn() 
    
    /**
    * Return value of 'created_by_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getCreatedById() {
      return $this->getColumnValue('created_by_id');
    } // getCreatedById()
    
    /**
    * Set value of 'created_by_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setCreatedById($value) {
      return $this->setColumnValue('created_by_id', $value);
    } // setCreatedById() 
    
    /**
    * Return value of 'updated_on' field
    *
    * @access public
    * @param void
    * @return DateTimeValue 
    */
    function getUpdatedOn() {
      return $this->getColumnValue('updated_on');
    } // getUpdatedOn()
    
    /**
    * Set value of 'updated_on' field
    *
    * @access public   
    * @param DateTimeValue $value
    * @return boolean
    */
    function setUpdatedOn($value) {
      return $this->setColumnValue('updated_on', $value);
    } // setUpdatedOn() 
    
    /**
    * Return value of 'updated_by_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getUpdatedById() {
      return $this->getColumnValue('updated_by_id');
    } // getUpdatedById()
    
    /**
    * Set value of 'updated_by_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setUpdatedById($value) {
      return $this->setColumnValue('updated_by_id', $value);
    } // setUpdatedById() 
    
    
    /**
    * Return manager instance
    *
    * @access protected
    * @param void
    * @return ProjectFiles 
    */
    function manager() {
      if (!($this->manager instanceof ProjectFiles)) {
        $this->manager = ProjectFiles::instance();
      }
      return $this->manager;
    } // manager
  
  } // BaseProjectFile 

?>