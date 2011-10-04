<?php
  
  /**
  * Assign template variable. 
  * 
  * If you want to assign multiple variables with one call pass associative array 
  * through $varname. In that case $varvalue will be ignored!
  *
  * @access public
  * @param mixed $varname Variable name or associative array of variables that need
  *   to be assigned
  * @param mixed $varvalue Variable name. If $varname is array this param is ignored
  * @return boolean
  */
  function tpl_assign($varname, $varvalue = null) {
    if (is_array($varname)) {
      $template_instance = Template::instance();
      foreach ($varname as $k => $v) {
        $template_instance->assign($k, $v);
      } // foreach
    } else {
      Template::instance()->assign($varname, $varvalue);
    } // if
  } // tpl_assign
  
  /**
  * Render template and return it as string
  *
  * @access public
  * @param string $template Template that need to be rendered
  * @return string
  * @throws FileDnxError
  */
  function tpl_fetch($template) {
    return Template::instance()->fetch($template);
  } // tpl_fetch
  
  /**
  * Render specific template
  *
  * @access public
  * @param string $template Template that need to be rendered
  * @return null
  * @throws FileDnxError
  */
  function tpl_display($template) {
    return Template::instance()->display($template);
  } // tpl_display

?>