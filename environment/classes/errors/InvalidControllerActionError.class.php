<?php

  /**
  * Invalid controller action error
  * 
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class InvalidControllerActionError extends Error {
    
    /**
    * Controller name
    *
    * @var string
    */
    private $controller;
    
    /**
    * Action name
    *
    * @var string
    */
    private $action;
  
    /**
    * Construct the InvalidControllerActionError
    *
    * @access public
    * @param string $controller Controller name
    * @param string $action Controller action
    * @param string $message Error message, if NULL default will be used
    * @return InvalidControllerActionError
    */
    function __construct($controller, $action, $message = null) {
      if (is_null($message)) {
        $message = "Invalid controller action $controller::$action()";
      } // if
      parent::__construct($message);
      
      $this->setController($controller);
      $this->setAction($action);
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
        'controller' => $this->getController(),
        'action' => $this->getAction()
      ); // array
    } // getAdditionalParams
    
    // -------------------------------------------------------
    // Getters and setters
    // -------------------------------------------------------
    
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
    
    /**
    * Get action
    *
    * @access public
    * @param null
    * @return string
    */
    function getAction() {
      return $this->action;
    } // getAction
    
    /**
    * Set action value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setAction($value) {
      $this->action = $value;
    } // setAction
  
  } // InvalidControllerActionError

?>