<?php

  /**
  * BaseSearchableObject class
  *
  * @http://www.projectpier.org/
  */
  abstract class BaseSearchableObject extends DataObject {
  
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
    * Return value of 'column_name' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getColumnName() {
      return $this->getColumnValue('column_name');
    } // getColumnName()
    
    /**
    * Set value of 'column_name' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setColumnName($value) {
      return $this->setColumnValue('column_name', $value);
    } // setColumnName() 
    
    /**
    * Return value of 'content' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getContent() {
      return $this->getColumnValue('content');
    } // getContent()
    
    /**
    * Set value of 'content' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setContent($value) {
      return $this->setColumnValue('content', $value);
    } // setContent() 
    
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
    * Return manager instance
    *
    * @access protected
    * @param void
    * @return SearchableObjects 
    */
    function manager() {
      if (!($this->manager instanceof SearchableObjects)) {
        $this->manager = SearchableObjects::instance();
      }
      return $this->manager;
    } // manager
  
  } // BaseSearchableObject 

?>