<?php

  /**
  * Single date time value. This class provides some handy methods for working 
  * with timestamps and extracting data from them
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class DateTimeValue {
    
    /**
    * Weekend days
    *
    * @var array
    */
    private $weekendDays = array(0,6);
    /**
    * Internal timestamp value
    *
    * @var integer
    */
    private $timestamp;
    
    /**
    * Cached day value
    *
    * @var integer
    */
    private $day;
    
    /**
    * Cached month value
    *
    * @var integer
    */
    private $month;
    
    /**
    * Cached year value
    *
    * @var integer
    */
    private $year;
    
    /**
    * Cached hour value
    *
    * @var integer
    */
    private $hour;
    
    /**
    * Cached minutes value
    *
    * @var integer
    */
    private $minute;
    
    /**
    * Cached seconds value
    *
    * @var integer
    */
    private $second;
  
    /**
    * Construct the DateTimeValue
    *
    * @param integer $timestamp
    * @return DateTimeValue
    */
    function __construct($timestamp) {
      $this->setTimestamp($timestamp);
    } // __construct
    
    /**
    * Advance for specific time
    *
    * @param void
    * @param integer $input Move the timestamp for this number of seconds
    * @param boolean $mutate If true update this timestamp, else reutnr new object and dont touch internal timestamp
    * @throws InvalidParamError
    */
    function advance($input, $mutate = true) {
      $timestamp = (integer) $input;
      if ($timestamp <> 0) {
        if ($mutate) {
          $this->setTimestamp($this->getTimestamp() + $timestamp);
        } else {
          return new DateTimeValue($this->getTimestamp() + $timestamp);
        } // if
      } // if
    } // advance

    /**
    * Difference to another DateTime
    *
    * @param void
    * @param integer $input 
    * @return integer $seconds
    */
    function difference(DateTimeValue $input) {  
      return $this->getTimestamp() - $input->getTimestamp();
    } // difference
    
    /**
    * This function will return true if this day is today
    *
    * @param void
    * @return boolean
    */
    function isToday() {
      $today = DateTimeValueLib::now();
      return $this->getDay() == $today->getDay() &&
             $this->getMonth() == $today->getMonth() &&
             $this->getYear() == $today->getYear();
    } // isToday
    
    /**
    * This function will return true if this datetime is yesterday
    *
    * @param void
    * @return boolean
    */
    function isYesterday() {
      $yesterday = DateTimeValueLib::makeFromString('yesterday');
      return $this->getDay() == $yesterday->getDay() &&
             $this->getMonth() == $yesterday->getMonth() &&
             $this->getYear() == $yesterday->getYear();
    } // isYesterday

    /**
    * This function will return true if this datetime is a week-end day
    *
    * @param void
    * @return boolean
    */
    function isWeekend() {
      return in_array($this->format('w'), $this->weekendDays);
    } // isWeekend
    
    /**
    * This function will return true if this datetime is a weekday
    *
    * @param void
    * @return boolean
    */
    function isWeekday() {
      return !$this->isWeekend();
    } // isWeekday
    
    /**
    * This function will move interlan data to the beginning of day and return modified object. 
    * It can be called as:
    * 
    * $beggining = DateTimeValueLib::now()->beginningOfDay()
    *
    * @access public
    * @param void
    * @return DateTime
    */
    function beginningOfDay() {
      $this->setHour(0);
      $this->setMinute(0);
      $this->setSecond(0);
      return $this;
    } // beginningOfDay
    
    /**
    * This function will set hours, minutes and seconds to 23:59:59 and return this object.
    * 
    * If you wish to get end of this day simply type:
    * 
    * $end = DateTimeValueLib::now()->endOfDay()
    *
    * @access public
    * @param void
    * @return null
    */
    function endOfDay() {
      $this->setHour(23);
      $this->setMinute(59);
      $this->setSecond(59);
      return $this;
    } // endOfDay
    
    // ---------------------------------------------------
    //  Format to some standard values
    // ---------------------------------------------------
    
    /**
    * Return formated datetime
    *
    * @param string $format
    * @return string
    */
    function format($format) {
      return gmdate($format, $this->getTimestamp());
    } // format
    
    /**
    * Return datetime formated in MySQL datetime format
    *
    * @param void
    * @return string
    */
    function toMySQL() {
      return $this->format(DATE_MYSQL);
    } // toMySQL
    
    /**
    * Return ISO8601 formated time
    *
    * @param void
    * @return string
    */
    function toISO8601() {
      return $this->format(DATE_ISO8601);
    } // toISO
    
    /**
    * Return atom formated time (W3C format)
    *
    * @param void
    * @return string
    */
    function toAtom() {
      return $this->format(DATE_ATOM);
    } // toAtom
    
    /**
    * Return RSS format
    *
    * @param void
    * @return string
    */
    function toRSS() {
      return $this->format(DATE_RSS);
    } // toRSS
    
    /**
    * Return iCalendar formated date and time
    *
    * @param void
    * @return string
    */
    function toICalendar() {
      return $this->format('Ymd\THis\Z');
    } // toICalendar
    
    // ---------------------------------------------------
    //  Utils
    // ---------------------------------------------------
    
    /**
    * Break timestamp into its parts and set internal variables
    *
    * @param void
    * @return null
    */
    private function parse() {
      $data = getdate($this->timestamp);
      
      if ($data) {
        $this->year   = (integer) $data['year'];
        $this->month  = (integer) $data['mon'];
        $this->day    = (integer) $data['mday'];
        $this->hour   = (integer) $data['hours'];
        $this->minute = (integer) $data['minutes'];
        $this->second = (integer) $data['seconds'];
      } // if
    } // parse
    
    /**
    * Update internal timestamp based on internal param values
    *
    * @param void
    * @return null
    */
    private function setTimestampFromAttributes() {
      $this->setTimestamp(mktime(
        $this->hour, 
        $this->minute, 
        $this->second, 
        $this->month, 
        $this->day, 
        $this->year
      )); // setTimestamp
    } // setTimestampFromAttributes
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get timestamp
    *
    * @param null
    * @return integer
    */
    function getTimestamp() {
      return $this->timestamp;
    } // getTimestamp
    
    /**
    * Set timestamp value
    *
    * @param integer $value
    * @return null
    */
    private function setTimestamp($value) {
      $this->timestamp = $value;
      $this->parse();
    } // setTimestamp
    
    /**
    * Return year
    *
    * @param void
    * @return integer
    */
    function getYear() {
      return $this->year;
    } // getYear
    
    /**
    * Set year value
    *
    * @param integer $value
    * @return null
    */
    function setYear($value) {
      $this->year = (integer) $year;
      $this->setTimestampFromAttributes();
    } // setYear
    
    /**
    * Return numberic representation of month
    *
    * @param void
    * @return integer
    */
    function getMonth() {
      return $this->month;
    } // getMonth
    
    /**
    * Set month value
    *
    * @param integer $value
    * @return null
    */
    function setMonth($value) {
      $this->month = (integer) $value;
      $this->setTimestampFromAttributes();
    } // setMonth
    
    /**
    * Return days
    *
    * @param void
    * @return integer
    */
    function getDay() {
      return $this->day;
    } // getDay
    
    /**
    * Set day value
    *
    * @param integer $value
    * @return null
    */
    function setDay($value) {
      $this->day = (integer) $value;
      $this->setTimestampFromAttributes();
    } // setDay
    
    /**
    * Return hour
    *
    * @param void
    * @return integer
    */
    function getHour() {
      return $this->hour;
    } // getHour
    
    /**
    * Set hour value
    *
    * @param integer $value
    * @return null
    */
    function setHour($value) {
      $this->hour = (integer) $value;
      $this->setTimestampFromAttributes();
    } // setHour
    
    /**
    * Return minute
    *
    * @param void
    * @return integer
    */
    function getMinute() {
      return $this->minute;
    } // getMinute
    
    /**
    * Set minutes value
    *
    * @param integer $value
    * @return null
    */
    function setMinute($value) {
      $this->minute = (integer) $value;
      $this->setTimestampFromAttributes();
    } // setMinute
    
    /**
    * Return seconds
    *
    * @param void
    * @return integer
    */
    function getSecond() {
      return $this->second;
    } // getSecond
    
    /**
    * Set seconds
    *
    * @param integer $value
    * @return null
    */
    function setSecond($value) {
      $this->second = (integer) $value;
      $this->setTimestampFromAttributes();
    } // setSecond
  
  } // DateTimeValue

?>