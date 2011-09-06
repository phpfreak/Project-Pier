<?php

  /**
  * Class that handles integer config values
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class DateTimeConfigHandler extends ConfigHandler {
    
    /**
    * Render form control
    *
    * @param string $control_name
    * @return string
    */
    function render($control_name) {
      $year = date('Y');
      return pick_date_widget($control_name, $this->getValue(), $year - 10, $year + 10);
    } // render
    
    /**
    * Conver $value to raw value
    *
    * @param DateTimeValue $value
    * @return null
    */
    protected function phpToRaw($value) {
      return $value instanceof DateTimeValue ? $value->toMySQL() : EMPTY_DATETIME;
    } // phpToRaw
    
    /**
    * Convert raw value to php
    *
    * @param string $value
    * @return mixed
    */
    protected function rawToPhp($value) {
      $from_value = trim($value) ? $value : EMPTY_DATETIME;
      return DateTimeValueLib::makeFromString($from_value);
    } // rawToPhp
    
  } // DateTimeConfigHandler

?>