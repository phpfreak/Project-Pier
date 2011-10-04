<?php

  /**
  * Database connection error
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class DBConnectError extends Error {
    
    /**
    * Hostname
    *
    * @var string
    */
    private $host;
    
    /**
    * Username
    *
    * @var string
    */
    private $user;
    
    /**
    * Password
    *
    * @var string
    */
    private $pass;
    
    /**
    * Database name
    *
    * @var string
    */
    private $database;
  
    /**
    * Construct the DBConnectError
    *
    * @access public
    * @param string $dsn Connection string (URL)
    * @param string $message
    * @return DBConnectError
    */
    function __construct($host, $user, $pass, $database, $message = null) {
      if (is_null($message)) {
        $message = "Failed to connect to database";
      } // if
      parent::__construct($message);
      
      $this->setHost($host);
      $this->setUser($user);
      $this->setPassword($pass);
      $this->setDatabase($database);
    } // __construct
    
    /**
    * Return errors specific params...
    *
    * @access public
    * @param void
    * @return array
    */
    function getAdditionalParams() {
      return array();
    } // getAdditionalParams
    
    /**
    * Get host
    *
    * @access public
    * @param null
    * @return string
    */
    function getHost() {
      return $this->host;
    } // getHost
    
    /**
    * Set host value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setHost($value) {
      $this->host = $value;
    } // setHost
    
    /**
    * Get user
    *
    * @access public
    * @param null
    * @return string
    */
    function getUser() {
      return $this->user;
    } // getUser
    
    /**
    * Set user value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setUser($value) {
      $this->user = $value;
    } // setUser
    
    /**
    * Get pass
    *
    * @access public
    * @param null
    * @return string
    */
    function getPassword() {
      return $this->pass;
    } // getPassword
    
    /**
    * Set pass value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setPassword($value) {
      $this->pass = $value;
    } // setPassword
    
    /**
    * Get database
    *
    * @access public
    * @param null
    * @return string
    */
    function getDatabase() {
      return $this->database;
    } // getDatabase
    
    /**
    * Set database value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setDatabase($value) {
      $this->database = $value;
    } // setDatabase
  
  } // DBConnectError

?>