<?php

  /**
  * Invalid controller action error
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class InvalidInstanceError extends Error {
    
    /**
    * Name of the variable
    *
    * @var string
    */
    private $variable_name;
    
    /**
    * Value of the variable
    *
    * @var mixed
    */
    private $variable_value;
    
    /**
    * Expected classname
    *
    * @var string
    */
    private $expected_class;
  
    /**
    * Construct the InvalidInstanceError
    *
    * @access public
    * @param void
    * @return InvalidInstanceError
    */
    function __construct($var_name, $var_value, $expected_class, $message = null) {
      
      // Prepare message...
      if (is_null($message)) {
        $message = "$$var_name is not valid $expected_class instance";
      } // if
      
      // Inherit...
      parent::__construct($message);
      
      // Set vars...
      $this->setVariableName($var_name);
      $this->setVariableValue($var_value);
      $this->setExpectedClass($expected_class);
      
    } // __construct
    
    /**
    * Return errors specific params...
    *
    * @access public
    * @param void
    * @return array
    */
    function getAdditionalParams() {
      return array(
        'variable name' => $this->getVariableName(),
        'variable value' => $this->getVariableValue(),
        'expected class' => $this->getExpectedClass()
      ); // array
    } // getAdditionalParams
    
    // -------------------------------------------------------
    // Getters and setters
    // -------------------------------------------------------
    
    /**
    * Get variable_name
    *
    * @access public
    * @param null
    * @return string
    */
    function getVariableName() {
      return $this->variable_name;
    } // getVariableName
    
    /**
    * Set variable_name value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setVariableName($value) {
      $this->variable_name = $value;
    } // setVariableName
    
    /**
    * Get variable_value
    *
    * @access public
    * @param null
    * @return mixed
    */
    function getVariableValue() {
      return $this->variable_value;
    } // getVariableValue
    
    /**
    * Set variable_value value
    *
    * @access public
    * @param mixed $value
    * @return null
    */
    function setVariableValue($value) {
      $this->variable_value = $value;
    } // setVariableValue
    
    /**
    * Get expected_class
    *
    * @access public
    * @param null
    * @return string
    */
    function getExpectedClass() {
      return $this->expected_class;
    } // getExpectedClass
    
    /**
    * Set expected_class value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setExpectedClass($value) {
      $this->expected_class = $value;
    } // setExpectedClass
  
  } // InvalidInstanceError

?>