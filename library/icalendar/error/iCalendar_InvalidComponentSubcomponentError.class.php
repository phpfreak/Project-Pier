<?php

  /**
  * This error is thrown when user tries to add a unsupported subcomponent to specific component
  *
  * @package iCalendar
  * @http://www.projectpier.org/
  */
  class iCalendar_InvalidComponentSubcomponentError extends Error {
  
    /**
    * Component name
    *
    * @var string
    */
    private $component_name;
    
    /**
    * Subcomponent name
    *
    * @var string
    */
    private $subcomponent_name;
  
    /**
    * Construct the iCalendar_InvalidComponentSubcomponentError
    *
    * @access public
    * @param string $component_name
    * @param string $subcomponent_name
    * @param string $message
    * @return iCalendar_InvalidComponentSubcomponentError
    */
    function __construct($component_name, $subcomponent_name, $message = null) {
      if (is_null($message)) $message = "'$subcomponent_name' is not valid subcomponent of '$component_name'";
      parent::__construct($message);
      $this->setComponentName($component_name);
      $this->setSubcomponentName($subcomponent_name);
    } // __construct
    
    /**
    * Return additional error params
    *
    * @access public
    * @param void
    * @return array
    */
    function getAdditionalParams() {
      return array(
        'component name' => $this->getComponentName(),
        'subcomponent name' => $this->getSubcomponentName(),
      ); // array
    } // getAdditionalParams
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get componetn_name
    *
    * @param null
    * @return string
    */
    function getComponentName() {
      return $this->componetn_name;
    } // getComponentName
    
    /**
    * Set componetn_name value
    *
    * @param string $value
    * @return null
    */
    function setComponentName($value) {
      $this->componetn_name = $value;
    } // setComponentName
    
    /**
    * Get subcomponent_name
    *
    * @param null
    * @return string
    */
    function getSubcomponentName() {
      return $this->subcomponent_name;
    } // getSubcomponentName
    
    /**
    * Set subcomponent_name value
    *
    * @param string $value
    * @return null
    */
    function setSubcomponentName($value) {
      $this->subcomponent_name = $value;
    } // setSubcomponentName
  
  } // iCalendar_InvalidComponentSubcomponentError

?>