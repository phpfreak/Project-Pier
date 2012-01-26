<?php
  /**
  * BuiltinAuthenticator class
  *
  * This class will perform authentication for a user. 
  * The builtin authentication based on the Users table.
  * 
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class BuiltinAuthenticator {
    
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
    * @return User of false
    */
    function authenticate($login_data) {
      $username = array_var($login_data, 'username');
      $password = array_var($login_data, 'password');
        
      if (trim($username == '')) {
        throw new Error('username value missing');
      } // if
        
      if (trim($password) == '') {
        throw new Error('password value missing');
      } // if
        
      $user = Users::getByUsername($username, owner_company());
      if (!($user instanceof User)) {
        throw new Error('invalid login data');
      } // if
        
      if (!$user->isValidPassword($password)) {
        throw new Error('invalid login data');
      } // if

      //if (!$user->isDisabled()) {
      //  throw new Error('account disabled');
      //} // if

      return $user;
    } // authenticate
    
  }
?>