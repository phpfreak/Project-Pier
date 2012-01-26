<?php
  class Reminder extends BaseReminder {
    function isEnabled() {
      return $this->getRemindersEnabled();
    }	
  
    function getId() {
      return $this->getUserId();
    }
    
    function setId($value) {
      return $this->setUserId($value);
    }

    function sendReminderOn($day) {
      $days = $this->getColumnValue('reminder_days');
      $yes = strpos($days, $day);
      if ($yes === false) {
        return false;
      } else {
        return true;
      }
    }
  }
?>