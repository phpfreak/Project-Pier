<?php

  /**
  * BasePageAttachment class
  *
  * @http://www.projectpier.org/
  */
  abstract class BasePageAttachment extends DataObject {
  
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
    * Return value of 'rel_object_id' field
    *
    * @access public
    * @param void
    * @return integer
    */
    function getRelObjectId() {
      return $this->getColumnValue('rel_object_id');
    } // getRelObjectId()

    /**
    * Set value of 'rel_object_id' field
    *
    * @access public
    * @param integer $value
    * @return boolean
    */
    function setRelObjectId($value) {
      return $this->setColumnValue('rel_object_id', $value);
    } // setRelObjectId()

    /**
    * Return value of 'rel_object_manager' field
    *
    * @access public
    * @param void
    * @return string
    */
    function getRelObjectManager() {
      return $this->getColumnValue('rel_object_manager');
    } // getRelObjectManager()

    /**
    * Set value of 'rel_object_manager' field
    *
    * @access public
    * @param string $value
    * @return boolean
    */
    function setRelObjectManager($value) {
      return $this->setColumnValue('rel_object_manager', $value);
    } // setRelObjectManager()

    /**
    * Return value of 'project_id' field
    *
    * @access public
    * @param void
    * @return integer
    */
    function getProjectId() {
      return $this->getColumnValue('project_id');
    } // getProjectId()

    /**
    * Set value of 'project_id' field
    *
    * @access public
    * @param integer $value
    * @return boolean
    */
    function setProjectId($value) {
      return $this->setColumnValue('project_id', $value);
    } // setProjectId()

    /**
    * Return value of 'page_name' field
    *
    * @access public
    * @param void
    * @return string
    */
    function getPageName() {
      return $this->getColumnValue('page_name');
    } // getPageName()

    /**
    * Set value of 'page_name' field
    *
    * @access public
    * @param string $value
    * @return boolean
    */
    function setPageName($value) {
      return $this->setColumnValue('page_name', $value);
    } // setPageName()

    /**
    * Return value of 'text' field
    *
    * @access public
    * @param void
    * @return string
    */
    function getText() {
      return $this->getColumnValue('text');
    } // getText()
    
    /**
    * Set value of 'text' field
    *
    * @access public
    * @param string $value
    * @return boolean
    */
    function setText($value) {
      return $this->setColumnValue('text', $value);
    } // setText()
    
    /**
    * Return value of 'order' field
    *
    * @access public
    * @param void
    * @return integer
    */
    function getOrder() {
      return $this->getColumnValue('order');
    } // getOrder()
    
    /**
    * Set value of 'order' field
    *
    * @access public
    * @param integer $value
    * @return boolean
    */
    function setOrder($value) {
      return $this->setColumnValue('order', $value);
    } // setOrder()
    
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
    * @return PageAttachments
    */
    function manager() {
      if (!($this->manager instanceof PageAttachments)) {
        $this->manager = PageAttachments::instance();
      }
      return $this->manager;
    } // manager
  
  } // BasePageAttachment

?>