<?php

  /**
  * Abstract database adapter
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  abstract class AbstractDBAdapter {
    
    /**
    * Connection resource
    *
    * @var resource
    */
    protected $link;
    
    /**
    * Array of params used fro this connection
    *
    * @var array
    */
    protected $connection_params;
    
    /**
    * Name of the database we are connected on
    *
    * @var string
    */
    protected $database_name;
    
    /**
    * Construct adpater and connect
    *
    * @access public
    * @param array $params Connection params
    * @return AbstractDBAdapter
    */
    function __construct($params) {
      $this->connect($params);
    } // __construct
    
    // ---------------------------------------------------
    //  Abstract methods
    // ---------------------------------------------------
  
    /**
    * Connect to the database based on the params array
    *
    * @access protected
    * @param array $params
    * @return null
    * @throws DBConnectError
    */
    abstract protected function connect($params);
    
    /**
    * Basic query execution
    *
    * @access protected
    * @param string $sql
    * @return mixed
    */
    abstract protected function executeQuery($sql);
    
    /**
    * Get begin work SQL (start transaction)
    *
    * @access public
    * @param void
    * @return string
    */
    abstract function getBeginWorkCommand();
    
    /**
    * Get comming SQL
    *
    * @access public
    * @param void
    * @return string
    */
    abstract function getCommitCommand();
    
    /**
    * Get rollback SQL
    *
    * @access public
    * @param void
    * @return string
    */
    abstract function getRollbackCommand();
    
    /**
    * Return number of affected rows
    *
    * @access public
    * @param void
    * @return integer
    */
    abstract function affectedRows();
    
    /**
    * Return last insert ID
    *
    * @access public
    * @param void
    * @return integer
    */
    abstract function lastInsertId();
    
    /**
    * Returns last error message that server thrown
    *
    * @access public
    * @param void
    * @return string
    */
    abstract function lastError();
    
    /**
    * Returns code of the last error
    *
    * @access public
    * @param void
    * @return integer
    */
    abstract function lastErrorCode();
    
    /**
    * Return array of tables that exists in database
    *
    * @access public
    * @param void
    * @return array
    */
    abstract function listTables();
    
    /**
    * Drop one or more tables. If $table_names is string only that table will be droped, else script will drop
    *
    * @access public
    * @param mixed $table_names Array of table names or single table name
    * @return boolean
    */
    abstract function dropTables($table_names);
    
    /**
    * Remove all data from specific tables
    *
    * @access public
    * @param mixed $table_names Single table name or array of table names
    * @return boolean
    */
    abstract function emptyTables($table_names);
    
    /**
    * This function will return array of table names and their CREATE TABLE commands
    *
    * @access public
    * @param void
    * @return array or NULL if there are no tables in database
    */
    abstract function exportDatabaseStructure();
    
    /**
    * This function is able to import database construction from any connected adapter
    *
    * @access public
    * @param AbstractDBAdapter $adapter
    * @param boolean $clear Clean up database before import
    * @return boolean
    */
    abstract function importDatabaseStructure(AbstractDBAdapter $adapter, $clear = false);
    
    /**
    * Return CREATE TABLE sql for specific table
    *
    * @access public
    * @param string $table_name
    * @return string or NULL if table does not exists
    */
    abstract function exportTableStructure($table_name);
    
    /**
    * Escape name of table field or name of the table
    *
    * @access public
    * @param string $field
    * @return string
    */
    abstract function escapeField($field);
    
    /**
    * Escape value before use it in query. This function makes difference between NULL, scalar
    * and DateTime values
    *
    * @access public
    * @param mixed $unescaped Value that need to be escaped
    * @return string
    */
    abstract function escapeValue($unescaped);
    
    /**
    * Fetch row from query result
    *
    * @access public
    * @param resource $resource
    * @return array
    */
    abstract function fetchRow($resource);
    
    /**
    * Return number of rows in specific query result
    *
    * @access public
    * @param resource $resource
    * @return integer
    */
    abstract function numRows($resource);
    
    /**
    * Free database result
    *
    * @access public
    * @param resource $resource
    * @return boolean
    */
    abstract function freeResult($resource);
    
    // ---------------------------------------------------
    //  Commong methods
    // ---------------------------------------------------
    
    /**
    * Reconnect
    *
    * @access public
    * @param void
    * @return null
    */
    function reconnect() {
      unset($this->link);
      unset($this->database_name);
      $this->connect($this->getParams());
    } // reconnect
    
    /**
    * Execute sql
    *
    * @access public
    * @param string $sql
    * @param array $arguments
    * @return DBResult
    * @throws DBQueryError
    */
    function execute($sql, $arguments = null) {
      return $this->prepareAndExecute($sql, $arguments);
    } // execute
    
    /**
    * Execute query and return first row. If there is no first row NULL is returned
    *
    * @access public
    * @param string $sql
    * @param array $arguments
    * @return array
    * @throws DBQueryError
    */
    function executeOne($sql, $arguments = null) {
      $result = $this->prepareAndExecute($sql, $arguments);
      if ($result instanceof DBResult) {
        $first = $result->fetchRow();
        $result->free();
        return $first ? $first : null;
      } // if
      return null;
    } // executeOne
    
    /**
    * Execute SQL and return all rows. If there is no rows NULL is returned
    *
    * @access public
    * @param string $sql
    * @param array $arguments
    * @return array
    * @throws DBQueryError
    */
    function executeAll($sql, $arguments = null) {
      $result = $this->prepareAndExecute($sql, $arguments);
      if ($result instanceof DBResult) {
        $all = $result->fetchAll();
        $result->free();
        return $all ? $all : null;
      } // if
      return null;
    } // executeAll
    
    /**
    * Start transaction
    *
    * @access public
    * @param void
    * @return boolean
    * @throws DBQueryError
    */
    function beginWork() {
      return $this->execute($this->getBeginWorkCommand());
    } // beginWork
    
    /**
    * Commit transaction
    *
    * @access public
    * @param void
    * @return boolean
    * @throws DBQueryError
    */
    function commit() {
      return $this->execute($this->getCommitCommand());
    } // commit
    
    /**
    * Rollback transaction
    *
    * @access public
    * @param void
    * @return boolean
    * @throws DBQueryError
    */
    function rollback() {
      return $this->execute($this->getRollbackCommand());
    } // rollback
    
    /**
    * This function will drop all tables from database this adapter is connected on
    *
    * @access public
    * @param void
    * @return boolean
    */
    function clearDatabase() {
      return $this->dropTables($this->listTables());
    } // clearDatabase
    
    /**
    * This function will remove all data from database keeping the structure intact
    *
    * @access public
    * @param void
    * @return boolean
    */
    function emptyDatabase() {
      return $this->emptyTables($this->listTables());
    } // emptyDatabase
    
    /**
    * Prepare SQL and execute it...
    *
    * @access protected
    * @param string $sql
    * @return DBResult
    * @throws DBQueryError
    */
    protected function prepareAndExecute($sql, $arguments = null) {
      if (is_array($arguments)) {
        $sql = DB::prepareString($sql, $arguments);
      } // if
      
      $query_result = $this->executeQuery($sql, $this->link);
      DB::addToSQLLog($sql);
      
      if ($query_result === false) {
        throw new DBQueryError($sql, $this->lastErrorCode(), $this->lastError());
      } // if
      return $query_result === true ? true : new DBResult($this, $query_result);
      
    } // prepareAndExecute
    
    /**
    * Returns true if this adapter is connected to the database
    *
    * @access public
    * @param void
    * @return boolean
    */
    function isConnected() {
      return is_resource($this->link);
    } // isConnected
    
    /**
    * Return link
    *
    * @param void
    * @return resource
    */
    function getLink() {
      return $this->link;
    } // getLink
    
    /**
    * Set connection link
    *
    * @access public
    * @param resource $link
    * @return null
    */
    protected function setLink($link) {
      if (is_resource($link)) {
        $this->link = $link;
      } // if
    } // setLink
    
    /**
    * Get params
    *
    * @access public
    * @param null
    * @return array
    */
    function getParams() {
      return $this->params;
    } // getParams
    
    /**
    * Set params value
    *
    * @access public
    * @param array $value
    * @return null
    */
    function setParams($value) {
      $this->params = $value;
    } // setParams
    
    /**
    * Get database_name
    *
    * @access public
    * @param null
    * @return string
    */
    function getDatabaseName() {
      return $this->database_name;
    } // getDatabaseName
    
    /**
    * Set database_name value
    *
    * @access protected
    * @param string $value
    * @return null
    */
    protected function setDatabaseName($value) {
      $this->database_name = $value;
    } // setDatabaseName
  
  } // AbstractDBAdapter

?>