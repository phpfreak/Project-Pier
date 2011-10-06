<?php

  /**
  * BaseUser class
  *
  * @http://www.projectpier.org/
  */
  abstract class BaseUser extends ApplicationDataObject {

    public function __construct() {
      $this->attr_protected = array_merge($this->attr_protected, array('is_admin', 'auto_assign'));
    }
  
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
    * Return value of 'username' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getUsername() {
      return $this->getColumnValue('username');
    } // getUsername()
    
    /**
    * Set value of 'username' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setUsername($value) {
      return $this->setColumnValue('username', $value);
    } // setUsername() 
    
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
    * Return value of 'token' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getToken() {
      return $this->getColumnValue('token');
    } // getToken()
    
    /**
    * Set value of 'token' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setToken($value) {
      return $this->setColumnValue('token', $value);
    } // setToken() 
    
    /**
    * Return value of 'salt' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getSalt() {
      return $this->getColumnValue('salt');
    } // getSalt()
    
    /**
    * Set value of 'salt' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setSalt($value) {
      return $this->setColumnValue('salt', $value);
    } // setSalt() 
    
    /**
    * Return value of 'twister' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getTwister() {
      return $this->getColumnValue('twister');
    } // getTwister()
    
    /**
    * Set value of 'twister' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setTwister($value) {
      return $this->setColumnValue('twister', $value);
    } // setTwister() 
    
    /**
    * Return value of 'display_name' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getDisplayName() {
      return $this->getColumnValue('username');
    } // getDisplayName()
    
    /**
    * Set value of 'display_name' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setDisplayName($value) {
      return true;  // handled by contact now
    } // setDisplayName() 
    
    /**
    * Return value of 'title' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getTitle() {
      return $this->getColumnValue('title');
    } // getTitle()
    
    /**
    * Set value of 'title' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setTitle($value) {
      return $this->setColumnValue('title', $value);
    } // setTitle() 
    
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
    * Return value of 'last_login' field
    *
    * @access public
    * @param void
    * @return DateTimeValue 
    */
    function getLastLogin() {
      return $this->getColumnValue('last_login');
    } // getLastLogin()
    
    /**
    * Set value of 'last_login' field
    *
    * @access public   
    * @param DateTimeValue $value
    * @return boolean
    */
    function setLastLogin($value) {
      return $this->setColumnValue('last_login', $value);
    } // setLastLogin() 
    
    /**
    * Return value of 'last_visit' field
    *
    * @access public
    * @param void
    * @return DateTimeValue 
    */
    function getLastVisit() {
      return $this->getColumnValue('last_visit');
    } // getLastVisit()
    
    /**
    * Set value of 'last_visit' field
    *
    * @access public   
    * @param DateTimeValue $value
    * @return boolean
    */
    function setLastVisit($value) {
      return $this->setColumnValue('last_visit', $value);
    } // setLastVisit() 
    
    /**
    * Return value of 'last_activity' field
    *
    * @access public
    * @param void
    * @return DateTimeValue 
    */
    function getLastActivity() {
      return $this->getColumnValue('last_activity');
    } // getLastActivity()
    
    /**
    * Set value of 'last_activity' field
    *
    * @access public   
    * @param DateTimeValue $value
    * @return boolean
    */
    function setLastActivity($value) {
      return $this->setColumnValue('last_activity', $value);
    } // setLastActivity() 
    
    /**
    * Return value of 'is_admin' field
    *
    * @access public
    * @param void
    * @return boolean 
    */
    function getIsAdmin() {
      return $this->getColumnValue('is_admin');
    } // getIsAdmin()
    
    /**
    * Set value of 'is_admin' field
    *
    * @access public   
    * @param boolean $value
    * @return boolean
    */
    function setIsAdmin($value) {
      return $this->setColumnValue('is_admin', $value);
    } // setIsAdmin() 
    
    /**
    * Return value of 'auto_assign' field
    *
    * @access public
    * @param void
    * @return boolean 
    */
    function getAutoAssign() {
      return $this->getColumnValue('auto_assign');
    } // getAutoAssign()
    
    /**
    * Set value of 'auto_assign' field
    *
    * @access public   
    * @param boolean $value
    * @return boolean
    */
    function setAutoAssign($value) {
      return $this->setColumnValue('auto_assign', $value);
    } // setAutoAssign() 

    /**
    * Return value of 'use_LDAP' field
    *
    * @access public
    * @param void
    * @return boolean 
    */
    function getUseLDAP() {
      return $this->getColumnValue('use_LDAP');
    } // getUseLDAP()
    
    /**
    * Set value of 'use_LDAP' field
    *
    * @access public   
    * @param boolean $value
    * @return boolean
    */
    function setUseLDAP($value) {
      return $this->setColumnValue('use_LDAP', $value);
    } // setUseLDAP() 

    /**
    * Return manager instance
    *
    * @access protected
    * @param void
    * @return Users 
    */
    function manager() {
      if (!($this->manager instanceof Users)) {
        $this->manager = Users::instance();
      }
      return $this->manager;
    } // manager
  
  } // BaseUser 

?>