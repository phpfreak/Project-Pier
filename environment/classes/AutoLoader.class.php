<?php
  
  /**
  * Fancy class loader which uses an index
  * 
  * This class is based on SmartLoader
  *
  * @package Environment
  */
  class AutoLoader {
    
    /**
    * mod settings for the index file
    */
    const INDEX_FILE_MOD = 0775;
    
    /**
    * Name of the $GLOBALS var where we'll store class names
    *
    * @var string
    */
    const GLOBAL_VAR = 'autoloader_classes';
    
    /**
    * Filename of index file
    *
    * @var string
    */
    private $index_filename = 'autoloader_index.php';
    
    /**
    * Array of directory paths that need to be parsed
    *
    * @var array
    */
    private $parse_directories = array();
    
    /**
    * Extension of files that need to be scaned
    *
    * @var string
    */
    private $scan_file_extension = 'class.php';
    
    /**
    * Ignore hidden and system files
    *
    * @var boolean
    */
    private $ignore_hidden_files = true;
    
    /**
    * Cached array of parsed directories, keep it from endless loop
    * 
    * @var array
    */
    private $parsed_directories = array();
    
    /**
    * Class index
    *
    * @var array
    */
    private $class_index = array();
    
    // ---------------------------------------------------
    //  Doers
    // ---------------------------------------------------
    
    /**
    * Loads a class by its name
    *
    * @access public
    * @param string $class_name
    * @throws Exception
    * @return boolean Success
    */
    public function loadClass($load_class_name) {
      static $retrying = false; // is this our second loading attempt?
      
      $class_name = strtoupper($load_class_name);
      
      /* Recreate the index file, if outdated */
      if (!isset($GLOBALS[self::GLOBAL_VAR])) {
        if ($retrying || !is_readable($this->getIndexFilename())) {
          $this->createCache();
          if (!is_readable($this->getIndexFilename())) {
            throw new Exception('SmartLoader index file "'.$this->indexFilename.'" is not readable!');
          } // if
        } // if
        include $this->getIndexFilename();
      } // if
      
      /* include the needed file or retry on failure */
      if (isset($GLOBALS[self::GLOBAL_VAR][$class_name])) {
        if (@include($GLOBALS[self::GLOBAL_VAR][$class_name])) {
          return true;
        } else {
          if ($retrying) {
            throw new Exception('Class file "' . $GLOBALS[self::GLOBAL_VAR][$class_name] . '" for class "'.$class_name.'" cannot be included!');
          } // if
        } // if
      } elseif ($retrying) {
        /* we failed while retrying. this is bad. */
        throw new Exception('Could not find class file for "'.$class_name.'"');
      } // if
      
      /* including failed. try again. */
      unset($GLOBALS[self::GLOBAL_VAR]);
      $retrying = true;
      return $this->loadClass($class_name);
    } // loadClass
    
    /**
    * - Scans the class dirs for class/interface definitions and 
    * 	creates an associative array (class name => class file) 
    * - Generates the array in PHP code and saves it as index file
    *
    * @access private
    * @param param_type $param_name
    * @throws Exception
    */
    private function createCache() {
      if (is_array($this->parse_directories) && count($this->parse_directories)) {
        foreach ($this->parse_directories as $dir) {
          $this->parseDir($dir);
        }
      } // if
      $this->createIndexFile();
    } // createCache
    
    /**
    * Write out to the index file
    *
    * @access private
    * @throws Exception
    */
    private function createIndexFile() {
      /* generate php index file */
      $index_content = "<?php\n";
      foreach ($this->class_index as $class_name => $class_file) {
        // $index_content .= "\t\$GLOBALS['autoloader_classes'][". var_export(strtoupper($class_name), true) . "] = " . var_export($class_file, true) . ";\n";
        $index_content .= "\t\$GLOBALS['autoloader_classes'][". var_export(strtoupper($class_name), true) . "] = ROOT." . var_export($class_file, true) . ";\n";
      } // foreach
      $index_content .= "?>";
      if (!@file_put_contents($this->getIndexFilename(), $index_content)) {
        throw new Exception('Could not write to "'.$this->getIndexFilename().'". Make sure, that your webserver has write access to it.');
      } // if
      
      /* Apply mod rights */
      @chmod($this->getIndexFilename(), self::INDEX_FILE_MOD );
    } // createIndexFile
    
    /**
    * Parses a directory for class/interface definitions. Saves found definitions
    * in $classIndex
    *
    * @access private
    * @param string $directory_path
    * @throws Exception
    * @return boolean Success
    */
    private function parseDir($directory_path) {
      $directory_path = with_slash($directory_path);
      if (in_array($directory_path, $this->parsed_directories)) {
        return;
      } else {
        $this->parsed_directories[] = $directory_path;
      } // if
      
      $dir = dir($directory_path);
      while (false !== ($entry = $dir->read())) {
        if ($entry == '.' || $entry == '..') {
          continue;
        } // if
        $path = $directory_path . $entry;
        if (is_dir($path)) {
          if ($this->getIgnoreHiddenFiles() && ($entry[0] == '.')) {
            continue;
          } // if
          if (!is_readable($path)) {
            continue;
          } // if
          $this->parseDir($path);
        } elseif (is_file($path)) {
          if (!is_readable($path)) {
            continue;
          } // if
          if (str_ends_with($path, $this->getScanFileExtension())) {
            $this->parseFile($path);
          } // if
        } // if
      } // if
      $dir->close();
    } // parseDir
    
    /**
    * Parse a file for PHP classes and add them to our classIndex
    *
    * @access private
    * @param string path to file
    * @throws Exception
    */
    private function parseFile($path) {
      if (!$buf = @file_get_contents($path)) {
        throw new Exception('Couldn\'t read file contents from "'.$path.'".');
      } // if
      
      /* searching for classes */
      if (preg_match_all("%(interface|class)\s+(\w+)\s+(extends\s+(\w+)\s+)?(implements\s+\w+\s*(,\s*\w+\s*)*)?{%im", $buf, $result)) {
        foreach ($result[2] as $class_name) {
          $absolute_path = str_replace('\\', '/', $path);
          $relative_path = str_replace(ROOT, '', $absolute_path);
          $this->class_index[$class_name] = $relative_path;
          // $this->class_index[$class_name] = $absolute_path;  // 0.8.6 way
        } // if
      } // if
    } // parseFile
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Add directory that need to be scaned
    *
    * @param string $path Directory path
    * @return null
    */
    function addDir($path) {
      if (is_dir($path)) {
        $this->parse_directories[] = $path;
      } // if
    } // addDir
    
    /**
    * Get index_filename
    *
    * @access public
    * @param null
    * @return string
    */
    function getIndexFilename() {
      return $this->index_filename;
    } // getIndexFilename
    
    /**
    * Set index_filename value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setIndexFilename($value) {
      $this->index_filename = $value;
    } // setIndexFilename
    
    /**
    * Get scan_file_extension
    *
    * @access public
    * @param null
    * @return string
    */
    function getScanFileExtension() {
      return $this->scan_file_extension;
    } // getScanFileExtension
    
    /**
    * Set scan_file_extension value
    *
    * @access public
    * @param string $value
    * @return null
    */
    function setScanFileExtension($value) {
      $this->scan_file_extension = $value;
    } // setScanFileExtension
    
    /**
    * Get ignore_hidden_files
    *
    * @access public
    * @param null
    * @return boolean
    */
    function getIgnoreHiddenFiles() {
      return $this->ignore_hidden_files;
    } // getIgnoreHiddenFiles
    
    /**
    * Set ignore_hidden_files value
    *
    * @access public
    * @param boolean $value
    * @return null
    */
    function setIgnoreHiddenFiles($value) {
      $this->ignore_hidden_files = $value;
    } // setIgnoreHiddenFiles
    
  } // AutoLoader
  
?>