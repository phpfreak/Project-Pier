<?php

  /**
  * This class provides interface for adding and retrieving files from public/files folder
  *
  * @http://www.projectpier.org/
  */
  final class PublicFiles {
    
    /**
    * Repository path
    *
    * @var string
    */
    private static $repository_path;
    
    /**
    * Repository URL
    *
    * @var string
    */
    private static $repository_url;
  
    /**
    * Add file to the repository. When file is added this function will return new filename (40 characters + $extension)
    *
    * @param string $source Path of source file
    * @param string $extension Use this file extension
    * @return string
    */
    static function addFile($source, $extension = null) {
      if (!is_readable($source)) {
        return false;
      }
      
      $attach_extension = trim($extension) == '' ? '' : '.' . trim($extension);
      do {
        $destination = self::getFilePath(sha1(uniqid(rand(), true)) . $attach_extension);
      } while (is_file($destination));
      
      return copy($source, $destination) ? basename($destination) : false;
    } // addFile
    
    /**
    * Update content of specific repository file (update $update_file with content from $source)
    *
    * @param string $source Source file
    * @param string $update_file File that need to be updated
    * @return boolean
    */
    static function updateFile($source, $update_file) {
      $destination = self::getFilePath($update_file);
      
      if (!is_readable($source)) {
        return false;
      } // if
      if (!file_is_writable($destination)) {
        return false;
      } // if
      
      return copy($source, $destination);
    } // updateFile
    
    /**
    * Delete file from repository
    *
    * @param string $delete_file Filename of file that need to be deleted
    * @return boolean
    */
    static function deleteFile($delete_file) {
      $destination = self::getFilePath($delete_file);
      return @unlink($destination);
    } // deleteFile
    
    /**
    * Return path of specific file
    *
    * @param string $filename
    * @return string
    */
    static function getFilePath($filename) {
      return self::$repository_path . $filename;
    } // getFilePath
    
    /**
    * Return URL of specific public file
    *
    * @param string $filename
    * @return string
    */
    static function getFileUrl($filename) {
      return self::$repository_url . $filename;
    } // getFileUrl
    
    /**
    * Returns true if file with filename $filename exists in repository
    *
    * @param string $filename
    * @return boolean
    */
    static function fileExists($filename) {
      return is_readable(self::getFilePath($file));
    } // fileExists
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get repository_path
    *
    * @param null
    * @return string
    */
    static function getRepositoryPath() {
      return self::$repository_path;
    } // getRepositoryPath
    
    /**
    * Set repository_path value
    *
    * @param string $value
    * @return null
    */
    static function setRepositoryPath($value) {
      self::$repository_path = with_slash($value);
    } // setRepositoryPath
    
    /**
    * Get repository_url
    *
    * @param null
    * @return string
    */
    static function getRepositoryUrl() {
      return self::$repository_url;
    } // getRepositoryUrl
    
    /**
    * Set repository_url value
    *
    * @param string $value
    * @return null
    */
    static function setRepositoryUrl($value) {
      self::$repository_url = with_slash($value);
    } // setRepositoryUrl
  
  } // PublicFiles

?>