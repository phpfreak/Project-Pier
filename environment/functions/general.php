<?php

  /**
  * Check if $object is valid $class instance
  *
  * @access public
  * @param mixed $object Variable that need to be checked agains classname
  * @param string $class Classname
  * @return null
  */
  function instance_of($object, $class) {
    return $object instanceof $class;
  } // instance_of
  
  /**
  * Show var dump. pre_var_dump() is used for testing only!
  *
  * @access public
  * @param mixed $var
  * @return null
  */
  function pre_var_dump($var) {
    print '<pre>';
    var_dump($var);
    print '</pre>';
  } // pre_var_dump
  
  /**
  * This function will return clean variable info
  *
  * @param mixed $var
  * @param string $indent Indent is used when dumping arrays recursivly
  * @param string $indent_close_bracet Indent close bracket param is used
  *   internally for array output. It is shorter that var indent for 2 spaces
  * @return null
  */
  function clean_var_info($var, $indent = '&nbsp;&nbsp;', $indent_close_bracet = '') {
    if (is_object($var)) {
      return 'Object (class: ' . get_class($var) . ')';
    } elseif (is_resource($var)) {
      return 'Resource (type: ' . get_resource_type($var) . ')';
    } elseif (is_array($var)) {
      $result = 'Array (';
      if (count($var)) {
        foreach ($var as $k => $v) {
          $k_for_display = is_integer($k) ? $k : "'" . clean($k) . "'";
          $result .= "\n" . $indent . '[' . $k_for_display . '] => ' . clean_var_info($v, $indent . '&nbsp;&nbsp;', $indent_close_bracet . $indent);
        } // foreach
      } // if
      return $result . "\n$indent_close_bracet)";
    } elseif (is_int($var)) {
      return '(int)' . $var;
    } elseif (is_float($var)) {
      return '(float)' . $var;
    } elseif (is_bool($var)) {
      return $var ? 'true' : 'false';
    } elseif (is_null($var)) {
      return 'NULL';
    } else {
      return "(string) '" . clean($var) . "'";
    } // if
  } // clean_var_info
  
  /**
  * Equivalent to htmlspecialchars(), but allows &#[0-9]+ (for unicode)
  * 
  * This function was taken from punBB codebase <http://www.punbb.org/>
  *
  * @param string $str
  * @return string
  */
  function clean($str) {
    $str = preg_replace('/&(?!#[0-9]+;)/s', '&amp;', $str);
  	$str = str_replace(array('<', '>', '"'), array('&lt;', '&gt;', '&quot;'), $str);
  	return $str;
  } // clean
  
  /**
  * Convert entities back to valid characters
  *
  * @param string $escaped_string
  * @return string
  */
  function undo_htmlspecialchars($escaped_string) {
    $search = array('&amp;', '&lt;', '&gt;');
    $replace = array('&', '<', '>');
    return str_replace($search, $replace, $escaped_string);
  } // undo_htmlspecialchars
  
  /**
  * This function will return true if $str is valid function name (made out of alpha numeric characters + underscore)
  *
  * @param string $str
  * @return boolean
  */
  function is_valid_function_name($str) {
    $check_str = trim($str);
    if ($check_str == '') {
      return false; // empty string
    }
    
    $first_char = substr_utf($check_str, 0, 1);
    if (is_numeric($first_char)) return false; // first char can't be number
    
    return (boolean) preg_match("/^([a-zA-Z0-9_]*)$/", $check_str);
  } // is_valid_function_name
  
  /**
  * Check if specific string is valid sha1() hash
  *
  * @param string $hash
  * @return boolean
  */
  function is_valid_hash($hash) {
    return ((strlen($hash) == 32) || (strlen($hash) == 40)) && (boolean) preg_match("/^([a-f0-9]*)$/", $hash);
  } // is_valid_hash
  
  /**
  * Return variable from hash (associative array). If value does not exists 
  * return default value
  *
  * @access public
  * @param array $from Hash
  * @param string $name
  * @param mixed $default
  * @return mixed
  */
  function array_var(&$from, $name, $default = null) {
    if (is_array($from)) {
      return isset($from[$name]) ? $from[$name] : $default;
    }
    return $default;
  } // array_var
  
  /**
  * This function will return $str as an array
  *
  * @param string $str
  * @return array
  */
  function string_to_array($str) {
    if (!is_string($str) || (strlen($str) == 0)) {
      return array();
    }
    
    $result = array();
    for ($i = 0, $strlen = strlen($str); $i < $strlen; $i++) {
      $result[] = $str[$i];
    } // if
    
    return $result;
  } // string_to_array
  
  /**
  * This function will return ID from array variables. Default settings will get 'id' 
  * variable from $_GET. If ID is not found function will return NULL
  *
  * @param string $var_name Variable name. Default is 'id'
  * @param array $from Extract ID from this array. If NULL $_GET will be used
  * @param mixed $default Default value is returned in case of any error
  * @return integer
  */
  function get_id($var_name = 'id', $from = null, $default = null) {
    $var_name = trim($var_name);
    if ($var_name == '') return $default; // empty varname?
    
    if (is_null($from)) {
      $from = $_GET;
    }
    
    if (!is_array($from)) return $default; // $from is array?
    if (!is_valid_function_name($var_name)) return $default; // $var_name is valid?
    
    $value = array_var($from, $var_name, $default);
    return is_numeric($value) ? (integer) $value : $default;
  } // get_id
  
  /**
  * Flattens the array. This function does not preserve keys, it just returns 
  * array indexed form 0 .. count - 1
  *
  * @access public
  * @param array $array If this value is not array it will be returned as one
  * @return array
  */
  function array_flat($array) {
    // Not an array
    if (!is_array($array)) {
      return array($array);
    }
    
    // Prepare result
    $result = array();
    
    // Loop elements
    foreach ($array as $value) {
      
      // Subelement is array? Flat it
      if (is_array($value)) {
        $value = array_flat($value);
        foreach ($value as $subvalue) {
          $result[] = $subvalue;
        }
      } else {
        $result[] = $value;
      } // if
    } // if
    
    // Return result
    return $result;
  } // array_flat
  
  /**
  * Replace first $search_for with $replace_with in $in. If $search_for is not found
  * original $in string will be returned...
  *
  * @access public
  * @param string $search_for Search for this string
  * @param string $replace_with Replace it with this value
  * @param string $in Haystack
  * @return string
  */
  function str_replace_first($search_for, $replace_with, $in) {
    $pos = strpos($in, $search_for);
    if ($pos === false) {
      return $in;
    } else {
      return substr($in, 0, $pos) . $replace_with . substr($in, $pos + strlen($search_for), strlen($in));
    } // if
  } // str_replace_first
  
  /**
  * String starts with something
  *
  * This function will return true only if input string starts with
  * niddle
  *
  * @param string $string Input string
  * @param string $niddle Needle string
  * @return boolean
  */
  function str_starts_with($string, $niddle) {
  	return substr($string, 0, strlen($niddle)) == $niddle;  	
  } // end func str_starts with
  
  /**
  * String ends with something
  *
  * This function will return true only if input string ends with
  * niddle
  *
  * @param string $string Input string
  * @param string $niddle Needle string
  * @return boolean
  */
  function str_ends_with($string, $niddle) {
    return substr($string, strlen($string) - strlen($niddle), strlen($niddle)) == $niddle;
  } // end func str_ends_with
  
  /**
  * Return path with trailing slash
  *
  * @param string $path Input path
  * @return string Path with trailing slash
  */
  function with_slash($path) {
    return str_ends_with($path, '/') ? $path : $path . '/';
  } // end func with_slash
  
  /**
  * Remove trailing slash from the end of the path (if exists)
  *
  * @param string $path File path that need to be handled
  * @return string
  */
  function without_slash($path) {
    return str_ends_with($path, '/') ? substr($path, 0, strlen($path) - 1) : $path;
  } // without_slash
  
  /**
  * Check if selected email has valid email format
  *
  * @param string $user_email Email address
  * @return boolean
  */
  function is_valid_email($user_email) {
    $chars = EMAIL_FORMAT;
    if (strstr($user_email, '@') && strstr($user_email, '.')) {
    	return (boolean) preg_match($chars, $user_email);
    } else {
    	return false;
    } // if
  } // end func is_valid_email
  
  /**
  * Verify the syntax of the given URL.
  *
  * @access public
  * @param $url The URL to verify.
  * @return boolean
  */
  function is_valid_url($url) {
    return preg_match(URL_FORMAT, $url);
  } // end func is_valid_url 
  

  function ignore_error($errno, $errstr, $errfile, $errline) {
    return true;
  }

  /**
  * Redirect to specific URL (header redirection)
  *
  * @access public
  * @param string $to Redirect to this URL
  * @param boolean $die Die when finished
  * @return void
  */
  function redirect_to($to, $die = true) {
    if (headers_sent($filename, $linenum)) {
      echo "Headers already sent in $filename on line $linenum\n" .
          "Click this <a href=\"".ROOT_URL."\">link</a> to continue\n";
      session_write_close();
      die();
    }
    trace('redirect_to', "($to, $die)");
    $to = trim($to);
    if (strpos($to, '&amp;') !== false) {
      $to = str_replace('&amp;', '&', $to);
    } // if

    if (ob_get_level()>0) {
      set_error_handler('ignore_error');
      while(@ob_end_clean());
      restore_error_handler();
    }
    header('Location: ' . $to);
    if ($die) {
      session_write_close();
      die();
    }
  } // end redirect_to
  
  /**
  * Redirect to referer
  *
  * @access public
  * @param string $alternative Alternative URL is used if referer is not valid URL
  * @return null
  */
  function redirect_to_referer($alternative = null) {
    $referer = get_referer();
    if (!is_valid_url($referer)) {
      redirect_to($alternative);
    } else {
      redirect_to($referer);
    } // if
  } // redirect_to_referer
  
  /**
  * Return referer URL
  *
  * @param string $default This value is returned if referer is not found or is empty
  * @return string
  */
  function get_referer($default = null) {
    return array_var($_SERVER, 'HTTP_REFERER', $default);
  } // get_referer
  
  /**
  * This function will return max upload size in bytes
  *
  * @param void
  * @return integer
  */
  function get_max_upload_size() {
    return min(
      php_config_value_to_bytes(ini_get('upload_max_filesize')), 
      php_config_value_to_bytes(ini_get('post_max_size'))
    ); // max
  } // get_max_upload_size
  
  /**
  * Convert PHP config value (2M, 8M, 200K...) to bytes
  * 
  * This function was taken from PHP documentation
  *
  * @param string $val
  * @return integer
  */
  function php_config_value_to_bytes($val) {
    $val = trim($val);
    $last = strtolower($val{strlen($val)-1});
    switch ($last) {
      // The 'G' modifier is available since PHP 5.1.0
      case 'g':
        $val *= 1024;
      case 'm':
        $val *= 1024;
      case 'k':
        $val *= 1024;
    } // if
    
    return $val;
  } // php_config_value_to_bytes
  
  // ==========================================================
  //  POST and GET
  // ==========================================================
  
  /**
  * This function will strip slashes if magic quotes is enabled so 
  * all input data ($_GET, $_POST, $_COOKIE) is free of slashes
  *
  * @access public
  * @param void
  * @return null
  */
  function fix_input_quotes() {
    if (get_magic_quotes_gpc()) {
      array_stripslashes($_GET);
      array_stripslashes($_POST);
      array_stripslashes($_COOKIE);
    } // if
  } // fix_input_quotes
  
  /**
  * This function will walk recursivly thorugh array and strip slashes from scalar values
  *
  * @param array $array
  * @return null
  */
  function array_stripslashes(&$array) {
    if (!is_array($array)) {
      return;
    }
    foreach ($array as $k => $v) {
      if (is_array($array[$k])) {
        array_stripslashes($array[$k]);
      } else {
        $array[$k] = stripslashes($array[$k]);
      } // if
    } // foreach
    return $array;
  } // array_stripslashes

  /**
  * This function will add hyperlinks to strings that look like links
  *
  * @param string $text
  * @return $text with possibly hyperlinks
  */
  function add_links(&$text) {
    // The following searches for strings that look like links and auto-links them
    $search = array(
        '/(?<!")(http:\/\/[^\s\"<]*)/',
        '/[^\/](www\.[^\s<]*)/'
    );
    $replace = array(
        "<a href=\"$1\" rel=\"nofollow\">$1</a>",
        " <a href=\"http://$1\" rel=\"nofollow\">$1</a>"
    );
    $text = preg_replace($search,$replace,$text);

    return $text;
  }

  /**
  * This function will return string in lowercase
  *
  * @param string $string
  * @return $string in lower case
  */
  function lc($string) {
    if (function_exists('mb_convert_case')) {
      return mb_convert_case($string, MB_CASE_LOWER, "UTF-8");
    }
    $uc = "ĄÇČĆĘŁŃÑÓŚŹŻABCDÐEFTGĞHIMJKLNOŒÖPRSŠŞUÜWYÝZŽQXVЁЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮÆÅÂÀÁÄÃÊÈÉËÎÍÌÏÔÕÒÓÖØÛÙÚÜİ";
    $lc = "ąçčćęłńñóśźżabcdðeftgğhimjklnoœöprsšşuüwyýzžqxvёйцукенгшщзхъфывапролджэячсмитьбюæåâàáäãêèéëîíìïôõòóöøûùúüi"; 
    return strtr($string, $uc, $lc);  
  }

  /**
  * This function will return string normalized
  *
  * @param string $string
  * @return $string normalized
  */
  function normalize ($string) {
    $table = array(
        'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
        'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r',
    );
    
    return strtr($string, $table);
  }

  /**
  * This function will return external url
  *
  * @param string $relative_url
  * @return $string with http:// etc. added
  */
  function externalUrl($relative_url) {
    $protocol = 'http://';
    if (isset($_SERVER['HTTPS'])) {
      if ($_SERVER['HTTPS']!='off') { // IIS
        if ($_SERVER['HTTPS']!='') {
          $protocol = 'https://'; 
        }
      }
    }
    return $protocol . $_SERVER['HTTP_HOST'] . $relative_url; 
  }

  /**
  * This function returns true if string begins with certain string
  * 
  * @param string $string
  * @param string $search
  * @return boolean
  */
  function string_begins_with($string, $search) {
    return (strncmp($string, $search, strlen($search)) == 0);
  }

  /**
  * This function will return chunked content unchunked
  * 
  * @param string $data
  * @return $unchunked_data
  * source: php.net
  */
  function http_unchunk($data) {
    $fp = 0;
    $outData = '';
    while ($fp < strlen($data)) {
        $rawnum = substr($data, $fp, strpos(substr($data, $fp), "\r\n") + 2);
        $num = hexdec(trim($rawnum));
        $fp += strlen($rawnum);
        $chunk = substr($data, $fp, $num);
        $outData .= $chunk;
        $fp += strlen($chunk);
    }
    return $outData;
  }

  /**
  * This function will return content from url
  * Note: Handles chunked content
  * 
  * @param string $host
  * @param string $port
  * @param string $url (within host)
  * @return $string with content
  */
  function get_content_from_url($host, $port, $url) {
    $reply='';
    $fp = fsockopen($host, $port, $errno, $errstr, 30);
    if (!$fp) {
      //echo "$errstr ($errno)<br />\n";
      return false;
    } else {
      $out = "GET /$url HTTP/1.0\r\n";
      $out .= "Host: $host\r\n";
      $out .= "Connection: Close\r\n\r\n";
      fwrite($fp, $out);
      while (!feof($fp)) {
        $reply .= fgets($fp, 1024);
      }
      fclose($fp);
    }
    $start_of_data = strpos($reply, "\r\n\r\n")+4;
    $headers = substr($reply, 0, $start_of_data);
    $data = substr($reply, $start_of_data);
    if (strpos(strtolower($headers), "transfer-encoding: chunked") !== FALSE) {
      $data = http_unchunk($data);
    }
    return $data;
  }
?>