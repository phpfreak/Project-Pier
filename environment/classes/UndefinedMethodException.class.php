<?php

  /**
  * UndefinedMethodException class
  * 
  * This exception is raised by the following classes when an undefined method
  * is called on the class or any of its children:
  * DataManager, DataObject, Controller
  *
  * @package env
  * @version 1.0
  * @http://www.projectpier.org/
  * @author Brett Edgar (The Walrus) brett.edgar@truedigitalsecurity.com
  */
  class UndefinedMethodException extends Exception {
      function __construct($message,$name,$args) {
	  parent::__construct($message,0);
      }

  } // UndefinedMethodException

?>