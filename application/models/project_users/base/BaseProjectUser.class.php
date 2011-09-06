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
    * Return value of 'can_manage_messages' field
    *
    * @access public
    * @param void
    * @return boolean 
    */
    function getCanManageMessages() {
      return $this->getColumnValue('can_manage_messages');
    } // getCanManageMessages()
    
    /**
    * Set value of 'can_manage_messages' field
    *
    * @access public   
    * @param boolean $value
    * @return boolean
    */
    function setCanManageMessages($value) {
      return $this->setColumnValue('can_manage_messages', $value);
    } // setCanManageMessages() 
    
    /**
    * Return value of 'can_manage_tasks' field
    *
    * @access public
    * @param void
    * @return boolean 
    */
    function getCanManageTasks() {
      return $this->getColumnValue('can_manage_tasks');
    } // getCanManageTasks()
    
    /**
    * Set value of 'can_manage_tasks' field
    *
    * @access public   
    * @param boolean $value
    * @return boolean
    */
    function setCanManageTasks($value) {
      return $this->setColumnValue('can_manage_tasks', $value);
    } // setCanManageTasks() 
    
    /**
    * Return value of 'can_manage_milestones' field
    *
    * @access public
    * @param void
    * @return boolean 
    */
    function getCanManageMilestones() {
      return $this->getColumnValue('can_manage_milestones');
    } // getCanManageMilestones()
    
    /**
    * Set value of 'can_manage_milestones' field
    *
    * @access public   
    * @param boolean $value
    * @return boolean
    */
    function setCanManageMilestones($value) {
      return $this->setColumnValue('can_manage_milestones', $value);
    } // setCanManageMilestones() 
    
    /**
    * Return value of 'can_upload_files' field
    *
    * @access public
    * @param void
    * @return boolean 
    */
    function getCanUploadFiles() {
      return $this->getColumnValue('can_upload_files');
    } // getCanUploadFiles()
    
    /**
    * Set value of 'can_upload_files' field
    *
    * @access public   
    * @param boolean $value
    * @return boolean
    */
    function setCanUploadFiles($value) {
      return $this->setColumnValue('can_upload_files', $value);
    } // setCanUploadFiles() 
    
    /**
    * Return value of 'can_manage_files' field
    *
    * @access public
    * @param void
    * @return boolean 
    */
    function getCanManageFiles() {
      return $this->getColumnValue('can_manage_files');
    } // getCanManageFiles()
    
    /**
    * Set value of 'can_manage_files' field
    *
    * @access public   
    * @param boolean $value
    * @return boolean
    */
    function setCanManageFiles($value) {
      return $this->setColumnValue('can_manage_files', $value);
    } // setCanManageFiles() 
    
    /**
    * Return value of 'can_assign_to_owners' field
    *
    * @access public
    * @param void
    * @return boolean 
    */
    function getCanAssignToOwners() {
      return $this->getColumnValue('can_assign_to_owners');
    } // getCanAssignToOwners()
    
    /**
    * Set value of 'can_assign_to_owners' field
    *
    * @access public   
    * @param boolean $value
    * @return boolean
    */
    function setCanAssignToOwners($value) {
      return $this->setColumnValue('can_assign_to_owners', $value);
    } // setCanAssignToOwners() 
    
    /**
    * Return value of 'can_assign_to_other' field
    *
    * @access public
    * @param void
    * @return boolean 
    */
    function getCanAssignToOther() {
      return $this->getColumnValue('can_assign_to_other');
    } // getCanAssignToOther()
    
    /**
    * Set value of 'can_assign_to_other' field
    *
    * @access public   
    * @param boolean $value
    * @return boolean
    */
    function setCanAssignToOther($value) {
      return $this->setColumnValue('can_assign_to_other', $value);
    } // setCanAssignToOther() 
    
    
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
