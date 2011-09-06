<?php

  /**
  * ContactImValue class
  *
  * @http://www.projectpier.org/
  */
  class ContactImValue extends BaseContactImValue {
  
    /**
    * Return IM type
    *
    * @access public
    * @param void
    * @return ImType
    */
    function getImType() {
      return ImTypes::findById($this->getImTypeId());
    } // getImType
    
    /**
    * Return contact
    *
    * @access public
    * @param void
    * @return Contact
    */
    function getContact() {
      return Contacts::findById($this->getContactId());
    } // getContact
    
  } // ContactImValue 

?>