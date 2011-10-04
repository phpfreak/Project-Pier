<?php

  /**
  * BaseFileType class
  *
  * @http://www.projectpier.org/
  */
  abstract class BaseFileType extends DataObject {
  
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
    * Return value of 'extension' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getExtension() {
      return $this->getColumnValue('extension');
    } // getExtension()
    
    /**
    * Set value of 'extension' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setExtension($value) {
      return $this->setColumnValue('extension', $value);
    } // setExtension() 
    
    /**
    * Return value of 'icon' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getIcon() {
      return $this->getColumnValue('icon');
    } // getIcon()
    
    /**
    * Set value of 'icon' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setIcon($value) {
      return $this->setColumnValue('icon', $value);
    } // setIcon() 
    
    /**
    * Return value of 'is_searchable' field
    *
    * @access public
    * @param void
    * @return boolean 
    */
    function getIsSearchable() {
      return $this->getColumnValue('is_searchable');
    } // getIsSearchable()
    
    /**
    * Set value of 'is_searchable' field
    *
    * @access public   
    * @param boolean $value
    * @return boolean
    */
    function setIsSearchable($value) {
      return $this->setColumnValue('is_searchable', $value);
    } // setIsSearchable() 
    
    /**
    * Return value of 'is_image' field
    *
    * @access public
    * @param void
    * @return boolean 
    */
    function getIsImage() {
      return $this->getColumnValue('is_image');
    } // getIsImage()
    
    /**
    * Set value of 'is_image' field
    *
    * @access public   
    * @param boolean $value
    * @return boolean
    */
    function setIsImage($value) {
      return $this->setColumnValue('is_image', $value);
    } // setIsImage() 
    
    
    /**
    * Return manager instance
    *
    * @access protected
    * @param void
    * @return FileTypes 
    */
    function manager() {
      if (!($this->manager instanceof FileTypes)) {
        $this->manager = FileTypes::instance();
      }
      return $this->manager;
    } // manager
  
  } // BaseFileType 

?>