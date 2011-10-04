<?php

  /**
  * Flash service
  *
  * Purpose of this service is to make some data available across pages. Flash
  * data is available on the next page but deleted when execution reach its end.
  *
  * Usual use of Flash is to make possible that current page pass some data
  * to the next one (for instance success or error message before HTTP redirect).
  *
  * Flash service as a concep is taken from Rails. This thing really rocks!
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class Flash {
  
    /**
    * Data that prevous page left in the Flash
    *
    * @var array
    */
    private $previous = array();
    
    /**
    * Data that current page is saving for the next page
    *
    * @var array
    */
    private $next = array();
    
    /**
    * Read flash data on construction
    *
    * @access public
    * @param void
    * @return FlashService
    */
    function __construct() {
      $this->readFlash();
    } // end func __construct
    
    /**
    * Return specific variable from the flash. If value is not found NULL is
    * returned
    *
    * @access public
    * @param string $var Variable name
    * @return mixed
    */
    function getVariable($var) {
      return isset($this->previous[trim($var)]) ? $this->previous[trim($var)] : null;
    } // end func getVariable
    
    /**
    * Add specific variable to the flash. This variable will be available on the
    * next page unlease removed with the removeVariable() or clear() method
    *
    * @access public
    * @param string $var Variable name
    * @param mixed $value Variable value
    * @return void
    */
    function addVariable($var, $value) {
      $this->next[trim($var)] = $value;
      $this->writeFlash();
    } // end func addVariable
    
    /**
    * Remove specific variable for the Flash
    *
    * @access public
    * @param string $var Name of the variable that need to be removed
    * @return void
    */
    function removeVariable($var) {
      if (isset($this->next[trim($var)])) {
        unset($this->next[trim($var)]);
      } // if
      $this->writeFlash();
    } // end func removeVariable
    
    /**
    * Call this function to clear flash. Note that data that previous page
    * stored will not be deleted - just the data that this page saved for
    * the next page
    *
    * @access public
    * @param void
    * @return void
    */
    function clear() {
      $this->next = array();
    } // end func cleare
    
    /**
    * This function will read flash data from the $_SESSION variable
    * and load it into $this->previous array
    *
    * @access private
    * @param void
    * @return void
    */
    function readFlash() {
      
      // Get flash data...
      $flash_data = array_var($_SESSION, 'flash_data');
      
      // If we have flash data set it to previous array and forget it :)
      if (!is_null($flash_data)) {
        if (is_array($flash_data)) {
          $this->previous = $flash_data;
        } // if
        unset($_SESSION['flash_data']);
      } // if
      
    } // end func readFlash
    
    /**
    * Save content of the $this->next array into the $_SESSION autoglobal var
    *
    * @access private
    * @param void
    * @return void
    */
    function writeFlash() {
      $_SESSION['flash_data'] = $this->next;
    } // end func writeFlash
    
    /**
    * Return flash service instance
    *
    * @access public
    * @param void
    * @return FlashService
    */
    static function &instance() {
      static $instance;
      
      // Check instance...
      if (!instance_of($instance, 'Flash')) {
        $instance = new Flash();
      } // if
      
      // Return instance...
      return $instance;
      
    } // end func instance
    
  } // end class Flash

?>