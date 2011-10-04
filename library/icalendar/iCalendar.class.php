<?php

  class iCalendar {
  
    /**
    * Generate file
    *
    * @param iCalendar_Calendar $calendar One calendar of array of calendars that need to be rendered
    * @return string
    */
    static function render($calendar) {
      if (is_array($calendar)) {
        $result = '';
        foreach ($calendar as $single_calendar) {
          $result .= self::render($single_calendar) . "\r\n";
        } // foreach
        return $result;
      } // if
      
      if (!($calendar instanceof iCalendar_Calendar)) return ''; // nothing to render
      
      return $calendar->render();
    } // render
  
  } // iCalendar

?>