<?php

  /**
  * Abstract upgrade script. Single script is used to upgrade product from $version_from 
  * to $verion_to or to execute some code changes regardles of the version
  *
  * @package ScriptUpgrader
  * @version 1.0
  * @http://www.projectpier.org/
  */
  abstract class ScriptUpgraderScript {
    
    /**
    * Output object
    *
    * @var Output
    */
    private $output;
    
    /**
    * Upgrader object that constructed this upgrade script
    *
    * @var ScriptUpgrader
    */
    private $upgrader;
  
    /**
    * Upgrade from version
    *
    * @var string
    */
    private $version_from;
    
    /**
    * Upgrader to version
    *
    * @var string
    */
    private $version_to;
    
    /**
    * Construct upgrade script
    *
    * @param Output $output
    * @return ScriptUpgraderScript
    */
    function __construct(Output $output) {
      $this->setOutput($output);
    } // __construct
    
    /**
    * Execute this script
    *
    * @param void
    * @return boolean
    */
    abstract function execute();
    
    /**
    * Return script name. This can be overriden by the single step
    *
    * @param void
    * @return string
    */
    function getScriptName() {
      return 'Upgrade ' . $this->getVersionFrom() . ' -> ' . $this->getVersionTo();
    } // getName
    
    // ---------------------------------------------------
    //  Utils
    // ---------------------------------------------------
    
    /**
    * Execute multiple queries
    * 
    * This one is really quick and dirty because I want to finish this and catch
    * the bus. Need to be redone ASAP
    * 
    * This function returns true if all queries are executed successfully
    *
    * @todo Make a better implementation
    * @param string $sql
    * @param integer $total_queries Total number of queries in SQL
    * @param integer $executed_queries Total number of successfully executed queries
    * @param resource $connection MySQL connection link
    * @return boolean
    */
    function executeMultipleQueries($sql, &$total_queries, &$executed_queries, $connection) {
      if (!trim($sql)) {
        $total_queries = 0;
        $executed_queries = 0;
        return true;
      } // if
      
      // Make it work on PHP 5.0.4
      $sql = str_replace(array("\r\n", "\r"), array("\n", "\n"), $sql);
      
      $queries = explode(";\n", $sql);
      if (!is_array($queries) || !count($queries)) {
        $total_queries = 0;
        $executed_queries = 0;
        return true;
      } // if
      
      $total_queries = count($queries);
      foreach ($queries as $query) {
        if (trim($query)) {
          if (@mysql_query(trim($query), $connection)) {
            $executed_queries++;
          } else {
            return false;
          } // if
        } // if
      } // if
      
      return true;
    } // executeMultipleQueries
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get upgrader
    *
    * @param null
    * @return ScriptUpgrader
    */
    function getUpgrader() {
      return $this->upgrader;
    } // getUpgrader
    
    /**
    * Set upgrader value
    *
    * @param ScriptUpgrader $value
    * @return null
    */
    function setUpgrader(ScriptUpgrader $value) {
      $this->upgrader = $value;
    } // setUpgrader
    
    /**
    * Get version_from
    *
    * @param null
    * @return string
    */
    function getVersionFrom() {
      return $this->version_from;
    } // getVersionFrom
    
    /**
    * Set version_from value
    *
    * @param string $value
    * @return null
    */
    protected function setVersionFrom($value) {
      $this->version_from = $value;
    } // setVersionFrom
    
    /**
    * Get version_to
    *
    * @param null
    * @return string
    */
    function getVersionTo() {
      return $this->version_to;
    } // getVersionTo
    
    /**
    * Set version_to value
    *
    * @param string $value
    * @return null
    */
    protected function setVersionTo($value) {
      $this->version_to = $value;
    } // setVersionTo
    
    /**
    * Return output instance
    *
    * @param void
    * @return Output
    */
    function getOutput() {
      return $this->output;
    } // getOutput
    
    /**
    * Set output object
    *
    * @param Output $output
    * @return Output
    */
    function setOutput(Output $output) {
      $this->output = $output;
      return $output;
    } // setOutput
    
    /**
    * Print message to the output
    *
    * @param string $message
    * @param boolean $is_error
    * @return null
    */
    function printMessage($message, $is_error = false) {
      if ($this->output instanceof Output) {
        $this->output->printMessage($message, $is_error);
      } // if
    } // printMessage
    
  } // ScriptUpgraderScript

?>