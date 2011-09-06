<?php

  /**
  * Shortcut method for retriving single lang value
  *
  * @access public
  * @param string $neme
  * @return string
  */
  function lang($name) {
    
    // Get function arguments and remove first one. 
    $args = func_get_args();
    if (is_array($args)) {
      array_shift($args);
    } // if
    
    // Get value and if we have NULL done!
    $value = Localization::instance()->lang($name);
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

?>
