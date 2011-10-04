<?php
  
  /**
  * Interface to flash add method
  *
  * @access public
  * @param string $name Variable name
  * @param mixed $value Value that need to be set
  * @return null
  */
  function flash_add($name, $value) {
    Flash::instance()->addVariable($name, $value);
  } // flash_add
  
  /**
  * Shortcut method for adding success var to flash
  *
  * @access public
  * @param string $message Success message
  * @return null
  */
  function flash_success($message) {
    flash_add('success', $message);
  } // flash_success
  
  /**
  * Shortcut method for adding error var to flash
  *
  * @access public
  * @param string $message Error message
  * @return null
  */
  function flash_error($message) {
    flash_add('error', $message);
  } // flash_error
  
  /**
  * Return variable from flash. If variable DNX NULL is returned
  *
  * @access public
  * @param string $name Variable name
  * @return mixed
  */
  function flash_get($name) {
    return Flash::instance()->getVariable($name);
  } // flash_get

?>