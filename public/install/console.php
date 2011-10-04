<?php

  require_once dirname(__FILE__) . '/include.php';

  if (!isset($argv) || !is_array($argv)) {
    die('Input arguments dbtype dbhost dbuser dbpass dbname tblprefix missing');
  } // if
  
  $installation = new installation(new Output_Console());
  $installation->setDatabaseType((string) trim(array_var($argv, 1)));
  $installation->setDatabaseHost((string) trim(array_var($argv, 2)));
  $installation->setDatabaseUsername((string) trim(array_var($argv, 3)));
  $installation->setDatabasePassword((string) array_var($argv, 4));
  $installation->setDatabaseName((string) trim(array_var($argv, 5)));
  $installation->setTablePrefix((string) trim(array_var($argv, 6)));
  
  $installation->execute();

?>