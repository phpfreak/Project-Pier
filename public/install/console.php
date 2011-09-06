<?php

  require_once dirname(__FILE__) . '/include.php';

  if (!isset($argv) || !is_array($argv)) {
    die('There is no input arguments');
  } // if
  
  $installation = new acInstallation(new Output_Console());
  $installation->setDatabaseType((string) trim(array_var($argv, 1)));
  $installation->setDatabaseHost((string) trim(array_var($argv, 2)));
  $installation->setDatabaseUsername((string) trim(array_var($argv, 3)));
  $installation->setDatabasePassword((string) array_var($argv, 4));
  $installation->setDatabaseName((string) trim(array_var($argv, 5)));
  $installation->setTablePrefix((string) trim(array_var($argv, 6)));
  $installation->setAbsoluteUrl((string) trim(array_var($argv, 7)));
  
  $installation->execute();

?>
