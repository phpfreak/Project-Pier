<?php

  /**
  * Simple interface for setting and getting cookie values
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class Cookie {
    
    /**
    * Return value from the cookien
    *
    * @param string $name Variable name
    * @param mixed $default
    * @return mixed
    */
    static function getValue($name, $default = null) {
      return array_var($_COOKIE, $name, $default);
    } // getValue
  
    /**
    * Set cookie value
    *
    * @param string $name Variable name
    * @param mixed $value
    * @param integer $expiration Number of seconds from current time when this cookie need to expire
    * @return null
    */
    static function setValue($name, $value, $expiration = null) {
      
      $expiration_time = DateTimeValueLib::now();
      if ((integer) $expiration > 0) {
        $expiration_time->advance($expiration);
      } else {
        $expiration_time->advance(3*3600); // three hour
      } // if
      
      // if $expiration is null, set the cookie to expire when the session is over
      $expiration_timestamp = is_null($expiration) ? null : $expiration_time->getTimestamp();

      $path = defined('COOKIE_PATH') ? COOKIE_PATH : '/';
      $domain = defined('COOKIE_DOMAIN') ? COOKIE_DOMAIN : '';
      $secure = defined('COOKIE_SECURE') ? COOKIE_SECURE : false;
      
      setcookie($name, $value, $expiration_timestamp, $path, $domain, $secure);
    } // setValue
    
    /**
    * Unset specific cookie value
    *
    * @param string $name
    * @return null
    */
    static function unsetValue($name) {
      self::setValue($name, false);
    } // unsetValue
  
  } // Cookie

?>