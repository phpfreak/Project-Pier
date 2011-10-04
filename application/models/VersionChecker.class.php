<?php

  /**
  * This class is reponsible for checking if there are new versions of the application available
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  final class VersionChecker {
    
    /**
    * Check if there is a new version of application available
    *
    * @param boolean $force When forced check will always construct the versions feed object
    *   try to fech the data and check for a new version. Version feed object is also returned
    * @return VersionFeed In case of error this function will return false
    */
    static function check($force = true) {
      $allow_url_fopen = strtolower(ini_get('allow_url_fopen'));
      if (function_exists('simplexml_load_file') && ($allow_url_fopen == '1' || $allow_url_fopen == 'on')) {
      
        // Execute once a day, if not forced check if we need to execute it now
        if (!$force) {
          if (config_option('upgrade_last_check_new_version', false)) {
            return true; // already have it checked and already have a new version
          } // if
          
          $last_check = config_option('upgrade_last_check_datetime');
          if (($last_check instanceof DateTimeValue) && (($last_check->getTimestamp() + 86400) > DateTimeValueLib::now()->getTimestamp())) {
            return true; // checked in the last day
          } // if
        } // if
        
        try {
          $versions_feed = new VersionsFeed();
          set_config_option('upgrade_last_check_datetime', DateTimeValueLib::now());
          set_config_option('upgrade_last_check_new_version', $versions_feed->hasNewVersions(product_version()));
          return $force ? $versions_feed : true;
        } catch(Exception $e) {
          return false;
        } // try
      
      } else {
        set_config_option('upgrade_check_enabled', false);
        return false;
      } // if
    } // check
  
  } // VersionChecker

?>