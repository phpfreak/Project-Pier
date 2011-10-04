<?php

  /**
  * Logger backend that is able to save session data into a text file
  *
  * @package Logger
  * @subpackage backends
  * @http://www.projectpier.org/
  */
  class Logger_Backend_File implements Logger_Backend {
    
    /** New line **/
    const NEW_LINE = "\r\n";
    const SET_SEPARATOR = '===============================================================================';
    const SESSION_SEPARATOR = '-------------------------------------------------------------------------------';
  
    /**
    * Path of the log file. If file exists it need to be writable, if not parent 
    * folder need to exist and be writable
    *
    * @var string
    */
    private $log_file;
    
    /**
    * Constructor
    *
    * @param void
    * @return Logger_Backend_File
    */
    function __construct($log_file) {
      $this->setLogFile($log_file);
    } // __construct
    
    // ---------------------------------------------------
    //  Backend interface implementation and utils
    // ---------------------------------------------------
    
    /**
    * Save array of sessions into a single session set
    *
    * @param array $sessions
    * @return boolean
    */
    public function saveSessionSet($sessions) {
      if (!is_array($sessions)) {
        return false;
      } // if
      
      $session_names = array();
      $session_outputs = array();
      foreach ($sessions as $session) {
        if ($session instanceof Logger_Session) {
          $session_names[] = $session->getName();
          $session_outputs[] = $this->renderSessionContent($session);
        } // if
      } // if
      
      if (!count($session_names) || !count($session_outputs)) {
        return false;
      } // if
      
      $output = self::SET_SEPARATOR . self::NEW_LINE . 'Session set: ' . implode(', ', $session_names) . self::NEW_LINE . self::SET_SEPARATOR;
      foreach ($session_outputs as $session_output) {
        $output .= self::NEW_LINE . $session_output;
      } // foreach
      
      $output .= self::NEW_LINE . self::SET_SEPARATOR;
      return file_put_contents($this->getLogFile(), self::NEW_LINE . $output . self::NEW_LINE, FILE_APPEND);
    } // saveSessionSet
    
    /**
    * Save session object into the file
    *
    * @param Logger_Session $session
    * @return boolean
    */
    public function saveSession(Logger_Session $session) {
      $output = $this->renderSessionContent($session);
      return file_put_contents($this->getLogFile(), self::NEW_LINE . $output . self::NEW_LINE, FILE_APPEND);
    } // saveSession
    
    /**
    * Prepare session output as string
    *
    * @param Logger_Session $session
    * @return string
    */
    private function renderSessionContent(Logger_Session $session) {
      $session_executed_in = microtime(true) - $session->getSessionStart();
      $counter = 0;
      
      $output = 'Session "' . $session->getName() . '" started at ' . gmdate(DATE_ISO8601, floor($session->getSessionStart())) . "\n";
      if ($session->isEmpty()) {
        $output .= 'Empty session';
      } else {
        foreach ($session->getEntries() as $entry) {
          $counter++;
          $output .= "#$counter " . Logger::severityToString($entry->getSeverity()) . ': ' . $entry->getFormattedMessage('    ') . "\n";
        } // foreach
      } // if
      
      $output .= "Time since start: " . $session_executed_in . " seconds\n" . self::SESSION_SEPARATOR;
      return str_replace("\n", self::NEW_LINE, $output);
    } // renderSessionContent
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get log_file
    *
    * @param null
    * @return string
    */
    function getLogFile() {
      if (trim($this->log_file) && !is_file($this->log_file)) {
        file_put_contents($this->log_file, '<?php die(); ?>');
      } // if
      return $this->log_file;
    } // getLogFile
    
    /**
    * Set log_file value
    *
    * @param string $value
    * @return null
    * @throws FileNotWritableError If file exists and is not writable
    * @throws DirDnxError If file does not exists and parent directory does not exists
    * @throws DirNotWritableError If file does not exists, but parent exists and is not writable
    */
    function setLogFile($value) {
      $file_path = $value;
      if (is_file($file_path)) {
        if (!file_is_writable($file_path)) {
          throw new FileNotWritableError($file_path);
        } // if
      } else {
        $folder_path = dirname($file_path);
        if (!is_dir($folder_path)) {
          throw new DirDnxError($folder_path);
        } // if
        if (!folder_is_writable($folder_path)) {
          throw new DirNotWritableError($folder_path);
        } // if
      } // if
      $this->log_file = $value;
    } // setLogFile
  
  } // Logger_Backend_File

?>