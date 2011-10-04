<?php

  /**
  * BaseConfigCategory class
  *
  * @http://www.projectpier.org/
  */
  abstract class BaseConfigCategory extends DataObject {
  
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
    * Return value of 'is_system' field
    *
    * @access public
    * @param void
    * @return boolean 
    */
    function getIsSystem() {
      return $this->getColumnValue('is_system');
    } // getIsSystem()
    
    /**
    * Set value of 'is_system' field
    *
    * @access public   
    * @param boolean $value
    * @return boolean
    */
    function setIsSystem($value) {
      return $this->setColumnValue('is_system', $value);
    } // setIsSystem() 
    
    /**
    * Return value of 'category_order' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getCategoryOrder() {
      return $this->getColumnValue('category_order');
    } // getCategoryOrder()
    
    /**
    * Set value of 'category_order' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setCategoryOrder($value) {
      return $this->setColumnValue('category_order', $value);
    } // setCategoryOrder() 
    
    
    /**
    * Return manager instance
    *
    * @access protected
    * @param void
    * @return ConfigCategories 
    */
    function manager() {
      if (!($this->manager instanceof ConfigCategories)) {
        $this->manager = ConfigCategories::instance();
      }
      return $this->manager;
    } // manager
  
  } // BaseConfigCategory 

?>