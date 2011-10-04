<?php

  /**
  * Timezones class list all avilable timezones and let you check if specific timezone 
  * value is valid
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class Timezones {
  
    /**
    * Array of valid timezones
    *
    * @var array
    */
    static private $timezones = array(
      -12, -11, -10, -9, -8, -7, -6, -5, -4, -3.5, -3, -2, -1, 0, 1, 2, 3, 3.5, 4, 4.5, 5, 5.5, 6, 7, 8, 9, 9.5, 10, 11, 12
    ); // array
    
    /**
    * Return all available timezones
    *
    * @param void
    * @return array
    */
    static function getTimezones() {
      return self::$timezones;
    } // getTimezones
    
    /**
    * Check if $input value is valid timezone
    *
    * @param float $input
    * @return boolean
    */
    static function isValidTimezone($input) {
      $check_value = (float) $input;
      return in_array($check_value, self::$timezones);
    } // isValidTimezone
    
  } // Timezones

?>