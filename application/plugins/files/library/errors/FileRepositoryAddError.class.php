<?php

  /**
  * This error will be thrown when FileRepository failes to import file
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class FileRepositoryAddError extends Error {
    
    /**
    * Source file
    *
    * @var string
    */
    private $source;
    
    /**
    * File ID
    *
    * @var string
    */
    private $unique_file_id;
  
    /**
    * Construct the FileRepositoryAddError
    *
    * @access public
    * @param string $source Soruce file
    * @param string $repository_dir
    * @param string $unique_file_id
    * @param string $message Exception message
    * @return FileRepositoryAddError
    */
    function __construct($source, $unique_file_id = null, $message = null) {
      if (is_null($message)) $message = "Failed to import file '$source' to the file repository (unique file id: $unique_file_id)";
      parent::__construct($message);
      $this->setSource($source);
      $this->setUniqueFileId($unique_file_id);
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
        'source file' => $this->getSource(),
        'unique file id' => $this->getUniqueFileId()
      ); // array
    } // getAdditionalParams
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get source
    *
    * @param null
    * @return string
    */
    function getSource() {
      return $this->source;
    } // getSource
    
    /**
    * Set source value
    *
    * @param string $value
    * @return null
    */
    function setSource($value) {
      $this->source = $value;
    } // setSource
    
    /**
    * Get unique_file_id
    *
    * @param null
    * @return string
    */
    function getUniqueFileId() {
      return $this->unique_file_id;
    } // getUniqueFileId
    
    /**
    * Set unique_file_id value
    *
    * @param string $value
    * @return null
    */
    function setUniqueFileId($value) {
      $this->unique_file_id = $value;
    } // setUniqueFileId
  
  } // FileRepositoryAddError

?>