<?php

  /**
  * Small logging library. It supports loggin messages into multople sessions at the 
  * same time and multiple backends for storing logged messages
  *
  * @package Logger
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class Logger {
    
    /** Default session name **/
    const DEFAULT_SESSION_NAME = 'default';
    
    /** Severity **/
    const DEBUG   = 0;
    const INFO    = 1;
    const WARNING = 2;
    const ERROR   = 3;
    const FATAL   = 4;
    const UNKNOWN = 5;
  
    /**
    * Default backend
    *
    * @var Logger_Backend
    */
    static private $default_backend;
    
    /**
    * Array of additional, named backends
    *
    * @var array
    */
    static private $additional_backends = array();
    
    /**
    * Default log session
    *
    * @var Logger_Session
    */
    static private $default_session;
    
    /**
    * Array of additional log sessions
    *
    * @var array
    */
    static private $additional_sessions = array();
    
    /**
    * Logger is enabled
    *
    * @var boolean
    */
    static private $enabled = true;
    
    // ---------------------------------------------------
    //  Utils
    // ---------------------------------------------------
    
    /**
    * Log a message (this will create a Logger_Entry in $session_name session - NULL for default session)
    *
    * @param string $message
    * @return boolean
    * @throws InvalidParamError If we don't get session by $session_name
    */
    static function log($message, $severity = Logger::DEBUG, $session_name = null) {
      if (!self::$enabled) {
        return false;
      } // if
      
      if ($message instanceof Exception) {
        $message_to_log = $message->__toString();
      } else {
        $message_to_log = (string) $message;
      } // if
      
      $session = self::getSession($session_name);
      if (!($session instanceof Logger_Session)) {
        throw new InvalidParamError('session_name', $session_name, "There is no session matching this name (null for default session): " . var_export($session_name, true));
      } // if
      
      return $session->addEntry(new Logger_Entry($message_to_log, $severity));
    } // log
    
    /**
    * Seve single session into specific backend
    *
    * @param string $session_name
    * @param string $backend_name
    * @return boolean
    * @throws InvalidParamError If session $session_name does not exists
    * @throws InvalidParamError If backedn $backend_name does not exists
    */
    static function saveSession($session_name = null, $backend_name = null) {
      if (!self::$enabled) {
        return false;
      } // if
      
      $session = self::getSession($session_name);
      if (!($session instanceof Logger_Session)) {
        throw new InvalidParamError('session_name', $session_name, 'There is no session matching this name (null for default session): ' . var_export($session_name, true));
      } // if
      
      $backend = self::getBackend($backend_name);
      if (!($backend instanceof Logger_Backend)) {
        throw new InvalidParamError('backend_name', $backend_name, 'There is no backend matching this name (null for default backend): ' . var_export($session_name, true));
      } // if
      
      return $backend->saveSession($session);
    } // saveSession
    
    /**
    * Save all sessions into specific backend
    *
    * @param string $backend_name Backend name, NULL for default
    * @return boolean
    * @throws InvalidParamError If backedn $backend_name does not exists
    */
    static function saveAll($backend_name = null) {
      if (!self::$enabled) {
        return false;
      } // if
      
      $backend = self::getBackend($backend_name);
      if (!($backend instanceof Logger_Backend)) {
        throw new InvalidParamError('backend_name', $backend_name, 'There is no backend matching this name (null for default backend): ' . var_export($session_name, true));
      } // if
      
      return $backend->saveSessionSet(self::getAllSessions());
    } // saveAll
    
    /**
    * Convert sverity to string. If $severity is not recognized UNKNOWN is returned
    *
    * @param integer $severity
    * @return string
    */
    static function severityToString($severity) {
      switch ($severity) {
        case Logger::DEBUG:
          return 'DEBUG';
        case Logger::INFO:
          return 'INFO';
        case Logger::WARNING:
          return 'WARNING';
        case Logger::ERROR:
          return 'ERROR';
        case Logger::FATAL:
          return 'FATAL';
        default:
          return 'UNKNOWN';
      } // switch
    } // severityToString
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Return specific backend. If $name is not specific default backend will be returned
    *
    * @param string $name Backend name, leave blank to use default backend
    * @return Logger_Backend
    */
    static function getBackend($name = null) {
      return is_null($name) ? self::$default_backend : array_var(self::$additional_backends, $name);
    } // getBackend
    
    /**
    * Set backend. If $name is NULL default backend will be set
    *
    * @param Logger_Backend $backend
    * @param string $name Leave blank to set default backend
    * @return Logger_Backend
    */
    static function setBackend(Logger_Backend $backend, $name = null) {
      if (is_null($name)) {
        self::$default_backend = $backend;
      } else {
        self::$additional_backends[$name] = $backend;
      } // if
      return $backend;
    } // setBackend
    
    /**
    * Return session. If $name is NULL default session will be returned
    *
    * @param string $name
    * @return Logger_Session
    */
    static function getSession($name = null) {
      return is_null($name) ? self::$default_session : array_var(self::$additional_sessions, $name);
    } // getSession
    
    /**
    * Set logger session. If $name is NULL default session will be set
    *
    * @param Logger_Session $session
    * @param string $name Session name, if NULL default session will be set
    * @return null
    */
    static function setSession(Logger_Session $session, $name = null) {
      if (is_null($name)) {
        self::$default_session = $session;
      } else {
        self::$additional_sessions[$name] = $session;
      } // if
    } // setSession
    
    /**
    * Return all sessions (default + additional) as array
    *
    * @param void
    * @return array
    */
    static function getAllSessions() {
      $result = array();
      
      if (self::$default_session instanceof Logger_Session) {
        $result[] = self::$default_session;
      } // if
      
      if (count(self::$additional_sessions)) {
        return array_merge($result, self::$additional_sessions);
      } else {
        return $result;
      } // if
    } // getAllSessions
    
    /**
    * Get enabled
    *
    * @param null
    * @return boolean
    */
    static function getEnabled() {
      return self::$enabled;
    } // getEnabled
    
    /**
    * Set enabled value
    *
    * @param boolean $value
    * @return null
    */
    static function setEnabled($value) {
      self::$enabled = (boolean) $value;
    } // setEnabled
  
  } // Logger

?>