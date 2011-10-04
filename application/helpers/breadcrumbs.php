<?php

  /**
  * Return all crumbs
  *
  * @access public
  * @param void
  * @return array
  */
  function bread_crumbs() {
    return BreadCrumbs::instance()->getCrumbs();
  } // bread_crumbs
  
  /**
  * Add single bread crumb to the list
  *
  * @access public
  * @param string $title Crumb title, required
  * @param string $url Crumb URL, optional
  * @param string $attributes Additional crumb attributes like class etc. Optional
  * @return null
  */
  function add_bread_crumb($title, $url = null, $attributes = null) {
    BreadCrumbs::instance()->addCrumb( new BreadCrumb($title, $url, $attributes) );
  } // add_bread_crumb

  /**
  * Crumbs collection that can be accessed globaly thorugh instance() method
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class BreadCrumbs {
  
    /**
    * Array of crumbs
    *
    * @var array
    */
    private $crumbs;
    
    /**
    * This function is used to add bread crumbs based on params passed to the function
    *
    * @access public
    * @param array $args Params collecected by func_get_args() in some function
    * @return null
    */
    function addByFunctionArguments($args) {
      
      // First element is array
      if (is_array($args[0])) {
        
        foreach ($args[0] as $arg) {
          if (is_array($arg)) {
            
            // Get data...
            $title = $arg[0];
            $url = array_var($arg, 1, false) ? array_var($arg, 1) : null;
            $attributes = array_var($arg, 2, false) ? array_var($arg, 2) : null;
            
            // And add
            $this->addCrumb($title, $url, $attributes);
            
          } elseif (is_string($arg)) {
            $this->addCrumb($arg);
          } // if
        } // foreach
        
      // Its string
      } elseif (is_string($args[0])) {
        
        // Get data...
        $title = $args[0];
        $url = array_var($args, 1, false) ? array_var($args, 1) : null;
        $attributes = array_var($args, 2, false) ? array_var($args, 2) : null;
        
        // And add
        $this->addCrumb($title, $url, $attributes);
        
      } // if
      
    } // addByFunctionArguments
    
    // ---------------------------------------------------
    //  Getters and seters
    // ---------------------------------------------------
    
    /**
    * Return all crumbs
    *
    * @access public
    * @param void
    * @return array
    */
    function getCrumbs() {
      return $this->crumbs;
    } // getCrumbs
    
    /**
    * Add signle crumb. First param can be instance of BreadCrumb class. On the
    * other hand you can use three params (title, url and additional attributes)
    * instead of object
    *
    * @access public
    * @param void
    * @return BreadCrumb
    */
    function addCrumb() {
      $args = func_get_args();
      if (!is_array($args) || !count($args)) {
        return null;
      }
      
      // First apram is crumb
      if (array_var($args, 0) instanceof BreadCrumb) {
        $crumb = array_var($args, 0);
        
      // Collect vars and construct crumb
      } else {
        $title = $args[0];
        $url = array_var($args, 1, false) ? array_var($args, 1) : null;
        $attributes = array_var($args, 2, false) ? array_var($args, 2) : null;
        
        if (trim($title)) {
          $crumb = new BreadCrumb($title, $url, $attributes);
        } else {
          $crumb = null;
        } // if
      } // if
      
      if ($crumb instanceof BreadCrumb) {
        $this->crumbs[] = $crumb;
      }
      return $crumb;
    } // addCrumb
    
    /**
    * Return single BreadCrumbs instance
    *
    * @access public
    * @param void
    * @return BreadCrumbs
    */
    function instance() {
      static $instance;
      
      // Check instance
      if (!($instance instanceof BreadCrumbs)) {
        $instance = new BreadCrumbs();
      } // if
      
      // Done!
      return $instance;
      
    } // instance
    
  } // BreadCrumbs
  
  /**
  * Single bread crumb
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class BreadCrumb {
    
    /**
    * Crumb title. This value is required
    *
    * @var string
    */
    private $title;
    
    /**
    * Crumb URL, optional
    *
    * @var string
    */
    private $url;
    
    /**
    * Array of crumb attributes. Can hold class, javascript events etc
    *
    * @var array
    */
    private $attributes;
  
    /**
    * Construct the BreadCrumb
    *
    * @access public
    * @param string $title Crumb title, required
    * @param string $url Crumb URL, optional
    * @param string $attributes Additional crumb attributes like class etc. Optional
    * @return BreadCrumb
    */
    function __construct($title, $url = null, $attributes = null) {
      $this->setTitle($title);
      $this->setURL($url);
      $this->setAttributes($attributes);
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
    * Get URL
    *
    * @access public
    * @param null
    * @return string
    */
    function getURL() {
      return $this->url;
    } // getURL
    
    /**
    * Set URL value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setURL($value) {
      $this->url = $value;
    } // setURL
    
    /**
    * Get attributes
    *
    * @access public
    * @param null
    * @return array
    */
    function getAttributes() {
      return $this->attributes;
    } // getAttributes
    
    /**
    * Set attributes value
    *
    * @access public
    * @param array $value
    * @return null
    */
    function setAttributes($value) {
      $this->attributes = $value;
    } // setAttributes
  
  } // BreadCrumb

?>