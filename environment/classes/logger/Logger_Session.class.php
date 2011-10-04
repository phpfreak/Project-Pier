<?php

  /**
  * Loggers sessions are sets of logged messages. They are introduces so logger can 
  * handle multiple events at the same time without mixing the messages
  *
  * @package Logger
  * @http://www.projectpier.org/
  */
  class Logger_Session {
  
    /**
    * Session name
    *
    * @var string
    */
    private $name;
    
    /**
    * Minimal severity that will be logged. In debug mode it would be Logger::DEBUG, in production it should be Logger::FATAL
    *
    * @var integer
    */
    private $min_severity;
    
    /**
    * Start time of the session
    *
    * @var float
    */
    private $session_start;
    
    /**
    * Array of log entries
    *
    * @var array
    */
    private $entries = array();
    
    /**
    * Constructor
    *
    * @param string $name Session name
    * @param integer $severity Min serverity that will be logged
    * @return Logger_Session
    */
    function __construct($name = Logger::DEFAULT_SESSION_NAME, $severity = Logger::DEBUG) {
      $this->setName($name);
      $this->setMinSeverity($severity);
      $this->session_start = microtime(true);
    } // __construct
    
    /**
    * Return true if this session is empty
    *
    * @param void
    * @return boolean
    */
    function isEmpty() {
      return count($this->entries) < 1;
    } // isEmpty
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get name
    *
    * @param null
    * @return string
    */
    function getName() {
      return $this->name;
    } // getName
    
    /**
    * Set name value
    *
    * @param string $value
    * @return null
    */
    function setName($value) {
      $this->name = $value;
    } // setName
    
    /**
    * Get min_severity
    *
    * @param null
    * @return integer
    */
    function getMinSeverity() {
      return $this->min_severity;
    } // getMinSeverity
    
    /**
    * Set min_severity value
    *
    * @param integer $value
    * @return null
    */
    function setMinSeverity($value) {
      $this->min_severity = $value;
    } // setMinSeverity
    
    /**
    * Return session start time (it is calculated in the constructor). Session start is unix 
    * timestamp with microtimes as part of the second
    *
    * @param void
    * @return float
    */
    function getSessionStart() {
      return $this->session_start;
    } // getSessionStart
    
    /**
    * Return entries
    *
    * @param void
    * @return array
    */
    function getEntries() {
      return $this->entries;
    } // getEntries
    
    /**
    * Add entry to the session
    *
    * @param Logger_Entry $entry
    * @return null
    */
    function addEntry(Logger_Entry $entry) {
      if ($entry->getSeverity() >= $this->getMinSeverity()) {
        $this->entries[] = $entry;
        return true;
      } // if
      return false;
    } // addEntry
  
  } // Logger_Session

?>