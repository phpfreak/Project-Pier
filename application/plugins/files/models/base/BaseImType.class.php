<?php

  /**
  * BaseImType class
  *
  * @http://www.projectpier.org/
  */
  abstract class BaseImType extends DataObject {
  
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
    * Return value of 'icon' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getIcon() {
      return $this->getColumnValue('icon');
    } // getIcon()
    
    /**
    * Set value of 'icon' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setIcon($value) {
      return $this->setColumnValue('icon', $value);
    } // setIcon() 
    
    
    /**
    * Return manager instance
    *
    * @access protected
    * @param void
    * @return ImTypes 
    */
    function manager() {
      if (!($this->manager instanceof ImTypes)) {
        $this->manager = ImTypes::instance();
      }
      return $this->manager;
    } // manager
  
  } // BaseImType 

?>