<?php

  /**
  * Single checklist item (text plus checked status)
  *
  * @package ScriptUpgrader
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class ChecklistItem {
  
    /**
    * Item text
    *
    * @var string
    */
    protected $text;
    
    /**
    * Is this item checked or not
    *
    * @var boolean
    */
    protected $checked = false;
    
    /**
    * Construct the ChecklistItem
    *
    * @access public
    * @param void
    * @return ChecklistItem
    */
    function __construct($text, $checked = false) {
      $this->setText($text);
      $this->setChecked($checked);
    } // __construct
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get text
    *
    * @param null
    * @return string
    */
    function getText() {
      return $this->text;
    } // getText
    
    /**
    * Set text value
    *
    * @param string $value
    * @return null
    */
    function setText($value) {
      $this->text = $value;
    } // setText
    
    /**
    * Get checked
    *
    * @param null
    * @return boolean
    */
    function getChecked() {
      return $this->checked;
    } // getChecked
    
    /**
    * Set checked value
    *
    * @param boolean $value
    * @return null
    */
    function setChecked($value) {
      $this->checked = $value;
    } // setChecked
  
  } // ChecklistItem

?>