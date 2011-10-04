<?php

  /**
  * UserImValue class
  * Generated on Wed, 22 Mar 2006 15:37:58 +0100 by DataObject generation tool
  *
  * @http://www.projectpier.org/
  */
  class UserImValue extends BaseUserImValue {
  
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
    * Return user
    *
    * @access public
    * @param void
    * @return User
    */
    function getUser() {
      return Users::findById($this->getUserId());
    } // getUser
    
  } // UserImValue 

?>