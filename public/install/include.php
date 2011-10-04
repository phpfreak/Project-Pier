<?php

  // PHP5?
  if (!version_compare(phpversion(), '5.0', '>=')) {
    die('<strong>Installation error:</strong> in order to run ProjectPier you need PHP5. Your current PHP version is: ' . phpversion());
  } // if
  
  $compatibility = strtolower(ini_get('zend.ze1_compatibility_mode'));
  if ($compatibility == 'on' || $compatibility == '1') {
    die('<strong>Installation error:</strong> ProjectPier will not run on PHP installations that have <strong>zend.ze1_compatibility_mode</strong> set to On. <strong>Please turn it off</strong> (in your php.ini file) in order to continue.');
  } // if

  session_start();
  error_reporting(E_ALL);
  
  if (function_exists('date_default_timezone_set')) {
    date_default_timezone_set('GMT');
  } // if
  
  define('INSTALLER_PATH', dirname(__FILE__));
  define('INSTALLATION_PATH', realpath(INSTALLER_PATH . '/../../'));
  
  // Check the config
  $config_is_set = @include_once INSTALLATION_PATH . '/config/config.php';
  if ($config_is_set) {
    //die('<strong>Installation error:</strong> ProjectPier is already installed');
  } // if

  $installation_root = dirname($_SERVER['PHP_SELF']);
  define('ROOT_URL', $installation_root);
  
  // Include library
  require_once INSTALLATION_PATH . '/environment/functions/general.php';
  require_once INSTALLATION_PATH . '/environment/functions/files.php';
  require_once INSTALLATION_PATH . '/environment/functions/utf.php';
  
  require_once INSTALLER_PATH . '/library/constants.php';
  require_once INSTALLER_PATH . '/library/functions.php';
  require_once INSTALLER_PATH . '/library/classes/ScriptInstaller.class.php';
  require_once INSTALLER_PATH . '/library/classes/ScriptInstallerStep.class.php';
  require_once INSTALLER_PATH . '/library/classes/ChecklistItem.class.php';
  require_once INSTALLER_PATH . '/library/classes/Output.class.php';
  require_once INSTALLER_PATH . '/library/classes/Output_Html.class.php';
  require_once INSTALLER_PATH . '/library/classes/Output_Console.class.php';
  require_once INSTALLER_PATH . '/installation/installation.class.php';
  
  require_once INSTALLATION_PATH . '/environment/classes/template/Template.class.php';

?>