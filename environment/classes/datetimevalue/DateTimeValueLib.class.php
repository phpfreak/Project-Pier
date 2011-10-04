<?php

  /**
  * This class is used to produce DateTimeValue object based on timestamos, strings etc
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class DateTimeValueLib {
  
    /**
    * Returns current time object
    *
    * @param void
    * @return DateTimeValue
    */
    static function now() {
      return new DateTimeValue(time());
    } // now
    
    /**
    * This function works like mktime, just it always returns GMT
    *
    * @param integer $hour
    * @param integer $minute
    * @param integer $second
    * @param integer $month
    * @param integer $day
    * @param integer $year
    * @return DateTimeValue
    */
    static function make($hour, $minute, $second, $month, $day, $year) {
      return new DateTimeValue(mktime($hour, $minute, $second, $month, $day, $year));
    } // make
    
    /**
    * Make time from string using strtotime() function. This function will return null
    * if it fails to convert string to the time
    *
    * @param string $str
    * @return DateTimeValue
    */
    static function makeFromString($str) {
      $timestamp = strtotime($str);// + date('Z');
      return ($timestamp === false) || ($timestamp === -1) ? null : new DateTimeValue($timestamp);
    } // makeFromString
  
  } // DateTimeValueLib

?>