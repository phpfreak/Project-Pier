<?php

  /**
  * BaseAdministrationTool class
  *
  * @http://www.projectpier.org/
  */
  abstract class BaseAdministrationTool extends DataObject {
  
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
    * Return value of 'controller' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getController() {
      return $this->getColumnValue('controller');
    } // getController()
    
    /**
    * Set value of 'controller' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setController($value) {
      return $this->setColumnValue('controller', $value);
    } // setController() 
    
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
    * @return AdministrationTools 
    */
    function manager() {
      if (!($this->manager instanceof AdministrationTools)) {
        $this->manager = AdministrationTools::instance();
      }
      return $this->manager;
    } // manager
  
  } // BaseAdministrationTool 

?>