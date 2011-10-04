<?php
  
  // ---------------------------------------------------
  //  Upgrader specific
  // ---------------------------------------------------
  
  /**
  * Compare to upgrader scripts by version
  *
  * @param ScriptUpgraderScript $script1
  * @param ScriptUpgraderScript $script2
  * @return integer
  */
  function compare_scripts_by_version_from($script1, $script2) {
    if (!($script1 instanceof ScriptUpgraderScript) || !($script2 instanceof ScriptUpgraderScript)) {
      return 0;
    } // if
    return version_compare($script1->getVersionFrom(), $script2->getVersionFrom());
  } // compare_scripts_by_version_from
  
  /**
  * Dump an error
  *
  * @param Exception $exception
  * @return null
  */
  function dump_upgrader_exception($exception) {
    print '<pre style="text-align: left">' . $exception->__toString() . '</pre>';
  } // dump_upgrader_exception
  
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
    return UPGRADER_PATH . '/templates/' . $tpl_file . '.php';
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