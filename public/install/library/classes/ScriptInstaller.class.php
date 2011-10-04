<?php

  /**
  * Script installer
  *
  * @package ScriptInstaller
  * @subpackage library
  * @http://www.projectpier.org/
  */
  class ScriptInstaller {
    
    /**
    * Installation name
    *
    * @var string
    */
    private $installation_name;
    
    /**
    * Installation description
    *
    * @var string
    */
    private $installation_description;
  
    /**
    * Array of installation steps
    *
    * @var array
    */
    private $steps = array();
    
    /**
    * List of errors
    *
    * @var array
    */
    private $errors = array();
    
    /**
    * Checklist is used in steps with reports made of messages that 
    * can be marked as error or success
    *
    * @var array
    */
    private $checklist = array();
    
    /**
    * Construct the ScriptInstaller
    *
    * @access public
    * @param void
    * @return ScriptInstaller
    */
    function __construct($name, $description) {
      $this->setInstallationName($name);
      $this->setInstallationDescription($description);
    } // __construct
    
    /**
    * Go to specific step
    *
    * @access public
    * @param integer $step Step instance or step number
    * @return boolean
    */
    function goToStep($step) {
      if (!($step instanceof ScriptInstallerStep)) {
        $step = $this->getStep($step);
      }
      if (!($step instanceof ScriptInstallerStep)) {
        die("Step '$step_number' does not exist in the installation process");
      } // if
      redirect_to($step->getStepUrl());
    } // goToStep
    
    /**
    * Execute specific step
    *
    * @access public
    * @param integer $step_number
    * @return null
    */
    function executeStep($step_number) {
      $step = $this->getStep($step_number);
      if (!($step instanceof ScriptInstallerStep)) {
        die("Step '$step_number' does not exist in the installation process");
      } // if
      
      tpl_assign('installer', $this);
      tpl_assign('current_step', $step);
      tpl_assign('installation_name', $this->getInstallationName());
      tpl_assign('installation_description', $this->getInstallationDescription());
      
      $execution_result = $step->execute();
      
      // If execute() returns true redirect to next step (if exists)
      if ($execution_result) {
        $this->addExecutedStep($step_number);
        
        $next_step = $step->getNextStep();
        if ($next_step instanceof ScriptInstallerStep) {
          $this->goToStep($next_step->getStepNumber());
        } // if
      } else {
        tpl_display(get_template_path('layout.php'));
      } // if
      
    } // executeStep
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get installation_name
    *
    * @access public
    * @param null
    * @return string
    */
    function getInstallationName() {
      return $this->installation_name;
    } // getInstallationName
    
    /**
    * Set installation_name value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setInstallationName($value) {
      $this->installation_name = $value;
    } // setInstallationName
    
    /**
    * Get installation_description
    *
    * @access public
    * @param null
    * @return string
    */
    function getInstallationDescription() {
      return $this->installation_description;
    } // getInstallationDescription
    
    /**
    * Set installation_description value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setInstallationDescription($value) {
      $this->installation_description = $value;
    } // setInstallationDescription
    
    /**
    * Return array of steps
    *
    * @access public
    * @param void
    * @return array
    */
    function getSteps() {
      return $this->steps;
    } // getSteps
    
    /**
    * Return $num step
    *
    * @access public
    * @param integer $num Step number, counting starts from 1
    * @return ScriptInstallerStep
    */
    function getStep($num) {
      $num = (integer) $num - 1;
      return isset($this->steps[$num]) ? $this->steps[$num] : null;
    } // getStep
    
    /**
    * Add step to installer. If step is successfully added this function return
    * its step number. In case of any error FALSE is returned
    *
    * @access public
    * @param ScriptInstallerStep $step
    * @return integer
    */
    function addStep($step) {
      if (!($step instanceof ScriptInstallerStep)) {
        return false;
      }
      
      $step_number = count($this->steps) + 1;
      
      $step->setInstaller($this);
      $step->setStepNumber($step_number);
      
      $previous_step = $this->getStep($step_number - 1);
      if ($previous_step instanceof ScriptInstallerStep) {
        $step->setPreviousStep($previous_step);
        $previous_step->setNextStep($step);
      } // if
      
      $this->steps[] = $step;
      return $step_number;
    } // addStep
    
    /**
    * Add specific variable to storage
    *
    * @access public
    * @param string $variable_name
    * @param mixed $value
    * @return boolean
    */
    function addToStorage($variable_name, $value) {
      if (!$trimmed = trim($variable_name)) {
        return false;
      }
      if (!isset($_SESSION[STORAGE_SESSION_VARIABLE])) {
        $_SESSION[STORAGE_SESSION_VARIABLE] = array();
      }
      $_SESSION[STORAGE_SESSION_VARIABLE][$trimmed] = $value;
    } // addToStorage
    
    /**
    * Return $variable_name value from storage
    *
    * @access public
    * @param string $variable_name
    * @param mixed $default Default value is returned in case when
    *   $variable_name is not found in storage
    * @return null
    */
    function getFromStorage($variable_name, $default = null) {
      if (isset($_SESSION[STORAGE_SESSION_VARIABLE]) && isset($_SESSION[STORAGE_SESSION_VARIABLE][$variable_name])) {
        return $_SESSION[STORAGE_SESSION_VARIABLE][$variable_name];
      } // if
      return $default;
    } // getFromStorage
    
    /**
    * Clear data from storage
    *
    * @param void
    * @return null
    */
    function clearStorage() {
      if (isset($_SESSION[STORAGE_SESSION_VARIABLE])) {
        unset($_SESSION[STORAGE_SESSION_VARIABLE]);
      } // if
    } // clearStorage
    
    /**
    * Return errors list
    *
    * @param void
    * @return array
    */
    function getErrors() {
      return $this->errors;
    } // getErrors
    
    /**
    * Add error message
    *
    * @param string $error
    * @return null
    */
    function addError($error) {
      if (trim($error)) {
        $this->errors[] = $error;
        return true;
      } else {
        return false;
      } // if
    } // addError
    
    /**
    * Returns true if there are errors in error array
    *
    * @param void
    * @return boolean
    */
    function hasErrors() {
      return (boolean) count($this->errors);
    } // hasErrors
    
    /**
    * Return checklist array
    *
    * @access public
    * @param void
    * @return array
    */
    function getChecklist() {
      return $this->checklist;
    } // getChecklist
    
    /**
    * Add specific message to checklist
    *
    * @access public
    * @param string $message
    * @param boolean $checked
    * @return null
    */
    function addToChecklist($message, $checked = false) {
      $this->checklist[] = new ChecklistItem($message, $checked);
    } // addToChecklist
    
    /**
    * Returns true if $step is executed
    *
    * @access public
    * @param integer $step Step number
    * @return boolean
    */
    function isExecutedStep($step) {
      if (!isset($_SESSION[EXECUTED_STEPS_SESSION_VARIABLE]) || !is_array($_SESSION[EXECUTED_STEPS_SESSION_VARIABLE])) {
        $_SESSION[EXECUTED_STEPS_SESSION_VARIABLE] = array();
      }
      return in_array($step, $_SESSION[EXECUTED_STEPS_SESSION_VARIABLE]);
    } // isExecutedStep
    
    /**
    * Register that step is executed
    *
    * @access public
    * @param void
    * @return boolean
    */
    function addExecutedStep($step) {
      $step = (integer) $step;
      if (!isset($this->steps[$step])) {
        return false;
      }
      
      if (!isset($_SESSION[EXECUTED_STEPS_SESSION_VARIABLE]) || !is_array($_SESSION[EXECUTED_STEPS_SESSION_VARIABLE])) {
        $_SESSION[EXECUTED_STEPS_SESSION_VARIABLE] = array();
      }
      $_SESSION[EXECUTED_STEPS_SESSION_VARIABLE][] = $step;
      return true;
    } // addExecutedStep
  
  } // ScriptInstaller

?>