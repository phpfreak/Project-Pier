<?php

  /**
  * Template class
  *
  * This class is template wrapper, responsible for forwarding variables to the
  * templates and including them.
  * 
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class Template {

    /**
     * Class instance
     *
     * @var Object
     */
    private static $_instance;
    
    /**
    * Array of template variables
    *
    * @var array
    */
    private $vars = array();
    
    /**
    * Assign specific variable to the template
    *
    * @param string $name Variable name
    * @param mixed $value Variable value
    * @return boolean
    */
    function assign($name, $value) {
      if (!$trimmed = trim($name)) {
        return false;
      }
      $this->vars[$trimmed] = $value;
      return true;
    } // assign
    
    /**
    * Display template and retur output as string
    *
    * @param string $template Template path (absolute path or path relative to 
    *   the templates dir)
    * @return string
    */
    function fetch($template) {
      ob_start();
      $inc = $this->includeTemplate($template);
      if ($inc === false) {
        ob_end_clean();
        return '';
      } else {
        return ob_get_clean();
      } // if
    } // fetch
    
    /**
    * Display template
    *
    * @param string $template Template path or path relative to templates dir
    * @return boolean
    * @throws FileDnxError
    */
    function display($template) {
      return $this->includeTemplate($template);
    } // display
    
    /**
    * Include specific template
    *
    * @param string $template Template name or path relative to templates dir
    * @return null
    */
    function includeTemplate($template) {
      if (file_exists($template)) {
        extract($this->vars, EXTR_SKIP);
        include $template;
        return true;
      } // if
      return false;
    } // includeTemplate
    
    /**
    * Return template service instance
    *
    * @param void
    * @return Template
    */
    static function instance() {
      if(!isset(self::$_instance)) {
        self::$_instance = new self;
      }
      return self::$_instance;
    } // instance
  
  } // Template

?>