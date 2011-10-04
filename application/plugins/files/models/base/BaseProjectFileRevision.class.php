<?php

  /**
  * BaseProjectFileRevision class
  *
  * @http://www.projectpier.org/
  */
  abstract class BaseProjectFileRevision extends ProjectDataObject {
  
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
    function getId() {
      return $this->getColumnValue('id');
    } // getId()
    
    /**
    * Set value of 'id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setId($value) {
      return $this->setColumnValue('id', $value);
    } // setId() 
    
    /**
    * Return value of 'file_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getFileId() {
      return $this->getColumnValue('file_id');
    } // getFileId()
    
    /**
    * Set value of 'file_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setFileId($value) {
      return $this->setColumnValue('file_id', $value);
    } // setFileId() 
    
    /**
    * Return value of 'file_type_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getFileTypeId() {
      return $this->getColumnValue('file_type_id');
    } // getFileTypeId()
    
    /**
    * Set value of 'file_type_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setFileTypeId($value) {
      return $this->setColumnValue('file_type_id', $value);
    } // setFileTypeId() 
    
    /**
    * Return value of 'repository_id' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getRepositoryId() {
      return $this->getColumnValue('repository_id');
    } // getRepositoryId()
    
    /**
    * Set value of 'repository_id' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setRepositoryId($value) {
      return $this->setColumnValue('repository_id', $value);
    } // setRepositoryId() 

    /**
    * Set value of 'filename' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setFilename($value) {
      return $this->setColumnValue('filename', $value);
    } // setFilename() 
    
    /**
    * Return value of 'thumb_filename' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getThumbFilename() {
      return $this->getColumnValue('thumb_filename');
    } // getThumbFilename()
    
    /**
    * Set value of 'thumb_filename' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setThumbFilename($value) {
      return $this->setColumnValue('thumb_filename', $value);
    } // setThumbFilename() 
    
    /**
    * Return value of 'revision_number' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getRevisionNumber() {
      return $this->getColumnValue('revision_number');
    } // getRevisionNumber()
    
    /**
    * Set value of 'revision_number' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setRevisionNumber($value) {
      return $this->setColumnValue('revision_number', $value);
    } // setRevisionNumber() 
    
    /**
    * Return value of 'comment' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getComment() {
      return $this->getColumnValue('comment');
    } // getComment()
    
    /**
    * Set value of 'comment' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setComment($value) {
      return $this->setColumnValue('comment', $value);
    } // setComment() 
    
    /**
    * Return value of 'type_string' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getTypeString() {
      return $this->getColumnValue('type_string');
    } // getTypeString()
    
    /**
    * Set value of 'type_string' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setTypeString($value) {
      return $this->setColumnValue('type_string', $value);
    } // setTypeString() 
    
    /**
    * Return value of 'filesize' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getFilesize() {
      return $this->getColumnValue('filesize');
    } // getFilesize()
    
    /**
    * Set value of 'filesize' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setFilesize($value) {
      return $this->setColumnValue('filesize', $value);
    } // setFilesize() 
    
    /**
    * Return value of 'created_on' field
    *
    * @access public
    * @param void
    * @return DateTimeValue 
    */
    function getCreatedOn() {
      return $this->getColumnValue('created_on');
    } // getCreatedOn()
    
    /**
    * Set value of 'created_on' field
    *
    * @access public   
    * @param DateTimeValue $value
    * @return boolean
    */
    function setCreatedOn($value) {
      return $this->setColumnValue('created_on', $value);
    } // setCreatedOn() 
    
    /**
    * Return value of 'created_by_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getCreatedById() {
      return $this->getColumnValue('created_by_id');
    } // getCreatedById()
    
    /**
    * Set value of 'created_by_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setCreatedById($value) {
      return $this->setColumnValue('created_by_id', $value);
    } // setCreatedById() 
    
    /**
    * Return value of 'updated_on' field
    *
    * @access public
    * @param void
    * @return DateTimeValue 
    */
    function getUpdatedOn() {
      return $this->getColumnValue('updated_on');
    } // getUpdatedOn()
    
    /**
    * Set value of 'updated_on' field
    *
    * @access public   
    * @param DateTimeValue $value
    * @return boolean
    */
    function setUpdatedOn($value) {
      return $this->setColumnValue('updated_on', $value);
    } // setUpdatedOn() 
    
    /**
    * Return value of 'updated_by_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getUpdatedById() {
      return $this->getColumnValue('updated_by_id');
    } // getUpdatedById()
    
    /**
    * Set value of 'updated_by_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setUpdatedById($value) {
      return $this->setColumnValue('updated_by_id', $value);
    } // setUpdatedById() 
    
    /**
    * Return manager instance
    *
    * @access protected
    * @param void
    * @return ProjectFileRevisions 
    */
    function manager() {
      if (!($this->manager instanceof ProjectFileRevisions)) {
        $this->manager = ProjectFileRevisions::instance();
      }
      return $this->manager;
    } // manager
  
  } // BaseProjectFileRevision 

?>