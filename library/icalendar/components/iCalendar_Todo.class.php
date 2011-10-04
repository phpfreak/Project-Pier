<?php

  /**
  * Class that represents single todo element in the calendar
  *
  * @package iCalendar
  * @http://www.projectpier.org/
  */
  final class iCalendar_Todo extends iCalendar_Component {
  
    /**
    * Construct the iCalendar_Todo
    *
    * @access public
    * @param void
    * @return iCalendar_Todo
    */
    function __construct() {
      $this->setName('VTODO');
      $this->setValidComponents('VALARM');
      $this->setValidProperties(
       'CLASS', 
       'COMPLETED', 
       'CREATED', 
       'DESCRIPTION', 
       'DTSTAMP',
       'DTSTART', 
       'GEO', 
       'LAST-MOD', 
       'LOCATION', 
       'ORGANIZER', 
       'PERCENT', 
       'PRIORITY', 
       'RECURID', 
       'SEQ', 
       'STATUS', 
       'SUMMARY', 
       'UID', 
       'URL', 
       'DUE', 
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
       'X-PROP'
      ); // setValidProperties
    } // __construct
  
  } // iCalendar_Todo

?>