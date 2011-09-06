<?php

  /**
  * Select secure LDAP connection value
  *
  */
  class SecureLDAPConnectionConfigHandler extends ConfigHandler {
  
    /**
    * Render form control
    *
    * @param string $control_name
    * @return string
    */
    function render($control_name) {
      $options = array();
      
      $option_attributes = $this->getValue() == 'no' ? array('selected' => 'selected') : null;
      $options[] = option_tag(lang('secure ldap connection no'), 'no', $option_attributes);
      
      $option_attributes = $this->getValue() == 'tls' ? array('selected' => 'selected') : null;
      $options[] = option_tag(lang('secure ldap connection tls'), 'tls', $option_attributes);
      
      return select_box($control_name, $options);
    } // render
  
  } // SecureLDAPConnectionConfigHandler

?>