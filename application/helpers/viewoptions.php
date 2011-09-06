<?php

  /**
  * Return all view options
  *
  * @access public
  * @param void
  * @return array
  */
  function view_options() {
    return ViewOptions::instance()->getOptions();
  } // view_options
  
  /**
  * Add single view option
  * 
  * @access public
  * @param string $title
  * @param string $url
  * @return ViewOption
  */
  function add_view_option($title, $img, $url) {
    
    if (!empty($title) && !empty($url)) {
      ViewOptions::instance()->addOption( new ViewOption($title, $img, $url) );
    } // if
   
  } // add_view_option

  /**
  * Single view option
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class ViewOption {
    
    /**
    * View title
    *
    * @var string
    */
    private $title;

    /**
    * View image
    *
    * @var string
    */
    private $img;
    
    /**
    * Option URL
    *
    * @var string
    */
    private $url;
  
    /**
    * Construct the ViewOption
    *
    * @access public
    * @param void
    * @return ViewOption
    */
    function __construct($title, $img, $url) {
      $this->setTitle($title);
      $this->setImageURL($img);
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
    * Get image url
    *
    * @access public
    * @param null
    * @return string
    */
    function getImageURL() {
      return $this->img;
    } // getURL
    
    /**
    * Set image url value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setImageURL($value) {
      $this->img = $value;
    } // setURL
      
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
  
  } // ViewOption
  
  /**
  * view options container that can be accessed globaly
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class ViewOptions {
    
    /**
    * Array of ViewOption objects
    *
    * @var array
    */
    private $options = array();
    
    /**
    * Return all options that are in this container
    *
    * @access public
    * @param void
    * @return array
    */
    function getOptions() {
      return count($this->options) ? $this->options : null;
    } // getOptions
    
    /**
    * Add single option
    *
    * @access public
    * @param ViewOption $option
    * @return ViewOption
    */
    function addOption(ViewOption $option) {
      $this->options[] = $option;
      return $option;
    } // addOption
    
    /**
    * Return single ViewOptions instance
    *
    * @access public
    * @param void
    * @return ViewOptions
    */
    function instance() {
      static $instance;
      
      // Check instance
      if (!($instance instanceof ViewOptions)) {
        $instance = new ViewOptions();
      } // if
      
      // Done!
      return $instance;
      
    } // instance
    
  } // ViewOptions

?>