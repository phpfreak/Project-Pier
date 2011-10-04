<?php

  /**
  * BaseCompany class
  *
  * @http://www.projectpier.org/
  */
  abstract class BaseCompany extends ApplicationDataObject {
  
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
    * Return value of 'client_of_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getClientOfId() {
      return $this->getColumnValue('client_of_id');
    } // getClientOfId()
    
    /**
    * Set value of 'client_of_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setClientOfId($value) {
      return $this->setColumnValue('client_of_id', $value);
    } // setClientOfId() 
    
    /**
    * Return value of 'name' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getName() {
      return $this->getColumnValue('name');
    } // getName()
    
    /**
    * Set value of 'name' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setName($value) {
      return $this->setColumnValue('name', $value);
    } // setName() 
    
    /**
    * Return value of 'description' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getDescription() {
      return $this->getColumnValue('description');
    } // getDescription()
        
    /**
    * Set value of 'description' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setDescription($value) {
      return $this->setColumnValue('description', $value);
    } // setDescription() 
    
    /**
    * Return value of 'email' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getEmail() {
      return $this->getColumnValue('email');
    } // getEmail()
    
    /**
    * Set value of 'email' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setEmail($value) {
      return $this->setColumnValue('email', $value);
    } // setEmail() 
    
    /**
    * Return value of 'homepage' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getHomepage() {
      return $this->getColumnValue('homepage');
    } // getHomepage()
    
    /**
    * Set value of 'homepage' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setHomepage($value) {
      return $this->setColumnValue('homepage', $value);
    } // setHomepage() 
    
    /**
    * Return value of 'address' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getAddress() {
      return $this->getColumnValue('address');
    } // getAddress()
    
    /**
    * Set value of 'address' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setAddress($value) {
      return $this->setColumnValue('address', $value);
    } // setAddress() 
    
    /**
    * Return value of 'address2' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getAddress2() {
      return $this->getColumnValue('address2');
    } // getAddress2()
    
    /**
    * Set value of 'address2' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setAddress2($value) {
      return $this->setColumnValue('address2', $value);
    } // setAddress2() 
    
    /**
    * Return value of 'city' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getCity() {
      return $this->getColumnValue('city');
    } // getCity()
    
    /**
    * Set value of 'city' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setCity($value) {
      return $this->setColumnValue('city', $value);
    } // setCity() 
    
    /**
    * Return value of 'state' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getState() {
      return $this->getColumnValue('state');
    } // getState()
    
    /**
    * Set value of 'state' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setState($value) {
      return $this->setColumnValue('state', $value);
    } // setState() 
    
    /**
    * Return value of 'zipcode' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getZipcode() {
      return $this->getColumnValue('zipcode');
    } // getZipcode()
    
    /**
    * Set value of 'zipcode' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setZipcode($value) {
      return $this->setColumnValue('zipcode', $value);
    } // setZipcode() 
    
    /**
    * Return value of 'country' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getCountry() {
      return $this->getColumnValue('country');
    } // getCountry()
    
    /**
    * Set value of 'country' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setCountry($value) {
      return $this->setColumnValue('country', $value);
    } // setCountry() 
    
    /**
    * Return value of 'phone_number' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getPhoneNumber() {
      return $this->getColumnValue('phone_number');
    } // getPhoneNumber()
    
    /**
    * Set value of 'phone_number' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setPhoneNumber($value) {
      return $this->setColumnValue('phone_number', $value);
    } // setPhoneNumber() 
    
    /**
    * Return value of 'fax_number' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getFaxNumber() {
      return $this->getColumnValue('fax_number');
    } // getFaxNumber()
    
    /**
    * Set value of 'fax_number' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setFaxNumber($value) {
      return $this->setColumnValue('fax_number', $value);
    } // setFaxNumber() 
    
    /**
    * Return value of 'logo_file' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getLogoFile() {
      return $this->getColumnValue('logo_file');
    } // getLogoFile()
    
    /**
    * Set value of 'logo_file' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setLogoFile($value) {
      return $this->setColumnValue('logo_file', $value);
    } // setLogoFile() 

    /* Return value of 'is_favorite' field
    *
    * @access public
    * @param void
    * @return boolean
    */
    function getIsFavorite() {
      return $this->getColumnValue('is_favorite');
    } // getIsFavorite()

    /**
    * Set value of 'is_favorite' field
    *
    * @access public
    * @param string $value
    * @return boolean
    */
    function setIsFavorite($value) {
      return $this->setColumnValue('is_favorite', $value);
    } // setIsFavorite()
 
    /**
    * Return value of 'timezone' field
    *
    * @access public
    * @param void
    * @return float 
    */
    function getTimezone() {
      return $this->getColumnValue('timezone');
    } // getTimezone()
    
    /**
    * Set value of 'timezone' field
    *
    * @access public   
    * @param float $value
    * @return boolean
    */
    function setTimezone($value) {
      return $this->setColumnValue('timezone', $value);
    } // setTimezone() 
    
    /**
    * Return value of 'hide_welcome_info' field
    *
    * @access public
    * @param void
    * @return boolean 
    */
    function getHideWelcomeInfo() {
      return $this->getColumnValue('hide_welcome_info');
    } // getHideWelcomeInfo()
    
    /**
    * Set value of 'hide_welcome_info' field
    *
    * @access public   
    * @param boolean $value
    * @return boolean
    */
    function setHideWelcomeInfo($value) {
      return $this->setColumnValue('hide_welcome_info', $value);
    } // setHideWelcomeInfo() 
    
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
    * @return Companies 
    */
    function manager() {
      if (!($this->manager instanceof Companies)) {
        $this->manager = Companies::instance();
      }
      return $this->manager;
    } // manager
  
  } // BaseCompany 

?>