<?php

  abstract class BaseReminder extends DataObject {
    
    // -------------------------------------------------------
    //  Access methods
    // -------------------------------------------------------
  
    /**
    * Return value of 'id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getUserId() {
      return $this->getColumnValue('user_id');
    } // getId()
    
    /**
    * Set value of 'id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setUserId($value) {
      return $this->setColumnValue('user_id', $value);
    } // setId() 
    
    
    function getRemindersEnabled() {
      return $this->getColumnValue('reminders_enabled');
    } 

    function setRemindersEnabled($value) {
      return $this->setColumnValue('reminders_enabled', $value);
    }  
    
    function getSummarizedBy() {
      return $this->getColumnValue('summarized_by');
    } 

    function setSummarizedBy($value) {
      return $this->setColumnValue('summarized_by', $value);
    }
    
    function getRemindersFuture() {
      return $this->getColumnValue('days_in_future');
    } 

    function setRemindersFuture($value) {
      return $this->setColumnValue('days_in_future', $value);
    }  
 
 	function getIncludeEveryone() {
 		return $this->getColumnValue('include_everyone');
 	}
  
 	function setIncludeEveryone($value) {
 		return $this->setColumnValue('include_everyone', $value);
 	}

    function getReminderDaysToSend() {
      return $this->getColumnValue('reminder_days');
    } 

    function setReminderDaysToSend($value) {
      return $this->setColumnValue('reminder_days', $value);
    }  

    function getReportsEnabled() {
      return $this->getColumnValue('reports_enabled');
    } 

    function setReportsEnabled($value) {
      return $this->setColumnValue('reports_enabled', $value);
    }  

    function getReportsSummarizedBy() {
      return $this->getColumnValue('reports_summarized_by');
    } 

    function setReportsSummarizedBy($value) {
      return $this->setColumnValue('reports_summarized_by', $value);
    }  

    function getReportsIncludeEveryone() {
      return $this->getColumnValue('reports_include');
    } 

    function setReportsIncludeEveryone($value) {
      return $this->setColumnValue('reports_include', $value);
    }  

    function getReportsIncludeActivity() {
      return $this->getColumnValue('reports_activity');
    } 

    function setReportsIncludeActivity($value) {
      return $this->setColumnValue('reports_activity', $value);
    }  

    function getReportDay() {
      return $this->getColumnValue('report_day');
    } 

    function setReportDay($value) {
      return $this->setColumnValue('report_day', $value);
    }  

    /**
    * Return manager instance
    *
    * @access protected
    * @param void
    * @return ProjectForms 
    */
    function manager() {
      if (!($this->manager instanceof Reminders)) {
        $this->manager = Reminders::instance();
      }
      return $this->manager;
    } // manager

  
  }
  

?>
