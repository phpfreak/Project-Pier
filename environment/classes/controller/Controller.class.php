<?php

  /**
  * Base controller class
  * 
  * This class is inherited by all script controllers. All methods of this class 
  * are reserved - there can't be actions with that names (for instance, there 
  * can't be execute actions in real controllers).
  *
  * @version 1.0
  * @http://www.projectpier.org/
  * @abstract
  */
  class Controller {
    
    /**
    * This controller name
    *
    * @var string
    */
    private $controller_name;
    
    /**
    * Action that was (or need to be) executed
    *
    * @var string
    */
    private $action;
    
    /**
    * System controller class. System controller class is class which methods
    * are reserved (can't be called). Basic system controllers are Controller and
    * PageController classes.
    *
    * @var string
    */
    private $system_controller_class;
    
    /**
    * Contruct controller and set controller name
    *
    * @access public
    * @param void
    * @return null
    */
    function __construct() {
      
      // Get controller name (tableized classname) and controller class
      $this->setControllerName( Env::getControllerName( get_class($this) ) );
      $this->setSystemControllerClass('Controller');
      
    } // __construct
    
    /**
    * Execute specific controller action
    *
    * @access public
    * @param string $action
    * @return InvalidControllerActionError if action name is not valid or true
    */
    function execute($action) {
      trace(__FILE__, "execute($action)" );
    
      // Prepare action name
      $action = trim(strtolower($action));
      
      // If we have valid action execute and done... Else throw exception
      if ($this->validAction($action)) {
        $this->setAction($action);
        trace(__FILE__, "execute($action) - {$action}()" );
        $this->$action();
        return true;
      } else {
        throw new InvalidControllerActionError($this->getControllerName(), $action);
      } // if
      
    } // execute
    
    /**
    * Forward to specific controller / action
    *
    * @access public
    * @param string $action
    * @param string $controller. If this value is NULL current controller will be
    *   used
    * @return null
    */
    function forward($action, $controller = null) {
      return empty($controller) ? $this->execute($action) : Env::executeAction($controller, $action);
    } // forward
    
    /**
    * Check if specific $action is valid controller action (method exists and it is not reserved)
    *
    * @access public
    * @param string $action
    * @return boolean or Error
    */
    function validAction($action) {
      
      // Get reserved names and check action name...
      $reserved_names = Controller::getReservedActionNames();
      if (is_array($reserved_names) && in_array($action, $reserved_names)) {
        return false;
      }
      
      // Get methods of this class...
      $methods = get_class_methods(get_class($this));
      
      // If we don't have defined action return false
      if (!in_array($action, $methods)) {
        return false;
      }
      
      // All fine...
      return true;
      
    } // validAction
    
    // -------------------------------------------------------
    // Getters and setters
    // -------------------------------------------------------
    
    /**
    * Get controller_name
    *
    * @access public
    * @param null
    * @return string
    */
    function getControllerName() {
      return $this->controller_name;
    } // getControllerName
    
    /**
    * Set controller_name value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setControllerName($value) {
      $this->controller_name = $value;
    } // setControllerName
    
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
    
    /**
    * Get system_controller_class
    *
    * @access public
    * @param null
    * @return string
    */
    function getSystemControllerClass() {
      return $this->system_controller_class;
    } // getSystemControllerClass
    
    /**
    * Set system_controller_class value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setSystemControllerClass($value) {
      $this->system_controller_class = $value;
    } // setSystemControllerClass
    
    /**
    * Return reserved action names (methods of controller class)
    *
    * @access private
    * @param void
    * @return arrays
    */
    function getReservedActionNames() {
      static $names;
      
      // Get and check controller class
      $controller_class = $this->getSystemControllerClass();
      if (!class_exists($controller_class)) {
        throw new Error("Controller class '$controller_class' does not exists");
      } // if
      
      // If we don't have names get them
      if (is_null($names)) {
        $names = get_class_methods($controller_class);
        foreach ($names as $k => $v) {
          $names[$k] = strtolower($v);
        }
      } // if
      
      // And return...
      return $names;
      
    } // getReservedActionNames

    /**
    * Define an action to take when an undefined method is called.
    *
    * @param name The name of the method that is undefined.
    * @param args Arguments passed to the undefined method.
    * @return throws UndefinedMethodException
    */
    function __call($name, $args) {
      trace(__FILE__,"__call($name,...) - undefined method");
      throw new UndefinedMethodException('Call to undefined method Controller::'.$name.'()',$name,$args);
    }
 
  } // Controller

?>