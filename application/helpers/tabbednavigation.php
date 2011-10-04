<?php
  /**
  * Return all tabbed navigation items
  *
  * @access public
  * @param void
  * @return array
  */
  function tabbed_navigation_items() {
    // PLUGIN HOOK
    return plugin_manager()->apply_filters('tabbed_navigation_items',
                                   TabbedNavigation::instance()->getItems());
    // PLUGIN HOOK
  } // tabbed_navigation_items
  
  /**
  * Add one tabbed navigation item
  *
  * @access public
  * @param TabbedNavigationItem $item
  * @return TabbedNavigationItem
  */
  function add_tabbed_navigation_item($id, $title, $url) {
    $item = new TabbedNavigationItem($id, lang($title), $url);
    return TabbedNavigation::instance()->addItem($item);
  } // add_tabbed_navigation
  
  /**
  * Select specific tab
  *
  * @access public
  * @param string $id Tab ID
  * @return null
  */
  function tabbed_navigation_set_selected($id) {
    TabbedNavigation::instance()->setSelectedTab($id);
  } // tabbed_navigation_set_selected

  /**
  * Single tabbed navigation item
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class TabbedNavigationItem {
  
    /**
    * Tab ID, must be unique in tab set
    *
    * @var string
    */
    private $id;
    
    /**
    * Title
    *
    * @var string
    */
    private $title;
    
    /**
    * URL
    *
    * @var string
    */
    private $url;
    
    /**
    * Is this tab selected
    *
    * @var boolean
    */
    private $selected = false;
    
    /**
    * Construct the TabbedNavigationItem
    *
    * @access public
    * @param string $id
    * @param string $title
    * @param string $url
    * @param boolean $selected
    * @param array $attributes
    * @return TabbedNavigationItem
    */
    function __construct($id, $title, $url, $selected = false, $attributes = null) {
      $this->setId($id);
      $this->setTitle($title);
      $this->setURL($url);
      $this->setSelected($selected);
    } // __construct
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get id
    *
    * @access public
    * @param null
    * @return string
    */
    function getId() {
      return $this->id;
    } // getId
    
    /**
    * Set id value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setId($value) {
      $this->id = $value;
    } // setId
    
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
    
    /**
    * Get selected
    *
    * @access public
    * @param null
    * @return boolean
    */
    function getSelected() {
      return $this->selecteed;
    } // getSelected
    
    /**
    * Set selected value
    *
    * @access public
    * @param boolean $value
    * @return null
    */
    function setSelected($value) {
      $this->selecteed = $value;
    } // setSelected
  
  } // TabbedNavigationItem
  
  /**
  * Tabbed navigation handler
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class TabbedNavigation {
  
    /**
    * Array of navigation tiems
    *
    * @var array
    */
    private $items = array();
    
    /**
    * Select single tab
    *
    * @access public
    * @param string $id Tab ID
    * @return null
    */
    function setSelectedTab($id) {
      foreach ($this->items as &$item) {
        $item->setSelected( $item->getId() == $id );
      } // foreach
    } // setSelectedTab
    
    /**
    * Return selected tab
    *
    * @access public
    * @param void
    * @return TabbedNavigationItem
    */
    function getSelectedTab() {
      foreach ($this->items as &$item) {
        if ($item->getSelected()) {
          return $item;
        }
      }
      return null;
    } // getSelectedTab
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Return all navigation items
    *
    * @access public
    * @param void
    * @return array
    */
    function getItems() {
      return $this->items;
    } // getItems
    
    /**
    * Add single tabbed navigation item
    *
    * @access public
    * @param TabbedNavigationItem $item
    * @return null
    */
    function addItem(TabbedNavigationItem $item) {
      $this->items[$item->getId()] = $item;
      return $item;
    } // addItem
    
    /**
    * Return single TabbedNavigation instance
    *
    * @access public
    * @param void
    * @return TabbedNavigation
    */
    function instance() {
      static $instance;
      
      // Check instance
      if (!($instance instanceof TabbedNavigation)) {
        $instance = new TabbedNavigation();
      } // if
      
      // Done!
      return $instance;
      
    } // instance
  
  } // TabbedNavigation

?>