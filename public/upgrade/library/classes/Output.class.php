<?php

  /**
  * Abstract output
  *
  * @http://www.projectpier.org/
  */
  abstract class Output {
    
    /**
    * Print a specific message to a specific output
    *
    * @param string $message
    * @param boolean $is_error
    * @return void
    */
    abstract function printMessage($message, $is_error = false);
    
  } // Output

?>