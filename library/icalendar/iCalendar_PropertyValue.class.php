<?php

  class iCalendar_PropertyValue {
  
    /**
    * Property value
    *
    * @var mixed
    */
    private $value;
    
    /**
    * Property attributes
    *
    * @var array
    */
    private $attributes = array();
    
    /**
    * Construct the iCalendar_PropertyValue
    *
    * @access public
    * @param void
    * @return iCalendar_PropertyValue
    */
    function __construct($value, $attributes = null) {
      $this->setValue($value);
      if (is_array($attributes)) {
        foreach ($attributes as $k => $v) {
          $this->setAttribute($k, $v);
        }
      } // if
    } // __construct
    
    /**
    * Return rendered property with property value
    *
    * @param string $property_name
    * @return null
    */
    function render($property_name) {
      $result = $property_name;
      if (count($this->getAttributes())) {
        foreach ($this->getAttributes() as $k => $v) {
          $result .= ';' . $k . '=' . $v;
        } // foreach
      } // if
      return $result . ':' . str_replace(array("\r\n", "\r", "\n"), array('\n', '\n', '\n'), $this->getValue());
    } // render
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get value
    *
    * @param null
    * @return mixed
    */
    function getValue() {
      return $this->value;
    } // getValue
    
    /**
    * Set value value
    *
    * @param mixed $value
    * @return null
    */
    function setValue($value) {
      $this->value = $value;
    } // setValue
    
    /**
    * Return all attributes
    *
    * @param void
    * @return array
    */
    function getAttributes() {
      return $this->attributes;
    } // getAttributes
    
    /**
    * Set attribute value
    *
    * @param string $name
    * @param string $value
    * @return null
    */
    function setAttribute($name, $value) {
      $this->attributes[strtoupper($name)] = $value;
    } // setAttribute
  
  } // iCalendar_PropertyValue

?>