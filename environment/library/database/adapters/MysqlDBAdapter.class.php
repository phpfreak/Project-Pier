<?php

  /**
  * DB access for MySQL
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class MysqlDBAdapter extends AbstractDBAdapter {
  
    /**
    * Connect to the database based on the params array
    *
    * @access protected
    * @param array $params
    * @return null
    * @throws DBConnectError
    */
    protected function connect($params) {
      
      $host     = array_var($params, 'host', '');
      $user     = array_var($params, 'user', '');
      $pass     = array_var($params, 'pass', '');
      $database = array_var($params, 'name', '');
      $persist  = array_var($params, 'persist', false);
      
      $link = $persist ? 
        @mysql_pconnect($host, $user, $pass) :
        @mysql_connect($host, $user, $pass);
        
      if (!is_resource($link)) {
        throw new DBConnectError($host, $user, $pass, $database);
      } // if
      
      if (!@mysql_select_db($database, $link)) {
        throw new DBConnectError($host, $user, $pass, $database);
      } // if
      
      $this->setLink($link);
      $this->setParams($params);
      $this->setDatabaseName($database);
      return true;
      
    } // connect
    
    /**
    * Basic query execution
    *
    * @access protected
    * @param string $sql
    * @return mixed
    */
    protected function executeQuery($sql) {
      return @mysql_query($sql, $this->link);
    } // executeQuery
    
    /**
    * Get begin work SQL (start transaction)
    *
    * @access public
    * @param void
    * @return string
    */
    function getBeginWorkCommand() {
      return 'BEGIN WORK';
    } // getBeginWorkCommand
    
    /**
    * Get comming SQL
    *
    * @access public
    * @param void
    * @return string
    */
    function getCommitCommand() {
      return 'COMMIT';
    } // getCommitCommand
    
    /**
    * Get rollback SQL
    *
    * @access public
    * @param void
    * @return string
    */
    function getRollbackCommand() {
      return 'ROLLBACK';
    } // getRollbackCommand
    
    /**
    * Return number of affected rows
    *
    * @access public
    * @param void
    * @return integer
    */
    function affectedRows() {
      return mysql_affected_rows($this->link);
    } // affectedRows
    
    /**
    * Return last insert ID
    *
    * @access public
    * @param void
    * @return integer
    */
    function lastInsertId() {
      return mysql_insert_id($this->link);
    } // lastInsertId
    
    /**
    * Returns last error message that server thrown
    *
    * @access public
    * @param void
    * @return string
    */
    function lastError() {
      return mysql_error($this->link);
    } // lastError
    
    /**
    * Returns code of the last error
    *
    * @access public
    * @param void
    * @return integer
    */
    function lastErrorCode() {
      return mysql_errno($this->link);
    } // lastErrorCode
    
    /**
    * Return array of tables that exists in database. This function will return NULL if there are 
    * no tables in database
    *
    * @access public
    * @param void
    * @return array
    */
    function listTables() {
      $extracted_table_names = $this->executeAll('SHOW TABLES');
      $table_names = array();
      if (count($extracted_table_names)) {
        foreach ($extracted_table_names as $extracted_table_name) {
          $table_names[] = array_var($extracted_table_name, 'Tables_in_' . $this->getDatabaseName());
        } // foreach
      } // if
      return count($table_names) ? $table_names : null;
    } // listTables
    
    /**
    * Drop one or more tables. If $table_names is string only that table will be droped, else script will drop
    *
    * @access public
    * @param mixed $table_names Array of table names or single table name
    * @return boolean
    */
    function dropTables($table_names) {
      
      if (empty($table_names)) {
        return true;
      } // if
      if (!is_array($table_names)) {
        $table_names = array($table_names);
      } // if
      
      $escaped_table_names = array();
      foreach ($table_names as $table_name) {
        $escaped_table_names[] = $this->escapeField($table_name);
      }
      return count($escaped_table_names) ? 
        $this->execute('DROP TABLE ' .  implode(', ', $escaped_table_names)) :
        true;
        
    } // dropTables
    
    /**
    * Remove all data from specific tables
    *
    * @access public
    * @param mixed $table_names Single table name or array of table names
    * @return boolean
    */
    function emptyTables($table_names) {
      
      if (empty($table_names)) {
        return true;
      } // if
      if (!is_array($table_names)) {
        $table_names = array($table_names);
      } // if
      
      foreach ($table_names as $table_name) {
        $this->execute('TRUNCATE ' . $this->escapeField($table_name));
      } // foreach
      
      return true;
      
    } // emptyTables
    
    /**
    * This function will return array of table names and their CREATE TABLE commands
    *
    * @access public
    * @param void
    * @return array or NULL if there are no tables in database
    */
    function exportDatabaseStructure() {
      $tables = $this->listTables();
      if (!is_array($tables) || !count($tables)) {
        return null;
      } // if
      $create_commands = array();
      foreach ($tables as $table) {
        $create_command = $this->exportTableStructure($table);
        if (trim($create_command) <> '') {
          $create_commands[$table] = $create_command;
        } // if
      } // foreach
      return count($create_commands) ? $create_commands : null;
    } // exportDatabaseStructure
    
    /**
    * This function is able to import database construction from any connected adapter
    *
    * @access public
    * @param AbstractDBAdapter $adapter
    * @param boolean $clear Clean up the database before execution
    * @return boolean
    */
    function importDatabaseStructure(AbstractDBAdapter $adapter, $clear = false) {
      if ($clear) {
        $this->clearDatabase();
      } // if
      $structure = $adapter->exportDatabaseStructure();
      if (is_array($structure)) {
        foreach ($structure as $table_name => $table_construction) {
          $this->execute($table_construction);
        } // foreach
      } // if
    } // importDatabaseStructure
    
    /**
    * Return CREATE TABLE sql for specific table
    *
    * @access public
    * @param string $table_name
    * @return string or NULL if table does not exists
    */
    function exportTableStructure($table_name) {
      $result = $this->executeOne('SHOW CREATE TABLE ' . $this->escapeField($table_name));
      return array_var($result, 'Create Table');
    } // exportTableStructure
    
    /**
    * Escape name of table field or name of the table
    *
    * @access public
    * @param string $field
    * @return string
    */
    function escapeField($field) {
      return '`' . trim($field) . '`';
    } // escapeField
    
    /**
    * Escape value before use it in query. This function makes difference between NULL, scalar
    * and DateTime values
    *
    * @access public
    * @param mixed $unescaped Value that need to be escaped
    * @return string
    */
    function escapeValue($unescaped) {
      if (is_null($unescaped)) {
        return 'NULL';
      } // if
      
      if (is_bool($unescaped)) {
        return $unescaped ? "'1'" : "'0'";
      } // if
      
      if (is_array($unescaped)) {
        $escaped_array = array();
        foreach ($unescaped as $unescaped_value) {
          $escaped_array[] = self::escapeValue($unescaped_value);
        }
        return implode(', ', $escaped_array);
      } // if
      
      if (is_object($unescaped) && ($unescaped instanceof DateTimeValue)) {
        return "'" . mysql_real_escape_string($unescaped->toMySQL()) . "'";
      } // if
      
      return "'" . mysql_real_escape_string($unescaped, $this->link) . "'";
    } // escapeValue
    
    /**
    * Fetch row from query result
    *
    * @access public
    * @param resource $resource
    * @return array
    */
    function fetchRow($resource) {
      return mysql_fetch_assoc($resource);
    } // fetchRow
    
    /**
    * Return number of rows in specific query result
    *
    * @access public
    * @param resource $resource
    * @return integer
    */
    function numRows($resource) {
      return mysql_num_rows($resource);
    } // numRows
    
    /**
    * Free database result
    *
    * @access public
    * @param resource $resource
    * @return boolean
    */
    function freeResult($resource) {
      return mysql_free_result($resource);
    } // freeResult
    
  } // MysqlDBAdapter

?>