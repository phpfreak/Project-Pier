<?php

  /**
  * Library does not exists error, used by Env::useLibrary() function or any 
  * situation when library is required but not found
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class LibraryDnxError extends Error {
    
    /**
    * Library name
    *
    * @var string
    */
    private $library;
      
    /**
    * Construct the LibraryDnxError
    *
    * @access public
    * @param string $library Library name
    * @param string $message Error message. If NULL default message will be used
    * @return LibraryDnxError
    */
    function __construct($library, $message = null) {
      if (is_null($message)) {
        $message = "Library '$library' does not exists";
      } // if
      parent::__construct($message);
      $this->setLibrary($library);
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
        'library' => $this->getLibrary()
      ); // array
    } // getAdditionalParams
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get library
    *
    * @access public
    * @param null
    * @return string
    */
    function getLibrary() {
      return $this->library;
    } // getLibrary
    
    /**
    * Set library value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setLibrary($value) {
      $this->library = $value;
    } // setLibrary
  
  } // LibraryDnxError

?>