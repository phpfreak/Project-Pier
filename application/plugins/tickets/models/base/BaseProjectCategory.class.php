<?php

  /**
  * BaseProjectCategory class
  *
  * @http://www.projectpier.org/
  */
  abstract class BaseProjectCategory extends ProjectDataObject {
  
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
  * @return integer 
  */
  function getName() {
    return $this->getColumnValue('name');
  } // getName()
    
  /**
  * Set value of 'name' field
  *
  * @access public   
  * @param integer $value
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
  * Return manager instance
  *
  * @access protected
  * @param void
  * @return ProjectCategories
  */
  function manager() {
    if(!($this->manager instanceof ProjectCategories)) { 
      $this->manager = ProjectCategories::instance();
    }
    return $this->manager;
  } // manager
 
  } // BaseProjectCategory 

?>