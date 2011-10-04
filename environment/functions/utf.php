<?php

  /**
  * Extended substr function. If it finds mbstring extension it will use, else 
  * it will use old substr() function
  *
  * @access public
  * @param string $string String that need to be fixed
  * @param integer $start Start extracting from
  * @param integer $length Extract number of characters
  * @return string
  */
  function substr_utf($string, $start = 0, $length = null) {
    
    $start = (integer) $start >= 0 ? (integer) $start : 0;
    if (is_null($length)) {
      $length = strlen_utf($string) - $start;
    } // if
    
    if (function_exists('mb_substr')) {
      return mb_substr($string, $start, $length);
    } else {
      return substr($string, $start, $length);
    } // if
    
  } // substr_utf
  
  /**
  * Return UTF safe string lenght
  *
  * @access public
  * @param strign $string
  * @return integer
  */
  function strlen_utf($string) {
    if (function_exists('mb_strlen')) {
      return mb_strlen($string);
    } else {
      return strlen($string);
    } // if
  } // strlen_utf

?>