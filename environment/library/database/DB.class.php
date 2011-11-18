<?php

  /**
  * This function holds open database connections and provides interface to them. It is also used
  * for SQL logging
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  final class DB {
    
    /** ID of primary connection **/
    const PRIMARY_CONNECTION_ID = 'PRIMARY';
    
    /**
    * Collection of connections
    *
    * @var array
    */
    static private $connections = array();
    
    /**
    * ID of primary connection. This connection will be used if connection name is not suplied
    *
    * @var string
    */
    static private $primary_connection = self::PRIMARY_CONNECTION_ID;
    
    /**
    * SQL log
    *
    * @var array
    */
    static private $sql_log = array();
    
    /**
    * This function will return specific connection. If $connection_name is NULL primary connection will be used
    *
    * @access public
    * @param string $connection_name Connection name, if NULL primary connection will be used
    * @return AbstractDBAdapter
    */
    static function connection($connection_name = null) {
      if (is_null($connection_name)) {
        $connection_name = self::getPrimaryConnection();
      } // if
      return array_var(self::$connections, $connection_name);
    } // connection
    
    /**
    * Create new database connection
    *
    * @access public
    * @param string $adapter Adapter name (currently only mysql adapter is implemeted)
    * @param array $params Connection params
    * @param string $connection_name Name of the connection, if NULL default connection ID will be used
    * @return boolean
    * @throws FileDnxError
    * @throws DBAdapterDnx
    */
    static function connect($adapter, $params, $connection_name = null) {
      $connection_name = is_null($connection_name) || trim($connection_name) == '' ? 
        self::PRIMARY_CONNECTION_ID : 
        trim($connection_name);
        
      $adapter = self::connectAdapter($adapter, $params);
      if (($adapter instanceof AbstractDBAdapter) && $adapter->isConnected()) {
        self::$connections[$connection_name] = $adapter;
        return $adapter;
      } else {
        return null;
      } // if
      
    } // connect
    
    /**
    * This function will include adapter and try to connect. In case of error DBConnectError will be thrown
    *
    * @access public
    * @param string $adapter_name
    * @param array $params
    * @return AbstractDBAdapter
    * @throws DBAdapterDnx
    * @throws DBConnectError
    */
    private function connectAdapter($adapter_name, $params) {
      
      self::useAdapter($adapter_name);
      
      $adapter_class = self::getAdapterClass($adapter_name);
      if (!class_exists($adapter_class)) {
        throw new DBAdapterDnx($adapter_name, $adapter_class);
      } // if
      
      return new $adapter_class($params);
      
    } // connectAdapter
    
    /**
    * Figure out adapter location and include it
    *
    * @access public
    * @param string $adapter_class
    * @return void
    */
    private function useAdapter($adapter_name) {
      $adapter_class = self::getAdapterClass($adapter_name);
      $path = dirname(__FILE__) . "/adapters/$adapter_class.class.php";
      if (!is_readable($path)) {
        throw new FileDnxError($path);
      } // if
      include_once $path;
    } // useAdapter
    
    /**
    * Return class based on adapter name
    *
    * @access public
    * @param string $adapter_name
    * @return string
    */
    private function getAdapterClass($adapter_name) {
      return Inflector::camelize($adapter_name) . 'DBAdapter';
    } // getAdapterClass
    
    // ---------------------------------------------------
    //  Interface to primary adapter
    // ---------------------------------------------------
    
    /**
    * Try to execute query, ignore the result
    *
    * @access public
    * @param string $sql
    * @return true
    */
    static function attempt($sql) {
      $arguments = func_get_args();
      array_shift($arguments);
      $arguments = count($arguments) ? array_flat($arguments) : null;
      try {
        self::connection()->execute($sql, $arguments);
      } catch(Exception $e) {
      }
      return true;
    } // execute

    /**
    * Execute query and return result
    *
    * @access public
    * @param string $sql
    * @return DBResult
    * @throws DBQueryError
    */
    static function execute($sql) {
      $arguments = func_get_args();
      array_shift($arguments);
      $arguments = count($arguments) ? array_flat($arguments) : null;
      
      return self::connection()->execute($sql, $arguments);
    } // execute
    
    /**
    * Execute query and return first row from result
    *
    * @access public
    * @param string $sql
    * @return array
    * @throws DBQueryError
    */
    static function executeOne($sql) {
      $arguments = func_get_args();
      array_shift($arguments);
      $arguments = count($arguments) ? array_flat($arguments) : null;
      
      return self::connection()->executeOne($sql, $arguments);
    } // executeOne
    
    /**
    * Execute query and return all rows
    *
    * @access public
    * @param string $sql
    * @return array
    * @throws DBQueryError
    */
    static function executeAll($sql) {
      $arguments = func_get_args();
      array_shift($arguments);
      $arguments = count($arguments) ? array_flat($arguments) : null;
      
      return self::connection()->executeAll($sql, $arguments);
    } // executeAll
    
    /**
    * Start transaction
    *
    * @access public
    * @param void
    * @return boolean
    * @throws DBQueryError
    */
    static function beginWork() {
      return self::connection()->beginWork();
    } // beginWork
    
    /**
    * Commit transaction
    *
    * @access public
    * @param void
    * @return boolean
    * @throws DBQueryError
    */
    static function commit() {
      return self::connection()->commit();
    } // commit
    
    /**
    * Rollback transaction
    *
    * @access public
    * @param void
    * @return boolean
    * @throws DBQueryError
    */
    static function rollback() {
      return self::connection()->rollback();
    } // rollback
    
    /**
    * Return insert ID
    *
    * @access public
    * @param void
    * @return integer
    */
    static function lastInsertId() {
      return self::connection()->lastInsertId();
    } // lastInsertId
    
    /**
    * Return number of affected rows
    *
    * @access public
    * @param void
    * @return integer
    */
    static function affectedRows() {
      return self::connection()->affectedRows();
    } // affectedRows
    
    /**
    * Escape value
    *
    * @access public
    * @param mixed $value
    * @return string
    */
    static function escape($value) {
      return self::connection()->escapeValue($value);
    } // escape
    
    /**
    * Escape field / table name
    *
    * @access public
    * @param string $field
    * @return string
    */
    static function escapeField($field) {
      return self::connection()->escapeField($field);
    } // escapeField
    
    /**
    * Prepare string. Replace every '?' with matching escaped value
    *
    * @param string $sql
    * @param array $arguments Array of arguments
    * @return string
    */
    static function prepareString($sql, $arguments = null) {
      if (is_array($arguments) && count($arguments)) {
        foreach ($arguments as $argument) {
          $sql = str_replace_first('?', DB::escape($argument), $sql);
        } // foreach
      } // if
      return $sql;
    } // prepareString
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get primary_connection
    *
    * @access public
    * @param null
    * @return string
    */
    static function getPrimaryConnection() {
      return self::$primary_connection;
    } // getPrimaryConnection
    
    /**
    * Set primary_connection value
    *
    * @access public
    * @param string $value
    * @return null
    * @throws Error if connection does not exists
    */
    static function setPrimaryConnection($value) {
      if (!isset(self::$connections[$value])) {
        throw new Error("Connection '$value' does not exists");
      } // if
      self::$primary_connection = $value;
    } // setPrimaryConnection
    
    /**
    * Add query to SQL log
    *
    * @access public
    * @param string $sql
    * @return void
    */
    function addToSQLLog($sql) {
      self::$sql_log[] = $sql;
    } // addToSQLLog
    
    /**
    * Return SQL log
    *
    * @access public
    * @param void
    * @return array
    */
    function getSQLLog() {
      return self::$sql_log;
    } // getSQLLog
  
  } // DB

?>