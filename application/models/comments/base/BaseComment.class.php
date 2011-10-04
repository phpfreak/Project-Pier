<?php

  /**
  * BaseComment class
  *
  * @http://www.projectpier.org/
  */
  abstract class BaseComment extends ProjectDataObject {
  
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
    * Return value of 'rel_object_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getRelObjectId() {
      return $this->getColumnValue('rel_object_id');
    } // getRelObjectId()
    
    /**
    * Set value of 'rel_object_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setRelObjectId($value) {
      return $this->setColumnValue('rel_object_id', $value);
    } // setRelObjectId() 
    
    /**
    * Return value of 'rel_object_manager' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getRelObjectManager() {
      return $this->getColumnValue('rel_object_manager');
    } // getRelObjectManager()
    
    /**
    * Set value of 'rel_object_manager' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setRelObjectManager($value) {
      return $this->setColumnValue('rel_object_manager', $value);
    } // setRelObjectManager() 
    
    /**
    * Return value of 'text' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getText() {
      return $this->getColumnValue('text');
    } // getText()
    
    /**
    * Set value of 'text' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setText($value) {
      return $this->setColumnValue('text', $value);
    } // setText() 
    
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
    * Return value of 'is_anonymous' field
    *
    * @access public
    * @param void
    * @return boolean 
    */
    function getIsAnonymous() {
      return $this->getColumnValue('is_anonymous');
    } // getIsAnonymous()
    
    /**
    * Set value of 'is_anonymous' field
    *
    * @access public   
    * @param boolean $value
    * @return boolean
    */
    function setIsAnonymous($value) {
      return $this->setColumnValue('is_anonymous', $value);
    } // setIsAnonymous() 
    
    /**
    * Return value of 'author_name' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getAuthorName() {
      return $this->getColumnValue('author_name');
    } // getAuthorName()
    
    /**
    * Set value of 'author_name' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setAuthorName($value) {
      return $this->setColumnValue('author_name', $value);
    } // setAuthorName() 
    
    /**
    * Return value of 'author_email' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getAuthorEmail() {
      return $this->getColumnValue('author_email');
    } // getAuthorEmail()
    
    /**
    * Set value of 'author_email' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setAuthorEmail($value) {
      return $this->setColumnValue('author_email', $value);
    } // setAuthorEmail() 
    
    /**
    * Return value of 'author_homepage' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getAuthorHomepage() {
      return $this->getColumnValue('author_homepage');
    } // getAuthorHomepage()
    
    /**
    * Set value of 'author_homepage' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setAuthorHomepage($value) {
      return $this->setColumnValue('author_homepage', $value);
    } // setAuthorHomepage() 
    
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
    * @return Comments 
    */
    function manager() {
      if (!($this->manager instanceof Comments)) {
        $this->manager = Comments::instance();
      }
      return $this->manager;
    } // manager
  
  } // BaseComment 

?>