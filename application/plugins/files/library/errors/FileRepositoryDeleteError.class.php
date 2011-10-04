<?php

  /**
  * This error is throw when we fail to remove file from the repository
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class FileRepositoryDeleteError extends Error {
  
    /**
    * Unique file ID
    *
    * @var string
    */
    private $file_id;
    
    /**
    * Construct the FileRepositoryDeleteError
    *
    * @access public
    * @param void
    * @return FileRepositoryDeleteError
    */
    function __construct($file_id, $message = null) {
      if (is_null($message)) $message = "Failed to remove '$file_id' from the '$repository_path' repository";
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
        'file ID' => $this->getSource(),
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
  
  } // FileRepositoryDeleteError

?>