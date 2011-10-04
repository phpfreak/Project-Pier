<?php

  require_once dirname(__FILE__) . '/include.php';

  if (!isset($argv) || !is_array($argv)) {
    die('There is no input arguments');
  } // if
  
  $from_version = array_var($argv, 1);
  $to_version = array_var($argv, 2);
  
  if (trim($from_version) == '') {
    die('First argument (current version) is required');
  } // if
  
  if (trim($to_version) == '') {
    die('Second argument (to version) is required');
  } // if

  // Construct the upgrader and load the scripts
  $upgrader = new ScriptUpgrader(new Output_Console(), 'Upgrade ProjectPier', 'Upgrade your ProjectPier installation');
  $upgrader->upgrade($from_version, $to_version);

?>