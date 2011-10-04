<?php

  /**
  * Page controller is special controller that is able to map controller name 
  * and actions name with layout and template and automatically display them. 
  * This behaviour is present only when action has not provided any exit by 
  * itself (redirect to another page, render template and die etc)
  *
  * @http://www.projectpier.org/
  */
  abstract class PageController extends Controller {
  
    /**
    * Template name. If it is empty this controller will use action name.php
    *
    * @var string
    */
    private $template;
    
    /**
    * Layout name. If it is empty this controller will use its name.php
    *
    * @var string
    */
    private $layout;
    
    /**
    * Array of helpers that will be automatically loaded when render method is called
    *
    * @var array
    */
    private $helpers = array();
    
    /**
    * Automatically render template / layout if action ends without exit
    *
    * @var boolean
    */
    private $auto_render = true;
    
    /**
    * Construct controller
    *
    * @param void
    * @return null
    */
    function __construct() {
      parent::__construct();
      $this->setSystemControllerClass('PageController');;
      
      $this->addHelper('common');
      $this->addHelper('page');
      $this->addHelper('form');
      $this->addHelper('format');
      $this->addHelper('pagination');
      // autoload helper with name equal to controller
      $cn = $this->getControllerName();
      if (Env::helperExists($cn, $cn)) { 
        $this->addHelper($cn, $cn); // controller name helper
      }
    } // __construct
    
    /**
    * Execute action
    *
    * @param string $action
    * @return null
    */
    function execute($action) {
      ob_start();
      parent::execute($action);
      if ($this->getAutoRender()) $render = $this->render(); // Auto render?
      return true;
    } // execute
    
    /**
    * Render content... If template and/layout are NULL script will resolve 
    * their names based on controller name and action. 
    * 
    * PageController::index will map with:
    *  - template => views/page/index.php
    *  - layout => layouts/page.php
    *
    * @param string $template
    * @param string $layout
    * @param boolean $die
    * @return boolean
    * @throws FileDnxError
    */
    function render($template = null, $layout = null, $die = true) {
      trace(__FILE__, "render($template, $layout, $die)" );

      // Set template and layout...
      if (!is_null($template)) {
        $this->setTemplate($template);
      } // if
      if (!is_null($layout)) {
        $this->setLayout($layout);
      } // if
      
      // Get template and layout paths
      $template_path = $this->getTemplatePath();
      $layout_path = $this->getLayoutPath();
      
      trace(__FILE__, "tpl_fetch($template_path)" );
      // Fetch content...
      $content = tpl_fetch($template_path);

      trace(__FILE__, "renderLayout($layout_path <xmp>$content</xmp>)" );
      // Assign content and render layout
      $this->renderLayout($layout_path, $content);
      
      // Die!
      if ($die) {
        session_write_close();
        die();
      } // if
      
      // We are done here...
      return true;
      
    } // render
    
    /**
    * Assign content and render layout
    *
    * @param string $layout_path Path to the layout file
    * @param string $content Value that will be assigned to the $content_for_layout
    *   variable
    * @return boolean
    * @throws FileDnxError
    */
    function renderLayout($layout_path, $content = null) {
      tpl_assign('content_for_layout', $content);
      return tpl_display($layout_path);
    } // renderLayout
    
    /**
    * Shortcut method for printing text and setting auto_render option
    *
    * @param string $text Text that need to be rendered
    * @param boolean $render_layout Render controller layout. Default is false for
    *   simple and fast text rendering
    * @return null
    */
    function renderText($text, $render_layout = false) {
      $this->setAutoRender(false); // Turn off auto render because we will render whole thing now...
      
      if ($render_layout) {
        $layout_path = $this->getLayoutPath();
        $this->renderLayout($layout_path, $text);
      } else {
        print $text;
      } // if
    } // renderText
    
    /**
    * Redirect. Params are same as get_url function
    *
    * @param string $controller
    * @param string $action
    * @param array $params
    * @param string $anchor
    * @return null
    */
    function redirectTo($controller = DEFAULT_CONTROLLER, $action = 'index', $params = null, $anchor = null) {
      redirect_to(get_url($controller, $action, $params, $anchor));
    } // redirectTo
    
    /**
    * Redirect to URL
    *
    * @param string $url
    * @return null
    */
    function redirectToUrl($url) {
      redirect_to($url);
    } // redirectToUrl
    
    /**
    * Redirect to referer. If referer is no valid this function will use $alternative URL
    *
    * @param string $alternative Alternative URL
    * @return null
    */
    function redirectToReferer($alternative) {
      redirect_to_referer($alternative);
    } // redirectToReferer
    
    // -------------------------------------------------------
    // Getters and setters
    // -------------------------------------------------------
    
    /**
    * Get template
    *
    * @param null
    * @return string
    */
    function getTemplate() {
      return $this->template;
    } // getTemplate
    
    /**
    * Set template value
    *
    * @param string $value
    * @return null
    */
    function setTemplate($value) {
      $this->template = $value;
    } // setTemplate
    
    /**
    * Get layout
    *
    * @param null
    * @return string
    */
    function getLayout() {
      return $this->layout;
    } // getLayout
    
    /**
    * Set layout value
    *
    * @param string $value
    * @return null
    */
    function setLayout($value) {
      $this->layout = $value;
    } // setLayout
    
    /**
    * Return helper / helpers array
    *
    * @param null
    * @return array
    */
    function getHelpers() {
      return is_array($this->helpers) ? $this->helpers : array($this->helpers);
    } // getHelpers
    
    /**
    * Add one or many helpers
    *
    * @param string $helper This param can be array of helpers
    * @return null
    */
    function addHelper($helper, $controller_name = null) {
      trace(__FILE__,"addHelper($helper, $controller_name) start");
      
      if (!in_array($helper, $this->helpers)) {
        if (Env::useHelper($helper, $controller_name)) {
          $this->helpers[] = $helper;
        } // if
      } // if
      trace(__FILE__,"addHelper($helper, $controller_name) end");      
      return true;
    } // addHelper
    
    /**
    * Get auto_render
    *
    * @param null
    * @return boolean
    */
    function getAutoRender() {
      return $this->auto_render;
    } // getAutoRender
    
    /**
    * Set auto_render value
    *
    * @param boolean $value
    * @return null
    */
    function setAutoRender($value) {
      $this->auto_render = (boolean) $value;
    } // setAutoRender
    
    /**
    * Return path of the template. If template dnx throw exception
    *
    * @param void
    * @return string
    * @throws FileDnxError
    */
    function getTemplatePath() {
      // Filename of template
      $template = trim($this->getTemplate()) == '' ? 
        $this->getAction() : 
        $this->getTemplate();
        
      // Prepare path...
      if (is_file($this->getTemplate())) {
        $path = $this->getTemplate();
      } else {
        $path = get_template_path($template, $this->getControllerName());
      } // if
      
      // Template dnx?
      if (!is_file($path)) {
        throw new FileDnxError($path);
      } // if
      
      // Return path
      return $path;
    } // getTemplatePath
    
    /**
    * Return path of the layout file.
    *
    * @param void
    * @return string
    * @throws FileDnxError
    */
    function getLayoutPath() {
      $layout_name = trim($this->getLayout()) == '' ? 
        $this->getControllerName() : 
        $this->getLayout();
      
      // Path of the layout
      $path = Env::getLayoutPath($layout_name);
      
      // File dnx? Throw exception
      if (!is_file($path)) {
        throw new FileDnxError($path);
      } // if
      
      // Return path
      return $path;
    } // getLayoutPath
  
  } // PageController

?>