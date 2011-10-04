<?php

  /**
  * ProjectTicketChanges class
  *
  * @http://www.projectpier.org/
  */
  class ProjectTicketChanges extends BaseProjectTicketChanges {
    
    /**
    * Return array of ticket's changes
    *
    * @param ProjectTicket $ticket
    * @return array
    */
    static function getChangesByTicket(ProjectTicket $ticket) {
      return self::findAll(array(
        'conditions' => array('`ticket_id` = ?', $ticket->getId()),
        'order' => '`created_on`'
      )); // array
    } // getChangesByTicket
    
  } // ProjectTicketChanges 

?>