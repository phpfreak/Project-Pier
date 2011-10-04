<?php

  /**
   * Plugin controller
   * (Need this for new "addPluginHelper" and "addPluginLibrary" functions
   * so that plugin helpers & libraries can be kept inside the appropriate
   * directory structure in the APPLICATION_ROOT/plugins/<plugin_name>
   * folder).
   *
   * @author Brett Edgar (True Digital Security, Inc.)
   * @version 1.0
   * @http://www.projectpier.org/
   */
abstract class PluginController extends ApplicationController {
  var $plugin_name;
  var $libraries;
  /**
   * Add application level constroller
   *
   * @param void
   * @return null
   */
  function __construct($name ) {
    parent::__construct();
    $this->plugin_name = $name;
    $this->libraries = array();
  } // __construct

  /**
   * Add one or many helpers
   *
   * @param string $helper This param can be array of helpers
   * @return null
   */
  function addPluginHelper($helper) {
    $args = func_get_args();
    if (!is_array($args)) {
      return false;
    } // if
      
    foreach ($args as $helper) {
      if (!in_array($helper, $this->helpers)) {
        if (PluginManager::useHelper($this->plugin_name,$helper)) {
          $this->helpers[] = $helper;
        }// if
      } // if
    } // foreach
      
    return true;
  } // addHelper

  function addPluginLibrary($library) {
    if (isset($this->libraries[$library]) && $this->libraries[$library]) {
      return true;
    } // if

    if (PluginManager::useLibrary($this->plugin_name,$library)) {
      $this->libraries[] = $library;
    } // if
  }
  
} // PluginController

?>