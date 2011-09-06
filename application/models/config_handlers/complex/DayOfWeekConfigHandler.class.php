<?php

  /**
  * Day of Week configuration option handler
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class DayOfWeekConfigHandler extends ConfigHandler {
  
    /**
    * Render form control
    *
    * @param string $control_name
    * @return string
    */
    function render($control_name) {
      $options = array();

      for ($dow = 1; $dow <= 7; $dow++) {
	$option_attributes = $this->getValue() == "$dow" ? array('selected' => 'selected') : null;
	$options[] = option_tag(lang('weekday full '.$dow), "$dow", $option_attributes);
      } // for
      
      return select_box($control_name, $options);
    } // render
  
  } // DayOfWeekConfigHandler

?>