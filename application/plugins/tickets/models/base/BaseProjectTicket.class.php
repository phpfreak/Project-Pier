<?php

  /**
  * BaseProjectTicket class
  *
  * @http://www.projectpier.org/
  */
  abstract class BaseProjectTicket extends ProjectDataObject {
  
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
    * Return value of 'milestone_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getMilestoneId() {
      return $this->getColumnValue('milestone_id');
    } // getMilestoneId()
    
    /**
    * Set value of 'milestone_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setMilestoneId($value) {
      return $this->setColumnValue('milestone_id', $value);
    } // setMilestoneId() 
    
    /**
    * Return value of 'category_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getCategoryId() {
      return $this->getColumnValue('category_id');
    } // getCategoryId()
    
    /**
    * Set value of 'category_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setCategoryId($value) {
      return $this->setColumnValue('category_id', $value);
    } // setCategoryId() 
    
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
    * Return value of 'closed_by_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getClosedById() {
      return $this->getColumnValue('closed_by_id');
    } // getClosedById()
    
    /**
    * Set value of 'closed_by_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setClosedById($value) {
      return $this->setColumnValue('closed_by_id', $value);
    } // getClosedById() 
    
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
    * Return value of 'summary' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getSummary() {
      return $this->getColumnValue('summary');
    } // getSummary()
    
    /**
    * Set value of 'summary' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setSummary($value) {
      return $this->setColumnValue('summary', $value);
    } // setSummary() 
    
    /**
    * Return value of 'type' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getType() {
      return $this->getColumnValue('type');
    } // getType()
    
    /**
    * Set value of 'type' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setType($value) {
      return $this->setColumnValue('type', $value);
    } // setType() 
    
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
    * Return value of 'priority' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getPriority() {
      return $this->getColumnValue('priority');
    } // getPriority()
    
    /**
    * Set value of 'priority' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setPriority($value) {
      return $this->setColumnValue('priority', $value);
    } // setPriority() 
    
    /**
    * Return value of 'state' field
    *
    * @access public
    * @param void
    * @return string 
    */
      function getState() {
      return $this->getColumnValue('state');
    } // getState()
  
    /**
    * Set value of 'state' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setState($value) {
      return $this->setColumnValue('state', $value);
    } // setState() 

    /**
    * Return value of 'created_on' field
    *
    * @access public
    * @param void
    * @return DateTimeValue 
    */
    function getDueDate() {
      return $this->getColumnValue('due_date');
    } // getDueDate()
    
    /**
    * Set value of 'created_on' field
    *
    * @access public   
    * @param DateTimeValue $value
    * @return boolean
    */
    function setDueDate($value) {
      return $this->setColumnValue('due_date', $value);
    } // setDueDate() 
  
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
    * Return value of 'closed_on' field
    *
    * @access public
    * @param void
    * @return DateTimeValue 
    */
    function getClosedOn() {
      return $this->getColumnValue('closed_on');
    } // getClosedOn()
    
    /**
    * Set value of 'closed_on' field
    *
    * @access public   
    * @param DateTimeValue $value
    * @return boolean
    */
    function setClosedOn($value) {
      return $this->setColumnValue('closed_on', $value);
    } // setClosedOn() 
    
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
    * Return value of 'updated' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getUpdated() {
      return $this->getColumnValue('updated');
    } // getUpdated()
    
    /**
    * Set value of 'updated' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setUpdated($value) {
      return $this->setColumnValue('updated', $value);
    } // setUpdated() 
    
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
    * @return ProjectTickets 
    */
    function manager() {
      if(!($this->manager instanceof ProjectTickets)) { 
        $this->manager = ProjectTickets::instance();
      }
      return $this->manager;
    } // manager
  
  } // BaseProjectTicket 

?>