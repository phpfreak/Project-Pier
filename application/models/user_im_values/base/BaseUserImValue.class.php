<?php

  /**
  * BaseUserImValue class
  *
  * @http://www.projectpier.org/
  */
  abstract class BaseUserImValue extends DataObject {
  
    // -------------------------------------------------------
    //  Access methods
    // -------------------------------------------------------
  
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
    * Return value of 'im_type_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getImTypeId() {
      return $this->getColumnValue('im_type_id');
    } // getImTypeId()
    
    /**
    * Set value of 'im_type_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setImTypeId($value) {
      return $this->setColumnValue('im_type_id', $value);
    } // setImTypeId() 
    
    /**
    * Return value of 'value' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getValue() {
      return $this->getColumnValue('value');
    } // getValue()
    
    /**
    * Set value of 'value' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setValue($value) {
      return $this->setColumnValue('value', $value);
    } // setValue() 
    
    /**
    * Return value of 'is_default' field
    *
    * @access public
    * @param void
    * @return boolean 
    */
    function getIsDefault() {
      return $this->getColumnValue('is_default');
    } // getIsDefault()
    
    /**
    * Set value of 'is_default' field
    *
    * @access public   
    * @param boolean $value
    * @return boolean
    */
    function setIsDefault($value) {
      return $this->setColumnValue('is_default', $value);
    } // setIsDefault() 
    
    
    /**
    * Return manager instance
    *
    * @access protected
    * @param void
    * @return UserImValues 
    */
    function manager() {
      if (!($this->manager instanceof UserImValues)) {
        $this->manager = UserImValues::instance();
      }
      return $this->manager;
    } // manager
  
  } // BaseUserImValue 

?>