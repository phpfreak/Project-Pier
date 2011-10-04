<?php

  /**
  * Script update framework. This simple tool will let us build most complext update scripts witout any problems
  *
  * @package ScriptUpdater
  * @version 1.0
  * @http://www.projectpier.org/
  */
  final class ScriptUpgrader {
    
    /**
    * Output object
    *
    * @var Output
    */
    private $output;
    
    /**
    * Upgrader name field
    *
    * @var string
    */
    private $name;
    
    /**
    * Upgrader description
    *
    * @var string
    */
    private $description;
  
    /**
    * Array of available upgrade scripts
    *
    * @var array
    */
    private $scripts = array();
    
    /**
    * Array of reported checklist items
    *
    * @var array
    */
    private $checklist_items = array();
    
    /**
    * Construct the ScriptUpgrader
    *
    * @param Output $output
    * @param string $name
    * @param string $desc
    * @return ScriptUpgrader
    */
    function __construct(Output $output, $name = null, $desc = null) {
      $this->setOutput($output);
      $this->setName($name);
      $this->setDescription($desc);
      
      $this->loadScripts();
    } // __construct
    
    /**
    * Execute upgrade script that is responsible for upgrade process from one version to targe version
    *
    * @param string $from_version
    * @param string $to_version
    * @return null
    */
    function upgrade($version_from, $version_to) {
      $scripts = $this->getScripts();
      if (is_array($scripts)) {
        foreach ($scripts as $script) {
          if (($script->getVersionFrom() == $version_from) && ($script->getVersionTo() == $version_to)) {
            $script->execute();
            return true;
          } // if
        } // foreach
      } // if
      
      $this->getOutput()->printMessage("There is no script that match your request ($version_from -> $version_to)");
    } // upgrade
    
    /**
    * Execute specfic upgrade script
    *
    * @param string $upgrader_script_class
    * @return boolean
    */
    function executeScript($upgrader_script_class) {
      $upgrader_script_file = UPGRADER_PATH . "/scripts/$upgrader_script_class.class.php";
      if (is_file($upgrader_script_file)) {
        if (!class_exists($upgrader_script_class)) {
          require_once $upgrader_script_file;
        } // if
        
        if (class_exists($upgrader_script_class)) {
          $installer_script = new $upgrader_script_class($this->getOutput());
          if ($installer_script instanceof ScriptUpgraderScript) {
            $installer_script->setUpgrader($this);
            
            $installer_script->execute();
            return true;
          } // if
        } // if
      } // if
      return false;
    } // executeScript
    
    // ---------------------------------------------------
    //  Utils
    // ---------------------------------------------------
    
    /**
    * Set content for layout
    *
    * @access public
    * @param string $content
    * @return null
    */
    function setContent($content) {
      tpl_assign('content_for_layout', $content);
    } // setContent
    
    /**
    * Load all scripts from /scripts folder
    *
    * @param void
    * @return null
    */
    private function loadScripts() {
      $script_path = UPGRADER_PATH . '/scripts';
      
      $d = dir($script_path);
      
      $scripts = array();
      while (($entry = $d->read()) !== false) {
        if (($entry == '.') || ($entry == '..')) {
          continue;
        } // if
        $file_path = $script_path . '/' . $entry;
        
        if (is_readable($file_path) && str_ends_with($file_path, '.class.php')) {
          include_once $file_path;
          $script_class = substr($entry, 0, strlen($entry) - 10);
          $script = new $script_class($this->getOutput());
          if ($script instanceof $script_class) {
            $script->setUpgrader($this);
            $scripts[] = $script;
          } // if
        } // if
      } // while
      $d->close();
      
      if (count($scripts)) {
        usort($scripts, 'compare_scripts_by_version_from');
        $this->scripts = $scripts;
      } // if
    } // loadScripts
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get output
    *
    * @param null
    * @return Output
    */
    function getOutput() {
      return $this->output;
    } // getOutput
    
    /**
    * Set output value
    *
    * @param Output $value
    * @return Output
    */
    function setOutput(Output $value) {
      $this->output = $value;
      return $value;
    } // setOutput
    
    /**
    * Get name
    *
    * @param null
    * @return string
    */
    function getName() {
      return $this->name;
    } // getName
    
    /**
    * Set name value
    *
    * @param string $value
    * @return null
    */
    function setName($value) {
      $this->name = $value;
    } // setName
    
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
    * Return array of loaded scripts
    *
    * @param void
    * @return array
    */
    function getScripts() {
      return $this->scripts;
    } // getScripts
    
    /**
    * Return all checklist items
    *
    * @param void
    * @return array
    */
    function getChecklistItems() {
      return $this->checklist_items;
    } // getChecklistItems
    
    /**
    * Add checklist item to the list
    *
    * @param string $group
    * @param string $text
    * @param boolean $checked
    * @return null
    */
    function addChecklistItem($group, $text, $checked = false) {
      if (!isset($this->checklist_items[$group]) || !is_array($this->checklist_items[$group])) {
        $this->checklist_items[$group] = array();
      } // if
      $this->checklist_items[$group][] = new ChecklistItem($text, $checked);
    } // addChecklistItem
  
  } // ScriptUpgrader

?>