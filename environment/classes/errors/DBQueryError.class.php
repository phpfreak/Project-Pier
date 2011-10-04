<?php

  /**
  * Query error
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class DBQueryError extends Error {
  
    /**
    * SQL that broke
    *
    * @var string
    */
    private $sql;
    
    /**
    * Error number
    *
    * @var integer
    */
    private $error_number;
    
    /**
    * Error message
    *
    * @var string
    */
    private $error_message;
    
    /**
    * Construct the DBQueryError
    *
    * @access public
    * @param void
    * @return DBQueryError
    */
    function __construct($sql, $error_number, $error_message, $message = null) {
      
      // Prepare message
      if (is_null($message)) {
        $message = "Query failed with message '$error_message'";
      } // if
      
      // Construct
      parent::__construct($message);
      
      // Set data...
      $this->setSQL($sql);
      $this->setErrorNumber($error_number);
      $this->setErrorMessage($error_message);
      
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
        'sql' => $this->getSQL(),
        'error number' => $this->getErrorNumber(),
        'error message' => $this->getErrorMessage()
      ); // array
    } // getAdditionalParams
    
    /**
    * Get sql
    *
    * @access public
    * @param null
    * @return string
    */
    function getSQL() {
      return $this->sql;
    } // getSQL
    
    /**
    * Set sql value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setSQL($value) {
      $this->sql = $value;
    } // setSQL
    
    /**
    * Get error_number
    *
    * @access public
    * @param null
    * @return integer
    */
    function getErrorNumber() {
      return $this->error_number;
    } // getErrorNumber
    
    /**
    * Set error_number value
    *
    * @access public
    * @param integer $value
    * @return null
    */
    function setErrorNumber($value) {
      $this->error_number = $value;
    } // setErrorNumber
    
    /**
    * Get error_message
    *
    * @access public
    * @param null
    * @return string
    */
    function getErrorMessage() {
      return $this->error_message;
    } // getErrorMessage
    
    /**
    * Set error_message value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setErrorMessage($value) {
      $this->error_message = $value;
    } // setErrorMessage
  
  } // DBQueryError

?>