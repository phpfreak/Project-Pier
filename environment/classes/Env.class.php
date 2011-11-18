<?php

  class Env {
    
    /**
    * Check if environment is in debug mode
    *
    * @access public
    * @param void
    * @return boolean
    */
    static function isDebugging() {
      return isset($_GET['debug']);
    } // isDebugging
    
    /**
    * Use specific library. This function will look in application directory 
    * first and then in environment library folder. If it doesn't finds requested 
    * class in it LibraryDnxError will be raised
    *
    * @access public
    * @param string $library Library name
    * @return null
    * @throws LibraryDnxError
    */
    static function useLibrary($library, $plugin = null) {
      static $included = array();
      if (isset($included[$library]) && $included[$library]) {
        return;
      } // if
      
      $library_path = ENVIRONMENT_PATH . "/library/$library/";
      if (!file_exists($library_path)) {
        $library_path = ROOT . "/library/$library/";
      } // if
      
      if (!is_dir($library_path)) {
        if ($plugin) {
          $library_path = APPLICATION_PATH . "/plugins/$plugin/library/$library/";
        }
        if (!is_dir($library_path)) {
          throw new LibraryDnxError($library);
        } // if
      } // if
      
      // Call init library file if it exists
      $library_init_file = $library_path . $library . '.php';
      if (is_file($library_init_file)) {
        include_once $library_init_file;
      } // if
      
      $included[$library] = true;
    } // useLibrary
    
    /**
    * Include library error class if class is not already included
    *
    * @access public
    * @param string $error_class
    * @param string $library Library name
    * @return boolean
    */
    static function useLibraryError($error_class, $library) {
      if (class_exists($error_class)) {
        return true;
      } // if
      
      $expected_path = ENVIRONMENT_PATH . "/library/$library/errors/$error_class.class.php";
      if (is_file($expected_path)) {
        include_once $expected_path;
        return true;
      } else {
        throw new FileDnxError($expected_path);
      } // if
    } // useLibraryError
    
    /**
    * Show nice error output.
    *
    * @access public
    * @param Error $error
    * @param boolean $die Die when done, default value is true
    * @return null
    */
    static function dumpError($error, $die = true) {
      static $css_rendered = false;
      
      // Check error instance...
      if (!instance_of($error, 'Error')) {
        if (!instance_of($error, 'Exception')) {
          print '$error is not an <i>Error</i> or <i>Exception</i> instance! ' . $error;
          return;
        } // if
      } // if
      
      // OK, include template...
      include ENVIRONMENT_PATH . '/templates/dump_error.php';
      
      // Die?
      if ($die) {
        die();
      } // if
    } // dumpError
    
    /**
    * Contruct controller and execute specific action
    *
    * @access public
    * @param string $controller_name
    * @param string $action
    * @return null
    */
    static function executeAction($controller_name, $action) {
      trace(__FILE__,"executeAction($controller_name, $action)");
      Env::useController($controller_name);
      
      $controller_class = Env::getControllerClass($controller_name);
      if (!class_exists($controller_class, false)) {
        trace(__FILE__,"executeAction($controller_name, $action) - $controller_class does not exist");
        throw new ControllerDnxError($controller_name);
      } // if
      
      trace(__FILE__,"executeAction($controller_name, $action) - new $controller_class()");
      $controller = new $controller_class();
      if (!instance_of($controller, 'Controller')) {
        trace(__FILE__,"executeAction($controller_name, $action) - $controller_class not Controller");
        throw new ControllerDnxError($controller_name);
      } // if
      
      trace(__FILE__,"executeAction($controller_name, $action) - $controller_class -> execute($action)");
      return $controller->execute($action);
    } // executeAction
    
    /**
    * Find and include specific controller based on controller name
    *
    * @access public
    * @param string $controller_name
    * @return boolean
    * @throws FileDnxError if controller file does not exists
    */
    static function useController($controller_name) {
      trace(__FILE__,"useController($controller_name)");
      $controller_class = Env::getControllerClass($controller_name);
      if (class_exists($controller_class, false)) {
        return true;
      } // if
      
      $controller_file = Env::getControllerPath($controller_name);
      if (is_file($controller_file)) {
        trace(__FILE__,"useController($controller_name) - include_once $controller_file");
        include_once $controller_file;
        return true;
      } else {
        throw new FileDnxError($controller_file, "Controller '$controller_name' does not exists (expected location '$controller_file')");
      } // if
    } // useController
    
    /**
    * Get Controller File Path, looks for controller file and returns the path 
    *
    * @access public
    * @param string $controller_name
    * @return boolean
    * @throws FileDnxError if controller file does not exists
    */
    static function getControllerPath($controller_name) {
      trace(__FILE__,"getControllerPath($controller_name)");
      $controller_class = Env::getControllerClass($controller_name);
      $controller_file = APPLICATION_PATH . "/controllers/$controller_class.class.php";
      trace(__FILE__,"getControllerPath($controller_name) - core: $controller_file");
      $controller_file_plugin = APPLICATION_PATH . "/plugins/$controller_name/controllers/$controller_class.class.php";
      trace(__FILE__,"getControllerPath($controller_name) - plugin: $controller_file_plugin");
      if (is_file($controller_file)) return $controller_file;
      else if (is_file($controller_file_plugin)) return $controller_file_plugin;
      else throw new FileDnxError($controller_file, "Controller '$controller_name' does not exists (expected location '$controller_file' or '$controller_file_plugin')");
    } // getControllerFilePath
    
    /**
    * Use specific helper
    *
    * @access public
    * @param string $helper Helper name
    * @return boolean
    * @throws FileDnxError
    */
    static function useHelper($helper, $controller_name = null) {
      trace(__FILE__,"useHelper($helper, $controller_name)");
      $helper_file = Env::getHelperPath($helper, $controller_name);
      
      // If we have it include, else throw exception
      if (is_file($helper_file)) {
        trace(__FILE__,"useHelper($helper, $controller_name) including $helper_file");
        include_once $helper_file;
        return true;
      } // if
      throw new FileDnxError($helper_file, "Helper '$helper' does not exists (expected location '$helper_file')");
    } // useHelper
    
    /**
    * Check if specific helper exists
    *
    * @access public
    * @param string $helper
    * @return boolean
    */
    static function helperExists($helper, $controller_name = null) {
      return is_file(self::getHelperPath($helper, $controller_name));
    } // helperExists
    
    /**
    * Return controller name based on controller class
    *
    * @access public
    * @param string $controller_class
    * @return string
    */
    static function getControllerName($controller_class) {
      return Inflector::underscore( substr($controller_class, 0, strlen($controller_class) - 10) );
    } // getControllerName
    
    /**
    * Return controller class based on controller name
    *
    * @access public
    * @param string $controller_name
    * @return string
    */
    static function getControllerClass($controller_name) {
      trace(__FILE__,"getControllerClass($controller_name)");
      return Inflector::camelize($controller_name) . 'Controller';
    } // getControllerClass
    
    /**
    * Return path of specific template
    *
    * @access public
    * @param string $template
    * @param string $controller_name
    * @return string
    */
    static function getTemplatePath($template, $controller_name = null) {
      trace(__FILE__,"getTemplatePath($template, $controller_name)");
      // Look for template file in theme, core and plugin directories
      $template_path=THEMES_DIR.'/'.config_option('theme')."/views/$controller_name/$template.php";
      if (is_readable($template_path)) return $template_path;
      $template_path=APPLICATION_PATH."/views/$controller_name/$template.php";
      if (is_readable($template_path)) return $template_path;
      $template_path_plugin='';
      if ($controller_name) {
      	$template_path_plugin=APPLICATION_PATH."/plugins/$controller_name/views/$template.php";
        if (is_readable($template_path_plugin)) return $template_path_plugin;
      } // if
      trace(__FILE__,"getTemplatePath($template, $controller_name) - can not read [$template_path] or [$template_path_plugin]");
      return false;
    } // getTemplatePath
    
    /**
    * Return layout
    *
    * @access public
    * @param string $layout
    * @return string
    */
    static function getLayoutPath($layout) {
      if (file_exists(THEMES_DIR.'/'.config_option('theme')."/layouts/$layout.php"))
        return THEMES_DIR.'/'.config_option('theme')."/layouts/$layout.php";
      else
        return APPLICATION_PATH . "/layouts/$layout.php";
    } // getLayoutPath
    
    /**
    * Return path of specific helper
    *
    * @access public
    * @param string $helper
    * @return string
    */
    static function getHelperPath($helper, $controller_name = null) {
      trace(__FILE__,"getHelperPath($helper, $controller_name)");
      //Look for helper file path into core and plugins directories
      $helper_path=APPLICATION_PATH . "/helpers/$helper.php";
      trace(__FILE__,"getHelperPath($helper, $controller_name): trying $helper_path");
      if (is_readable($helper_path)) return $helper_path;
      $helper_path_plugin='';
      if ($controller_name) {
      	$helper_path_plugin=APPLICATION_PATH . "/plugins/$controller_name/helpers/$helper.php";
        trace(__FILE__,"getHelperPath($helper, $controller_name): trying $helper_path_plugin");
        if (file_exists($helper_path_plugin)) return $helper_path_plugin;
      } 
      trace(__FILE__,"getHelperPath($helper, $controller_name) - can not read [$helper_path] or [$helper_path_plugin]");
      return false;
    } // getHelperPath
    
    /**
    * Return default base URL based on owner company status
    *
    * @access private
    * @param void
    * @return string
    */
    private function getDefaultBase() {
      return ROOT_URL;
    } // getDefaultBase
  
  } // Env
  
  // ---------------------------------------------------
  //  This routines are used a lot in controllers and 
  //  templates so here are shortcut methods
  // ---------------------------------------------------
  
  /**
  * Interface to Env::getTemplatePath() function
  *
  * @access public
  * @param string $template Template name
  * @param string $controller_name
  * @return string
  */
  function get_template_path($template, $controller_name = null) {
    return Env::getTemplatePath($template, $controller_name);
  } // get_template_path

?>