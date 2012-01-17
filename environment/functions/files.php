<?php

  /**
  * Check if specific folder is writable
  *
  * @param string $path
  * @return boolean
  */
  function folder_is_writable($path) {
    if (!is_dir($path)) {
      return false;
    } // if
    
    do {
      $test_file = with_slash($path) . sha1(uniqid(rand(), true));
    } while (is_file($test_file));
    
    $put = @file_put_contents($test_file, 'test');
    if ($put === false) {
      return false;
    } // if
    
    @unlink($test_file);
    return true;
  } // folder_is_writable
  
  /**
  * Check if specific file is writable
  *
  * @param string $path
  * @return boolean
  */
  function file_is_writable($path) {
    if (!is_file($path)) {
      return false;
    } // if
    
    $open = @fopen($path, 'a+');
    if ($open === false) {
      return false;
    } // if
    
    @fclose($open);
    return true;
  } // file_is_writable

  /**
  * Return specific line of specific file
  *
  * @access public
  * @param string $file
  * @param integer $line
  * @param midex $default Returned if file or line does not exists
  * @return string
  */
  function get_file_line($file, $line, $default = null) {
    if (is_file($file)) {
      $lines = file($file);
      return isset($file[$line]) ? $file[$line] : $default;
    } else {
      return $default;
    } // if
  } // get_file_line

  /**
  * Return directories
  *
  * @access public
  * @param string $dir
  * @param integer $full_path
  * @return array
  */
  function get_dirs($dir, $full_path = true) {
    // Check dir...
    if (!is_dir($dir)) {
      return false;
    } // if
    
    // Prepare input data...
    $dir = with_slash($dir);
    // We have a dir...
    if (!is_dir($dir)) {
      return null;
    } // if
    
    // Open dir and prepare result
    $d = dir($dir);
    $dirs = array();
    
    // Loop dir entries
    while (false !== ($entry = $d->read())) {
      
      // Valid entry?
      if (($entry <> '.') && ($entry <> '..')) {
      
        // Get file path...
        $path = $dir . $entry;
        
        // Check if we have a valid directory
        if (is_dir($path)) {
          $dirs[] = $full_path ? $path : $entry;
        } // if
      } // if
    } // while
    
    // Done... close dir...
    $d->close();
    // And return...
    return count($dirs) > 0 ? $dirs : null;
  } // get_dirs

  /**
  * Return the files from specific directory. This function can filter result
  * by file extension (accepted param is single extension or array of extensions)
  *
  * @example get_files($dir, array('doc', 'pdf', 'xst'))
  *
  * @param string $dir Dir that need to be scaned
  * @param mixed $extension Single or multiple file extensions that need to be
  *   mached. If null no check is performed...
  * @param boolean $base_name_only Return only filenames. If this option is set to
  *   false this function will return full paths.
  * @return array
  */
  function get_files($dir, $extension = null, $base_name_only = false) {
  	
    // Check dir...
    if (!is_dir($dir)) {
      return false;
    } // if
    
  	// Prepare input data...
  	$dir = with_slash($dir);
  	if (!is_null($extension)) {
  	  if (is_array($extension)) {
  	    foreach ($extension as $k => $v) {
  	      $extension[$k] = strtolower($v);
  	    } // foreach
  	  } else {
  	    $extension = strtolower($extension);
  	  } // if
  	} // if
  	
  	// We have a dir...
  	if (!is_dir($dir)) {
  	  return null;
  	} // if
  	
  	// Open dir and prepare result
    $d = dir($dir);
    $files = array();
    
    // Loop dir entries
    while (false !== ($entry = $d->read())) {
      
      // Valid entry?
      if (($entry <> '.') && ($entry <> '..')) {
      	
      	// Get file path...
        $path = $dir . $entry;
        
        // If we have valid file that do the checks
        if (is_file($path)) {
        	
        	if (is_null($extension)) {
        	  $files[] = $base_name_only ? basename($path) : $path;
        	} else {
        	
        		// Match multiple extensions?
        		if (is_array($extension)) {
        			
        			// If in array add...
        		  if (in_array( strtolower(get_file_extension($path)), $extension )) {
        		    $files[] = $base_name_only ? basename($path) : $path;
        		  } // if
        		  
        		// Match single extension
        		} else {
        			
        			// If extensions match add...
        		  if (strtolower(get_file_extension($path)) == $extension) {
        		    $files[] = $base_name_only ? basename($path) : $path;
        		  } // if
        		  
        		} // if
        		
        	} // if
        
        } // if
        
      } // if
      
    } // while
    
    // Done... close dir...
    $d->close();
    
    // And return...
    return count($files) > 0 ? $files : null;
  
  } // get_files
  
  /**
  * Return file extension from specific path
  *
  * @access public
  * @param string $path File path
  * @param boolean $leading_dot Include leading dot (or not...)
  * @return string
  */
  function get_file_extension($path, $leading_dot = false) {
  	$filename = basename($path);
  	$dot_offset = (boolean) $leading_dot ? 0 : 1;
  	
    if ( ($pos = strrpos($filename, '.')) !== false ) {
      return substr($filename, $pos + $dot_offset, strlen($filename));
    } // if
    
    return '';
  } // get_file_extension
  
  /**
  * Return size of a specific dir in bytes
  *
  * @access public
  * @param string $dir Directory
  * @return integer
  */
  function dir_size($dir) {
  	$totalsize = 0;
  	
  	if ($dirstream = @opendir($dir)) {
  		while (false !== ($filename = readdir($dirstream))) {
  			if (($filename != ".") && ($filename != "..")) {
  				$path = with_slash($dir) . $filename;
  				if (is_file($path)) $totalsize += filesize($path);
  				if (is_dir($path)) $totalsize += dir_size($path);
  			} // if
  		} // while
  	} // if
  	
  	closedir($dirstream);
  	return $totalsize;
  } // end func dir_size
  
  /**
  * Remove specific directory
  *
  * @access public
  * @param string $dir Directory path
  * @return boolean
  */
  function delete_dir($dir) {
  	$dh = opendir($dir);
  	while ($file = readdir($dh)) {
  		if (($file != ".") && ($file != "..")) {
  			$fullpath = $dir . "/" . $file;
  			
  			if (!is_dir($fullpath)) {
  				unlink($fullpath);
  			} else {
  				delete_dir($fullpath);
  			} // if
  		} // if
  	} // while

  	closedir($dh);
  	return rmdir($dir) ? true : false;
  } // end func delete_dir
  
  /**
  * Force creation of all dirs
  *
  * @access public
  * @param void
  * @return null
  */
  function force_mkdir($path, $chmod = null) {
    return mkdir($path, $chmod, true);

    if (is_dir($path)) {
      return true;
    } // if
    $real_path = str_replace('\\', '/', $path);
    $parts = explode('/', $real_path);
    
    $forced_path = '';
    foreach ($parts as $part) {
      
      // Skip first on windows
      if ($forced_path == '') {
        $start = substr(__FILE__, 0, 1) == '/' ? '/' : '';
        $forced_path = $start . $part;
      } else {
        $forced_path .= '/' . $part;
      } // if
      
      if (!is_dir($forced_path)) {
        if (!is_null($chmod)) {
          if (!mkdir($forced_path)) {
            return false;
          } // if
        } else {
          if (!mkdir($forced_path, $chmod)) {
            return false;
          } // if
        } // if
      } // if
    } // foreach
    
    return true;
  } // force_mkdir
  
  /**
  * This function will return true if $dir_path is empty
  *
  * @param string $dir_path
  * @return boolean
  */
  function is_dir_empty($dir_path) {
    $d = dir($dir_path);
    if ($d) {
  		while (false !== ($entry = $d->read())) {
  		  if (($entry == '.') || ($entry == '..')) {
  		    continue;
  		  } // if
  		  return false;
  		} // while
    } // if
    return true;
  } // is_dir_empty
  
  /**
  * Check if file $in/$desired_filename exists and if it exists save it in 
  * $in/$desired_filename(x).exteionsion (X is inserted in front of the extension)
  *
  * @access public
  * @param string $in Directory
  * @param string $desired_filename
  * @return string
  */
  function get_unique_filename($in, $desired_filename) {
    
    if (!is_dir($in)) {
      false;
    } // if
    
    $file_path = $in . '/' . $desired_filename;
    $counter = 0;
    while (is_file($file_path)) {
      $counter++;
      $file_path = insert_before_file_extension($file_path, '(' . $counter . ')');
    } // if
    
    return $file_path;
    
  } // get_unique_filename
  
  /**
  * Set something before file extension
  *
  * @access public
  * @param string $in Filename
  * @param string $insert Insert this
  * @return null
  */
  function insert_before_file_extension($filename, $insert) {
    return str_replace_first('.', '.' . $insert, $filename);
  } // insert_before_file_extension
  
  /**
  * Forward specific file to the browser. Download can be forced (disposition: attachment) or passed as inline file
  *
  * @access public
  * @param string $path File path
  * @param string $type Serve file as this type
  * @param string $name If set use this name, else use filename (basename($path))
  * @param boolean $force_download Force download (add Disposition => attachement)
  * @return boolean
  */
  function download_file($path, $type = 'application/octet-stream', $name = '', $force_download = false) {
    if (!is_readable($path)) {
      return false;
    } // if
    
    $filename = trim($name) == '' ? basename($path) : trim($name);
    return download_contents(file_get_contents($path), $type, $filename, filesize($path), $force_download);
  } // download_file
  
  /**
  * Use content (from file, from database, other source...) and pass it to the browser as a file
  *
  * @param string $content
  * @param string $type MIME type
  * @param string $name File name
  * @param integer $size File size
  * @param boolean $force_download Send Content-Disposition: attachment to force save dialog
  * @return boolean
  */
  /**
  * SAVR 10/20/06 : force file download over SSL for IE
  * BIP  09/17/07 : inserted and tested for ProjectPier 
  * Was:
  * function download_contents($content, $type, $name, $size, $force_download = false) {
  */
  function download_contents($content, $type, $name, $size, $force_download = true, $from_filesystem = false) {
    if (connection_status() != 0) return false; // check connection

    if ($force_download) {
      /** SAVR 10/20/06
      * Was:
      * header("Cache-Control: public");
      */
      header("Cache-Control: public, must-revalidate");
      header("Pragma: hack");
    } else {
      header("Cache-Control: no-store, no-cache, must-revalidate");
      header("Cache-Control: post-check=0, pre-check=0", false);
      header("Pragma: no-cache");
    } // if
    header("Expires: " . gmdate("D, d M Y H:i:s", mktime(date("H") + 2, date("i"), date("s"), date("m"), date("d"), date("Y"))) . " GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Content-Type: $type");
    header("Content-Length: " . $size);
    // Prepare disposition
    $disposition = $force_download ? 'attachment' : 'inline';
    // http://www.ietf.org/rfc/rfc2183.txt
    $download_name = strtr($name, " ()<>@,;:\\/[]?=*%'\"", '--------------------');
    $download_name = normalize($download_name);
    header("Content-Disposition: $disposition; filename=\"$download_name\"");
    //header("Content-Disposition: $disposition; filename=$download_name");
    header("Content-Transfer-Encoding: binary");
    if ($from_filesystem) {
      if (!is_readable($content)) return false;
      if (!ini_get('safe_mode')) @set_time_limit(0);
      $chunksize = 1*(1024*1024); // how many bytes per chunk
      $buffer = '';
      $handle = fopen($content, 'rb');
      if ($handle === false) {
        return false;
      }
      while (!feof($handle)) {
        $buffer = fread($handle, $chunksize);
        print $buffer;
        flush();
        ob_flush();
      }
      return fclose($handle);
    } else {
/*
      print $content;
*/
      header("X-ProjectPier-Storage: mysql");
      header("X-ProjectPier-Size: " . $size);
      // 0.8.8 $content = repository id
      //print $content;
      $repository_id = $content;
      $repo_table = TABLE_PREFIX.'file_repo';
      $query = sprintf("SELECT `content`, `seq` FROM $repo_table WHERE `id`='%s' order by `seq` asc", mysql_real_escape_string($repository_id));
      trace(__FILE__,$query);
      header("X-ProjectPier-Debug1: " . $query);
      $result = mysql_query($query);
      header("X-ProjectPier-Debug2: " . mysql_error());
      while ($row = mysql_fetch_assoc($result)) {
        trace(__FILE__,$row['seq']);
        header("X-ProjectPier-Debug3-" . $row['seq'] . ": " . mysql_error());
        print $row['content'];
        flush();
        ob_flush();
      }
      header("X-ProjectPier-Debug4: " . mysql_error());
      mysql_free_result($result);
    }
    return((connection_status() == 0) && !connection_aborted());
  } // download_contents
  
  /**
  * This function is used for sorting list of files. 
  * 
  * The most important thing about this function is $extractor. It is function 
  * name of function that will be used to extract data that we need for sorting
  *  - filesize, file modification type, content-type... Anything. First param of
  * $extractor function must be filepath.
  *
  * After the extract have all the data it need $sort_with function will be used
  * to sort by the extracted data... First param of the $sort_with function must
  * be array that need to be sorted. This function MUST RETURN SORTED ARRAY, cant
  * use side effect...
  *
  * Important = $sort_with must be key sorting function because this function
  * saves extracted data into the array keys...
  *
  * Examples:
  *
  * sort_files($files, 'filemtime', 'krsort', SORT_NUMERIC) will sort all files 
  * by modification time and the freshest files will be at the top of the result
  *
  * @access public
  * @param array $file Array of filenames
  * @param string $extractor Function that will be used for extractiong specific
  *   file data (like file creation time or filesize)
  * @param string $sort_with Function that will be used to sort the array
  *   when we are done...
  * @param mixed $sort_method If this value is <> null that this will be passed
  *   to the sort functions as second param. I added it because there are great
  *   number of function that can use it to make a diffrence between string and int
  *   sorting... 
  * @return array
  */
  function sort_files($files, $extractor, $sort_with = 'array_ksort', $sort_method = null) {
    
    // Prepare...
    $extractor = trim($extractor);
    $sort_with = trim($sort_with);
    
    // Check the input data...
    if (!is_array($files)) {
      return false;
    } // if
    if (!function_exists($extractor)) {
      return false;
    } // if
    if (!function_exists($sort_with)) {
      return false;
    } // if
    
    // Prepare the tmp array...
    $tmp = array();
    
    // OK, now get the files...
    foreach ($files as $file) {
    
      // Pass this one?
      if (!is_file($file)) {
        continue;
      } // if
      
      // Get data...
      $data = call_user_func($extractor, $file);
      
      // Prepare array...
      if (!isset($tmp[$data])) {
        $tmp[$data] = array();
      } // if
      
      // Add filename to the extracted param...
      $tmp[$data][] = $file;
      
    } // foreach
    
    // OK, now sort subarrays
    foreach ($tmp as &$subarray) {
      if (count($subarray) > 0) {
        sort($subarray);
      } // if
    } // foreach
    
    // OK, do the sort thing...
    if (is_null($sort_method)) {
      $sorted = call_user_func($sort_with, $tmp);
    } else {
      $sorted = call_user_func_array($sort_with, array($tmp, $sort_method));
    } // if
    
    // Check sorted array
    if (!is_array($sorted)) {
      return false;
    } // if
    
    // OK, flatten...
    $result = array();
    foreach ($sorted as &$subarray) {
      $result = array_merge($result, $subarray);
    } // foreach
    
    // And done...
    return $result;
    
  } // sort_files
  
  // ================================================================
  //  SORT FUNC REPLACEMENTS
  //
  //  These function RETURN sorted array, don't use side effect. They
  //  are used by the sort_files() function in the 
  //  environment/functions/files.php
  // ================================================================
  
  /**
  * Replacement function for sort() function. Returns array
  *
  * @access public
  * @param array $array Array that need to be sorted
  * @param int $flag Sort flag, described on sort() function documentation page
  * @return array
  */
  function array_sort($array, $flag = SORT_REGULAR) {
    sort($array, $flag);
    return $array;
  } // end func 
  
  /**
  * Replacement function for rsort() function. Returns array
  *
  * @access public
  * @param array $array Array that need to be sorted
  * @param int $flag Sort flag, described on sort() function documentation page
  * @return array
  */
  function array_rsort($array, $flag = SORT_REGULAR) {
    rsort($array, $flag);
    return $array;
  } // end func array_rsort
  
  /**
  * Replacement function for ksort() function. Returns array
  *
  * @access public
  * @param array $array Array that need to be sorted
  * @param int $flag Sort flag, described on sort() function documentation page
  * @return array
  */
  function array_ksort($array, $flag = SORT_REGULAR) {
    ksort($array, $flag);
    return $array;
  } // end func array_ksort
  
  /**
  * Replacement function for krsort() function. Returns array
  *
  * @access public
  * @param array $array Array that need to be sorted
  * @param int $flag Sort flag, described on sort() function documentation page
  * @return array
  */
  function array_krsort($array, $flag = SORT_REGULAR) {
    krsort($array, $flag);
    return $array;
  } // end func array_krsort
  
  /*** / SORT FUNC REPLACEMENTS ***/

?>