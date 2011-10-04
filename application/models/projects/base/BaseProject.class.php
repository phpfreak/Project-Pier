<?php

  /**
  * BaseProject class
  *
  * @http://www.projectpier.org/
  */
  abstract class BaseProject extends ApplicationDataObject {
  //abstract class BaseProject extends ProjectDataObject {
  
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
    * Return value of 'parent_id' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getParentId() {
      return $this->getColumnValue('parent_id');
    } // getParent()
    
    /**
    * Set value of 'parent_id' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setParentId($value) {
      return $this->setColumnValue('parent_id', $value);
    } // setParentId() 
    
    /**
    * Return value of 'priority' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getPriority() {
      return $this->getColumnValue('priority');
    } // getPriority()
    
    /**
    * Set value of 'priority' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setPriority($value) {
      return $this->setColumnValue('priority', $value);
    } // setPriority() 
    
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
    * Return value of 'show_description_in_overview' field
    *
    * @access public
    * @param void
    * @return boolean 
    */
    function getShowDescriptionInOverview() {
      return $this->getColumnValue('show_description_in_overview');
    } // getShowDescriptionInOverview()
    
    /**
    * Set value of 'show_description_in_overview' field
    *
    * @access public   
    * @param boolean $value
    * @return boolean
    */
    function setShowDescriptionInOverview($value) {
      return $this->setColumnValue('show_description_in_overview', $value);
    } // setShowDescriptionInOverview() 

    /**
    * Return value of 'logo_file' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getLogoFile() {
      return $this->getColumnValue('logo_file');
    } // getLogoFile()
    
    /**
    * Set value of 'logo_file' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setLogoFile($value) {
      return $this->setColumnValue('logo_file', $value);
    } // setLogoFile() 
    
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
    * @return Projects 
    */
    function manager() {
      if (!($this->manager instanceof Projects)) {
        $this->manager = Projects::instance();
      }
      return $this->manager;
    } // manager
  
  } // BaseProject 

?>