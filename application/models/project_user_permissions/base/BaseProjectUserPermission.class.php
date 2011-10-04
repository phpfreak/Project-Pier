<?php

  /**
  * BaseProjectUserPermission class
  *
  * @author Brett Edgar (TheWalrus) True Digital Security, Inc. www.truedigitalsecurity.com
  * @http://www.projectpier.org/
  */
  abstract class BaseProjectUserPermission extends DataObject {
  
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
    * Return value of 'permission_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getPermissionId() {
      return $this->getColumnValue('permission_id');
    } // getPermissionId()
    
    /**
    * Set value of 'permission_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setPermissionId($value) {
      return $this->setColumnValue('permission_id', $value);
    } // setPermissionId() 
    
    /**
    * Return manager instance
    *
    * @access protected
    * @param void
    * @return ProjectUsers 
    */
    function manager() {
      if (!($this->manager instanceof ProjectUserPermissions)) {
        $this->manager = ProjectUserPermissions::instance();
      }
      return $this->manager;
    } // manager
  
  } // BaseProjectUserPermission

?>