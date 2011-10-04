<?php

  /**
  * This error is thrown when directory that need to be writable is not writable
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class DirNotWritableError extends Error {
    
    /**
    * Dir path
    *
    * @var string
    */
    private $dir_path;
  
    /**
    * Construct the DirNotWritable
    *
    * @access public
    * @param string $dir_path
    * @param string $message
    * @return DirNotWritable
    */
    function __construct($dir_path, $message = null) {
      if (is_null($message)) {
        $message = "Directory '$dir_path' is not writable by PHP";
      } // if
      parent::__construct($message);
      $this->setDirPath($dir_path);
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
        'dir path' => $this->getDirPath()
      ); // array
    } // getAdditionalParams
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get dir_path
    *
    * @param null
    * @return string
    */
    function getDirPath() {
      return $this->dir_path;
    } // getDirPath
    
    /**
    * Set dir_path value
    *
    * @param string $value
    * @return null
    */
    function setDirPath($value) {
      $this->dir_path = $value;
    } // setDirPath
  
  } // DirNotWritable

?>