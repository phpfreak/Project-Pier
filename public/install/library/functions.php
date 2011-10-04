<?php
  
  include_once INSTALLATION_PATH . '/environment/functions/general.php'; // general functions
  
  // ---------------------------------------------------
  //  Templates
  // ---------------------------------------------------
  
  /**
  * Return full path of specific template file
  *
  * @param string $tpl_file
  * @return string
  */
  function get_template_path($tpl_file) {
    return INSTALLER_PATH . '/installation/templates/' . $tpl_file;
  } // get_template_path
  
  /**
  * Assign template variable. 
  * 
  * If you want to assign multiple variables with one call pass associative array 
  * through $varname. In that case $varvalue will be ignored!
  *
  * @param mixed $varname Variable name or associative array of variables that need
  *   to be assigned
  * @param mixed $varvalue Variable name. If $varname is array this param is ignored
  * @return boolean
  */
  function tpl_assign($varname, $varvalue = null) {
    $template_instance = Template::instance();
    if (is_array($varname)) {
      foreach ($varname as $k => $v) {
        $template_instance->assign($k, $v);
      } // foreach
    } else {
      $template_instance->assign($varname, $varvalue);
    } // if
  } // tpl_assign
  
  /**
  * Render template and return it as string
  *
  * @param string $template Template that need to be rendered
  * @return boolean
  */
  function tpl_fetch($template) {
    $template_instance = Template::instance();
    return $template_instance->fetch($template);
  } // tpl_fetch
  
  /**
  * Render specific template
  *
  * @param string $template Template that need to be rendered
  * @return boolean
  */
  function tpl_display($template) {
    $template_instance = Template::instance();
    return $template_instance->display($template);
  } // tpl_display

?>