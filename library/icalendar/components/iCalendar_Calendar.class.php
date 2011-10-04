<?php

  /**
  * Component that represents single calendar entry
  *
  * @package iCalendar
  * @http://www.projectpier.org/
  */
  final class iCalendar_Calendar extends iCalendar_Component {
  
    /**
    * Construct the iCalendar_Calendar
    *
    * @access public
    * @param void
    * @return iCalendar_Calendar
    */
    function __construct() {
      $this->setName('VCALENDAR');
      $this->setValidComponents('VEVENT', 'VTODO', 'VJOURNAL', 'VFREEBUSY', 'VTIMEZONE', 'VALARM');
      $this->setValidProperties('CALSCALE', 'METHOD', 'PRODID', 'VERSION');
    } // __construct
  
  } // iCalendar_Calendar

?>