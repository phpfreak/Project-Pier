<?php

  /**
  * This error is thrown when users tries to set a value of invalid property for specific iCalendar component
  *
  * @package iCalendar
  * @http://www.projectpier.org/
  */
  class iCalendar_InvalidComponentPropertyError extends Error {
    
    /**
    * Component name
    *
    * @var string
    */
    private $component_name;
    
    /**
    * Property name
    *
    * @var string
    */
    private $property_name;
  
    /**
    * Construct the iCalendar_InvalidComponentPropertyError
    *
    * @access public
    * @param string $component_name
    * @param string $property_name
    * @param string $message
    * @return iCalendar_InvalidComponentPropertyError
    */
    function __construct($component_name, $property_name, $message = null) {
      if (is_null($message)) $message = "'$property_name' is not valid property of '$component_name'";
      parent::__construct($message);
      $this->setComponentName($component_name);
      $this->setPropertyName($property_name);
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
        'property name' => $this->getPropertyName(),
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
    * Get property_name
    *
    * @param null
    * @return string
    */
    function getPropertyName() {
      return $this->property_name;
    } // getPropertyName
    
    /**
    * Set property_name value
    *
    * @param string $value
    * @return null
    */
    function setPropertyName($value) {
      $this->property_name = $value;
    } // setPropertyName
  
  } // iCalendar_InvalidComponentPropertyError

?>