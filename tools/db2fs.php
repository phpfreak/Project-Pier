<?php
  
  define('UPLOAD_ROOT', dirname(__FILE__));
  
  if(file_exists('../config/config.php')) {
    require_once '../config/config.php';  	
  } else {
    die('Failed to include config file.');
  } // if
  
  $log_data = file_exists('db2fs.log') ? file_get_contents('db2fs.log') : "Converted files from database to file system: ";
  
  $file_attributes = require_once 'attributes.php';
  
  $link = @mysql_connect(DB_HOST, DB_USER, DB_PASS);
  $file_repo_table = DB_PREFIX . 'file_repo';
  $file_repo_attributes_table = DB_PREFIX . 'file_repo_attributes';
  
  $keys = array_keys($file_attributes);
  $ids = "'" . implode("', '", $keys) . "'";
  
  if($link) {
    if(mysql_select_db(DB_NAME, $link)) {
      
      if(count($keys) > 0) {
        $sql = "SELECT * FROM $file_repo_table WHERE $file_repo_table.id NOT IN ($ids) LIMIT 1";
      } else {
        $sql = "SELECT * FROM $file_repo_table LIMIT 1";
      } // if
      $db_files = mysql_query($sql, $link);
      if (!$db_files) {
        echo mysql_error();
        die();
      } else {
        if(mysql_num_rows($db_files) == 0) {
          print "<p>Files have been converted.</p>";
          print $log_data;
          die();
        }
      } // if
      
      while ($db_file = mysql_fetch_array($db_files)) {
      	$db_file_id = $db_file['id'];
      	
      	$db_file_attributes = mysql_query("SELECT * FROM $file_repo_attributes_table WHERE $file_repo_attributes_table.id = '$db_file_id'", $link);
      	while ($db_file_attribute = mysql_fetch_array($db_file_attributes)) {
      	  $clean = array("return '", "';");
      	  if($db_file_attribute['attribute'] == 'name') {
            $db_file_name = str_replace($clean, '', $db_file_attribute['value']);
      	  } // if
      	  if($db_file_attribute['attribute'] == 'size') {
            $db_file_size = str_replace($clean, '', $db_file_attribute['value']);
      	  } // if
      	  if($db_file_attribute['attribute'] == 'type') {
            $db_file_type = str_replace($clean, '', $db_file_attribute['value']);
      	  } // if
      	} // while
      	
      	if(!file_exists(UPLOAD_ROOT . '/' . substr($db_file_id, 0, 5))) {
      	  mkdir(UPLOAD_ROOT . '/' . substr($db_file_id, 0, 5));
      	  
      	  if(!file_exists(UPLOAD_ROOT . '/' . substr($db_file_id, 0, 5) . '/' . substr($db_file_id, 5, 5))){
      	    mkdir(UPLOAD_ROOT . '/' . substr($db_file_id, 0, 5) . '/' . substr($db_file_id, 5, 5));
      	    
      	    if(!file_exists(UPLOAD_ROOT . '/' . substr($db_file_id, 0, 5) . '/' . substr($db_file_id, 5, 5) . '/' . substr($db_file_id, 10, 5))){
      	      mkdir(UPLOAD_ROOT . '/' . substr($db_file_id, 0, 5) . '/' . substr($db_file_id, 5, 5) . '/' . substr($db_file_id, 10, 5));
      	      file_put_contents(UPLOAD_ROOT . '/' . substr($db_file_id, 0, 5) . '/' . substr($db_file_id, 5, 5) . '/' . substr($db_file_id, 10, 5) . '/' . substr($blob_file_id, 15, strlen($blob_file_id)), $blob_file['content']);
      	     } // if
      	  } // if
      	} // if
      	
      	$file_attributes[$db_file_id] = array (
      	  'name' => $blob_file_name,
      	  'size' => $blob_file_size,
      	  'type' => $blob_file_type,
      	);
      	
      	$log_data .= ", '$db_file_name'";
      } // while
      
      mysql_free_result($db_files);
      
      $data = "<?php \n\n";
      $data .= "return " . var_export($file_attributes, true) . ";\n";
      $data .= "?>";
      
      file_put_contents(UPLOAD_ROOT . '/db2fs.log', $log_data);
      file_put_contents(UPLOAD_ROOT . '/attributes.php', $data);
      
      print "<html>\n";
      print "<head><meta http-equiv=\"refresh\" content=\"1\"></head>\n";
      print '<body><p>Converting files. <blink style="color: red;">Please wait ...</blink></p></body></html>';
    } else {
      die('Failed to select database');
    } // if
  } else {
    die('Faild to connect to database');
  } // if
?>