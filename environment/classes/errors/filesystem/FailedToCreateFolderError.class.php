<?php

  /**
  * This exception is thrown when script fail to create specific folder
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class FailedToCreateFolderError extends Error {
    
    /**
    * Failed to create this path
    *
    * @var string
    */
    private $folder_path;
  
    /**
    * Construct the FailedToCreateFolderError
    *
    * @access public
    * @param string $folder_path
    * @param string $message If NULL default message will be used
    * @return FailedToCreateFolderError
    */
    function __construct($folder_path, $message = null) {
      if (is_null($message)) {
        $message = "Failed to create folder '$folder_path'";
      } // if
      parent::__construct($message);
      $this->setFolderPath($folder_path);
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
        'folder path' => $this->getfolderPath()
      ); // array
    } // getAdditionalParams
    
    // -------------------------------------------------------
    // Getters and setters
    // -------------------------------------------------------
    
    /**
    * Get folder_path
    *
    * @access public
    * @param null
    * @return string
    */
    function getFolderPath() {
      return $this->folder_path;
    } // getFolderPath
    
    /**
    * Set folder_path value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setFolderPath($value) {
      $this->folder_path = $value;
    } // setFolderPath
  
  } // FailedToCreateFolderError

?>