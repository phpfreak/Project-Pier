<?php

  /**
  * Object container
  * 
  * Container that 
  *
  * @package turtle.base
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class ObjectContainer extends Container {
    
    /**
    * Name of the class that will be accepted
    *
    * @var string
    */
    private $accept_class;
  
    /**
    * Construct the ObjectContainer
    *
    * @access public
    * @param string $accept_class
    * @return ObjectContainer
    */
    function __construct($accept_class) {
      $this->setAcceptClass($accept_class);
    } // __construct
    
    /**
    * Set value of specific variable
    *
    * @access public
    * @param string $var Variable name
    * @param string $value Variable value
    * @return null
    * @throws InvalidInstanceException
    */
    public function set($var, $value) {
      
      // Get accept class
      $class = $this->getAcceptClass();
      
      // Check value instance...
      if (!($value instanceof $class)) {
        throw new InvalidInstanceException('$value', $value, $class);
      } // if
      
      // Set var...
      return parent::set($var, $value);
      
    } // set
    
    /**
    * Get accept_class
    *
    * @access public
    * @param null
    * @return string
    */
    function getAcceptClass() {
      return $this->accept_class;
    } // getAcceptClass
    
    /**
    * Set accept_class value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setAcceptClass($value) {
      $this->accept_class = $value;
    } // setAcceptClass
  
  } // ObjectContainer

?>