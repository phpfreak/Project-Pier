<?php

  /**
  * Initialize environment: load required files, set environment options etc.
  *
  * @http://www.projectpier.org/
  */

  // ---------------------------------------------------
  //  Directories
  // ---------------------------------------------------
  set_include_path(ROOT . PATH_SEPARATOR . APPLICATION_PATH);

  // Environment path is used by many environment classes. If not
  // defined do it now
  if (!defined('ENVIRONMENT_PATH')) define('ENVIRONMENT_PATH', dirname(__FILE__));
  
  // Configure PHP
  ini_set('short_open_tag', 'on');
  ini_set('date.timezone', 'GMT');
  if (function_exists('date_default_timezone_set')) {
    date_default_timezone_set('GMT');
  } else {
    putenv('TZ=GMT');
  } // if

  if (defined('DEBUG') && DEBUG) {
    //set_time_limit(120);
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
  } else {
    ini_set('display_errors', 0);
  } // if
  
  if (!ini_get('session.auto_start') || (strtolower(ini_get('session.auto_start')) == 'off')) {
    if(!session_id()) session_regenerate_id();
    session_start(); // Start the session
  }
  
  include_once ENVIRONMENT_PATH . '/classes/Env.class.php';
  include_once ENVIRONMENT_PATH . '/constants.php';
  include_once ENVIRONMENT_PATH . '/functions/utf.php';
  include_once ENVIRONMENT_PATH . '/functions/general.php';
  include_once ENVIRONMENT_PATH . '/functions/files.php';
  
  // Remove slashes is magic quotes gpc is on from $_GET, $_POST and $_COOKIE
  fix_input_quotes();
  
  // Debug
  if (Env::isDebugging()) {
    include_once ENVIRONMENT_PATH . '/classes/debug/BenchmarkTimer.class.php';
    benchmark_timer_start();
    benchmark_timer_set_marker('Init environment');
  } // if
  
  // Include autoloader...
  include ENVIRONMENT_PATH . '/classes/AutoLoader.class.php';
  include ENVIRONMENT_PATH . '/classes/template/template.php';
  include ENVIRONMENT_PATH . '/classes/flash/flash.php';
  include ENVIRONMENT_PATH . '/classes/localization/localization.php';
  
  include ENVIRONMENT_PATH . '/classes/logger/Logger_Entry.class.php';
  include ENVIRONMENT_PATH . '/classes/logger/Logger_Session.class.php';
  include ENVIRONMENT_PATH . '/classes/logger/Logger_Backend.class.php';
  include ENVIRONMENT_PATH . '/classes/logger/Logger.class.php';
  include ENVIRONMENT_PATH . '/classes/logger/backend/Logger_Backend_File.class.php';
  
  // Init libraries
  Env::useLibrary('database');
  
?>
