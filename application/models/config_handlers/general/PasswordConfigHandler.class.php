<?php

  /**
  * Masked single line string value
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class PasswordConfigHandler extends ConfigHandler {
  
    /**
    * Render form control
    *
    * @param string $control_name
    * @return string
    */
    function render($control_name) {
      return password_field($control_name, $this->getValue(), array('class' => 'middle'));
    } // render
  
  } // PasswordConfigHandler

?>