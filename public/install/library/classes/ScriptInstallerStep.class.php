<?php

  /**
  * ScriptInstallerStep
  *
  * @package ScriptInstaller
  * @subpackage library
  * @http://www.projectpier.org/
  */
  class ScriptInstallerStep {
  
    /**
    * Installer instance, set when we add this step to installer
    *
    * @var ScriptInstaller
    */
    protected $installer;
    
    /**
    * Step number, set by installer when we add this step to it
    *
    * @var integer
    */
    protected $step_number = 0;
    
    /**
    * Step name
    *
    * @var string
    */
    protected $name;
    
    /**
    * Previous step
    *
    * @var ScriptInstallerStep
    */
    protected $previous_step;
    
    /**
    * Next installation step
    *
    * @var ScriptInstallerStep
    */
    protected $next_step;
    
    /**
    * Next is disabled from some reason
    *
    * @var boolean
    */
    protected $next_disabled = false;
    
    /**
    * Execute installation step. If this function returns true installer will 
    * automaticly redirect to next step
    *
    * @access public
    * @param void
    * @return boolean
    */
    function execute() {
      return false;
    } // execute
    
    /**
    * Return next step URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getNextStepUrl() {
      $next_step = $this->getNextStep();
      return $next_step instanceof ScriptInstallerStep ? $next_step->getStepUrl() : null;
    } // getNextStepUrl
    
    /**
    * Returns true if there is next step
    *
    * @access public
    * @param void
    * @return boolean
    */
    function hasNextStep() {
      return $this->getNextStep() instanceof ScriptInstallerStep;
    } // hasNextStep
    
    /**
    * Return previous step URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getPreviousStepUrl() {
      $previous_step = $this->getPreviousStep();
      return $previous_step instanceof ScriptInstallerStep ? $previous_step->getStepUrl() : null;
    } // getPreviousStepUrl
    
    /**
    * Return previous step
    *
    * @access public
    * @param void
    * @return boolean
    */
    function hasPreviousStep() {
      return $this->getPreviousStep() instanceof ScriptInstallerStep;
    } // hasPreviousStep
    
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
    * Set content from template
    *
    * @access public
    * @param void
    * @return null
    */
    function setContentFromTemplate($template) {
      tpl_assign('content_for_layout', tpl_fetch(get_template_path($template)));
    } // setContentFromTemplate
    
    /**
    * Returns true if step form is submitted
    *
    * @access public
    * @param void
    * @return boolean
    */
    function isSubmitted() {
      return array_var($_POST, 'submitted') == 'submitted';
    } // isSubmitted
    
    // ---------------------------------------------------
    //  Installer interface functions
    // ---------------------------------------------------
    
    /**
    * Redirect to step
    *
    * @access public
    * @param ScriptInstallerStep $step
    * @return null
    */
    function goToStep($step) {
      if (!($this->installer instanceof ScriptInstaller)) {
        return false;
      }
      return $this->installer->goToStep($step);
    } // goToStep
    
    /**
    * Add message to checklist
    *
    * @param string $message
    * @param boolean $checked
    * @return null
    */
    function addToChecklist($message, $checked = false) {
      if (!($this->installer instanceof ScriptInstaller)) {
        return false;
      }
      return $this->installer->addToChecklist($message, $checked);
    } // addToChecklist
    
    /**
    * Add error
    *
    * @param string $error Error message
    * @return boolean
    */
    function addError($error) {
      if (!($this->installer instanceof ScriptInstaller)) {
        return false;
      }
      return $this->installer->addError($error);
    } // addError
    
    /**
    * Returns true if there are errors in installer
    *
    * @param void
    * @return boolean
    */
    function hasErrors() {
      if (!($this->installer instanceof ScriptInstaller)) {
        return false;
      }
      return $this->installer->hasErrors();
    } // hasErrors
    
    /**
    * Add varible value to storage
    *
    * @access public
    * @param string $variable_name
    * @param mixed $value
    * @return boolean
    */
    function addToStorage($variable_name, $value) {
      if (!($this->installer instanceof ScriptInstaller)) {
        return false;
      }
      return $this->installer->addToStorage($variable_name, $value);
    } // addToStorage
    
    /**
    * Get variable value from storage
    *
    * @access public
    * @param string $variable_name
    * @param $default This value is returned if $variable_name is not found
    *   in storage
    * @return mixed
    */
    function getFromStorage($variable_name, $default = null) {
      if (!($this->installer instanceof ScriptInstaller)) {
        return $default;
      }
      return $this->installer->getFromStorage($variable_name, $default);
    } // getFromStorage
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Return step URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getStepUrl() {
      return 'index.php?step=' . $this->getStepNumber();
    } // getStepUrl
    
    /**
    * Return installer instance
    *
    * @access public
    * @param void
    * @return ScriptInstaller
    */
    function &getInstaller() {
      return $this->installer;
    } // getInstaller
    
    /**
    * Set installer instance
    *
    * @access public
    * @param ScriptInstaller $installer
    * @return null
    */
    function setInstaller(&$installer) {
      if ($installer instanceof ScriptInstaller) {
        $this->installer = $installer;
      } // if
    } // setInstaller
    
    /**
    * Get step_number
    *
    * @access public
    * @param null
    * @return integer
    */
    function getStepNumber() {
      return $this->step_number;
    } // getStepNumber
    
    /**
    * Set step_number value
    *
    * @access public
    * @param integer $value
    * @return null
    */
    function setStepNumber($value) {
      $this->step_number = $value;
    } // setStepNumber
    
    /**
    * Get name
    *
    * @access public
    * @param null
    * @return string
    */
    function getName() {
      return $this->name;
    } // getName
    
    /**
    * Set name value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setName($value) {
      $this->name = $value;
    } // setName
    
    /**
    * Get previous_step
    *
    * @access public
    * @param null
    * @return ScriptInstallerStep
    */
    function &getPreviousStep() {
      return $this->previous_step;
    } // getPreviousStep
    
    /**
    * Set previous_step value
    *
    * @access public
    * @param ScriptInstallerStep $value
    * @return null
    */
    function setPreviousStep(&$value) {
      if ($value instanceof ScriptInstallerStep) {
        $this->previous_step = $value;
      } // if
    } // setPreviousStep
    
    /**
    * Get next_step
    *
    * @access public
    * @param null
    * @return ScriptInstallerStep
    */
    function &getNextStep() {
      return $this->next_step;
    } // getNextStep
    
    /**
    * Set next_step value
    *
    * @access public
    * @param ScriptInstallerStep $value
    * @return null
    */
    function setNextStep(&$value) {
      if ($value instanceof ScriptInstallerStep) {
        $this->next_step = $value;
      } // if 
    } // setNextStep
    
    /**
    * Get next_disabled
    *
    * @access public
    * @param null
    * @return boolean
    */
    function getNextDisabled() {
      return $this->next_disabled;
    } // getNextDisabled
    
    /**
    * Set next_disabled value
    *
    * @access public
    * @param boolean $value
    * @return null
    */
    function setNextDisabled($value) {
      $this->next_disabled = $value;
    } // setNextDisabled
  
  } // ScriptInstallerStep

?>