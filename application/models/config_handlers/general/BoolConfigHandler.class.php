<?php

  class BoolConfigHandler extends ConfigHandler {
  
    /**
    * Render form control
    *
    * @param string $control_name
    * @return string
    */
    function render($control_name) {
      return yes_no_widget($control_name, 'yes_no_' . $this->getConfigOption()->getName(), $this->getValue(), lang('yes'), lang('no'));
    } // render
    
    /**
    * Conver $value to raw value
    *
    * @param mixed $value
    * @return null
    */
    protected function phpToRaw($value) {
      return $value ? '1' : '0';
    } // phpToRaw
    
    /**
    * Convert raw value to php
    *
    * @param string $value
    * @return mixed
    */
    protected function rawToPhp($value) {
      return (integer) $value ? true : false;
    } // rawToPhp
  
  } // BoolConfigHandler

?>