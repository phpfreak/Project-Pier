<?php

  /**
  * Base config handler. Config handlers are used for typecasting and rendering controls 
  * that represent single config options
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  abstract class ConfigHandler {
  
    /**
    * Config option that this handler is attached to (config options are used for handler contruction)
    *
    * @var ConfigOption
    */
    private $config_option;
    
    /**
    * Raw value
    *
    * @var mixed
    */
    private $raw_value;
    
    // ---------------------------------------------------
    //  Utils and abstract functions
    // ---------------------------------------------------
    
    /**
    * Get value
    *
    * @param null
    * @return mixed
    */
    function getValue() {
      return $this->rawToPhp($this->getRawValue());
    } // getValue
    
    /**
    * Set value value
    *
    * @param mixed $value
    * @return null
    */
    function setValue($value) {
      $this->setRawValue($this->phpToRaw($value));
    } // setValue
    
    /**
    * Render form control
    *
    * @param string $control_name
    * @return string
    */
    abstract function render($control_name);
    
    /**
    * Conver $value to raw value
    *
    * @param mixed $value
    * @return null
    */
    protected function phpToRaw($value) {
      return $value;
    } // phpToRaw
    
    /**
    * Convert raw value to php
    *
    * @param string $value
    * @return mixed
    */
    protected function rawToPhp($value) {
      return $value;
    } // rawToPhp
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get config_option
    *
    * @param null
    * @return ConfigOption
    */
    function getConfigOption() {
      return $this->config_option;
    } // getConfigOption
    
    /**
    * Set config_option value
    *
    * @param ConfigOption $value
    * @return null
    */
    function setConfigOption(ConfigOption $value) {
      $this->config_option = $value;
    } // setConfigOption
    
    /**
    * Get raw_value
    *
    * @param null
    * @return mixed
    */
    function getRawValue() {
      return $this->raw_value;
    } // getRawValue
    
    /**
    * Set raw_value value
    *
    * @param mixed $value
    * @return null
    */
    function setRawValue($value) {
      $this->raw_value = $value;
    } // setRawValue
    
  } // ConfigHandler

?>