<?php

  /**
  * Return all page actions
  *
  * @access public
  * @param void
  * @return array
  */
  function page_actions() {
    return PageActions::instance()->getActions();
  } // page_actions
  
  /**
  * Add single page action
  * 
  * You can use set of two params where first param is title and second one
  * is URL (the default set) and you can use array of actions as first
  * parram mapped like $title => $url
  *
  * @access public
  * @param string $title
  * @param string $url
  * @return PageAction
  */
  function add_page_action() {
    
    $args = func_get_args();
    if (!is_array($args) || !count($args)) {
      return;
    }
    
    // Array of data as first param mapped like $title => $url
    if (is_array(array_var($args, 0))) {
      
      foreach (array_var($args, 0) as $title => $url) {
        if (!empty($title) && !empty($url)) {
          PageActions::instance()->addAction( new PageAction($title, $url) );
        } // if
      } // foreach
      
    // Two string params, title and URL
    } else {
      
      $title = array_var($args, 0);
      $url = array_var($args, 1);
      
      if (!empty($title) && !empty($url)) {
        PageActions::instance()->addAction( new PageAction($title, $url) );
      } // if
      
    } // if
    
  } // add_page_action

  /**
  * Single page action
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class PageAction {
    
    /**
    * Acction title
    *
    * @var string
    */
    private $title;
    
    /**
    * Action URL
    *
    * @var string
    */
    private $url;
  
    /**
    * Construct the PageAction
    *
    * @access public
    * @param void
    * @return PageAction
    */
    function __construct($title, $url) {
      $this->setTitle($title);
      $this->setURL($url);
    } // __construct
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get title
    *
    * @access public
    * @param null
    * @return string
    */
    function getTitle() {
      return $this->title;
    } // getTitle
    
    /**
    * Set title value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setTitle($value) {
      $this->title = $value;
    } // setTitle
    
    /**
    * Get url
    *
    * @access public
    * @param null
    * @return string
    */
    function getURL() {
      return $this->url;
    } // getURL
    
    /**
    * Set url value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setURL($value) {
      $this->url = $value;
    } // setURL
  
  } // PageAction
  
  /**
  * Page actions container that can be accessed globaly
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class PageActions {
    
    /**
    * Array of PageAction objects
    *
    * @var array
    */
    private $actions = array();
    
    /**
    * Return all actions that are in this container
    *
    * @access public
    * @param void
    * @return array
    */
    function getActions() {
      return count($this->actions) ? $this->actions : null;
    } // getActions
    
    /**
    * Add single action
    *
    * @access public
    * @param PageAction $action
    * @return PageAction
    */
    function addAction(PageAction $action) {
      $this->actions[] = $action;
      return $action;
    } // addAction
    
    /**
    * Return single PageActions instance
    *
    * @access public
    * @param void
    * @return PageActions
    */
    function instance() {
      static $instance;
      
      // Check instance
      if (!($instance instanceof PageActions)) {
        $instance = new PageActions();
      } // if
      
      // Done!
      return $instance;
      
    } // instance
    
  } // PageActions

?>