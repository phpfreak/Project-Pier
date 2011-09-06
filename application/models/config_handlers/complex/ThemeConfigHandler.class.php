<?php

  class ThemeConfigHandler extends ConfigHandler {
  
    /**
    * Array of available themes (subfolders of themes folder)
    *
    * @var array
    */
    private $available_themes = array();
    
    /**
    * Constructor
    *
    * @param void
    * @return ThemeConfigHandler
    */
    function __construct() {
      $themes_dir = with_slash(THEMES_DIR);
      
      if (is_dir($themes_dir)) {
        $d = dir($themes_dir);
        while (($entry = $d->read()) !== false) {
          if (str_starts_with($entry, '.')) {
            continue;
          } // if
          
          if (is_dir($themes_dir . $entry)) {
            $this->available_themes[] = $entry;
          } // if
        } // while
        $d->close();
      } // if
    } // __construct
    
    /**
    * Render form control
    *
    * @param string $control_name
    * @return string
    */
    function render($control_name) {
      $options = array();
      
      foreach ($this->available_themes as $theme) {
        $option_attributes = $this->getValue() == $theme ? array('selected' => true) : null;
        $options[] = option_tag($theme, $theme, $option_attributes);
      } // foreach
      
      return select_box($control_name, $options);
    } // render
  
  } // ThemeConfigHandler

?>