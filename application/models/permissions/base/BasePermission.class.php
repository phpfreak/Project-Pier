<?php

  /**
  * BasePermission class
  *
  * @author Brett Edgar (TheWalrus) True Digital Security, Inc. www.truedigitalsecurity.com
  * @http://www.projectpier.org/
  */
  abstract class BasePermission extends DataObject {
  
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
    * Return value of 'source' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getSource() {
      return $this->getColumnValue('source');
    } // getSource()
    
    /**
    * Set value of 'source' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setSource($value) {
      return $this->setColumnValue('source', $value);
    } // setSource() 
   
    /**
    * Return value of 'permission' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getName() {
      return $this->getColumnValue('permission');
    } // getName()
    
    /**
    * Set value of 'permission' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setName($value) {
      return $this->setColumnValue('permission', $value);
    } // setName() 
    
    /**
    * Return manager instance
    *
    * @access protected
    * @param void
    * @return Permissions 
    */
    function manager() {
      if (!($this->manager instanceof Permissions)) {
        $this->manager = Permissions::instance();
      }
      return $this->manager;
    } // manager
  
  } // BasePermission

?>