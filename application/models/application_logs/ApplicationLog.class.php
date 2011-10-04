<?php

  /**
  * ApplicationLog class
  * Generated on Tue, 07 Mar 2006 12:19:49 +0100 by DataObject generation tool
  *
  * @http://www.projectpier.org/
  */
  class ApplicationLog extends BaseApplicationLog {
    
    /**
    * Return user who made this acction
    *
    * @access public
    * @param void
    * @return User
    */
    function getTakenBy() {
      return Users::findById($this->getTakenById());
    } // getTakenBy
    
    /**
    * Return taken by display name
    *
    * @access public
    * @param void
    * @return string
    */
    function getTakenByDisplayName() {
      $taken_by = $this->getTakenBy();
      return $taken_by instanceof User ? $taken_by->getDisplayName() : lang('n/a');
    } // getTakenByDisplayName
    
    /**
    * Returns true if this application log is made today
    *
    * @access public
    * @param void
    * @return boolean
    */
    function isToday() {
      $now = DateTimeValueLib::now();
      $created_on = $this->getCreatedOn();
      
      // getCreatedOn and similar functions can return NULL
      if (!($created_on instanceof DateTimeValue)) {
        return false;
      }
      
      return $now->getDay() == $created_on->getDay() && 
             $now->getMonth() == $created_on->getMonth() && 
             $now->getYear() == $created_on->getYear();
    } // isToday
    
    /**
    * Returns true if this application log entry was made yesterday
    *
    * @param void
    * @return boolean
    */
    function isYesterday() {
      $created_on = $this->getCreatedOn();
      if (!($created_on instanceof DateTimeValue)) {
        return false;
      }
      
      $day_after = $created_on->advance(24 * 60 * 60, false);
      $now = DateTimeValueLib::now();
      
      return $now->getDay() == $day_after->getDay() && 
             $now->getMonth() == $day_after->getMonth() && 
             $now->getYear() == $day_after->getYear();
    } // isYesterday

    /**
    * Return project id with log entry or associated object
    *
    * @access public
    * @param void
    * @return integer
    */
    function getProjectId() {
      $project_id = parent::getProjectId();
      if ($project_id>0) { 
         return $project_id;
      }
      try {
        $object = $this->getObject();
        if ($object instanceof Project) {
          return $object->getId();
        }
        if ($object instanceof ProjectDataObject) {
          return $object->getProjectId();
        }
      } catch(Exception $e) {
        return false;
      }
      return false;
    } // getProjectId
  
    /**
    * Return project
    *
    * @access public
    * @param void
    * @return Project
    */
    function getProject() {
      return Projects::findById($this->getProjectId());
    } // getProject
    
    /**
    * Return text message for this entry. If is lang formed as 'log' + action + manager name
    * 
    * 'log add projectmessages'
    * 
    * Object name is passed as a first param so it can be used in a message
    *
    * @access public
    * @param void
    * @return string
    */
    function getText() {
      $code = strtolower('log ' . ($this->getAction()) . ' ' . $this->getRelObjectManager());
      return lang($code, $this->getObjectName());
    } // getText
  
    /**
    * Return object connected with this action
    *
    * @access public
    * @param void
    * @return ApplicationDataObject
    */
    function getObject() {
      return get_object_by_manager_and_id($this->getRelObjectId(), $this->getRelObjectManager());
    } // getObject
    
    /**
    * This function will try load related object and return its YRL. If object is not found '' is retuned
    *
    * @access public
    * @param void
    * @return string
    */
    function getObjectUrl() {
      $object = $this->getObject();
      return $object instanceof ApplicationDataObject ? $object->getObjectUrl() : null;
    } // getObjectMessage
    
    /**
    * Return object type name
    *
    * @param void
    * @return string
    */
   function getObjectTypeName() {
     $mgr = $this->getRelObjectManager(); // string
     $obj = new $mgr();                   // instance of $mgr
     $obj = $obj->getItemClass();         // string
     $obj = new $obj();                   // instance of item class
     return $obj instanceof ApplicationDataObject ? $obj->getObjectTypeName() : $mgr;
   } // getObjectTypeName
    
  } // ApplicationLog 

?>