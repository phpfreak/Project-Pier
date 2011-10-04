<?php

  /**
  * BaseMessageSubscription class
  *
  * @http://www.projectpier.org/
  */
  abstract class BaseMessageSubscription extends DataObject {
  
    // -------------------------------------------------------
    //  Access methods
    // -------------------------------------------------------
  
    /**
    * Return value of 'message_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getMessageId() {
      return $this->getColumnValue('message_id');
    } // getMessageId()
    
    /**
    * Set value of 'message_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setMessageId($value) {
      return $this->setColumnValue('message_id', $value);
    } // setMessageId() 
    
    /**
    * Return value of 'user_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getUserId() {
      return $this->getColumnValue('user_id');
    } // getUserId()
    
    /**
    * Set value of 'user_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setUserId($value) {
      return $this->setColumnValue('user_id', $value);
    } // setUserId() 
    
    
    /**
    * Return manager instance
    *
    * @access protected
    * @param void
    * @return MessageSubscriptions 
    */
    function manager() {
      if (!($this->manager instanceof MessageSubscriptions)) {
        $this->manager = MessageSubscriptions::instance();
      }
      return $this->manager;
    } // manager
  
  } // BaseMessageSubscription 

?>