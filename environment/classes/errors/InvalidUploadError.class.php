<?php

  /**
  * Upload error
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class InvalidUploadError extends Error {

    /**
    * Filename
    *
    * @var string
    */
    private $name;
    
    /**
    * MIME type
    *
    * @var string
    */
    private $type;
    
    /**
    * Filesize
    *
    * @var integer
    */
    private $size;
    
    /**
    * TMP file location
    *
    * @var string
    */
    private $tmp_name;
    
    /**
    * Upload error code
    *
    * @var integer
    */
    private $upload_error_code;
     
    /**
    * Construct the InvalidUploadError
    *
    * @access public
    * @param array $file Element of $_FILES array
    * @return InvalidUploadError
    */
    function __construct($file, $message = null) {
      if (is_null($message)) {
        $message = 'Failed to upload file.';
      } // if
      parent::__construct($message);
      
      $this->setName(array_var($file, 'name'));
      $this->setType(array_var($file, 'type'));
      $this->setSize(array_var($file, 'size'));
      $this->setTmpName(array_var($file, 'tmp_name'));
      $this->setUploadErrorCode(array_var($file, 'error'));
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
        'name'              => $this->getName(),
        'type'              => $this->getType(),
        'size'              => $this->getSize(),
        'tmp name'          => $this->getTmpName(),
        'upload error code' => $this->getUploadErrorCode()
      ); // array
    } // getAdditionalParams
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get name
    *
    * @access public
    * @param null
    * @return string
    */
    function getName() {
      return $this->name;
    } // getName
    
    /**
    * Set name value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setName($value) {
      $this->name = $value;
    } // setName
    
    /**
    * Get type
    *
    * @access public
    * @param null
    * @return string
    */
    function getType() {
      return $this->type;
    } // getType
    
    /**
    * Set type value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setType($value) {
      $this->type = $value;
    } // setType
    
    /**
    * Get size
    *
    * @access public
    * @param null
    * @return integer
    */
    function getSize() {
      return $this->size;
    } // getSize
    
    /**
    * Set size value
    *
    * @access public
    * @param integer $value
    * @return null
    */
    function setSize($value) {
      $this->size = $value;
    } // setSize
    
    /**
    * Get tmp_name
    *
    * @access public
    * @param null
    * @return string
    */
    function getTmpName() {
      return $this->tmp_name;
    } // getTmpName
    
    /**
    * Set tmp_name value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setTmpName($value) {
      $this->tmp_name = $value;
    } // setTmpName
    
    /**
    * Get upload_error_code
    *
    * @access public
    * @param null
    * @return integer
    */
    function getUploadErrorCode() {
      return $this->upload_error_code;
    } // getUploadErrorCode
    
    /**
    * Set upload_error_code value
    *
    * @access public
    * @param integer $value
    * @return null
    */
    function setUploadErrorCode($value) {
      $this->upload_error_code = $value;
    } // setUploadErrorCode
  
  } // InvalidUploadError

?>