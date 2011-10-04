<?php

  /**
  * Controller does not exists error, thrown when controller is missing
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class ControllerDnxError extends Error {
    
    /**
    * Controller name
    *
    * @var string
    */
    private $controller;
  
    /**
    * Construct the ControllerDnxError
    *
    * @access public
    * @param void
    * @return ControllerDnxError
    */
    function __construct($controller, $message = null) {
      
      // Prepare message
      if (is_null($message)) {
        $message = "Controller '$controller' is missing";
      } // if
      
      // Inherit...
      parent::__construct($message);
      
      // Set data...
      $this->setController($controller);
      
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
        'controller' => $this->getController()
      ); // array
    } // getAdditionalParams
    
    /**
    * Get controller
    *
    * @access public
    * @param null
    * @return string
    */
    function getController() {
      return $this->controller;
    } // getController
    
    /**
    * Set controller value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setController($value) {
      $this->controller = $value;
    } // setController
  
  } // ControllerDnxError

?>