<?php

  //var_dump($_POST); die();

  if(file_exists('../config/config.php')) {
    require_once '../config/config.php';  	
  } else {
    die('Failed to include config file.');
  } // if
  
  $link = @mysql_connect(DB_HOST, DB_USER, DB_PASS);
  $changes_table = DB_PREFIX . 'changes';
  
  if($link) {
    if(mysql_select_db(DB_NAME, $link)) {

      $sql = "SELECT `change_time`, `change_type`, `change_value`, `id` FROM `$changes_table` WHERE `change_time` < '2011-11-07 14:00:00' order by `change_time` DESC limit 150";
      $sql = "SELECT `change_time`, `change_type`, `change_value`, `id` FROM `$changes_table` tt NATURAL JOIN ( SELECT `change_value`, MAX(`change_time`) AS `change_time` FROM `$changes_table` where `change_time` > '2011-12-25 11:00:00' GROUP BY `change_value`) mostrecent order by `change_time` DESC limit 10000";
      $result = mysql_query($sql, $link);
      if (!$result) {
        echo mysql_error();
        die();
      }

      $count = 0;
      $s = "";
      echo "<table cellspacing=1 cellpadding=1 bgcolor=#000000>";
      while($row=mysql_fetch_array($result)) {
       $count++;
       $a=$row[0]; $b=$row[1]; $c=$row[2]; $id=$row[3];
       echo "<tr bgcolor=#ffffff><td>$count</td><td>$id</td><td>$a</td><td>$b</td><td>$c</td></tr>";
       $s = "file $id $c\r\n" . $s;
      }
      echo "</table>";
      echo "<xmp>$s</xmp>"; 

      mysql_close($link);
    } else {
      mysql_close($link);
      die('Failed to select database');
    } // if
  } else {
      die('Failed to connect to database');
  } // if
?>