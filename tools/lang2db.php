<?php

$counter = 0;

function walk($path, $filter) {
  //echo 'walking '.$path."\n";
  if (is_dir($path)) {
    walk_dir($path, $filter);
  }
  if(is_file($path)) {
    walk_file($path, $filter);
  }
}

function walk_dir($path, $filter) {
  if (preg_match('/\/language\/(.*)$/', $path, $matches)) { 
    if (strpos($path, $filter)===false) return;
    $locale = $matches[1];
    //$locale = 'is_is';
    add2database($locale, $path);
  } else {
    if ($dh = opendir($path)) {
      while (($file = readdir($dh)) !== false) {
        if($file != '.' && $file != '..') {
          walk($path.'/'.$file, $filter);
        }
      }
      closedir($dh);
    }
  }
}

function walk_file($path, $filter) {
}

function add2database($locale, $path) {
  global $counter;
  echo "$path\n";
  $localefile = $locale . '.php';
  $parts = explode('_', $locale);
  $lc = $parts[0];
  $cc = $parts[1];
  if ($dh = opendir($path)) {

    $sql = "insert into `".DB_PREFIX."i18n_locales` (`name`, `description`, `country_code`, `language_code`) values( '$locale', 'Imported $path', '$cc', '$lc' ) ON DUPLICATE KEY UPDATE `id`=`id`;";
    mysql_query($sql);

    $sql = "select id from `".DB_PREFIX."i18n_locales` where `country_code` = '$cc' and `language_code` = '$lc';";
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

        $sql = "insert into `".DB_PREFIX."i18n_categories` (`name`, `description`) values( '$category', 'Imported $path/$file' ) ON DUPLICATE KEY UPDATE `id`=`id`;";
        mysql_query($sql);

        $sql = "select id from `".DB_PREFIX."i18n_categories` where `name` = '$category';";
        $result = mysql_query($sql);
        $row = mysql_fetch_assoc($result);
        $category_id = $row['id'];

        $filepath="$path/$file";
        $items = include $filepath;
        foreach($items as $k => $v) {
          $counter++;
          $sql = "insert into `".DB_PREFIX."i18n_values` (`locale_id`, `category_id`, `name`, `description`) values( '$locale_id', '$category_id', '$k', '".mysql_real_escape_string($v)."');";
          mysql_query($sql);
          $e = mysql_error();
          echo "$counter : $e : $sql\n";
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
      walk('../language', 'en_us');
      walk('../application/plugins', 'en_us');
      echo '</xmp>';
      echo '</body></html>';
    }
  }
?>