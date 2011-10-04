<?php

  /**
  * File does not exists exception
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class DirDnxError extends Error {
  
    /**
    * Path of the requested directory
    *
    * @var string
    */
    private $dir_path;
    
    /**
    * Construct the DirDnxError
    *
    * @access public
    * @param string $dir_path
    * @param string $message
    * @return DirDnxError
    */
    function __construct($dir_path, $message = null) {
      if (is_null($message)) {
        $message = "Directory '$dir_path' doesn't exists";
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
    
    // -------------------------------------------------------
    // Getters and setters
    // -------------------------------------------------------
    
    /**
    * Get dir_path
    *
    * @access public
    * @param null
    * @return string
    */
    function getDirPath() {
      return $this->dir_path;
    } // getDirPath
    
    /**
    * Set dir_path value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setDirPath($value) {
      $this->dir_path = $value;
    } // setDirPath
  
  } // DirDnxError

?>