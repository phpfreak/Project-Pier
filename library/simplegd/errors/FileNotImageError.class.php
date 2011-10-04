<?php

  /**
  * This exception is thrown when script expects an image and receives path 
  * to some other file type
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class FileNotImageError extends Error {
  
    /**
    * Path of the file
    *
    * @var string
    */
    protected $file_path;
    
    /**
    * Construct the FileNotImageError
    *
    * @param string $file_path
    * @param string $message If NULL default message will be used
    * @return FileNotImageError
    */
    function __construct($file_path, $message = null) {
      if (is_null($message)) {
      	$message = "File '$file_path' is not an image";
      }
      parent::__construct($message);
      $this->setFilePath($file_path);
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
        'file path' => $this->getFilePath()
      ); // array
    } // getAdditionalParams
    
    // ---------------------------------------------------
    //  Getters and setter
    // ---------------------------------------------------
    
    /**
    * Get file_path
    *
    * @param null
    * @return string
    */
    function getFilePath() {
      return $this->file_path;
    } // getFilePath
    
    /**
    * Set file_path value
    *
    * @param string $value
    * @return null
    */
    function setFilePath($value) {
      $this->file_path = $value;
    } // setFilePath
  
  } // FileNotImageError

?>