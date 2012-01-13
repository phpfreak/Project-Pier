<?php

  /**
  * Class that implements method common to all application objects (users, companies, projects etc)
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  abstract class ApplicationDataObject extends DataObject {
    
    /**
    * Cached author object reference
    *
    * @var User
    */
    private $created_by = null;
    
    /**
    * Cached reference to user who created last update on object
    *
    * @var User
    */
    private $updated_by = null;
    
    /**
    * Return object ID
    *
    * @param void
    * @return integer
    */
    function getObjectId() {
      return $this->columnExists('id') ? $this->getId() : null;
    } // getObjectId
    
    /**
    * Return object name
    *
    * @param void
    * @return string
    */
    function getObjectName() {
      return $this->columnExists('name') ? $this->getName() : null;
    } // getObjectName
    
    /**
    * Return object type name - message, user, project etc
    *
    * @param void
    * @return string
    */
    function getObjectTypeName() {
      return '';
    } // getObjectTypeName
    
    /**
    * Return object URL
    *
    * @param void
    * @return string
    */
    function getObjectUrl() {
      return '#';
    } // getObjectUrl
    
    /**
    * Return time when this object was created
    *
    * @param void
    * @return DateTime
    */
    function getObjectCreationTime() {
      return $this->columnExists('created_on') ? $this->getCreatedOn() : null;
    } // getObjectCreationTime
    
    /**
    * Return time when this object was updated last time
    *
    * @param void
    * @return DateTime
    */
    function getObjectUpdateTime() {
      return $this->columnExists('updated_on') ? $this->getUpdatedOn() : $this->getObjectCreationTime();
    } // getOjectUpdateTime
    
    // ---------------------------------------------------
    //  Created by
    // ---------------------------------------------------
    
    /**
    * Return user who created this message
    *
    * @access public
    * @param void
    * @return User
    */
    function getCreatedBy() {
      trace(__FILE__,'getCreatedBy()');
      if (is_null($this->created_by)) {
        if ($this->columnExists('created_by_id')) {
          if ($this->getCreatedById()>0) {
            $this->created_by = Users::findById($this->getCreatedById());
          }
        }
      } // 
      return $this->created_by;
    } // getCreatedBy
    
    /**
    * Return display name of author
    *
    * @access public
    * @param void
    * @return string
    */
    function getCreatedByDisplayName() {
      $created_by = $this->getCreatedBy();
      return $created_by instanceof User ? $created_by->getDisplayName() : lang('n/a');
    } // getCreatedByDisplayName
    
    /**
    * Return card URL of created by user
    *
    * @param void
    * @return string
    */
    function getCreatedByCardUrl() {
      $created_by = $this->getCreatedBy();
      return $created_by instanceof User ? $created_by->getCardUrl() : null;
    } // getCreatedByCardUrl
    
    // ---------------------------------------------------
    //  Updated by
    // ---------------------------------------------------
    
    /**
    * Return user who updated this object
    *
    * @access public
    * @param void
    * @return User
    */
    function getUpdatedBy() {
      if (is_null($this->updated_by)) {
        if ($this->columnExists('updated_by_id')) {
          if ($this->getUpdatedById()>0) {
            $this->updated_by = Users::findById($this->getUpdatedById());
          }
        }
      } // 
      return $this->updated_by;
    } // getCreatedBy
    
    /**
    * Return display name of author
    *
    * @access public
    * @param void
    * @return string
    */
    function getUpdatedByDisplayName() {
      $updated_by = $this->getUpdatedBy();
      return $updated_by instanceof User ? $updated_by->getDisplayName() : lang('n/a');
    } // getUpdatedByDisplayName
    
    /**
    * Return card URL of created by user
    *
    * @param void
    * @return string
    */
    function getUpdatedByCardUrl() {
      $updated_by = $this->getUpdatedBy();
      return $updated_by instanceof User ? $updated_by->getCardUrl() : null;
    } // getUpdatedByCardUrl

    /**
    * Return object path (location of the object)
    *
    * @param void
    * @return string
    */
    function getObjectPath() {
      return array();
    } // getObjectPath

    /**
    * Delete specific object and associated objects
    *
    * @param void
    * @return boolean
    */
    function delete() {
      PageAttachments::clearAttachmentsByObject($this);
      return parent::delete();
    } // delete
      
  } // ApplicationDataObject

?>