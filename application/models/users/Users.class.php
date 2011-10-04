<?php

  /**
  * Users
  *
  * @http://www.projectpier.org/
  */
  class Users extends BaseUsers {
    
    /**
    * Return all users
    *
    * @param void
    * @return array
    */
    function getAll() {
      return self::findAll();
    } // getAll
    
    /**
    * Return user by username
    *
    * @access public
    * @param string $username
    * @return User
    */
    static function getByUsername($username) {
      return self::findOne(array(
        'conditions' => array('`username` = ?', $username)
      )); // array
    } // getByUsername
    
    /**
    * Return user object by email
    *
    * @param string $email
    * @return User
    */
    static function getByEmail($email) {
      return self::findOne(array(
        'conditions' => array('`email` = ?', $email)
      )); // findOne
    } // getByEmail
    
    /**
    * Return all users that was active in past $active_in minutes (defautl is 15 minutes)
    *
    * @access public
    * @param integer $active_in
    * @return array
    */
    static function getWhoIsOnline($active_in = 15) {
      if ((integer) $active_in < 1) {
        $active_in = 15;
      }
      
      $datetime = DateTimeValueLib::now();
      $datetime->advance(-1 * $active_in * 60);
      return Users::findAll(array(
        'conditions' => array('`last_activity` > ?', $datetime)
      )); // findAll
    } // getWhoIsOnline
    
    /**
    * Return user by token
    *
    * @param string $token
    * @return User
    */
    static function getByToken($token) {
      return self::findOne(array(
        'conditions' => array('`token` = ?', $token)
      )); // findOne
    } // getByToken
    
    /**
    * Check if specific token already exists in database
    *
    * @param string $token
    * @return boolean
    */
    static function tokenExists($token) {
      return self::count(array('`token` = ?', $token)) > 0;
    } // tokenExists
    
    /**
    * Return users grouped by company
    *
    * @param void
    * @return array
    */
    static function getGroupedByCompany() {
      $companies = Companies::getAll();
      if (!is_array($companies) || !count($companies)) {
        return null;
      } // if
      
      $result = array();
      foreach ($companies as $company) {
        $users = $company->getUsers();
        if (is_array($users) && count($users)) {
          $result[$company->getName()] = array(
            'details' => $company,
            'users' => $users,
          ); // array
        } // if
      } // foreach
      
      return count($result) ? $result : null;
    } // getGroupedByCompany
    
  } // Users 

?>