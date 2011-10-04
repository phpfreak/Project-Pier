<?php

  /**
  * BaseProjectForm class
  *
  * @http://www.projectpier.org/
  */
  abstract class BaseProjectForm extends ProjectDataObject {
  
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
    * Return value of 'success_message' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getSuccessMessage() {
      return $this->getColumnValue('success_message');
    } // getSuccessMessage()
    
    /**
    * Set value of 'success_message' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setSuccessMessage($value) {
      return $this->setColumnValue('success_message', $value);
    } // setSuccessMessage() 
    
    /**
    * Return value of 'action' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getAction() {
      return $this->getColumnValue('action');
    } // getAction()
    
    /**
    * Set value of 'action' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setAction($value) {
      return $this->setColumnValue('action', $value);
    } // setAction() 
    
    /**
    * Return value of 'in_object_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getInObjectId() {
      return $this->getColumnValue('in_object_id');
    } // getInObjectId()
    
    /**
    * Set value of 'in_object_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setInObjectId($value) {
      return $this->setColumnValue('in_object_id', $value);
    } // setInObjectId() 
    
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
    * Return value of 'is_enabled' field
    *
    * @access public
    * @param void
    * @return boolean 
    */
    function getIsEnabled() {
      return $this->getColumnValue('is_enabled');
    } // getIsEnabled()
    
    /**
    * Set value of 'is_enabled' field
    *
    * @access public   
    * @param boolean $value
    * @return boolean
    */
    function setIsEnabled($value) {
      return $this->setColumnValue('is_enabled', $value);
    } // setIsEnabled() 
    
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
    * @return ProjectForms 
    */
    function manager() {
      if (!($this->manager instanceof ProjectForms)) {
        $this->manager = ProjectForms::instance();
      }
      return $this->manager;
    } // manager
  
  } // BaseProjectForm 

?>