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
  define('DB_USER', 'root'); 
  define('DB_PASS', ''); 
  define('DB_NAME', 'projectpier'); 
  define('DB_PERSIST', true); 
  define('TABLE_PREFIX', 'ac_'); 
  define('ROOT_URL', 'http://projectpier.dev'); 
  define('DEFAULT_LOCALIZATION', 'en_us'); 
  // define('DEFAULT_LOCALIZATION', 'de_de'); //German
  define('DEBUG', true); 
  define('DB_CHARSET', 'utf8'); 
  //Define if notification messages should include the message body for these three
  // types of messages.  To disable this feature, change the word "true" to "false" (no quotes)
  define('SHOW_MESSAGE_BODY', true);
  define('SHOW_COMMENT_BODY', true);
  define('SHOW_MILESTONE_BODY', true);
  
  return true;
  
?>
