<?php

  /**
  * Object that represents single iCalendar event
  *
  * @package iCalendar
  * @http://www.projectpier.org/
  */
  final class iCalendar_Event extends iCalendar_Component {
  
    /**
    * Construct the iCalendar_Event
    *
    * @access public
    * @param void
    * @return iCalendar_Event
    */
    function __construct() {
      $this->setName('VEVENT');
      $this->setValidComponents('VALARM');
      $this->setValidProperties(
        'CLASS', 
        'CREATED', 
        'DESCRIPTION', 
        'DTSTART', 
        'GEO', 
        'LAST-MOD', 
        'LOCATION', 
        'ORGANIZER', 
        'PRIORITY', 
        'DTSTAMP', 
        'SEQ', 
        'STATUS', 
        'SUMMARY', 
        'TRANSP', 
        'UID', 
        'URL', 
        'RECURID', 
        'DTEND', 
        'DURATION', 
        'ATTACH', 
        'ATTENDEE', 
        'CATEGORIES', 
        'COMMENT',
        'CONTACT', 
        'EXDATE', 
        'EXRULE', 
        'RSTATUS', 
        'RELATED', 
        'RESOURCES', 
        'RDATE', 
        'RRULE',
        'ACTION',
        'ATTACH',
        'ATTENDEE',
        'DESCRIPTION',
        'DURATION',
        'REPEAT',
        'SUMMARY', 
        'TRIGGER',
        'BEGIN',
        'END',       
        'X-PROP'
      ); // setValidProperties
    } // __construct
  
  } // iCalendar_Event

?>