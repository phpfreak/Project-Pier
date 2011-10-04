<?php

  /**
  * BaseProjectTask class
  *
  * @http://www.projectpier.org/
  */
  abstract class BaseProjectTask extends ProjectDataObject {
  
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
    * Return value of 'task_list_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getTaskListId() {
      return $this->getColumnValue('task_list_id');
    } // getTaskListId()
    
    /**
    * Set value of 'task_list_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setTaskListId($value) {
      return $this->setColumnValue('task_list_id', $value);
    } // setTaskListId() 
    
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
    * Return value of 'start_date' field
    *
    * @access public
    * @param void
    * @return DateTimeValue 
    */
    function getStartDate() {
      return $this->getColumnValue('start_date');
    } // getStartDate()
    
    /**
    * Set value of 'start_date' field
    *
    * @access public   
    * @param DateTimeValue $value
    * @return boolean
    */
    function setStartDate($value) {
      return $this->setColumnValue('start_date', $value);
    } // setStartDate() 

    /**
    * Return value of 'due_date' field
    *
    * @access public
    * @param void
    * @return DateTimeValue 
    */
    function getDueDate() {
      return $this->getColumnValue('due_date');
    } // getDueDate()
    
    /**
    * Set value of 'due_date' field
    *
    * @access public   
    * @param DateTimeValue $value
    * @return boolean
    */
    function setDueDate($value) {
      return $this->setColumnValue('due_date', $value);
    } // setDueDate() 

    /**
    * Return value of 'assigned_to_company_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getAssignedToCompanyId() {
      return $this->getColumnValue('assigned_to_company_id');
    } // getAssignedToCompanyId()
    
    /**
    * Set value of 'assigned_to_company_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setAssignedToCompanyId($value) {
      return $this->setColumnValue('assigned_to_company_id', $value);
    } // setAssignedToCompanyId() 
    
    /**
    * Return value of 'assigned_to_user_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getAssignedToUserId() {
      return $this->getColumnValue('assigned_to_user_id');
    } // getAssignedToUserId()
    
    /**
    * Set value of 'assigned_to_user_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setAssignedToUserId($value) {
      return $this->setColumnValue('assigned_to_user_id', $value);
    } // setAssignedToUserId() 
    
    /**
    * Return value of 'completed_on' field
    *
    * @access public
    * @param void
    * @return DateTimeValue 
    */
    function getCompletedOn() {
      return $this->getColumnValue('completed_on');
    } // getCompletedOn()
    
    /**
    * Set value of 'completed_on' field
    *
    * @access public   
    * @param DateTimeValue $value
    * @return boolean
    */
    function setCompletedOn($value) {
      return $this->setColumnValue('completed_on', $value);
    } // setCompletedOn() 
    
    /**
    * Return value of 'completed_by_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getCompletedById() {
      return $this->getColumnValue('completed_by_id');
    } // getCompletedById()
    
    /**
    * Set value of 'completed_by_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setCompletedById($value) {
      return $this->setColumnValue('completed_by_id', $value);
    } // setCompletedById() 
    
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
    * Return value of 'order' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getOrder() {
      return $this->getColumnValue('order');
    } // getOrder()
    
    /**
    * Set value of 'order' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setOrder($value) {
      return $this->setColumnValue('order', $value);
    } // setOrder() 
    
    
    /**
    * Return manager instance
    *
    * @access protected
    * @param void
    * @return ProjectTasks 
    */
    function manager() {
      if (!($this->manager instanceof ProjectTasks)) {
        $this->manager = ProjectTasks::instance();
      }
      return $this->manager;
    } // manager
  
  } // BaseProjectTask 

?>