<?php

  /**
  * Single log entry
  *
  * @package Logger
  * @http://www.projectpier.org/
  */
  class Logger_Entry {
    
    /**
    * Entry message
    *
    * @var string
    */
    private $message;
    
    /**
    * Severity
    *
    * @var integer
    */
    private $severity;
    
    /**
    * Time when this entry is created. It is microtime, not a DateTime
    *
    * @var float
    */
    private $created_on;
  
    /**
    * Constructor
    *
    * @param void
    * @return Logger_Entry
    */
    function __construct($message, $severity = Logger::DEBUG) {
      $this->setMessage($message);
      $this->setSeverity($severity);
      $this->setCreatedOn(microtime(true));
    } // __construct
    
    /**
    * Return formated message
    *
    * @param string $new_line_prefix Prefix that is put in front of every new line (so multiline 
    * messages are indented and separated from the rest of the messages)
    * @return string
    */
    function getformattedMessage($new_line_prefix = '') {
      $message = $this->getMessage();
      $message = str_replace(array("\r\n", "\r"), array("\n", "\n"), $message);
      $message = str_replace("\n", "\n" . $new_line_prefix, $message);
      return $message;
    } // getformattedMessage
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get message
    *
    * @param null
    * @return string
    */
    function getMessage() {
      return $this->message;
    } // getMessage
    
    /**
    * Set message value
    *
    * @param string $value
    * @return null
    */
    function setMessage($value) {
      $this->message = $value;
    } // setMessage
    
    /**
    * Get severity
    *
    * @param null
    * @return integer
    */
    function getSeverity() {
      return $this->severity;
    } // getSeverity
    
    /**
    * Set severity value
    *
    * @param integer $value
    * @return null
    */
    function setSeverity($value) {
      $this->severity = $value;
    } // setSeverity
    
    /**
    * Get created_on
    *
    * @param null
    * @return float
    */
    function getCreatedOn() {
      return $this->created_on;
    } // getCreatedOn
    
    /**
    * Set created_on value
    *
    * @param float $value
    * @return null
    */
    protected function setCreatedOn($value) {
      $this->created_on = $value;
    } // setCreatedOn
  
  } // Logger_Entry

?>