<?php

  /**
  * Empty config.php is sample configuration file. Use it when you need to manualy set up 
  * your ProjectPier installation (installer doesn't work properly, or any other reason). 
  * 
  * When you set the values in this file delete original 'config.php' (it should just have 
  * return false; command) and rename this one to 'config.php'
  *
  * @http://www.projectpier.org/
  * @modified for ProjectPier
  */
  
  define('DB_ADAPTER', 'mysql'); 
  define('DB_HOST', 'localhost'); 
  define('DB_USER', ''); 
  define('DB_PASS', ''); 
  define('DB_NAME', ''); 
  define('DB_PERSIST', false); 
  define('DB_CHARSET', 'utf8'); 
  define('TABLE_PREFIX', 'pp_'); 
  
?>
