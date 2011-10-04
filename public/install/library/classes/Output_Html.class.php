<?php

  /**
  * Render HTML formated output
  *
  * @http://www.projectpier.org/
  */
  class Output_Html extends Output {
  
    /**
    * Print message to the console
    *
    * @param string $message
    * @param boolean $is_error
    * @return void
    */
    function printMessage($message, $is_error = false) {
      $print_message = htmlspecialchars($message);
      if ($is_error) {
        print "<span class=\"error\">$print_message</span>\n";
      } else {
        print "<span>$print_message</span>\n";
      } // if
    } // printMessage
  
  } // Output_Html

?>