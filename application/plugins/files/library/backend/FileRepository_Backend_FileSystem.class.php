<?php

  /**
  * File repository backend that stores file in destination folder on file system
  *
  * @package FileRepository.backend
  * @http://www.projectpier.org/
  */
  class FileRepository_Backend_FileSystem implements FileRepository_Backend {
    
    /**
    * Path to repository directory in the file system
    *
    * @var string
    */
    private $repository_dir;
    
    /**
    * Array of attributes indexed by file ID
    *
    * @var array
    */
    private $attributes = null;
  
    /**
    * Construct the FileRepository_Backend_FileSystem
    *
    * @param string $repository_dir Path to the file system repository
    * @return FileRepository_Backend_FileSystem
    */
    function __construct($repository_dir) {
      $this->setRepositoryDir($repository_dir);
      $this->loadFileAttributes();
    } // __construct
    
    // ---------------------------------------------------
    //  Backend implementation
    // ---------------------------------------------------
    
    /**
    * Return array of all files in repository
    *
    * @param void
    * @return null
    */
    function listFiles() {
      return array_keys($this->attributes);
    } // listFiles
    
    /**
    * Return number of files in repository
    *
    * @param void
    * @return integer
    */
    function countFiles() {
      return count($this->attributes);
    } // countFiles
    

    /**
    * Return the file path (trigger: streaming)
    *
    * @param string $file_id
    * @return string
    */
    function getFilePath($file_id) {
      if (!$this->isInRepository($file_id)) {
        throw new FileNotInRepositoryError($file_id);
      } // if
      
      $file_path = $this->_getFilePath($file_id);
      if (!is_file($file_path) || !is_readable($file_path)) {
        throw new FileNotInRepositoryError($file_id);
      } // if
      
      return $file_path;
    } // getFilePath

    /**
    * Read the content of the file and return it
    *
    * @param string $file_id
    * @return string
    */
    function getFileContent($file_id) {
      if (!$this->isInRepository($file_id)) {
        throw new FileNotInRepositoryError($file_id);
      } // if
      
      $file_path = $this->_getFilePath($file_id);
      if (!is_file($file_path) || !is_readable($file_path)) {
        throw new FileNotInRepositoryError($file_id);
      } // if
      
      return file_get_contents($file_path);
    } // getFileContent
    
    /**
    * Return all file attributes for specific file. If file has no attributes empty array is
    * returned
    *
    * @param string $file_id
    * @return array
    * @throws FileNotInRepositoryError
    */
    function getFileAttributes($file_id) {
      if (!$this->isInRepository($file_id)) {
        throw new FileNotInRepositoryError($file_id);
      } // if
      
      return is_array($this->attributes[$file_id]) ? $this->attributes[$file_id] : array();
    } // getFileAttributes
    
    /**
    * Return value of specific file attribute
    *
    * @param string $file_id
    * @param string $attribute_name
    * @param mixed $default Default value is returned when attribute is not found
    * @return mixed
    * @throws FileNotInRepositoryError if file is not in repository
    */
    function getFileAttribute($file_id, $attribute_name, $default = null) {
      if (!$this->isInRepository($file_id)) {
        throw new FileNotInRepositoryError($file_id);
      } // if
      
      if (isset($this->attributes[$file_id]) && is_array($this->attributes[$file_id]) && isset($this->attributes[$file_id][$attribute_name])) {
        return $this->attributes[$file_id][$attribute_name];
      } // if
      
      return $default;
    } // getFileAttribute
    
    /**
    * Set attribute value for specific file
    *
    * @param string $file_id
    * @param string $attribute_name
    * @param mixed $attribute_value Objects and resources are not supported. Scalars and arrays are
    * @return null
    * @throws FileNotInRepositoryError If $file_id does not exists in repository
    * @throws InvalidParamError If we have an object or a resource as attribute value
    */
    function setFileAttribute($file_id, $attribute_name, $attribute_value) {
      if (!$this->isInRepository($file_id)) {
        throw new FileNotInRepositoryError($file_id);
      } // if
      
      if (!isset($this->attributes[$file_id]) || !is_array($this->attributes[$file_id])) {
        $this->attributes[$file_id] = array();
      } // if
      
      if (is_object($attribute_value) || is_resource($attribute_value)) {
        throw new InvalidParamError('$attribute_value', $attribute_value, 'Objects and resources are not supported as attribute values');
      } // if
      
      if (!isset($this->attributes[$file_id][$attribute_name]) || ($this->attributes[$file_id][$attribute_name] <> $attribute_value)) {
        $this->attributes[$file_id][$attribute_name] = $attribute_value;
        $this->saveFileAttributes();
      } // if
    } // setFileAttribute
    
    /**
    * Add file to the repository
    *
    * @param string $source Path of the source file
    * @param array $attributes Array of file attributes
    * @return string File ID
    * @throws FileDnxError if source is not readable
    * @throws FailedToCreateFolderError if we fail to create subdirectory
    * @throws FileRepositoryAddError if we fail to move file to the repository
    */
    function addFile($source, $attributes = null) {
      if (!is_readable($source)) {
        throw new FileDnxError($source);
      } // if
      
      $file_id = $this->getUniqueId();
      $file_path = $this->_getFilePath($file_id);
      $destination_dir = dirname($file_path);
      
      if (!is_dir($destination_dir)) {
        if (!force_mkdir($destination_dir, 0777)) {
          throw new FailedToCreateFolderError($destination_dir);
        } // if
      } // if
      
      if (!copy($source, $file_path)) {
        throw new FileRepositoryAddError($source, $file_id);
      } // if
      
      $this->attributes[$file_id] = true; // register file
      
      if (is_array($attributes)) {
        foreach ($attributes as $attribute_name => $attribute_value) {
          $this->setFileAttribute($file_id, $attribute_name, $attribute_value);
        } // foreach
      } // if
      
      return $file_id;
    } // addFile
    
    /**
    * Update content of specific file
    *
    * @param string $file_id
    * @param string $source
    * @return boolean
    * @throws FileDnxError if source file is not readable
    * @throws FileNotInRepositoryError if $file_id is not in the repository
    * @throws FileRepositoryAddError if we fail to update file
    */
    function updateFileContent($file_id, $source) {
      if (!is_readable($source)) {
        throw new FileDnxError($source);
      } // if
      
      if (!$this->isInRepository($file_id)) {
        throw new FileNotInRepositoryError($file_id);
      } // if
      
      $file_path = $this->_getFilePath($file_id);
      
      if (!copy($source, $file_path)) {
        throw new FileRepositoryAddError($source, $file_id);
      } // if
      
      return true;
    } // updateFileContent
    
    /**
    * Delete file from the repository
    *
    * @param string $file_id
    * @return boolean
    * @throws FileNotInRepositoryError if $file_id is not in the repository
    * @throws FileRepositoryDeleteError if we fail to delete file
    */
    function deleteFile($file_id) {
      if (!$this->isInRepository($file_id)) {
        throw new FileNotInRepositoryError($file_id);
      } // if
      
      $file_path = $this->_getFilePath($file_id);
      
      if (!unlink($file_path)) {
        throw new FileRepositoryDeleteError($file_id);
      } // if
      
      if (isset($this->attributes[$file_id])) {
        unset($this->attributes[$file_id]);
        $this->saveFileAttributes();
      } // if
      
      $this->cleanUpDir($file_id);
      
      return true;
    } // deleteFile
    
    /**
    * Drop all files from repository
    *
    * @param void
    * @return null
    */
    function cleanUp() {
      $dir = dir($this->getRepositoryDir());
      if ($dir) {
    		while (false !== ($entry = $dir->read())) {
    		  if (str_starts_with($entry, '.')) continue; // '.', '..' and hidden files ('.svn' for instance)
    		  $path = with_slash($this->getRepositoryDir()) . $entry;
    		  if (is_dir($path)) {
    		    delete_dir($path);
    		  } elseif (is_file($path)) {
    		    unlink($path);
    		  } // if
    		} // while
  		} // if
    } // cleanUp
    
    /**
    * Check if specific file is in repository
    *
    * @param string $file_id
    * @return boolean
    */
    function isInRepository($file_id) {
      return isset($this->attributes[$file_id]) && is_file($this->_getFilePath($file_id));
    } // isInRepository
    
    // ---------------------------------------------------
    //  Utils
    // ---------------------------------------------------
    
    /**
    * Return file path by file_id. This function does not check if file really 
    * exists in repository, it just creates and returns the path
    *
    * @param string $file_id
    * @return string
    */
    private function _getFilePath($file_id) {
      return with_slash($this->getRepositoryDir()) . $this->idToPath($file_id);
    } // _getFilePath
    
    /**
    * This function will clean up the file dir after the file was deleted
    *
    * @param string $file_id
    * @return null
    */
    private function cleanUpDir($file_id) {
      $path = $this->idToPath($file_id);
      
      if (!$path) return;
      
      $path_parts = explode('/', $path);
      $repository_path = with_slash($this->getRepositoryDir());
      
      $for_cleaning = array(
        $repository_path . $path_parts[0] . '/' . $path_parts[1] . '/' . $path_parts[2],
        $repository_path . $path_parts[0] . '/' . $path_parts[1],
        $repository_path . $path_parts[0],
      ); // array
      
      foreach ($for_cleaning as $dir) {
        if (is_dir_empty($dir)) {
          delete_dir($dir);
        } else {
          return; // break, not empty
        } // if
      } // foreach
    } // cleanUpDir
    
    /**
    * Convert file ID to repository file path
    *
    * @param string $file_id
    * @return string
    */
    private function idToPath($file_id) {
      if (strlen($file_id) == 40) {
        $parts = array();
        for ($i = 0; $i < 3; $i++) {
          $parts[] = substr($file_id, $i * 5, 5);
        } // for
        $parts[] = substr($file_id, 15, 25);
        return implode('/', $parts);
      } else {
        return null;
      } // if
    } // idToPath
    
    /**
    * Return unique file ID
    *
    * @param void
    * @return string
    */
    private function getUniqueId() {
      do {
        $id = sha1(uniqid(rand(), true));
        $file_path = $this->_getFilePath($id);
      } while (is_file($file_path));
      return $id;
    } // getUniqueId
    
    // ---------------------------------------------------
    //  Attribute handling
    // ---------------------------------------------------
    
    /**
    * Load file attributes
    *
    * @param void
    * @return null
    */
    protected function loadFileAttributes() {
      $file = $this->getAttributesFilePath();
      
      if (is_file($file)) {
        if (!is_readable($file)) {
          throw new FileDnxError($file);
        } // if
        
        $attributes = include $file; // read from file
        if (is_array($attributes)) {
          $this->attributes = $attributes;
        } else {
          $this->attributes = array();
          $this->saveFileAttributes();
        } // if
        
      } else {
        $this->attributes = array();
        $this->saveFileAttributes();
      } // if
      
    } // loadFileAttributes
    
    /**
    * Safe file attribute value to a file
    *
    * @param void
    * @return boolean
    */
    protected function saveFileAttributes() {
      $file = $this->getAttributesFilePath();
      if (is_file($file) && !file_is_writable($file)) {
        throw new FileNotWritableError($file);
      } // if
      return file_put_contents($file, "<?php\n\nreturn " . var_export($this->attributes, true) . ";\n\n?>");
    } // saveFileAttributes
    
    /**
    * Return path of file where we save file attributes
    *
    * @param void
    * @return string
    */
    protected function getAttributesFilePath() {
      return with_slash($this->getRepositoryDir()) . 'attributes.php';
    } // getAttributesFilePath
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get repository_dir
    *
    * @param null
    * @return string
    */
    function getRepositoryDir() {
      return $this->repository_dir;
    } // getRepositoryDir
    
    /**
    * Set repository_dir value
    *
    * @param string $value
    * @return null
    * @throws DirDnxError
    * @throws DirNotWritableError
    */
    function setRepositoryDir($value) {
      if (!is_null($value) && !is_dir($value)) {
        throw new DirDnxError($value);
      } // if
      
      if (!folder_is_writable($value)) {
        throw new DirNotWritableError($value);
      } // if
      
      $this->repository_dir = $value;
    } // setRepositoryDir
  
  } // FileRepository_Backend_FileSystem

?>