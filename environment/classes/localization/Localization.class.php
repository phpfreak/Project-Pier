<?php
include_once 'persian.php';

function utf8_strrev($str, $reverse_numbers = true){
    $pattern = $reverse_numbers ? '/./us' : '/(\d+)?./us';
    preg_match_all($pattern, $str, $ar);
    return join('',array_reverse($ar[0]));
} 


  /**
  * Localization class
  *
  * This class will set up PHP environment to mach locale settings (using 
  * setlocale() function) and import apropriate set of words from language
  * folder. Properties of this class are used by some other system classes
  * for outputing data in correct format (for instance DateTimeValueLib).
  * 
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class Localization {
    
    /**
    * Path to directory where language settings are
    *
    * @var string
    */
    private $language_dir_path = null;
    
    /**
    * strftime() function format used for presenting date and time
    *
    * @var string
    */
    private $datetime_format = 'M d. Y H:i';
    
    /**
    * strftime() function format used for presenting date
    *
    * @var string
    */
    private $date_format = 'M d. Y';
    
    /**
    * Descriptive date format is string used in date() function that will autput date 
    * in such a way that it tells as much as it can: with day it is and when it is. 
    * This one is used for such things as milestones and tasks where you need to see 
    * as much info about due date as you can from a simple, short string
    *
    * @var string
    */
    private $descriptive_date_format = 'l, j F';
    
    /**
    * strftime() function format used for presenting time
    *
    * @var string
    */
    private $time_format = 'H:i';
    
    /**
    * Locale code
    *
    * @var string
    */
    private $locale;
    
    /**
    * Current locale settings, returned by setlocale() function
    *
    * @var string
    */
    private $current_locale;
    
    /**
    * Container of langs
    *
    * @var Container
    */
    private $langs;
  
    /**
    * Construct the Localization
    *
    * @access public
    * @param string $language_dir_path Path to the language dir
    * @param string $local
    * @return Localization
    */
    function __construct() {
      $this->langs = new Container();
    } // __construct
    
    /**
    * Return lang by name
    *
    * @param string $name
    * @param mixed $default Default value that will be returned if lang is not found
    * @return string
    */
    function lang($name, $default = null) {
      if (is_null($default)) {
        $default = "{$this->locale}($name)";
      } // if
      return $this->langs->get($name, $default);
    } // lang
    
    /**
    * Load language settings
    *
    * @access public
    * @param string $locale Locale code
    * @param string $language_dir Path to directory where we have all 
    *   languages defined
    * @return null
    * @throws DirDnxError If language dir does not exists
    * @throws FileDnxError If language settings file for this local settings
    *   does not exists in lanuage dir
    */
    function loadSettings($locale, $languages_dir) {
      
      $this->setLocale($locale);
      $this->setLanguageDirPath($languages_dir);
      
      return $this->loadLanguageSettings();
      
    } // loadSettings
    
    /**
    * Load language settings
    *
    * @param void
    * @throws DirDnxError If language dir does not exists
    * @throws FileDnxError If language settings file for this local settings
    *   does not exists in lanuage dir
    */
    private function loadLanguageSettings() {
      trace(__FILE__,'loadLanguageSettings()');
      // Check dir...
      $language_dir = $this->getLanguageDirPath();
      if (!is_dir($language_dir)) {
        throw new DirDnxError($language_dir);
      } // if

      $locale = $this->getLocale();
      $locale_dir = $language_dir.'/'.$locale;
      if (!is_dir($locale_dir)) {
        throw new DirDnxError($locale_dir);
      } // if

      // Get settings file path and include it
      $settings_file = $locale_dir.'/'.$locale.'.php';
      if (!is_file($settings_file)) {
        trace(__FILE__,'loadLanguageSettings()');
        throw new FileDnxError($settings_file, "Failed to find language settings file".$settings_file);
      }
      trace(__FILE__,'loadLanguageSettings():include_once '.$settings_file);
      include_once $settings_file;

      // Clear langs
      $this->langs->clear();
      
      // Load core language files
      $this->loadLanguageFiles($locale_dir);

      // load every plugin language files
      $dirs = get_dirs(PLUGINS_DIR,false);
      foreach ($dirs as $plugin_dir) {
        if (plugin_active($plugin_dir)) {  // plugin_dir is same as plugin name
          $locale_dir = PLUGINS_DIR.'/'.$plugin_dir.'/language/' . $locale;
          if (is_dir($locale_dir)) {
            $this->loadLanguageFiles($locale_dir);
          } else {
            //$locale_dir = PLUGINS_DIR.'/'.$plugin_dir.'/language/en_us';
            if (is_dir($locale_dir)) {
              $this->loadLanguageFiles($locale_dir);
            } // if
          } // if
        } // if
      } // foreach
      
      // Done!
      return true;
      
    } // loadLanguageSettings

    /**
    * loadLanguageFiles
    *
    * @access private
    * @param String $dir Select files from this dir
    * @param String $ext Select files with given extension
    * @return string
    */
    private function loadLanguageFiles($dir, $ext = 'php') {
      trace(__FILE__,"loadLanguageFiles($dir, $ext):begin");
      $files = get_files($dir, $ext);
        
      // Loop through files and add langs
      if (is_array($files)) {
        foreach ($files as $file) {
          //try {
            $langs = include_once $file;
          //} catch (Exception $e) {}
          if (is_array($langs)) {
            $this->langs->append($langs);
          } // if
        } // foreach
      } // if
    }

  
    /**
    * Return language specific formatted date
    *
    * @access public
    * @param $fmt (see date() in php.net)
    * @param $timestamp 
    * @return string
    */
    function date_lang($fmt, $timestamp = 0) {
      $jd = unixtojd($timestamp);
      $pdate = jd_to_persian( $jd );
      $date_lang = date($fmt, $timestamp);
      if (strpos($fmt, 'a')!==false) {
        $a = date('a', $timestamp);  // e.g. am or pm
        $date_lang = str_replace( $a, lang($a), $date_lang ); 
      }
      if (strpos($fmt, 'A')!==false) {
        $a = date('A', $timestamp);  // e.g. AM or PM
        $date_lang = str_replace( $a, lang($a), $date_lang ); 
      }
      if (strpos($fmt, 'l')!==false) {
        $l = date('l', $timestamp);  // e.g. Thursday
        $n = date('N', $timestamp);  // e.g. 1=Monday, ..., 7=Sunday
        $date_lang = str_replace( $l, lang('weekday full ' . $n), $date_lang ); 
      }
      if (strpos($fmt, 'D')!==false) {
        $d = date('D', $timestamp);  // e.g. Thu
        $n = date('N', $timestamp);  // e.g. 1=Monday, ..., 7=Sunday
        $date_lang = str_replace( $d, lang('weekday short ' . $n), $date_lang ); 
      }
      if (strpos($fmt, 'M')!==false) {
        $m = date('M', $timestamp);  // e.g. Feb
        $n = date('n', $timestamp);  // e.g. 2
        $date_lang = str_replace( $m, lang('month short ' . $n), $date_lang ); 
      }
      if (strpos($fmt, 'F')!==false) {
        $f = date('F', $timestamp);  // e.g. February
        $n = date('n', $timestamp);  // e.g. 2
        $date_lang = str_replace( $f, lang('month full ' . $n), $date_lang ); 
      }
      if (strpos($fmt, 'S')!==false) {
        $s = date('S', $timestamp);  // e.g. st, nd, rd or th
        $n = 4;
        if ($s=='st') $n = 1;
        if ($s=='nd') $n = 2;
        if ($s=='rd') $n = 3;
        $date_lang = str_replace( $s, lang('ordinal ' . $n), $date_lang ); 
      }
      //return $date_lang . ' reversed Persian=' . utf8_strrev(FormatPersianSmallDate ( $pdate )) . ' Persian=' . FormatPersianSmallDate ( $pdate );
      //return utf8_strrev(FormatPersianDate ( $pdate ));
      return $date_lang;
    } // date_lang

    /**
    * Return formatted date
    *
    * @access public
    * @param DateTimeValue $date
    * @param float $timezone Timezone offset in hours
    * @return string
    */
    function formatDate(DateTimeValue $date, $timezone = 0, $format = NULL) {
      $lang_date_format = $this->langs->get('date format', null);
      $date_format = ($format) ? $format : ( ($lang_date_format) ? $lang_date_format : $this->date_format );
      return $this->date_lang($date_format, $date->getTimestamp() + ($timezone * 3600));
    } // formatDate
    
    /**
    * * Descriptive date format is string used in date() function that will autput date 
    * in such a way that it tells as much as it can: with day it is and when it is. 
    * This one is used for such things as milestones and tasks where you need to see 
    * as much info about due date as you can from a simple, short string
    *
    * @param DateTimeValue $date
    * @param float $timezone Timezone offset in hours
    * @return string
    */
    function formatDescriptiveDate(DateTimeValue $date, $timezone = 0, $format = NULL) {
      $lang_date_format = $this->langs->get('descriptive date format', null);
      $date_format = ($format) ? $format : ( ($lang_date_format) ? $lang_date_format : $this->descriptive_date_format );
      return $this->date_lang($date_format, $date->getTimestamp() + ($timezone * 3600));
    } // formatDescriptiveDate
    
    /**
    * Return formated datetime
    *
    * @access public
    * @param DateTimeValue $date
    * @param float $timezone Timezone offset in hours
    * @return string
    */
    function formatDateTime(DateTimeValue $date, $timezone = 0) {
      $lang_datetime_format = $this->langs->get('datetime format', null);
      $datetime_format = ($lang_datetime_format) ? $lang_datetime_format : $this->datetime_format;
      return $this->date_lang($datetime_format, $date->getTimestamp() + ($timezone * 3600));
    } // formatDateTime
    
    /**
    * Return formated time
    *
    * @access public
    * @param DateTimeValue $date
    * @param float $timezone Timezone offset in hours
    * @return string
    */
    function formatTime(DateTimeValue $date, $timezone = 0) {
      $lang_time_format = $this->langs->get('time format', null);
      $time_format = ($lang_time_format) ? $lang_time_format : $this->time_format;
      return $this->date_lang($time_format, $date->getTimestamp() + ($timezone * 3600));
    } // formatTime

    
    // -------------------------------------------------------------
    //  Getters and setters
    // -------------------------------------------------------------
    
    /**
    * Get language_dir_path
    *
    * @access public
    * @param null
    * @return string
    */
    function getLanguageDirPath() {
      return $this->language_dir_path;
    } // getLanguageDirPath
    
    /**
    * Set language_dir_path value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setLanguageDirPath($value) {
      $this->language_dir_path = $value;
    } // setLanguageDirPath
    
    /**
    * Get datetime format
    *
    * @access public
    * @param null
    * @return string
    */
    function getDateTimeFormat() {
      return $this->datetime_format;
    } // getDateTimeFormat
    
    /**
    * Set datetime foramt value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setDateTimeFormat($value) {
      $this->datetime_format = (string) $value;
    } // setDateTimeFormat
    
    /**
    * Get date format
    *
    * @access public
    * @param null
    * @return string
    */
    function getDateFormat() {
      return $this->date_format;
    } // getDateFormat
    
    /**
    * Set date format value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setDateFormat($value) {
      $this->date_format = (string) $value;
    } // setDateFormat
    
    /**
    * Get time format
    *
    * @access public
    * @param null
    * @return string
    */
    function getTimeFormat() {
      return $this->time_format;
    } // getTimeFormat
    
    /**
    * Set time format value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setTimeFormat($value) {
      $this->time_format = (string) $value;
    } // setTimeFormat
    
    /**
    * Get locale
    *
    * @access public
    * @param null
    * @return string
    */
    function getLocale() {
      return $this->locale;
    } // getLocale
    
    /**
    * Set locale value
    *
    * @access public
    * @param string $value
    * @return boolean
    */
    function setLocale($value) {
      $this->locale = $value;
    } // setLocale
    
    /**
    * Return current locale settings
    *
    * @access public
    * @param void
    * @return string
    */
    //function getCurrentLocale() {
    //  if (trim($this->current_locale)) {
    //    return $this->current_locale;
    //  } else {
    //    return setlocale(LC_ALL, 0);
    //  } // if
    //} // getCurrentLocale
    
    /**
    * Interface to langs container
    *
    * @access public
    * @param void
    * @return Container
    */
    function langs() {
      return $this->langs;
    } // langs
    
    /**
    * Return localization instance
    *
    * @access public
    * @param string $locale Localization code
    * @return Localization
    */
    static function instance() {
      static $instance;
      
      // Prepare instance
      if (!($instance instanceof Localization)) {
        $instance = new Localization();
      } // if
      
      // Done...
      return $instance;
      
    } // instance
  
  } // Localization

?>