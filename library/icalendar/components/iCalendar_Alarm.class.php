<?php

  /**
  * Class that represents single alarm element in the calendar
  *
  * @package iCalendar
  * @http://www.projectpier.org/
  */
  final class iCalendar_Alarm extends iCalendar_Component {
  
    /**
    * Construct the iCalendar_Alarm
    *
    * @access public
    * @param void
    * @return iCalendar_Alarm
    */
    function __construct() {
      $this->setName('VALARM');
      $this->setValidProperties(
       'ACTION',
       'ATTACH',
       'ATTENDEE',
       'DESCRIPTION',
       'DURATION',
       'REPEAT',
       'SUMMARY', 
       'TRIGGER',
       'X-PROP'
      ); // setValidProperties
    } // __construct
  
  } // iCalendar_Alarm

?>