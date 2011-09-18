<?php

  echo "file 58 /public_html/pp088/tools/commits.php
file 59 /public_html/pp088/application/plugins/wiki/views/delete.php
file 60 /public_html/pp088/application/plugins/wiki/views/diff.php
file 61 /public_html/pp088/application/plugins/wiki/views/edit.php
file 62 /public_html/pp088/application/plugins/wiki/views/view.php
file 63 /public_html/pp088/application/plugins/time/views/index.php
file 64 /public_html/pp088/application/plugins/time/views/view.php
file 65 /public_html/pp088/application/plugins/wiki/views/all_pages.php
file 66 /public_html/pp088/application/plugins/time/views/bytask.php
file 67 /public_html/pp088/application/plugins/time/views/byuser.php
file 68 /public_html/pp088/application/plugins/time/views/add_time.php
file 69 /public_html/pp088/application/plugins/time/views/byproject.php
file 70 /public_html/pp088/application/plugins/links/views/edit_logo.php
file 71 /public_html/pp088/application/plugins/links/views/index.php
file 72 /public_html/pp088/application/plugins/links/views/edit_link.php
commit 16 remove invalid constants from plugins";
die();

  //var_dump($_POST); die();
echo "file 26 /public_html/pp088/application/plugins/tickets/helpers/tickets.php
file 27 /public_html/pp088/application/plugins/tickets/views/index_sidebar.php
file 28 /public_html/pp088/application/plugins/tickets/views/tickets_sidebar.php
commit 11 ticket filters
file 30 /public_html/pp088/application/controllers/AccessController.class.php
commit 12 installation fix (company_id no longer with user)
file 30 /public_html/pp088/application/controllers/DashboardController.class.php
commit 13 initialize upcoming_tickets (gave error in log)";
die();

  echo "file 11 /public_html/pp088/application/plugins/files/models/ProjectFileRevision.class.php
commit 6 handle missing content (happens when storage is manipulated outside of PP)
file 12 /public_html/pp088/language/en_us/messages.php
file 13 /public_html/pp088/public/assets/themes/marine/stylesheets/application_logs.css
file 14 /public_html/pp088/application/controllers/DashboardController.class.php
file 15 /public_html/pp088/application/models/application_logs/ApplicationLog.class.php
commit 7 application log improvements";
die();

  echo "file 2 /public_html/pp088/tools/time.php
commit 2 test program for time differences ";
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