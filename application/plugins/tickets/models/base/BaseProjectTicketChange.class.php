<?php

  /**
  * BaseProjectTicketChange class
  *
  * @http://www.projectpier.org/
  */
  abstract class BaseProjectTicketChange extends ApplicationDataObject {
  
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
    * Return value of 'type' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getType() {
      return $this->getColumnValue('type');
    } // getType()
    
    /**
    * Set value of 'type' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setType($value) {
      return $this->setColumnValue('type', $value);
    } // setType() 
    
    /**
    * Return value of 'from_data' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getFromData() {
      return $this->getColumnValue('from_data');
    } // getFromData()
   
    /**
    * Set value of 'from_data' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setFromData($value) {
      return $this->setColumnValue('from_data', $value);
    } // setFromData() 
    
    /**
    * Return value of 'to_data' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getToData() {
      return $this->getColumnValue('to_data');
    } // getToData()
    
    /**
    * Set value of 'to_data' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setToData($value) {
      return $this->setColumnValue('to_data', $value);
    } // setToData() 
    
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
    * Return manager instance
    *
    * @access protected
    * @param void
    * @return ProjectTicketChanges 
    */
    function manager() {
      if(!($this->manager instanceof TicketChanges)) { 
        $this->manager = ProjectTicketChanges::instance();
      }
      return $this->manager;
    } // manager
  
  } // BaseProjectTicketChange

?>