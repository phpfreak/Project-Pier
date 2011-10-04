<?php

  /**
  * This error is thrown when there are multiple errors with submitted data. This error 
  * is recognized by form_errors template and $errors field is displayed as a list of 
  * submission errors
  *
  * @http://www.projectpier.org/
  */
  class FormSubmissionErrors extends Error {
  
    /**
    * Array of submission errors
    *
    * @var array
    */
    private $errors;
    
    /**
    * Constructor
    *
    * @param array $errors Array of errors
    * @param string $message If NULL default message will be used
    * @return FormSubmissionErrors
    */
    function __construct($errors, $message = null) {
      if (is_null($message)) {
        $message = 'Form submission failed';
      } // if
      parent::__construct($message);
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
        'errors' => $this->getErrors(),
      ); // array
    } // getAdditionalParams
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get errors
    *
    * @param null
    * @return array
    */
    function getErrors() {
      return $this->errors;
    } // getErrors
    
    /**
    * Set errors value
    *
    * @param array $value
    * @return null
    */
    function setErrors($value) {
      if (is_array($value)) {
        $this->errors = $value;
      } else {
        throw new InvalidParamError('value', $value, 'Value should be an array of errors');
      } // if
    } // setErrors
  
  } // FormSubmissionErrors

?>