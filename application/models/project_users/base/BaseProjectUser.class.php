<?php

  /**
  * BaseProjectUser class
  *
  * @http://www.projectpier.org/
  */
  abstract class BaseProjectUser extends DataObject {
  
    // -------------------------------------------------------
    //  Access methods
    // -------------------------------------------------------
  
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
    * Return value of 'user_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getUserId() {
      return $this->getColumnValue('user_id');
    } // getUserId()
    
    /**
    * Set value of 'user_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setUserId($value) {
      return $this->setColumnValue('user_id', $value);
    } // setUserId() 

    /**
    * Return value of 'note' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getNote() {
      return $this->getColumnValue('note');
    } // getNote()
    
    /**
    * Set value of 'note' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setNote($value) {
      return $this->setColumnValue('note', $value);
    } // setNote() 
        
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
    * @return ProjectUsers 
    */
    function manager() {
      if (!($this->manager instanceof ProjectUsers)) {
        $this->manager = ProjectUsers::instance();
      }
      return $this->manager;
    } // manager
  
  } // BaseProjectUser 

?>