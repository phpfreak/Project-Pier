<?php

  /**
  * This exception is thrown when we fail to save object because it failed 
  * to pass validation
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class DAOValidationError extends Error {
    
    /**
    * Object that we failed to save
    *
    * @var DataObject
    */
    private $object;
    
    /**
    * Array of validation errors
    *
    * @var array
    */
    private $errors;
  
    /**
    * Construct the DAOValidationError
    *
    * @access public
    * @param DataObject $object
    * @param array $errors Validation errors
    * @param string $message
    * @return DAOValidationError
    */
    function __construct($object, $errors, $message = null) {
      if (is_null($message)) {
        $message = 'Failed to save object because some of its properties are not valid';
      } // if
      
      parent::__construct($message);
      
      $this->setObject($object);
      $this->setErrors($errors);
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
        'object' => $this->getObject(),
        'errors' => $this->getErrors()
      ); // array
    } // getAdditionalParams
    
    /**
    * Get object
    *
    * @access public
    * @param null
    * @return DataObject
    */
    function getObject() {
      return $this->object;
    } // getObject
    
    /**
    * Set object value
    *
    * @access public
    * @param DataObject $value
    * @return null
    */
    function setObject($value) {
      $this->object = $value;
    } // setObject
    
    /**
    * Get errors
    *
    * @access public
    * @param null
    * @return array
    */
    function getErrors() {
      return $this->errors;
    } // getErrors
    
    /**
    * Set errors value
    *
    * @access public
    * @param array $value
    * @return null
    */
    function setErrors($value) {
      $this->errors = $value;
    } // setErrors
  
  } // DAOValidationError

?>