<?php

  /**
  * Open HTML tag
  *
  * @access public
  * @param string $name Tag name
  * @param array $attributes Array of tag attributes
  * @param boolean $empty If tag is empty it will be automaticly closed
  * @return string
  */
  function open_html_tag($name, $attributes = null, $empty = false) {
    $attribute_string = '';
    if (is_array($attributes) && count($attributes)) {
      $prepared_attributes = array();
      foreach ($attributes as $k => $v) {
        if (trim($k) <> '') {
          
          if (is_bool($v)) {
            if ($v) {
              $prepared_attributes[] = "$k=\"$k\"";
            }
          } else {
            $prepared_attributes[] = $k . '="' . clean($v) . '"';
          } // if
          
        } // if
      } // foreach
      $attribute_string = implode(' ', $prepared_attributes);
    } // if
    
    $empty_string = $empty ? ' /' : ''; // Close?
    return "<$name $attribute_string$empty_string>"; // And done...
  } // html_tag
  
  /**
  * Close specific HTML tag
  *
  * @access public
  * @param string $name Tag name
  * @return string
  */
  function close_html_tag($name) {
    return "</$name>";
  } // close_html_tag
  
  /**
  * Return title tag
  *
  * @access public
  * @param string $title
  * @return string
  */
  function title_tag($title) {
    return open_html_tag('title') . $title . close_html_tag('title');
  } // title_tag

  /**
  * Prepare link tag
  *
  * @access public
  * @param string $href
  * @param string $rel_or_rev Rel or rev
  * @param string $rel
  * @param array $attributes
  * @return string
  */
  function link_tag($href, $rel_or_rev = 'rel', $rel = 'alternate', $attributes = null) {
    
    // Prepare attributes
    $all_attributes = array(
      'href' => $href,
      $rel_or_rev => $rel
    ); // array
    
    // Additional attributes
    if (is_array($attributes) && count($attributes)) {
      $all_attributes = array_merge($all_attributes, $attributes);
    } // if
  	  
    // And done!
    return open_html_tag('link', $all_attributes, true);
  	  
  } // link_tag
  
  /**
  * Rel link tag
  *
  * @access public
  * @param string $href
  * @param string $rel
  * @param string $attributes
  * @return string
  */
  function link_tag_rel($href, $rel, $attributes = null) {
    return link_tag($href, 'rel', $rel, $attributes);
  } // link_tag_rel
  
  /**
  * Rev link tag
  *
  * @access public
  * @param string $href
  * @param string $rel
  * @param string $attributes
  * @return string
  */
  function link_tag_rev($href, $rel, $attributes = null) {
    return link_tag($href, 'rev', $rel, $attributes);
  } // link_tag_rev
  
  /**
  * Return code of meta tag
  *
  * @access public
  * @param string $name Name of the meta property
  * @param string $content
  * @param boolean $http_equiv
  * @return string
  */
  function meta_tag($name, $content, $http_equiv = false) {
    
    // Name attribute
    $name_attribute = $http_equiv ? 'http-equiv' : 'name';
    
    // Prepare attributes
    $attributes = array(
      $name_attribute => $name,
      'content' => $content
    ); // array
    
    // And done...
    return open_html_tag('meta', $attributes, true);
    
  } // meta_tag
  
  /**
  * Generate javascript tag
  *
  * @access public
  * @param string $src Path to external file
  * @param string $content Tag content
  * @return string
  */
  function javascript_tag($src = null, $content = null) {
    
    // Content formatting
    if ($content) {
      $content = "\n" . $content . "\n";
    }
    
    // Prepare attributes
    $attributes = array('type' => 'text/javascript');
    if (!is_null($src)) {
      $attributes['src'] = is_valid_url($src) ? $src : get_javascript_url($src);
    } // if
    
    // Generate
    return open_html_tag('script', $attributes) . $content . close_html_tag('script');
    
  } // javascript_tag
  
  /**
  * Render stylesheet tag
  *
  * @access public
  * @param string $href URL of external stylesheet
  * @Param array $attributes
  * @return string
  */
  function stylesheet_tag($href, $attributes = null) {
    if (!is_valid_url($href)) {
      $href = get_stylesheet_url($href);
    } // if
    
    $all_attributes = array(
      'type' => 'text/css'
    ); // array
    
    if (is_array($attributes) && count($attributes)) {
      array_merge($all_attributes, $attributes);
    } // if
    
    return link_tag($href, 'rel', 'Stylesheet', $all_attributes);
  } // stylesheet_tag
  
  /**
  * Render style tag inside optional conditional comment
  *
  * @access public
  * @param string $content
  * @param string $condition Condition for conditional comment (IE, lte IE6...). If null
  *   conditional comment will not be added
  * @return string
  */
  function style_tag($content, $condition = null) {
    
    // Open and close for conditional comment
    $open = '';
    $close = '';
    if ($condition) {
      $open = "<!--[if $condition]>\n";
      $close = '<![endif]-->';
    } // if
    
    // And return...
    return $open . open_html_tag('style', array('type' => 'text/css')) . 
      "\n" . $content . "\n" . 
      close_html_tag('style') . "\n" . $close;
    
  } // style_tag

  /**
  * Style class for sequence number
  *
  * @access public
  * @param integer $seq_num
  * @return string
  */
  function odd_even_class(&$seq_num) {
    (isset($seq_num)) ? $seq_num++ : $seq_num = 1;
    return (($seq_num % 2) == 0) ? 'even' : 'odd';
  }

  /**
  * Page description class
  * 
  * Class that hold XHTML page properties. This class can be used from templates
  * to inform layouts that templates want some proprety changes. It is entirely
  * on layout to decide if it will use properties from instance of this class or
  * some other set of values.
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class PageDescription {
    
    /**
    * Page title
    *
    * @var string
    */
    private $title;
    
    /**
    * Array of page metadata
    *
    * @var array
    */
    private $meta = array();
    
    /**
    * Array of links
    *
    * @var array
    */
    private $links = array();
    
    /**
    * Array of inline CSS rules
    *
    * @var array
    */
    private $inline_css = array();
    
    /**
    * Array of links to external JS files
    *
    * @var array
    */
    private $javascript = array();
    
    /**
    * Array of inline JS code
    *
    * @var array
    */
    private $inline_js = array();
    
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
    * Get meta
    *
    * @access public
    * @param null
    * @return type
    */
    function getMeta() {
      return $this->meta;
    } // getMeta
    
    /**
    * Add page meta entry
    *
    * @access public
    * @param string $name
    * @param string $content
    * @param boolean $http_equiv
    * @return null
    */
    function addMeta($name, $content, $http_equiv = false) {
      $this->meta[] = array(
        'name'       => $name,
        'content'    => $content,
        'http_equiv' => $http_equiv
      ); // array
    } // addMeta
    
    /**
    * Get links
    *
    * @access public
    * @param null
    * @return array
    */
    function getLinks() {
      return $this->links;
    } // getLinks
    
    /**
    * Add rel link
    *
    * @param string $href Link locator
    * @param string $rel Rel value
    * @param string $attributes
    * @return mixed
    */
    function addRelLink($href, $rel = 'alternate', $attributes) {
      $this->addLink($href, 'rel', $rel, $attributes);
    } // end func addRelMedia
  	
    /**
    * Add rev link
    *
    * @param string $href Link locator
    * @param string $rev Rev value
    * @param array $attributes
    * @return mixed
    */
    function addRevLink($href, $rev = 'alternate', $attributes = null) {
      $this->addLink($href, 'rev', $rev, $attributes);
    } // end func addRevLink
  	
    /**
    * Add link
    *
    * @access public
    * @param string $href
    * @param string $rel_or_rev
    * @param string $rel
    * @param array $attributes
    * @return null
    */
    function addLink($href, $rel_or_rev = 'rel', $rel = 'alternate', $attributes = null) {
    
      // Do we have this link?
      foreach ($this->links as $link) {
        if (array_var($link, 'href') == $href) {
          return;
        }
      }
  	  
      // Prepare link attributes...
      $link = array(
        'href'      => $href,
        $rel_or_rev => $rel
      ); // array
  	  
      // Additional attributes
      if (is_array($attributes) && count($attributes)) {
        $link = array_merge($link, $attributes);
      }
      $this->links[] = $link;
    
    } // addLink
    
    /**
    * Get inline_css
    *
    * @access public
    * @param null
    * @return array
    */
    function getInlineCSS() {
      return $this->inline_css;
    } // getInlineCSS
    
    /**
    * Add inline CSS block
    *
    * @access public
    * @param string $content
    * @param string $condition
    * @return null
    */
    function addInlineCSS($content, $condition = null) {
      $this->inline_css[] = array(
        'content' => $content,
        'condition' => $condition
      ); // array
    } // addInlineCSS
    
    /**
    * Get javascription
    *
    * @access public
    * @param null
    * @return array
    */
    function getJavascript() {
      return $this->javascript;
    } // getJavascript
    
    /**
    * Add external JS link
    *
    * @access public
    * @param string $src JS file URL
    * @return null
    */
    function addJavascript($src) {
      $this->javascript[] = $src;
    } // addJavascript
    
    /**
    * Check if specific javascript file is included on page
    *
    * @access public
    * @param string $src
    * @return boolean
    */
    function isJavascriptIncluded($src) {
      return in_array($src, $this->inline_js);
    } // isJavascriptIncluded
    
    /**
    * Get inline_js
    *
    * @access public
    * @param null
    * @return array
    */
    function getInlineJS() {
      return $this->inline_js;
    } // getInlineJS
    
    /**
    * Add inline JS entry
    *
    * @access public
    * @param string
    * @return null
    */
    function addInlineJS($content) {
      $this->inline_js[] = $content;
    } // addInlineJS
  
    /**
    * Return single PageDescription instance
    *
    * @access public
    * @param void
    * @return PageDescription
    */
    static function instance() {
      static $instance;
      if (!instance_of($instance, 'PageDescription')) {
        $instance = new PageDescription();
      } // if
      return $instance;
    } // instance
    
  } // PageDescription
    
  /**
  * Return page title
  *
  * @access public
  * @param void
  * @return string
  */
  function get_page_title() {
    $page = PageDescription::instance();
    
    // If we dont have title use action
    if ($page->getTitle() == '') {
      $action = array_var($_GET, 'action');
      return $action ? ucfirst($action) : PRODUCT_NAME;
    } else {
      return $page->getTitle();
    } // if
  } // get_page_title
  
  /**
  * Set page title
  *
  * @access public
  * @param string $value
  * @return null
  */
  function set_page_title($value) {
    PageDescription::instance()->setTitle(clean($value));
  } // set_page_title
  
  /**
  * Add external stylesheet file to page
  *
  * @access public
  * @param string $href
  * @param string $title
  * @param string $media
  * @return null
  */
  function add_stylesheet_to_page($href, $title = null, $media = null) {
    if (!is_valid_url($href)) {
      $href = get_stylesheet_url($href);
    }
    $page = PageDescription::instance();
    $attributes = array('type' => 'text/css');
    if ($title) $attributes['title'] = $title;
    if ($media) $attributes['media'] = $media;
    $page->addRelLink($href, 'Stylesheet', $attributes); // addRelLink
  } // add_stylesheet_to_page
  
  /**
  * Add external JS to page
  *
  * @access public
  * @param string $src URL of external JS file
  * @return null
  */
  function add_javascript_to_page($src) {
    $page = PageDescription::instance();
    $page->addJavascript($src);
  } // add_javascript_to_page
  
  /**
  * Add inline JS to page
  *
  * @access public
  * @param string $content
  * @return null
  */
  function add_inline_javascript_to_page($content) {
    $page = PageDescription::instance();
    $page->addInlineJS($content);
  } // add_inline_javascript_to_page
  
  /**
  * Add inline CSS to page
  *
  * @access public
  * @param string $content
  * @param string $condition
  * @return null
  */
  function add_inline_css_to_page($content, $condition = null) {
    $page = PageDescription::instance();
    $page->addInlineCSS($content, $condition);
  } // add_inline_css_to_page
  
  /**
  * Return generated page meta code
  *
  * @access public
  * @param void
  * @return string
  */
  function render_page_meta() {
    
    // Get page instance...
    $page = PageDescription::instance();
    
    // Get meta...
    $meta = $page->getMeta();
    
    // Generated code...
    $generated_code = '';
    if (is_array($meta) && count($meta)) {
      $generated = array();
      foreach ($meta as $data) {
        $generated[] = meta_tag($data['name'], $data['content'], $data['http_equiv']);
      } // foreach
      $generated_code = implode("\n", $generated);
    } // if
    
    // Return...
    return $generated_code;
    
  } // render_page_meta
  
  /**
  * Render page links
  *
  * @access public
  * @param void
  * @return string
  */
  function render_page_links() {
    
    // Get page instance...
    $page = PageDescription::instance();
    
    // Getlinks...
    $links = $page->getLinks();
    
    // Prepare result
    $generated_code = '';
    
    // If we have links go...
    if (is_array($links) && count($links)) {
      $generated = array();
      foreach ($links as $data) {
        $href = array_var($data, 'href');

        
        $rel_or_rev = isset($data['rel']) ? 'rel' : 'rev';
        $rel = '';
        if (isset($data[$rel_or_rev])) {
          $rel = $data[$rel_or_rev];
          unset($data[$rel_or_rev]);
        } // if
        
        $generated[] = link_tag($href, $rel_or_rev, $rel, $data);
      } // if
      $generated_code = implode("\n", $generated);
    } // if
    
    return $generated_code;
  } // render_page_links
  
  /**
  * Render page inline CSS
  *
  * @access public
  * @param void
  * @return string
  */
  function render_page_inline_css() {
    
    // Get page instance...
    $page = PageDescription::instance();
    
    // Get inline CSS
    $css = $page->getInlineCSS();
    
    // Prepare result...
    $generated_code = '';
    
    // And get code...
    if (is_array($css) && count($css)) {
      $generated = array();
      foreach ($css as $data) {
        
        // Get...
        $content = array_var($data, 'content');
        $condition = array_var($data, 'condition');
        
        // If we have content generate tag...
        if ($content) {
          $generated[] = style_tag($content, $condition);
        }
        
      } // foreach
      $generated_code = implode("\n", $generated);
    } // if
    
    // And done!
    return $generated_code;
    
  } // render_page_inline_css
  
  /**
  * Render javascript tags
  *
  * @access public
  * @param void
  * @return string
  */
  function render_page_javascript() {
    
    // Get page instance...
    $page = PageDescription::instance();
    
    // Get page javascript...
    $javascript = $page->getJavascript();
    
    // Prepare result...
    $generated_code = '';
    
    // Loop...
    if (is_array($javascript) && count($javascript)) {
      $generated = array();
      foreach ($javascript as $data) {
        $generated[] = javascript_tag($data);
      } // foreach
      $generated_code = implode("\n", $generated);
    } // if
    
    // Done...
    return $generated_code;
    
  } // render_page_javascript
  
  /**
  * Render inline javascript
  *
  * @access public
  * @param void
  * @return string
  */
  function render_page_inline_js() {
    
    // Get page instance...
    $page = PageDescription::instance();
    
    // Get page javascript...
    $javascript = $page->getInlineJS();
    
    // Prepare result...
    $generated_code = '';
    
    // Loop...
    if (is_array($javascript) && count($javascript)) {
      $generated = array();
      foreach ($javascript as $data) {
        $generated[] = javascript_tag(null, $data);
      } // foreach
      $generated_code = implode("\n", $generated);
    } // if
    
    // Done...
    return $generated_code;
    
  } // render_page_inline_js
  
  /**
  * Render page head...
  *
  * @access public
  * @param string $title
  * @return string
  */
  function render_page_head() {
    $page = PageDescription::instance();
    
    $head = render_page_links() . "\n" .
      render_page_meta() . "\n" .
      render_page_javascript() . "\n" .
      render_page_inline_js() . "\n" .
      render_page_inline_css();
      
    return trim($head) . "\n";
  } // render_page_head
  
  /**
  * Return URL relative to public folder
  *
  * @param string $rel
  * @return string
  */
  function get_public_url($rel) {
    $base = trim(PUBLIC_FOLDER) == '' ? with_slash(ROOT_URL) : with_slash(with_slash(ROOT_URL) . PUBLIC_FOLDER);
    return $base . $rel;
  } // get_public_url
  
  /**
  * Return URL of specific file in /public/files
  *
  * @param string $file_name Name of the file or path relative to /public/files/
  * @return string
  */
  function get_file_url($file_name) {
    return get_public_url('files/' . $file_name);
  } // get_file_url
  
  /**
  * Return javascript URL
  *
  * @param string $file_name
  * @return string
  */
  function get_javascript_url($file_name) {
    if (file_exists(THEMES_DIR.'/'.config_option('theme')."/javascript/$file_name"))
      return get_public_url('assets/themes/'.config_option('theme')."/javascript/$file_name");
    else
      return get_public_url('assets/javascript/' . $file_name);
  } // get_javascript_url
  
  /**
  * Return URL of specific stylesheet
  *
  * @param string $file_name
  * @return string
  */
  function get_stylesheet_url($file_name) {
    static $theme = null;
    
    if (is_null($theme)) {
      if (function_exists('config_option')) {
        $theme = config_option('theme');
      } // if
      if (trim($theme) == '') {
        $theme = DEFAULT_THEME;
      } // if
    } // if
    
    return get_public_url("assets/themes/$theme/stylesheets/$file_name");
  } // get_stylesheet_url
  
  /**
  * Return image URl
  *
  * @param string $file_name
  * @return string
  */
  function get_image_url($file_name) {
    static $theme = null;
    
    if (is_null($theme)) {
      if (function_exists('config_option')) {
        $theme = config_option('theme');
      } // if
      if (trim($theme) == '') {
        $theme = DEFAULT_THEME;
      } // if
    } // if
    
    return get_public_url("assets/themes/$theme/images/$file_name");
  } // get_image_url

?>