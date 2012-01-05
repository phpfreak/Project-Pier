<?php

function walk($path) {
  //echo 'walking '.$path."\n";
  if (is_dir($path)) {
    walk_dir($path);
  }
  if(is_file($path)) {
    walk_file($path);
  }
}

function walk_dir($path) {
  if (preg_match('/\/language\/(.*)$/', $path, $matches)) { 
    $locale = $matches[1];
    //$locale = 'is_is';
    add2database($locale, $path);
  } else {
    if ($dh = opendir($path)) {
      while (($file = readdir($dh)) !== false) {
        if($file != '.' && $file != '..') {
          walk($path.'/'.$file);
        }
      }
      closedir($dh);
    }
  }
}

function walk_file($path) {
}

function add2database($locale, $path) {
  echo "$path\n";
  $localefile = $locale . '.php';
  $parts = explode('_', $locale);
  $lc = $parts[0];
  $cc = $parts[1];
  if ($dh = opendir($path)) {

    $sql = "insert into `pp088_i18n_locale` (`name`, `description`, `country_code`, `language_code`) values( '$locale', 'Imported $path', '$cc', '$lc' ) ON DUPLICATE KEY UPDATE `id`=`id`;";
    mysql_query($sql);

    $sql = "select id from `pp088_i18n_locale` where `country_code` = '$cc' and `language_code` = '$lc';";
    $result = mysql_query($sql);
    $row = mysql_fetch_assoc($result);
    $locale_id = $row['id'];

    while (($file = readdir($dh)) !== false) {
      if ($file != '.' && $file != '..' && $file != $localefile) {
        $category=$file;
        $i=strrpos($file, '.');
        if ($i!==false) {
          $category=substr($file,0,$i);
        }            

        $sql = "insert into `pp088_i18n_category` (`name`, `description`) values( '$category', 'Imported $path/$file' ) ON DUPLICATE KEY UPDATE `id`=`id`;";
        mysql_query($sql);

        $sql = "select id from `pp088_i18n_category` where `name` = '$category';";
        $result = mysql_query($sql);
        $row = mysql_fetch_assoc($result);
        $category_id = $row['id'];

        $filepath="$path/$file";
        $items = include $filepath;
        foreach($items as $k => $v) {
          $sql = "insert into `pp088_i18n_value` (`locale_id`, `category_id`, `name`, `description`) values( '$locale_id', '$category_id', '$k', '$v' );";
          mysql_query($sql);
          //echo "$sql\n";
        }
      }
    }
    closedir($dh);
  }
}

  if(file_exists('../config/config.php')) {
    require_once '../config/config.php';  	
  } else {
    die('Failed to include config file.');
  } // if
  
  $log_data = file_exists('lang2db.log') ? file_get_contents('lang2db.log') : "=== lang2db ===";
  
  $link = @mysql_connect(DB_HOST, DB_USER, DB_PASS);
  
  if($link) {
    if(mysql_select_db(DB_NAME, $link)) {
      mysql_query("set names 'utf8'");

      echo '<html><head>';
      echo '<meta http-equiv="content-type" content="text/html; charset=utf-8" />';

      echo '</head><body>';
      echo '<xmp>';
      walk('../language');
      walk('../application/plugins');
      echo '</xmp>';
      echo '</body></html>';
    }
  }
?>