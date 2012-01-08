<?php

  /**
  * Shortcut function for retrieving single lang value
  *
  * @access public
  * @param string $name
  * @return string
  */
  function lang($name) {
    
    // Get function arguments and remove first one. 
    $args = func_get_args();
    if (is_array($args)) {
      array_shift($args);
    } // if
    
    // Get value and if we have NULL done!
    if (plugin_active('i18n')) {
      $value = lang_from_db($name);
    } else {
      $value = Localization::instance()->lang($name);
    }
    if (is_null($value)) {
      return $value;
    } // if
    
    // We have args? Replace all %s with arguments
    if (is_array($args) && count($args)) {
      foreach ($args as $arg) {
        $value = str_replace_first('%s', $arg, $value);
      } // foreach
    } // if
    
    // Done here...
    return $value;
    
  } // lang

  /**
  * Function for retrieving single lang value from database
  *
  * @access public
  * @param string $name
  * @return string
  */
  function lang_from_db($name) {
    static $langs;
    if (!is_array($langs)) $langs = array();
    if (!array_key_exists($name, $langs)) {
      $langs[$name] = $name;
      $sql = "select `description` from `".TABLE_PREFIX."i18n_values` where `name` = '$name'";
      try {
        $result = DB::executeOne($sql);
        if ($result) {
          $langs[$name] = $result['description'];
        }
      } catch(Exception $e) {}
    }
    return $langs[$name];
  }
?>