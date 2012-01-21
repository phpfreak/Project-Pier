<?php
 /**
  * PluginManager
  *
  * This file contains logic that has been borrowed from my favourite
  *  publishing platform; WordPress
  * The implementation is only a part reproduction and has been modified
  *  to suit the ProjectPier application.
  * @author Mark Brennand
  * @link http://www.activeingredient.com.au
  *
  * The plugin architecture supports both actions and filters. The difference
  * between these is a matter of input; all actions on the same hook receive
  * the same input regardless of order, filters received modified input from
  * previous filters on the same hook.
  * 
  * @see application/plugins.php
  *  
  * @version 1.0
  * @http://www.projectpier.org/
  */
class PluginManager {
    
  /**
   * List of filters and actions
   *
   * @var array
   */
  var $filter_table;
  var $included;
    
  function init() {
    if (isset($this) && ($this instanceof PluginManager)) {

      $this->included = array();
      $this->filter_table = array();
      $activated_plugins = Plugins::getActivatedPlugins();
        
      // now load each plugin
      foreach(array_keys($activated_plugins) as $name) {
        include_once 'plugins/'.$name.'/init.php';
      } // foreach
        
      // TODO : cleanup up old activated plugins without valid file??
        
    } else {
      PluginManager::instance()->init();
    } // if
  } // init
    
  function add_filter($tag, $function_to_add, $priority = 10, $accepted_args = 1) {
    if ( isset($this->filter_table[$tag][$priority]) ) {
      foreach($this->filter_table[$tag][$priority] as $filter) {
        if ( $filter['function'] == $function_to_add ) {
          return false;
        } // if
      } // foreach
    } // if
    $this->filter_table[$tag][$priority][] = array('function'=>$function_to_add,
                                                   'accepted_args'=>$accepted_args);
    return true;
  } // add_filter
    
  function remove_filter($tag, $function_to_remove, $priority = 10) {
    $toret = false;
    
    if ( isset($this->filter_table[$tag][$priority]) ) {
      foreach($this->filter_table[$tag][$priority] as $filter) {
        if ( $filter['function'] != $function_to_remove ) {
          $new_function_list[] = $filter;
        } else {
          $toret = true;
        } // if
      } // foreach
      $this->filter_table[$tag][$priority] = $new_function_list;
    } // if
    return $toret;
  } // remove_filter
    
  function do_action($tag,$arg='') {
    
    if ( !isset($this->filter_table[$tag]) ) {
      return;
    } else {
      ksort($this->filter_table[$tag]);
    } // if
      
    $args = array();
    if ( is_array($arg) && 1 == count($arg) && is_object($arg[0]) ) {
      $args[] =& $arg[0];
    } else {
      $args[] = $arg;
    } // if
    
    for ( $a = 2; $a < func_num_args(); $a++ ) {
      $args[] = func_get_arg($a);
    } // for
      
    foreach ($this->filter_table[$tag] as $priority => $functions) {
      if ( !is_null($functions) ) {
        foreach($functions as $f) {
          trace(__FILE__,"call_user_func_array({$f['function']},..");
          try {
            call_user_func_array($f['function'], array_slice($args, 0, (int)$f['accepted_args']));
          } catch (Exception $e) {
            Logger::log($e, Logger::FATAL);
          }
        } // foreach
      } // if
    } // foreach
  } // do_action
  
  function apply_filters($tag,$value) {
    $args = func_get_args();
    
    if ( !isset($this->filter_table[$tag]) ) {
      return $value;
    } else {
      ksort($this->filter_table[$tag]);
    } // if
      
    foreach ($this->filter_table[$tag] as $priority => $functions) {
      if ( !is_null($functions) ) {
        foreach($functions as $f) {
          $args[1] = $value;
          $value = call_user_func_array($f['function'], array_slice($args, 1,(int)$f['accepted_args']));
        } // foreach
      } // if
    } // foreach
    return $value;
  } // apply_filters

  function useHelper($plugin_name, $helper) {
    //$helper_file = APPLICATION_PATH . "/plugins/$plugin_name/helpers/$helper.php";
    $helper_file = "plugins/$plugin_name/helpers/$helper.php";

    // If we have it include, else throw exception
    if (is_file($helper_file)) {
      include_once $helper_file;
      return true;
    } else {
      throw new FileDnxError($helper_file, "Helper '$helper' for plugin '$plugin_name' does not exists (expected location '$helper_file')");
    } // if
  } // useHelper

  /**
   * Use specific library. This function will look in plugin directory.
   * If it doesn't find requested library class, then LibraryDnxError
   * will be raised
   *
   * @access public
   * @param string $library Library name
   * @return null
   * @throws LibraryDnxError
   */
  static function useLibrary($plugin_name, $library) {
    //$library_path = APPLICATION_PATH . "/plugins/$plugin_name/library/$library/";
    $library_path = "plugins/$plugin_name/library/$library/";
    if (file_exists($library_path) && is_dir($library_path)) {
      // Call init library file if it exists
      $library_init_file = $library_path . $library . '.php';
      if (is_file($library_init_file)) {
        include_once $library_init_file;
      } // if
      return true;
    } // if

    throw new LibraryDnxError($library);
  } // useLibrary
   
  /**
   * Return single PluginManager instance
   *
   * @access public
   * @param void
   * @return PluginManager 
   */
  static function instance() {
    static $instance;
    if (!($instance instanceof PluginManager )) {
      $instance = new PluginManager();
    } // if
    return $instance;
  } // instance

}
?>