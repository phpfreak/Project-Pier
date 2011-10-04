<?php

  /**
  * Feed class
  *
  * @package Angie.toys
  * @subpackage feed
  * @http://www.projectpier.org/
  */
  class Angie_Feed {
    
    /**
    * Feed title
    *
    * @var string
    */
    private $title;
    
    /**
    * Website URL
    *
    * @var string
    */
    private $link;
    
    /**
    * Feed description
    *
    * @var string
    */
    private $description;
    
    /**
    * Language used in feed
    *
    * @var string
    */
    private $language;
    
    /**
    * Feed author
    *
    * @var Angie_Feed_Author
    */
    private $author;
    
    /**
    * Array of feed items
    *
    * @var array
    */
    private $items = array();
  
    /**
    * Constructor
    * 
    * Construct the feed object and set feed properties
    *
    * @param string $title
    * @param string $link
    * @param string $description
    * @param string $language
    * @param Angie_Feed_Author $author
    * @return Angie_Feed
    */
    function __construct($title, $link, $description = null, $language = null, $author = null) {
      $this->setTitle($title);
      $this->setLink($link);
      $this->setDescription($description);
      $this->setLanguage($language);
      $this->setAuthor($author);
    } // __construct
    
    /**
    * Render in RSS 2.0 format
    *
    * @param void
    * @return string
    */
    function renderRSS2() {
      $renderer = new Angie_Feed_Renderer_RSS2();
      return $renderer->render($this);
    } // renderRSS2
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get title
    *
    * @param null
    * @return string
    */
    function getTitle() {
      return $this->title;
    } // getTitle
    
    /**
    * Set title value
    *
    * @param string $value
    * @return null
    */
    function setTitle($value) {
      $this->title = $value;
    } // setTitle
    
    /**
    * Get link
    *
    * @param null
    * @return string
    */
    function getLink() {
      return $this->link;
    } // getLink
    
    /**
    * Set link value
    *
    * @param string $value
    * @return null
    */
    function setLink($value) {
      $this->link = $value;
    } // setLink
    
    /**
    * Get description
    *
    * @param null
    * @return string
    */
    function getDescription() {
      return $this->description;
    } // getDescription
    
    /**
    * Set description value
    *
    * @param string $value
    * @return null
    */
    function setDescription($value) {
      $this->description = $value;
    } // setDescription
    
    /**
    * Get language
    *
    * @param null
    * @return string
    */
    function getLanguage() {
      return $this->language;
    } // getLanguage
    
    /**
    * Set language value
    *
    * @param string $value
    * @return null
    */
    function setLanguage($value) {
      $this->language = $value;
    } // setLanguage
    
    /**
    * Get author
    *
    * @param null
    * @return Angie_Feed_Author
    */
    function getAuthor() {
      return $this->author;
    } // getAuthor
    
    /**
    * Set author value
    *
    * @param Angie_Feed_Author $value
    * @return null
    */
    function setAuthor($value) {
      if (!is_null($value) && !($value instanceof Angie_Feed_Author)) {
        throw new InvalidInstanceError('value', $value, 'Angie_Feed_Author');
      } // if
      $this->author = $value;
    } // setAuthor
    
    /**
    * Return an array of feed items
    *
    * @param void
    * @return array
    */
    function getItems() {
      return $this->items;
    } // getItems
    
    /**
    * Add item to feed
    * 
    * This function will add single feed item to the feed and return the item that was added
    *
    * @param Angie_Feed_Item $item
    * @return Angie_Feed_Item
    */
    function addItem(Angie_Feed_Item $item) {
      $this->items[] = $item;
      return $item;
    } // addItem
  
  } // Angie_Feed

?>