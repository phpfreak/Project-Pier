<?php

  /**
  * Anonymous user class
  *
  * Anonymous users is user who is not registered in the system but can post
  * content from some public service or interface (through API). This type of
  * user is usualy used for comments on objects in database through public
  * interface (public bugtracker, public blog etc)
  * 
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class AnonymousUser {
    
    /**
    * Users name. Required value
    *
    * @var string
    */
    protected $name;
    
    /**
    * Users email address. This value is required and must be valid email address
    *
    * @var string
    */
    protected $email;
    
    /**
    * Users homepage. This value is optional and if present must be valid URL
    *
    * @var string
    */
    protected $homepage;
  
    /**
    * Construct the AnonymousUser
    *
    * @param string $name
    * @param string $email
    * @param string $homepage
    * @return AnonymousUser
    */
    function __construct($name, $email, $homepage = null) {
      $this->setName($name);
      $this->setEmail($email);
      $this->setHomepage($homepage);
    } // __construct
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get name
    *
    * @param null
    * @return string
    */
    function getName() {
      return $this->name;
    } // getName
    
    /**
    * Set name value
    *
    * @param string $value
    * @return null
    */
    function setName($value) {
      $this->name = $value;
    } // setName
    
    /**
    * Get email
    *
    * @param null
    * @return string
    */
    function getEmail() {
      return $this->email;
    } // getEmail
    
    /**
    * Set email value
    *
    * @param string $value
    * @return null
    */
    function setEmail($value) {
      $value = trim($value);
      if (is_valid_email($value)) {
        $this->email = $value;
      } else {
        throw new InvalidEmailAddressError($value);
      } // if
    } // setEmail
    
    /**
    * Get homepage
    *
    * @param null
    * @return string
    */
    function getHomepage() {
      return $this->homepage;
    } // getHomepage
    
    /**
    * Set homepage value
    *
    * @param string $value
    * @return null
    */
    function setHomepage($value) {
      $value = trim($value);
      if ($value && is_valid_url($value)) {
        $this->homepage = $value;
      }
    } // setHomepage
  
  } // AnonymousUser

?>