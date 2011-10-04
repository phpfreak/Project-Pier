<?php

  /**
  * Failed to load image from file
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class FailedToLoadImageError extends Error {
    
    /**
    * Path of the image
    *
    * @var string
    */
    protected $file_path;
  
    /**
    * Construct the FailedToLoadImageError
    *
    * @param string $file_path
    * @param string $message If NULL default message will be used
    * @return FileNotImageError
    */
    function __construct($file_path, $message = null) {
      if (is_null($message)) {
      	$message = "Failed to load image from '$file_path'";
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
  
  } // FailedToLoadImageError

?>