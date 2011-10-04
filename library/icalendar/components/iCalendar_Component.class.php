<?php

  /**
  * Base class of all iCalendar components
  *
  * @package iCalendar
  * @http://www.projectpier.org/
  */
  abstract class iCalendar_Component {
  
    /**
    * Names of valid properties. Names are uppercase
    *
    * @var array
    */
    private $valid_properties = array();
    
    /**
    * Classes of valid components. Names are in uppercase
    *
    * @var array
    */
    private $valid_components = array();
    
    /**
    * Name of this component (VCALENDAR, VEVENT, VTODO). This value is always uppercased
    *
    * @var string
    */
    private $name;
    
    /**
    * Array of property values (property name => property value)
    *
    * @var array
    */
    private $property_values = array();
    
    /**
    * Array of subcomponents for this specific component
    *
    * @var array
    */
    private $components = array();
    
    /**
    * Return specific property value
    *
    * @param string $property_name
    * @param mixed $default
    * @return mixed
    */
    function getPropertyValue($property_name, $default = null) {
      $search_for = strtoupper($property_name);
      return isset($this->property_values[$property_name]) ? $this->property_values[$property_name] : $default;
    } // getPropertyValue
    
    /**
    * Set value of specific property
    *
    * @param string $property_name
    * @param mixed $value
    * @param mixed $attributes Value attributes
    * @return void
    * @throws iCalendar_InvalidComponentPropertyError
    */
    function setPropertyValue($property_name, $value, $attributes = null) {
      $prepared_property_name = strtoupper($property_name);
      if (!$this->isValidProperty($prepared_property_name)) {
        throw new iCalendar_InvalidComponentPropertyError($this->getName(), $prepared_property_name);
      } // if
      $this->property_values[$property_name] = new iCalendar_PropertyValue($value, $attributes);
    } // setPropertyValue
    
    /**
    * Add new subcomponent to this component
    *
    * @param iCalendar_Component $component
    * @return null
    * @throws iCalendar_InvalidComponentSubcomponentError
    */
    function addComponent(iCalendar_Component $component) {
      if (!$this->isValidComponent($component)) {
        throw new iCalendar_InvalidComponentSubcomponentError($this->getName(), $component->getName());
      } // if
      $this->components[] = $component;
    } // addComponent
    
    /**
    * Check if specific property is valid in case of this component
    *
    * @param string $property_name
    * @return boolean
    */
    function isValidProperty($property_name) {
      $search_for = strtoupper($property_name);
      return str_starts_with($search_for, 'X-') || in_array($search_for, $this->valid_properties);
    } // isValidProperty
    
    /**
    * Check if $component is valid subcomponent
    *
    * @param iCalendar_Component $component
    * @return boolean
    */
    function isValidComponent(iCalendar_Component $component) {
      $search_for = $component->getName();
      return in_array($search_for, $this->valid_components);
    } // isValidComponent
    
    /**
    * Render this specific component
    *
    * @param void
    * @return string
    */
    function render() {
      $parts = array('BEGIN:' . $this->getName());
      //pre_var_dump($this->getName());
      
      // Render properties
      foreach ($this->property_values as $property => $value) {
        $parts[] = $value->render($property);
      } // foreach
      
      // Now render components
      foreach ($this->components as $component) {
        $parts[] = $component->render();
      } // foreach
      
      $parts[] = 'END:' . $this->getName();
      
      return implode("\r\n", $parts);
    } // render
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get valid_properties
    *
    * @param null
    * @return array
    */
    function getValidProperties() {
      return $this->valid_properties;
    } // getValidProperties
    
    /**
    * Set valid_properties value. Insert them like $this->setValidProperties('STATUS', 'CATEGORY', 'CLASS')
    *
    * @param null
    * @return null
    */
    function setValidProperties() {
      $value = func_get_args();
      if (is_array($value)) {
        foreach ($value as $k => $v) {
          $value[$k] = strtoupper($v);
        } // foreach
        $this->valid_properties = $value;
      } else {
        $this->valid_properties = array();
      } // if
    } // setValidProperties
    
    /**
    * Get valid_components
    *
    * @param null
    * @return array
    */
    function getValidComponents() {
      return $this->valid_components;
    } // getValidComponents
    
    /**
    * Set valid_components value. Input them like $this->setValidComponents('VEVENT', 'VCALENDAR')
    *
    * @param null
    * @return null
    */
    function setValidComponents() {
      $value = func_get_args();
      if (is_array($value)) {
        foreach ($value as $k => $v) {
          $value[$k] = strtoupper($v);
        } // foreach
        $this->valid_components = $value;
      } else {
        $this->valid_components;
      } // if
    } // setValidComponents
    
    /**
    * Get name
    *
    * @param null
    * @return string
    */
    function getName() {
      return $this->name;
    } // getName
    
    /**
    * Set name value
    *
    * @param string $value
    * @return null
    */
    protected function setName($value) {
      $this->name = strtoupper($value);
    } // setName
    
    /**
    * Return all property values
    *
    * @param void
    * @return array
    */
    function getPropertyValues() {
      return $this->property_values;
    } // getPropertyValues
    
    /**
    * Return all subcomponents
    *
    * @param void
    * @return array
    */
    function getComponents() {
      return $this->components;
    } // getComponents
  
  } // iCalendar_Component

?>