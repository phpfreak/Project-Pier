<?php

  /**
  * Error class
  * 
  * Errors are similar to exceptions in PHP5 but without some cool tricks
  * that build in error handling provides.
  *
  * @package havoc
  * @subpackage Base classes
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class Error extends Exception {
    
    /**
    * Return error params (name -> value pairs). General params are file and line
    * and any specific error have their own params...
    *
    * @access public
    * @param void
    * @return array
    */
    function getParams() {
      
      // Prepare base params...
      $base = array(
        'file' => $this->getFile(),
        'line' => $this->getLine()
      ); // array
      
      // Get additional params...
      $additional = $this->getAdditionalParams();
      
      // And return (join if we have additional params)
      return is_array($additional) ? array_merge($base, $additional) : $base;
      
    } // getParams
    
    /**
    * Return additional error params
    *
    * @access public
    * @param void
    * @return array
    */
    function getAdditionalParams() {
      return null;
    } // getAdditionalParams
  
  } // Error

?>