<?php

  /**
  * BaseProjectCompany class
  *
  * @http://www.projectpier.org/
  */
  abstract class BaseProjectCompany extends DataObject {
  
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
    * Return value of 'company_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getCompanyId() {
      return $this->getColumnValue('company_id');
    } // getCompanyId()
    
    /**
    * Set value of 'company_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setCompanyId($value) {
      return $this->setColumnValue('company_id', $value);
    } // setCompanyId() 
    
    
    /**
    * Return manager instance
    *
    * @access protected
    * @param void
    * @return ProjectCompanies 
    */
    function manager() {
      if (!($this->manager instanceof ProjectCompanies)) {
        $this->manager = ProjectCompanies::instance();
      }
      return $this->manager;
    } // manager
  
  } // BaseProjectCompany 

?>