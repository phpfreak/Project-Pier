<?php

  /**
  * BaseProjectFolder class
  *
  * @http://www.projectpier.org/
  */
  abstract class BaseProjectFolder extends ProjectDataObject {
  
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
    * Return value of 'parent_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getParentId() {
      return $this->getColumnValue('parent_id');
    } // getParentId()
    
    /**
    * Set value of 'parent_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setParentId($value) {
      return $this->setColumnValue('parent_id', $value);
    } // setParentId() 

    /**
    * Return value of 'locked_by_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getLockedById() {
      return $this->getColumnValue('locked_by_id');
    } // getLockedById()
    
    /**
    * Set value of 'locked_by_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setLockedById($value) {
      return $this->setColumnValue('locked_by_id', $value);
    } // setLockedById() 
    
    /**
    * Return manager instance
    *
    * @access protected
    * @param void
    * @return ProjectFolders 
    */
    function manager() {
      if (!($this->manager instanceof ProjectFolders)) {
        $this->manager = ProjectFolders::instance();
      }
      return $this->manager;
    } // manager
  
  } // BaseProjectFolder 

?>