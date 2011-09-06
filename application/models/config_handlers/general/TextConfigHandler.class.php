<?php

  /**
  * Multiline string value
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class TextConfigHandler extends ConfigHandler {
  
    /**
    * Render form control
    *
    * @param string $control_name
    * @return string
    */
    function render($control_name) {
      return textarea_field($control_name, $this->getValue());
    } // render
  
  } // TextConfigHandler

?>