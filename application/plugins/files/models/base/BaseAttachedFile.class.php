<?php

  /**
  * BaseAttachedFile class
  *
  * @http://www.projectpier.org/
  */
  abstract class BaseAttachedFile extends DataObject {
  
    // -------------------------------------------------------
    //  Access methods
    // -------------------------------------------------------
  
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
    * Return value of 'file_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getFileId() {
      return $this->getColumnValue('file_id');
    } // getFileId()
    
    /**
    * Set value of 'file_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setFileId($value) {
      return $this->setColumnValue('file_id', $value);
    } // setFileId() 
    
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
    * Return manager instance
    *
    * @access protected
    * @param void
    * @return AttachedFiles 
    */
    function manager() {
      if (!($this->manager instanceof AttachedFiles)) {
        $this->manager = AttachedFiles::instance();
      }
      return $this->manager;
    } // manager
  
  } // BaseAttachedFile 

?>