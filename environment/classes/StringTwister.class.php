<?php

  /**
  * String twister is set of functions that modify string based on twister so they are harder to guess
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  final class StringTwister {
  
    /**
    * Return twister ID, 10 digits integer that is user for twisting the string
    *
    * @param void
    * @return integer
    */
    static function getTwister() {
      $twister = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
      do {
        shuffle($twister);
      } while ($twister[0] == '0');
      return implode('', $twister);
    } // getTwister
    
    /**
    * Twist $untwisted_string with $twister
    *
    * @param string $untwisted_string
    * @param string $twister
    * @return string
    */
    static function twist($untwisted_string, $twister) {
      if (strlen($untwisted_string) <> strlen($twister)) {
        return $untwisted_string;
      } // if
      
      $twisted_array = array();
      for ($i = 0, $strlen = strlen($twister); $i < $strlen; $i++) {
        $twisted_array[(integer) $twister[$i]] = $untwisted_string[$i];
      } // for
      
      ksort($twisted_array);
      return implode('', $twisted_array);
    } // twist
    
    /**
    * Untwist $twisted_string string based on $twister
    *
    * @param string $twisted_string
    * @param string $twister
    * @return string
    */
    static function untwist($twisted_string, $twister) {
      if (strlen($twisted_string) <> strlen($twister)) {
        return $twisted_string;
      } // if
      
      $twisted_array = string_to_array($twisted_string);
      $untwisted_array = array();
      for ($i = 0, $strlen = strlen($twister); $i < $strlen; $i++) {
        $untwisted_array[] = $twisted_array[(integer) $twister[$i]];
      } // for
      
      return implode('', $untwisted_array);
    } // untwist
    
    /**
    * Twist sha1() hash
    *
    * @param string $untwisted_hash
    * @param string $twister
    * @return string
    */
    static function twistHash($untwisted_hash, $twister) {
      if (!is_valid_hash($untwisted_hash)) {
        return $untwisted_sha1;
      } // if
      $result = '';
      for ($i = 0; $i < 4; $i++) {
        $result .= self::twist(substr($untwisted_hash, $i * 10, 10), $twister);
      } // for
      return $result;
    } // twistHash
    
    /**
    * Untwist $twisted_hash based on $twister
    *
    * @param string $twisted_hash
    * @param string $twister
    * @return string
    */
    static function untwistHash($twisted_hash, $twister) {
      if (!is_valid_hash($twisted_hash)) {
        return $twisted_hash;
      } // if
      $result = '';
      for ($i = 0; $i < 4; $i++) {
        $result .= self::untwist(substr($twisted_hash, $i * 10, 10), $twister);
      } // for
      return $result;
    } // untwistHash
    
  } // StringTwister

?>