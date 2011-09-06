<?php
  //$s = file_get_contents('t');
  //$s .= $_SERVER['HTTP_USER_AGENT'] . "\n";
  //file_put_contents('t', $s);
  // Request starts
  $GLOBALS['request_start_time'] = microtime(true);
  if (!version_compare(phpversion(), '5.0', '>=')) {
    die('<strong>Installation error:</strong> in order to run ProjectPier you need PHP5. Your current PHP version is: ' . phpversion());
  } // if
  define('PUBLIC_FOLDER', 'public');
  require 'init.php';
?>