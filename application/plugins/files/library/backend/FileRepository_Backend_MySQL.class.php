<?php

  /**
  * File repository backend that put files into the MySQL database
  *
  * @package FileRepository.backend
  * @http://www.projectpier.org/
  */
  class FileRepository_Backend_MySQL implements FileRepository_Backend {
    
    /** Names of database tables, prefix will be added in front of them **/
    const FILES_TABLE = 'file_repo';
    const ATTRIBUTES_TABLE = 'file_repo_attributes';
    
    /**
    * Database connection resource
    *
    * @var resource
    */
    private $db_link;
    
    /**
    * Table prefix
    *
    * @var string
    */
    private $table_prefix;
  
    /**
    * Constructor
    *
    * @param resource $db_link Databse connection resource
    * @param string $table_prefix
    * @return FileRepository_Backend_MySQL
    */
    function __construct($db_link, $table_prefix) {
      trace(__FILE__, '__construct()');
      $this->setDbLink($db_link);
      $this->setTablePrefix($table_prefix);
    } // __construct
    
    // ---------------------------------------------------
    //  FileRepository_Backend implementation
    // ---------------------------------------------------
    
    /**
    * Return array of all files in repository
    *
    * @param void
    * @return null
    */
    function listFiles() {
      $files_table = $this->getFilesTableName();
      if ($result = mysql_query("SELECT `id` FROM $files_table ORDER BY `order`", $this->db_link)) {
        $ids = array();
        while ($row = mysql_fetch_assoc($result)) {
          $ids[] = $row['id'];
        } // while
        return $ids;
      } // if
      return array();
    } // listFiles
    
    /**
    * Return number of files in repository
    *
    * @param void
    * @return integer
    */
    function countFiles() {
      $files_table = $this->getFilesTableName();
      if ($result = mysql_query("SELECT COUNT(`id`) AS 'row_count' FROM $files_table", $this->db_link)) {
        if ($row = mysql_fetch_assoc($result)) {
          return (integer) $row['row_count'];
        } // if
      } // if
      return 0;
    } // countFiles
    
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
      
      $files_table = $this->getFilesTableName();
      $escaped_id = mysql_real_escape_string($file_id, $this->db_link);
      if ($result = mysql_query("SELECT `content` FROM $files_table WHERE `id` = '$escaped_id'", $this->db_link)) {
        if ($row = mysql_fetch_assoc($result)) {
          return $row['content'];
        } // if
      } // if
      return null;
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
      
      $attributes_table = $this->getAttributesTableName();
      $escaped_id = mysql_real_escape_string($file_id, $this->db_link);
      if ($result = mysql_query("SELECT `attribute`, `value` FROM $attributes_table WHERE `id` = '$escaped_id'", $this->db_link)) {
        $attributes = array();
        while ($row = mysql_fetch_assoc($result)) {
          $attributes[$row['attribute']] = eval($row['value']);
        } // while
        return $attributes;
      } // if
      return array();
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
      
      $attributes_table = $this->getAttributesTableName();
      $escaped_id = mysql_real_escape_string($file_id, $this->db_link);
      $escaped_attribute = mysql_real_escape_string($attribute_name, $this->db_link);
      if ($result = mysql_query("SELECT `value` FROM $attributes_table WHERE `id` = '$escaped_id' AND `attribute` = '$escaped_attribute'", $this->db_link)) {
        if ($row = mysql_fetch_assoc($result)) {
          return eval($row['value']);
        } // if
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
      
      if (is_object($attribute_value) || is_resource($attribute_value)) {
        throw new InvalidParamError('$attribute_value', $attribute_value, 'Objects and resources are not supported as attribute values');
      } // if
      
      $attributes_table = $this->getAttributesTableName();
      $escaped_id = mysql_real_escape_string($file_id, $this->db_link);
      $escaped_attribute = mysql_real_escape_string($attribute_name, $this->db_link);
      $escaped_value = mysql_real_escape_string('return ' . var_export($attribute_value, true) . ';', $this->db_link);
      
      if ($result = mysql_query("SELECT `value` FROM $attributes_table WHERE `id` = '$escaped_id' AND `attribute` = '$escaped_attribute'", $this->db_link)) {
        if (mysql_num_rows($result) == 0) {
          mysql_query("INSERT INTO $attributes_table (`id`, `attribute`, `value`) VALUES ('$escaped_id', '$escaped_attribute', '$escaped_value')", $this->db_link);
        } else {
          mysql_query("UPDATE $attributes_table SET `value` = '$escaped_value' WHERE `id` = '$escaped_id' AND `attribute` = '$escaped_attribute''", $this->db_link);
        } // if
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
      $files_table = $this->getFilesTableName();
      $escaped_id = mysql_real_escape_string($file_id, $this->db_link);
      $order = intval($this->getNextOrder());

      mysql_query("BEGIN WORK", $this->db_link);
      $success = true;
      $seq = 0;
      $block_size = 500 * 1024; // 500 KB
      $handle = fopen($source, "rb");
      while (!feof($handle)) {
        $seq++;
        $data = fread($handle, $block_size);
        $escaped_content = mysql_real_escape_string($data, $this->db_link);
        if (!mysql_query("INSERT INTO $files_table (`id`, `seq`, `content`, `order`) VALUES ('$escaped_id', $seq, '$escaped_content', $order)", $this->db_link)) {
echo mysql_error();
          $success = false;
          break;
        }
      }
      fclose($handle);

      if ($success) {
        mysql_query("COMMIT", $this->db_link);
        
        if (is_array($attributes)) {
          foreach ($attributes as $attribute_name => $attribute_value) {
            $this->setFileAttribute($file_id, $attribute_name, $attribute_value);
          } // foreach
        } // if
        
        return $file_id;
      } else {
        mysql_query("ROLLBACK", $this->db_link);
        throw new FileRepositoryAddError($source, $file_id);
      } // if
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
      
      $files_table = $this->getFilesTableName();
      $escaped_id = mysql_real_escape_string($file_id, $this->db_link);
      $escaped_content = mysql_real_escape_string(file_get_contents($source), $this->db_link);
      
      if (mysql_query("UPDATE $files_table SET `content` = '$escaped_content' WHERE `id` = '$escaped_id'", $this->db_link)) {
        return true;
      } else {
        throw new FileRepositoryAddError($source, $file_id);
      } // if
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
      
      $files_table = $this->getFilesTableName();
      $attributes_table = $this->getAttributesTableName();
      $escaped_id = mysql_real_escape_string($file_id, $this->db_link);
      
      mysql_query("BEGIN WORK", $this->db_link);
      if (!mysql_query("DELETE FROM $files_table WHERE `id` = '$escaped_id'", $this->db_link)) {
        throw new FileRepositoryDeleteError($file);
      } // if
      
      if (!mysql_query("DELETE FROM $attributes_table WHERE `id` = '$escaped_id'", $this->db_link)) {
        mysql_query('ROLLBACK', $this->db_link);
        throw new FileRepositoryDeleteError($file);
      } // if
      
      return mysql_query("COMMIT", $this->db_link);
    } // deleteFile
    
    /**
    * Drop all files from repository
    *
    * @param void
    * @return null
    */
    function cleanUp() {
      $files_table = $this->getFilesTableName();
      $attributes_table = $this->getAttributesTableName();
      
      mysql_query("BEGIN WORK", $this->db_link);
      mysql_query("DELETE FROM $files_table", $this->db_link);
      mysql_query("DELETE FROM $attributes_table", $this->db_link);
      mysql_query("COMMIT", $this->db_link);
    } // cleanUp
    
    /**
    * Check if specific file is in repository
    *
    * @param string $file_id
    * @return boolean
    */
    function isInRepository($file_id) {
      $files_table = $this->getFilesTableName();
      $escaped_id = mysql_real_escape_string($file_id, $this->db_link);
      if ($result = mysql_query("SELECT COUNT(`id`) AS 'row_count' FROM $files_table WHERE `id` = '$escaped_id'", $this->db_link)) {
        if ($row = mysql_fetch_assoc($result)) {
          return (boolean) $row['row_count'];
        } // if
      } // if
      return false;
    } // isInRepository
    
    // ---------------------------------------------------
    //  Utils
    // ---------------------------------------------------
    
    /**
    * Return files table name
    *
    * @param boolean $escape Escape table name
    * @return string
    */
    protected function getFilesTableName($escape = true) {
      $table_name = $this->getTablePrefix() . self::FILES_TABLE;
      return $escape ? '`' . $table_name . '`' : $table_name;
    } // getFilesTableName
    
    /**
    * Return attributes table name
    *
    * @param boolean $escape Escape table name
    * @return string
    */
    protected function getAttributesTableName($escape = true) {
      $table_name = $this->getTablePrefix() . self::ATTRIBUTES_TABLE;
      return $escape ? '`' . $table_name . '`' : $table_name;
    } // getAttributesTableName
    
    /**
    * Return unique file ID
    *
    * @param void
    * @return string
    */
    protected function getUniqueId() {
      $files_table = $this->getFilesTableName();
      do {
        $id = sha1(uniqid(rand(), true));
        $escaped_id = mysql_real_escape_string($id, $this->db_link);
        if ($result = mysql_query("SELECT COUNT(`id`) AS 'row_count' FROM $files_table WHERE `id` = '$escaped_id'", $this->db_link)) {
          $row = mysql_fetch_assoc($result);
          if (!is_array($row) || !isset($row['row_count'])) $row['row_count'] = 0;
        } else {
          $row['row_count'] = 0;
        } // if
      } while ($row['row_count'] > 0);
      return $id;
    } // getUniqueId
    
    /**
    * Return next order
    *
    * @param void
    * @return integer
    */
    protected function getNextOrder() {
      $files_table = $this->getFilesTableName();
      if ($result = mysql_query("SELECT max(`order`) as `order` FROM $files_table", $this->db_link)) {
        if ($row = mysql_fetch_assoc($result)) {
          return (integer) $row['order'] + 1;
        } // if
      } // if
      return 1;
    } // getNextOrder
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get db_link
    *
    * @param null
    * @return resource
    */
    function getDbLink() {
      return $this->db_link;
    } // getDbLink
    
    /**
    * Set db_link value
    *
    * @param resource $value
    * @return null
    */
    function setDbLink($value) {
      trace(__FILE__, '__setDbLink()');
      if (!is_resource($value) || (strpos(get_resource_type($value), 'mysql') === false)) {
        throw new InvalidParamError('value', $value, 'DB link need to be MySQL connection resouce');
      } // if
      $this->db_link = $value;
    } // setDbLink
    
    /**
    * Get table_prefix
    *
    * @param null
    * @return string
    */
    function getTablePrefix() {
      return $this->table_prefix;
    } // getTablePrefix
    
    /**
    * Set table_prefix value
    *
    * @param string $value
    * @return null
    */
    function setTablePrefix($value) {
      $this->table_prefix = $value;
    } // setTablePrefix
  
  } // FileRepository_Backend_MySQL

?>