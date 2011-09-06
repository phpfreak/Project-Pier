<?php

  /**
  * File repository provides a wrapper for storing files in a specific repository. It provides methods for
  * adding, updating and removing files. Every file is reprepsented by a file ID and can be accessed by it
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  final class FileRepository {
    
    /**
    * Backend adapter instance
    *
    * @var FileRepository_Backend
    */
    static private $default_backend;
    
    /**
    * Array of additional backends
    *
    * @var array
    */
    static private $additional_backends = array();
    
    // ---------------------------------------------------
    //  File manipulation
    // ---------------------------------------------------
    
    /**
    * Return all file IDs that are stored in repository
    *
    * @param string $backend_name Backend name. If NULL default backend will be used
    * @return array
    */
    static function listFiles($backend_name = null) {
      return self::getBackend($backend_name)->listFiles();
    } // listFiles
    
    /**
    * Return number of files from the repository
    *
    * @param string $backend_name Backend name. If NULL default backend will be used
    * @return integer
    */
    static function countFiles($backend_name = null) {
      return self::getBackend($backend_name)->countFiles();
    } // countFiles

    /**
    * Return path of specific file
    *
    * @param string $file_id File ID
    * @param string $backend_name Backend name. If NULL default backend will be used
    * @return string
    */
    static function getFilePath($file_id, $backend_name = null) {
      return self::getBackend($backend_name)->getFilePath($file_id);
    } // getFileContent
    
    /**
    * Return content of specific file
    *
    * @param stirng $file_id File ID
    * @param string $backend_name Backend name. If NULL default backend will be used
    * @return string
    */
    static function getFileContent($file_id, $backend_name = null) {
      return self::getBackend($backend_name)->getFileContent($file_id);
    } // getFileContent
    
    /**
    * Return all file attributes
    *
    * @param string $file_id
    * @param string $backend_name Backend name. If NULL default backend will be used
    * @return array
    */
    static function getFileAttributes($file_id, $backend_name = null) {
      return self::getBackend($backend_name)->getFileAttributes($file_id);
    } // getFileAttributes
    
    /**
    * Return value of specific file attribute. If attrbute is not available return $default
    *
    * @param string $file_id
    * @param string $attribute_name
    * @param mixed $default
    * @param string $backend_name Backend name. If NULL default backend will be used
    * @return mixed
    */
    static function getFileAttribute($file_id, $attribute_name, $default = null, $backend_name = null) {
      return self::getBackend($backend_name)->getFileAttribute($file_id, $attribute_name, $default);
    } // getFileAttribute
    
    /**
    * Set value of specific attribute
    *
    * @param string $file_id
    * @param string $attribute_name
    * @param mixed $attribute_value Resources and objects are not supported!
    * @param string $backend_name Backend name. If NULL default backend will be used
    * @return null
    */
    static function setFileAttribute($file_id, $attribute_name, $attribute_value, $backend_name = null) {
      return self::getBackend($backend_name)->setFileAttribute($file_id, $attribute_name, $attribute_value);
    } // setFileAttribute
    
    /**
    * Add file to the repository
    *
    * @param string $source File path of source file
    * @param array $attributes
    * @param string $backend_name Backend name. If NULL default backend will be used
    * @return string File ID
    */
    static function addFile($source, $attributes = null, $backend_name = null) {
      return self::getBackend($backend_name)->addFile($source, $attributes);
    } // addFile
    
    /**
    * Update content of specific file with content from $source file
    *
    * @param string $file_id
    * @param string $source
    * @param string $backend_name Backend name. If NULL default backend will be used
    * @return boolean
    */
    static function updateFileContent($file_id, $source, $backend_name = null) {
      return self::getBackend($backend_name)->updateFileContent($file_id, $source);
    } // updateFileContent
    
    /**
    * Delete specific file from repository
    *
    * @param string $file_id
    * @param string $backend_name Backend name. If NULL default backend will be used
    * @return boolean
    */
    static function deleteFile($file_id, $backend_name = null) {
      return self::getBackend($backend_name)->deleteFile($file_id);
    } // deleteFile
    
    /**
    * Clean up the repository - delete all files
    *
    * @param string $backend_name Backend name. If NULL default backend will be used
    * @return boolean
    */
    static function cleanUp($backend_name = null) {
      return self::getBackend($backend_name)->cleanUp();
    } // cleanUp
    
    /**
    * Check if $file_id is in repository
    *
    * @param string $file_id
    * @param string $backend_name Backend name. If NULL default backend will be used
    * @return boolean
    */
    static function isInRepository($file_id, $backend_name = null) {
      return self::getBackend($backend_name)->isInRepository($file_id);
    } // isInRepository
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get backend
    *
    * @param string $backend_name If NULL default backend will be returned. Else backend 
    * named $backend_name will be returned if avialble
    * @return FileRepository_Backend
    */
    static function getBackend($backend_name = null) {
      if (is_null($backend_name)) {
        return self::$default_backend;
      } else {
        if (isset(self::$additional_backends[$backend_name])) {
          return self::$additional_backends[$backend_name];
        } else {
          throw new InvalidParamError('backend_name', $backend_name, "Backend '$backend_name' not available");
        } // if
      } // if
    } // getBackend
    
    /**
    * Set backend value
    *
    * @param FileRepository_Backend $value
    * @return null
    * @throws InvalidInstanceError
    */
    static function setBackend($value, $backend_name = null) {
      if ($value instanceof FileRepository_Backend) {
        if (is_null($backend_name)) {
          self::$default_backend = $value;
        } else {
          self::$additional_backends[$backend_name] = $value;
        } // if
      } else {
        throw new InvalidInstanceError('value', $value, 'FileRepository_Backend');
      } // if
    } // setBackend
  
  } // FileRepository

?>