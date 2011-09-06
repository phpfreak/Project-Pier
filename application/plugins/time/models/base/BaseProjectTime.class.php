<?php

  /**
  * BaseProjectTime class
  *
  */
  abstract class BaseProjectTime extends ProjectDataObject {
  
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

// Attiks - BEGIN

// SQL: alter table ac_project_time add task_id int after project_id;
// SQL: alter table ac_project_time add task_list_id int after project_id;

/**
* Return value of 'task_id' field
*
* @access public
* @param void
* @return integer 
*/
function getTaskId() {
return $this->getColumnValue('task_id');
} // getTaskId()

/**
* Set value of 'task_id' field
*
* @access public   
* @param integer $value
* @return boolean
*/
function setTaskId($value) {
return $this->setColumnValue('task_id', $value);
} // setTaskId() 

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

// Attiks - END

    /**
    * Return value of 'name' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getName() {
      return $this->getColumnValue('name');
    } // getName()
    
    /**
    * Set value of 'name' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setName($value) {
      return $this->setColumnValue('name', $value);
    } // setName() 

    /**
    * Return value of 'hours' field
    *
    * @access public
    * @param void
    * @return string
    */
    function getHours() {
      return $this->getColumnValue('hours');
    } // getHours()

    /**
    * Set value of 'hours' field
    *
    * @access public
    * @param string $value
    * @return boolean
    */
    function setHours($value) {
      return $this->setColumnValue('hours', $value);
    } // setHours()
   
    /**
    * Return value of 'is_billable' field
    *
    * @access public
    * @param void
    * @return string
    */
    function getBillable() {
      return $this->getColumnValue('is_billable');
    } // getBillable()
    
    /**
    * Set value of 'is_billable' field
    *
    * @access public
    * @param string $value
    * @return boolean
    */
    function setBillable($value) {
      return $this->setColumnValue('is_billable', $value);
    } // setBillable()
 
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
    * Return value of 'done_date' field
    *
    * @access public
    * @param void
    * @return DateTimeValue 
    */
    function getDoneDate() {
      return $this->getColumnValue('done_date');
    } // getDoneDate()
    
    /**
    * Set value of 'done_date' field
    *
    * @access public   
    * @param DateTimeValue $value
    * @return boolean
    */
    function setDoneDate($value) {
      return $this->setColumnValue('done_date', $value);
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
    * Return value of 'is_closed' field
    *
    * @access public
    * @param void
    * @return boolean 
    */
    function getIsClosed() {
      return $this->getColumnValue('is_closed');
    } // getIsClosed()
    
    /**
    * Set value of 'is_closed' field
    *
    * @access public   
    * @param boolean $value
    * @return boolean
    */
    function setIsClosed($value) {
      return $this->setColumnValue('is_closed', $value);
    } // setIsClosed() 
    
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
    * Return manager instance
    *
    * @access protected
    * @param void
    * @return ProjectTimes
    */
    function manager() {
      if(!($this->manager instanceof ProjectTimes)) $this->manager = ProjectTimes::instance();
      return $this->manager;
    } // manager
  
  } // BaseProjectTime

?>