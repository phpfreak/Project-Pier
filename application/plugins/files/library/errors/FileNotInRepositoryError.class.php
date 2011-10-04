<?php

  /**
  * This error is throw when we are trying to manipulate with file that 
  * is not in the file repository
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class FileNotInRepositoryError extends Error {
  
    /**
    * Unique file ID
    *
    * @var string
    */
    private $file_id;
    
    /**
    * Construct the FileNotInRepositoryError
    *
    * @access public
    * @param void
    * @return FileNotInRepositoryError
    */
    function __construct($file_id, $message = null) {
      if (is_null($message)) $message = "File '$file_id' can not be found in the repository";
      parent::__construct($message);
      $this->setFileId($file_id);
    } // __construct
    
    /**
    * Return errors specific params...
    *
    * @param void
    * @return array
    */
    function getAdditionalParams() {
      return array(
        'file ID' => $this->getFileId()
      ); // array
    } // getAdditionalParams
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get file_id
    *
    * @param null
    * @return string
    */
    function getFileId() {
      return $this->file_id;
    } // getFileId
    
    /**
    * Set file_id value
    *
    * @param string $value
    * @return null
    */
    function setFileId($value) {
      $this->file_id = $value;
    } // setFileId
  
  } // FileNotInRepositoryError

?>