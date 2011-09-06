<?php

  /**
  * Select mail transport (mail or SMPT currently)
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class MailTransportConfigHandler extends ConfigHandler {
  
    /**
    * Render form control
    *
    * @param string $control_name
    * @return string
    */
    function render($control_name) {
      $options = array();
      
      $option_attributes = $this->getValue() == 'mail()' ? array('selected' => 'selected') : null;
      $options[] = option_tag(lang('mail transport mail()'), 'mail()', $option_attributes);
      
      $option_attributes = $this->getValue() == 'smtp' ? array('selected' => 'selected') : null;
      $options[] = option_tag(lang('mail transport smtp'), 'smtp', $option_attributes);
      
      return select_box($control_name, $options);
    } // render
  
  } // MailTransportConfigHandler

?>