<?php

  /**
  * This exception is thrown when we are trying to use non-existing DB adapter
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class DBAdapterDnx extends Error {
    
    /**
    * Name of the missing adapter
    *
    * @var string
    */
    private $adapter_name;
    
    /**
    * Class of the missing adapter
    *
    * @var string
    */
    private $adapter_class;
  
    /**
    * Construct the DBAdapterDnx
    *
    * @access public
    * @param string $adapter_name
    * @param string $adapter_class
    * @param string $message If NULL default will be used
    * @return DBAdapterDnx
    */
    function __construct($adapter_name, $adapter_class, $message = null) {
      if (is_null($message)) {
        $message = "Database adapter '$adapter_name' (class '$adapter_class') was not found";
      } // if
      parent::__construct($message);
      $this->setAdapterClass($adapter_class);
      $this->setAdapterName($adapter_name);
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
        'adapter name' => $this->getAdapterName(),
        'adapter class' => $this->getAdapterClass()
      ); // array
    } // getAdditionalParams
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get adapter_name
    *
    * @access public
    * @param null
    * @return string
    */
    function getAdapterName() {
      return $this->adapter_name;
    } // getAdapterName
    
    /**
    * Set adapter_name value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setAdapterName($value) {
      $this->adapter_name = $value;
    } // setAdapterName
    
    /**
    * Get adapter_class
    *
    * @access public
    * @param null
    * @return string
    */
    function getAdapterClass() {
      return $this->adapter_class;
    } // getAdapterClass
    
    /**
    * Set adapter_class value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setAdapterClass($value) {
      $this->adapter_class = $value;
    } // setAdapterClass
  
  } // DBAdapterDnx

?>