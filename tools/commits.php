<?php
echo "file 2659 /public_html/pp088/application/views/company/company_card.php
commit 56 show description in card
file 2660 /public_html/pp088/application/views/project/overview.php
commit 57 fix subproject progress
file 2661 /public_html/pp088/application/controllers/ContactsController.class.php
commit 58 $password defined properly
file 2662 /public_html/pp088/application/models/users/User.class.php
commit 59 handle no active projects situation
file 2663 /public_html/pp088/endings.php
commit 60 utility to check files with extra space after last ?>
file 2664 /public_html/pp088/application/permissions.php
commit 61 handle situation when no project available
file 2665 /public_html/pp088/application/plugins/tickets/views/add_ticket.php
file 2666 /public_html/pp088/application/plugins/tickets/views/edit_ticket.php
commit 62 milestone in add ticket, remove lang() in edit for now";
die();

  echo "file 73 /public_html/pp088/application/views/task/add_list.php
commit 17 add send notification checkbox
file 74 /public_html/pp088/application/views/comment/object_comments.php
commit 18 fix to get avatar from contact
file 76 /public_html/pp088/application/views/administration/time.php
commit 19 set selected tab
file 77 /public_html/pp088/application/plugins/links/controllers/LinksController.class.php
commit 20 added variables for index_sidebar template
file 80 /public_html/pp088/application/models/contacts/Contact.class.php
commit 21 added test for tags available or not
file 81 /public_html/pp088/README.txt
file 82 /public_html/pp088/UPGRADE.txt
file 83 /public_html/pp088/CHANGES.txt
commit 22 0.8.8 version corrected
file 84 /public_html/pp088/application/views/message/view.php
file 85 /public_html/pp088/application/views/project/tags.php
file 86 /public_html/pp088/application/views/message/index.php
file 87 /public_html/pp088/application/views/message/move_message.php
file 88 /public_html/pp088/application/views/message/del_message.php
file 89 /public_html/pp088/application/views/dashboard/weekly_schedule.php
file 90 /public_html/pp088/application/views/administration/time.php
file 91 /public_html/pp088/application/views/administration/tools.php
file 92 /public_html/pp088/application/plugins/time/init.php
file 93 /public_html/pp088/application/plugins/time/views/index.php
file 94 /public_html/pp088/application/plugins/tags/init.php
file 95 /public_html/pp088/application/plugins/tags/views/project_tag.php
file 96 /public_html/pp088/application/plugins/links/views/index.php
file 97 /public_html/pp088/application/views/task/view_task.php
file 98 /public_html/pp088/application/views/task/move_list.php
file 99 /public_html/pp088/application/views/task/reorder_tasks.php
file 100 /public_html/pp088/application/views/task/view_list.php
file 101 /public_html/pp088/application/views/task/index.php
file 102 /public_html/pp088/application/views/task/del_task.php
file 103 /public_html/pp088/application/views/task/del_list.php
file 104 /public_html/pp088/application/views/task/add_task.php
file 105 /public_html/pp088/application/views/task/copy_list.php
file 106 /public_html/pp088/application/views/task/add_list.php
file 107 /public_html/pp088/application/views/milestone/index.php
file 108 /public_html/pp088/application/views/milestone/view.php
file 109 /public_html/pp088/application/views/milestone/calendar.php
file 110 /public_html/pp088/application/views/milestone/del_milestone.php
file 111 /public_html/pp088/application/views/milestone/add_milestone.php
file 112 /public_html/pp088/application/views/message/add_message.php
file 113 /public_html/pp088/application/views/contacts/add_contact.php
file 114 /public_html/pp088/application/plugins/time/init.php
file 115 /public_html/pp088/application/plugins/tags/init.php
file 116 /public_html/pp088/application/helpers/project_website.php
file 117 /public_html/pp088/application/plugins/reports/models/Reports.class.php
file 118 /public_html/pp088/application/plugins/tickets/views/index.php
commit 23 set selected tab
file 119 /public_html/pp088/application/plugins/reports/library/jpgraph/src/jpgraph_gantt.class.php
file 120 /public_html/pp088/application/plugins/reports/library/jpgraph/src/jpgraph.class.php
commit 24 replaced ereg with preg_match and split with explode (deprecated)";
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