<?php

  /**
  * BaseProjectTicketSubscription class
  *
  * @http://www.projectpier.org/
  */
  abstract class BaseProjectTicketSubscription extends DataObject {
  
    // -------------------------------------------------------
    //  Access methods
    // -------------------------------------------------------
  
    /**
    * Return value of 'ticket_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getTicketId() {
      return $this->getColumnValue('ticket_id');
    } // getTicketId()
    
    /**
    * Set value of 'ticket_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setTicketId($value) {
      return $this->setColumnValue('ticket_id', $value);
    } // setTicketId() 
    
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
    * @return TicketSubscriptions 
    */
    function manager() {
      if(!($this->manager instanceof ProjectTicketSubscriptions)) $this->manager = ProjectTicketSubscriptions::instance();
      return $this->manager;
    } // manager
  
  } // BaseProjectTicketSubscription

?>