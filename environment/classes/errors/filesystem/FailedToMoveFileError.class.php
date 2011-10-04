<?php

  /**
  * This exception if thrown when we fail to move file from one location to 
  * another. It is usualy used when we move uploaded file from temp location 
  * to new location in the application
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class FailedToMoveFileError extends Error {
  
    /**
    * From path
    *
    * @var string
    */
    private $from_path;
    
    /**
    * Destination path
    *
    * @var string
    */
    private $to_path;
    
    /**
    * Construct the FailedToMoveFileError
    *
    * @access public
    * @param string $from_path
    * @param string $to_path
    * @param string $message If NULL default message will be used
    * @return FailedToMoveFileError
    */
    function __construct($from_path, $to_path, $message = null) {
      if (is_null($message)) {
        $message = "Failed to move file '$from_path' to '$to_path'";
      } // if
      parent::__construct($message);
      
      $this->setFromPath($from_path);
      $this->setToPath($to_path);
    } // __construct
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get from_path
    *
    * @access public
    * @param null
    * @return string
    */
    function getFromPath() {
      return $this->from_path;
    } // getFromPath
    
    /**
    * Set from_path value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setFromPath($value) {
      $this->from_path = $value;
    } // setFromPath
    
    /**
    * Get to_path
    *
    * @access public
    * @param null
    * @return string
    */
    function getToPath() {
      return $this->to_path;
    } // getToPath
    
    /**
    * Set to_path value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setToPath($value) {
      $this->to_path = $value;
    } // setToPath
  
  } // FailedToMoveFileError

?>