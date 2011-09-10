<?php

  //var_dump($_POST); die();

  echo "file 34239 /public_html/pp088/language/en_us
commit 3223 reinier is slim
file 34239 /public_html/pp088/language/en_us/en_us.php
commit 333 1e commit
file 34239 /public_html/pp088/language/en_us/objects.php
commit 33123 2e commit
file 35239 /public_html/pp088/application/controllers
file 35239 /public_html/pp088/application/controllers/TaskController.class.php
commit 3523 3e commit
file 35559 /public_html/pp088/application/controllers/ProjectController.class.php
commit 3555 4e commit
";
die();
  
  if(file_exists('../config/config.php')) {
    require_once '../config/config.php';  	
  } else {
    die('Failed to include config file.');
  } // if
  
  $log_data = file_exists('commits.log') ? file_get_contents('commits.log') : "=== commits request ===";
  
  $link = @mysql_connect(DB_HOST, DB_USER, DB_PASS);
  $changes_table = DB_PREFIX . 'changes';
  
  if($link) {
    if(mysql_select_db(DB_NAME, $link)) {

      // . 2011-09-04 11:16:10.265 File: "/public_html/pp088/language/en_us"
      foreach( $changes as $change ) {
        if (trim($change)>"") {
          $change_time = substr($change, 2, 19);
          $from = strpos($change, 'File:', 0);
          $from = strpos($change, '"', $from+4);
          $to = strpos($change, '"', $from+1);
          $change_value = mysql_real_escape_string(substr($change, $from+1, $to - 2 - $from));
          $change_type = 'FileChange';      
          $sql = "INSERT INTO `$changes_table` (`change_time`, `change_type`, `change_value`) values ( '$change_time', '$change_type', '$change_value' )";
          $result = mysql_query($sql, $link);
          if (!$result) {
            echo mysql_error();
            die();
          }
          $log_data .= "\n '$change'";
        } // if
      } // while
    
      mysql_close($link);
      file_put_contents('commits.log', $log_data);
      echo $log_data;     
    } else {
      mysql_close($link);
      die('Failed to select database');
    } // if
  } else {
      die('Failed to connect to database');
  } // if
?>