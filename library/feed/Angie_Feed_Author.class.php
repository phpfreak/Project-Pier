<?php

  /**
  * Feed author class
  * 
  * Object of Angie_Feed_Author describes single feed entry author described by name, email and homepage URL properties. 
  * Name and email properties are required
  *
  * @package Angie.toys
  * @subpackage feed
  * @http://www.projectpier.org/
  */
  class Angie_Feed_Author {
    
    /**
    * Author name
    *
    * @var string
    */
    private $name;
    
    /**
    * Author email address
    *
    * @var string
    */
    private $email;
    
    /**
    * Author homepage URL
    *
    * @var string
    */
    private $link;
  
    /**
    * Constructor
    *
    * @param string $name
    * @param string $email
    * @param string $link
    * @return Angie_Feed_Author
    * @throws InvalidParamError if $email or $link values are present but they are not valid
    */
    function __construct($name, $email, $link = null) {
      $this->setName($name);
      $this->setEmail($email);
      $this->setLink($link);
    } // __construct
    
    /**
    * Check if author object is empty
    * 
    * This function will return true if values of required fields are empty. Required fields are name and email. Link is 
    * optional
    *
    * @param void
    * @return boolean
    */
    function isEmpty() {
      return (trim($this->name) == '') && (trim($this->email) == '');
    } // isEmpty
    
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
    * @throws InvalidParamError
    */
    function setEmail($value) {
      if (!is_null($value) && !is_valid_email($value)) {
        throw new InvalidParamError('value', $value, "$value is not a valid email address");
      } // if
      $this->email = $value;
    } // setEmail
    
    /**
    * Get link
    *
    * @param null
    * @return string
    */
    function getLink() {
      return $this->link;
    } // getLink
    
    /**
    * Set link value
    *
    * @param string $value
    * @return null
    * @throws InvalidParamError
    */
    function setLink($value) {
      if (!is_null($value) && !is_valid_url($value)) {
        throw new InvalidParamError('value', $value, "$value is not a valid URL");
      } // if
      $this->link = $value;
    } // setLink
  
  } // Angie_Feed_Author

?>