<?php

  /**
  * Renders locale select box
  *
  * @param string  $name
  * @param array   $locales
  * @param integer $selected   id of selected element
  * @param array   $attributes additional attributes
  * @return string
  */
  function select_locale($name, $locales = null, $selected = null, $attributes = null) {
    if (is_array($attributes)) {
      if (!isset($attributes['class'])) {
        $attributes['class'] = 'select_locale';
      }
    } else {
      $attributes = array('class' => 'select_locale');
    } // if
    
    $options = array(option_tag(lang('none'), 0));
    if (is_null($locales)) {
      $locales = array();
    }
    if (is_array($locales)) {
      foreach ($locales as $k => $locale) {
        if (is_string($locale)) {
          $option_attributes = $locale == $selected ? array('selected' => 'selected') : null;
          $options[] = option_tag($locale, $k, $option_attributes);
        } else {
          $option_attributes = $locale->getId() == $selected ? array('selected' => 'selected') : null;
          $options[] = option_tag($locale->getName(), $locale->getId(), $option_attributes);
        }
      } // foreach
    } // if
    
    return select_box($name, $options, $attributes);
  } // select_locale

  /**
  * Return an array with locales found in the file system
  *
  * @return array
  */
  function getLocalesFromFilesystem() {
    $answer = array();
    include(ROOT . '/language/locales.php');  // $locales = array(...)
    if ($handle = opendir(ROOT . '/language')) {
      while (false !== ($file = readdir($handle))) {
        if (is_dir(ROOT . '/language/' . $file)) {
          if ($file != "." && $file != "..") {
            $answer[$file] = $file; 
            if (array_key_exists($file, $locales)) {  // add description if available
              $answer[$file] = $locales[$file]; 
            }
          }
        }
      }
      closedir($handle);
    }
    return $answer;
  }

  function i18n_load($path, $locale, $id) {
    if (is_dir($path)) {
      i18n_load_dir($path, $locale, $id);
    }
  }

  function i18n_load_dir($path, $locale, $id) {
    if (preg_match('/\/language\/(.*)$/', $path, $matches)) { 
      if (strpos($path, $locale)===false) return;
      i18n_load_values($path, $locale, $id);
    } else {
      if ($dh = opendir($path)) {
        while (($file = readdir($dh)) !== false) {
          if($file != '.' && $file != '..') {
            i18n_load($path.'/'.$file, $locale, $id);
          }
        }
        closedir($dh);
      }
    }
  }

  function i18n_load_values($path, $locale, $id) {
    $localefile = $locale . '.php';
    $parts = explode('_', $locale);
    $lc = $parts[0];
    $cc = $parts[1];
    if ($dh = opendir($path)) {

      $locale_id = $id;
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
            $sql = "insert into `".DB_PREFIX."i18n_values` (`locale_id`, `category_id`, `name`, `description`) values( '$locale_id', '$category_id', '$k', '".mysql_real_escape_string($v)."');";
            mysql_query($sql);
            $e = mysql_error();
            echo "$key : $e : $sql\n";
          }
        }
      }
      closedir($dh);
    }
  }

?>