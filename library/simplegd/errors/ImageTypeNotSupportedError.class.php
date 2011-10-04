<?php

  /**
  * This error is thrown when we try to use types other than PNG, JPEG and GIF 
  * with SimpleGD
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class ImageTypeNotSupportedError extends Error {
  
    /**
    * Image file path
    *
    * @var string
    */
    protected $file_path;
    
    /**
    * Type value
    *
    * @var integer
    */
    protected $type_value;
    
    /**
    * Construct the ImageTypeNotSupportedError
    *
    * @access public
    * @param void
    * @return ImageTypeNotSupportedError
    */
    function __construct($file_path, $type_value, $message = null) {
      if (is_null($message)) {
      	$message = "This type of image is not supported. SimpleGD supports only PNG, JPG and GIF image types. Type: $type_value";
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
    
    /**
    * Get type_value
    *
    * @param null
    * @return integer
    */
    function getTypeValue() {
      return $this->type_value;
    } // getTypeValue
    
    /**
    * Set type_value value
    *
    * @param integer $value
    * @return null
    */
    function setTypeValue($value) {
      $this->type_value = $value;
    } // setTypeValue
  
  } // ImageTypeNotSupportedError

?>