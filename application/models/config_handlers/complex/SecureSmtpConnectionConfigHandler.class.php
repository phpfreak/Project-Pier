<?php

  /**
  * Select secure SMTP connection value
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class SecureSmtpConnectionConfigHandler extends ConfigHandler {
  
    /**
    * Render form control
    *
    * @param string $control_name
    * @return string
    */
    function render($control_name) {
      $options = array();
      
      $option_attributes = $this->getValue() == 'no' ? array('selected' => 'selected') : null;
      $options[] = option_tag(lang('secure smtp connection no'), 'no', $option_attributes);
      
      $option_attributes = $this->getValue() == 'ssl' ? array('selected' => 'selected') : null;
      $options[] = option_tag(lang('secure smtp connection ssl'), 'ssl', $option_attributes);
      
      $option_attributes = $this->getValue() == 'tls' ? array('selected' => 'selected') : null;
      $options[] = option_tag(lang('secure smtp connection tls'), 'tls', $option_attributes);
      
      return select_box($control_name, $options);
    } // render
  
  } // SecureSmtpConnectionConfigHandler

?>