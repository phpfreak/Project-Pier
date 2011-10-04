<?php

  /**
  * ProjectTicketChange class
  *
  * @http://www.projectpier.org/
  */
  class ProjectTicketChange extends BaseProjectTicketChange {
    
    /**
    * ProjectTicket
    *
    * @var ProjectTicket
    */
    private $ticket;
    
    /**
    * Return ticket object
    *
    * @param void
    * @return ProjectTicket
    */
    function getTicket() {
      if(is_null($this->ticket)) $this->ticket = ProjectTickets::findById($this->getTicketId());
      return $this->ticket;
    } // getTicket
    
    /**
    * Return if data needs translation
    *
    * @param void
    * @return ProjectTicket
    */
    function dataNeedsTranslation() {
      return ($this->getType() == 'priority') || ($this->getType() == 'state') || ($this->getType() == 'type') || ($this->getType() == 'status') || ($this->getType() == 'private');
    } // dataNeedsTranslation
  
  } // ProjectTicketChange 

?>