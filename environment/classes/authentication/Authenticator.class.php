<?php
  /**
  * Authenticator class
  *
  * This class will perform authentication for a user. 
  * Make custom authentication solution by subclassing.
  * 
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class Authenticator {
    
    /**
    * Construct the instance
    *
    * @access public
    * @return Localization
    */
    function __construct() {
    } // __construct
    
    /**
    * authenticate
    *
    * @param string $name
    * @param string $password
    * @return boolean
    */
    function authenticate() {
      throw new Error('no access allowed');
    } // lang
    
  }
?>