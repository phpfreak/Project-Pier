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
    global $language, $locale_id;
    static $langs;
    if (!is_array($langs)) $langs = array();
    if (!array_key_exists($name, $langs)) {
      if (!isset($language)) $language = 'en_us';
      if (!isset($locale_id)) {
        $language_country = explode('_', $language);
        $a = isset($language_country[0]) ? $language_country[0] : 'en';
        $b = isset($language_country[1]) ? $language_country[1] : 'us';
        $sql = "select `id` from `".TABLE_PREFIX."i18n_locales` where language_code = '$a' and country_code = '$b'";
        try {
          $result = DB::executeOne($sql);
          if ($result) {
            $locale_id = $result['id'];
          }
        } catch(Exception $e) { $locale_id = 1; }
      }
      $langs[$name] = $name;
      $sql = "select `description` from `".TABLE_PREFIX."i18n_values` where `name` = '$name' and locale_id = '$locale_id'";
      try {
        $result = DB::executeOne($sql);
        if ($result) {
          $langs[$name] = $result['description'];
        } else {
          $category_id = 0;
          $sql = "insert into `".TABLE_PREFIX."i18n_values` (`locale_id`, `category_id`, `name`, `description`) values( '$locale_id', '$category_id', '$name', '~{$name}');";
          try {
            mysql_query($sql);
          } catch(Exception $e) {}
        }
      } catch(Exception $e) {}
    }
    return $langs[$name];
  }
?>