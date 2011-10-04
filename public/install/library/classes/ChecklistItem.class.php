<?php

  /**
  * Checklist item used in installers checklist
  *
  * @package ScriptInstaller
  * @subpackage library
  * @http://www.projectpier.org/
  */
  class ChecklistItem {
    
    /**
    * Item message
    *
    * @var string
    */
    private $message;
    
    /**
    * Item is checked
    *
    * @var boolean
    */
    private $checked = false;
  
    /**
    * Construct the ChecklistItem
    *
    * @access public
    * @param void
    * @return ChecklistItem
    */
    function __construct($message, $checked = false) {
      $this->setMessage($message);
      $this->setChecked($checked);
    } // __construct
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get message
    *
    * @access public
    * @param null
    * @return string
    */
    function getMessage() {
      return $this->message;
    } // getMessage
    
    /**
    * Set message value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setMessage($value) {
      $this->message = $value;
    } // setMessage
    
    /**
    * Get checked
    *
    * @access public
    * @param null
    * @return boolean
    */
    function getChecked() {
      return $this->checked;
    } // getChecked
    
    /**
    * Set checked value
    *
    * @access public
    * @param boolean $value
    * @return null
    */
    function setChecked($value) {
      $this->checked = $value;
    } // setChecked
  
  } // ChecklistItem

?>