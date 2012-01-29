<?php

  /**
  * Data object class
  *
  * This class enables easy implementation of any object that is based
  * on a single database row. It enables reading, updating, inserting and 
  * deleting a row without writing any SQL. Also, it can check if a 
  * specific row exists in a database.
  * 
  * This class supports primary keys over multiple fields
  *
  * @package System
  * @version 1.0.1
  * @http://www.projectpier.org/
  * 
  */
  abstract class DataObject {
  
    /**
    * Indicates if this is a new object (not saved)
    *
    * @var boolean
    */
    private $is_new = true;
    
    /**
    * Indicates if this object has been deleted from database
    *
    * @var boolean
    */
    private $is_deleted = false;
    
    /**
    * Object is loaded
    *
    * @var boolean
    */
    private $is_loaded = false;
    
    /**
    * Cached column values
    *
    * @var array
    */
    private $column_values = array();
    
    /**
    * Array of modified columns (if any)
    *
    * @var array
    */
    private $modified_columns = array();
    
    /**
    * Array of updated primary key columns with cached old values (used in WHERE clausule on update or delete)
    *
    * @var array
    */
    private $updated_pks = array();
    
    /**
    * Manager object instance
    *
    * @var DataManager
    */
    protected $manager;
    
    /**
    * Array of protected attributes that can not be set through mass-assignment functions (like setFromAttributes)
    * 
    * One of the great ActiveRecord tricks
    *
    * @var array
    */
    protected $attr_protected = array('id', 'created_on', 'created_by_id', 'updated_on', 'updated_by_id');
    
    /**
    * Array of acceptable attributes (fields) that can be set through mass-assignment function (setFromAttributes)
    * 
    * One of the great ActiveRecord tricks
    *
    * @var array
    */
    protected $attr_acceptable = null;
    
    /**
    * Constructor
    *
    * @param void
    * @return null
    */
    function __construct() {
      // Empty...
    } // __construct
    
    // ----------------------------------------------------------
    //  Abstract function
    // ----------------------------------------------------------
    
    /**
    * Return object manager
    *
    * @access public
    * @param void
    * @return DataManager
    */
    abstract function manager();
    
    /**
    * Validate input data (usually collected from form). This method is called
    * before the item is saved and can be used to fetch errors in data before
    * we really save it database. $errors array is populated with errors
    *
    * @access public
    * @param array $errors
    * @return boolean
    * @throws ModelValidationError
    */
    function validate($errors) {
      return true;
    } // validate
    
    /**
    * Set object attributes / properties. This function will take hash and set 
    * value of all fields that she finds in the hash
    *
    * @access public
    * @param array $attributes
    * @return null
    */
    function setFromAttributes($attributes) {
      if (is_array($attributes)) {
        foreach ($attributes as $k => &$v) {
          if (is_array($this->attr_protected) && in_array($k, $this->attr_protected)) {
            continue; // protected attribute
          } // if
          if (is_array($this->attr_acceptable) && !in_array($k, $this->attr_acceptable)) {
            continue; // not acceptable
          } // if
          if ($this->columnExists($k)) {
            $this->setColumnValue($k, $attributes[$k]); // column exists, set
          } // if
        } // foreach
      } // if
    } // setFromAttributes
    
    /**
    * Return table name
    *
    * @access public
    * @param boolean $escape Escape table name
    * @return boolean
    */
    function getTableName($escape = false) {
      return $this->manager()->getTableName($escape);
    } // getTableName
    
    /**
    * Return array of columns
    *
    * @access public
    * @param void
    * @return array
    */
    function getColumns() {
      return $this->manager()->getColumns();
    } // getColumns
    
    /**
    * Check if specific column exists in this object
    *
    * @access public
    * @param string $column_name
    * @return boolean
    */
    function columnExists($column_name) {
      return in_array($column_name, $this->getColumns());
    } // columnExists
    
    /**
    * Return type of specific column
    *
    * @access public
    * @param string $column_name
    * @return string
    */
    function getColumnType($column_name) {
      return $this->manager()->getColumnType($column_name);
    } // getColumnType
    
    /**
    * Return name of Primary key column (or array of columns)
    *
    * @access public
    * @param void
    * @return string or array
    */
    function getPkColumns() {
      return $this->manager()->getPkColumns();
    } // getPkColumns
    
    /**
    * Check if a specific column is part of the primary key
    *
    * @access public
    * @param string $column Column that need to be checked
    * @return boolean
    */
    function isPrimaryKeyColumn($column) {
      
      // Get primary key column name or array of column names that
      // make PK here
      $pks = $this->getPkColumns();
      
      // Check...
      if (is_array($pks)) {
        return in_array($column, $pks);
      } else {
        return $column == $pks;
      } // if
      
    } // isPrimaryKeyColumn
    
    /**
    * Check if a column is a PK and if it is modified
    *
    * @access public
    * @param string $column
    * @return boolean
    */
    function isModifiedPrimaryKeyColumn($column) {
      
      // Check if we have modified column...
      if ($this->isPrimaryKeyColumn($column)) {
        return isset($this->modified_columns[$column]);
      } // if
      
      // Selected column is not PK column
      return false;
      
    } // isModifiedPrimaryKeyColumn
    
    /**
    * Return value of PK colum(s) that was initaly loaded (it will 
    * load old values of PK columns that was modified)
    *
    * @access public
    * @param void
    * @return array or mixed
    */
    function getInitialPkValue() {
      
      // Get primary key column, name...
      $pks = $this->getPkColumns();
      
      // If we have multiple PKs get values and return as array
      // else, return as scalar
      if (is_array($pks)) {
      
        // Prepare result
        $ret = array();
        
        // Loop primary keys and get values...
        foreach ($pks as $column) {
          $ret[$column] = $this->isModifiedPrimaryKeyColumn($column) ?
            $this->modified_columns[$column] :
            $this->getColumnValue($column);
        } // foreach
        
        // Return result
        return $ret;
        
      } else {
        return $this->isModifiedPrimaryKeyColumn($pks) ?
          $this->modified_columns[$pks] :
          $this->getColumnValue($pks);
      } // if
      
    } // getInitialPkValue
    
    /**
    * Return auto increment column if exists
    *
    * @access public
    * @param void
    * @return string
    */
    function getAutoIncrementColumn() {
      return $this->manager()->getAutoIncrementColumn();
    } // getAutoIncrementColumn
    
    /**
    * Return auto increment column
    *
    * @access public
    * @param string $column
    * @return boolean
    */
    function isAutoIncrementColumn($column) {
      return $this->getAutoIncrementColumn() == $column;
    } // isAutoIncrementColumn
    
    /**
    * Return lazy load columns if there are lazy load columns
    *
    * @access public
    * @param void
    * @return array
    */
    function getLazyLoadColumns() {
      return $this->manager()->getLazyLoadColumns();
    } // getLazyLoadColumns
    
    /**
    * Check if specific column is lazy load
    *
    * @access public
    * @param string $column
    * @return boolean
    */
    function isLazyLoadColumn($column) {
      $lazy_load = $this->getLazyLoadColumns();
      if (is_array($lazy_load)) {
        return in_array($column, $lazy_load);
      } // if
      return false;
    } // isLazyLoadColumn
    
    /**
    * Return value of specific column
    *
    * @access public
    * @param string $column_name
    * @param mixed $default
    * @return mixed
    */
    function getColumnValue($column_name, $default = null) {
      
      // Do we have it cached?
      if (isset($this->column_values[$column_name])) {
        return $this->column_values[$column_name];
      } // if
      
      // We don't have it cached. Exists?
      if (!$this->columnExists($column_name) && $this->isLazyLoadColumn($column_name)) {
          return $this->loadLazyLoadColumnValue($column_name, $default);
      } // if
      
      // Failed to load column or column DNX
      return $default;
      
    } // getColumnValue
    
    /**
    * Set specific field value
    *
    * @access public
    * @param string $field Field name
    * @param mixed $value New field value
    * @return boolean
    */
    function setColumnValue($column, $value) {
      
      // Field defined
      if (!$this->columnExists($column)) return false;
      
      // Get type...
      $new_value = $this->rawToPHP($value, $this->getColumnType($column));
      $old_value = $this->getColumnValue($column);
      
      // Do we have a modified value?
      if ($this->isNew() || ($old_value <> $new_value)) {
        
        // Set the value and report modification
        $this->column_values[$column] = $new_value;
        $this->addModifiedColumn($column);
        
        // Save primary key value. Also make sure that only the first PK value is
        // saved as old. Not to save second value on third modification ;)
        if ($this->isPrimaryKeyColumn($column) && !isset($this->updated_pks[$column])) {
          $this->updated_pks[$column] = $old_value;
        } // if
        
      } // if
      
      // Set!
      return true;
      
    } // setColumnValue
    
    // -------------------------------------------------------------
    //  Top level manipulation methods
    // -------------------------------------------------------------
    
    /**
    * Save object into database (insert or update)
    *
    * @access public
    * @param void
    * @return boolean
    * @throws DBQueryError
    * @throws DAOValidationError
    */
    function save() {
          trace(__FILE__, 'save():begin');
      $errors = $this->doValidate();
      
      if (is_array($errors)) {
            trace(__FILE__, 'save():errors');
          throw new DAOValidationError($this, $errors);
      } // if
      
      return $this->doSave();
    } // save

    /**
    * Copy object into database (insert or update)
    *
    * @access public
    * @param void
    * @return boolean
    * @throws DBQueryError
    * @throws DAOValidationError
    */
    function copy(&$source) {
          trace(__FILE__, 'copy():begin');
      $errors = $this->doValidate();
      
      if (is_array($errors)) {
            trace(__FILE__, 'copy():errors');
          throw new DAOValidationError($this, $errors);
      } // if
      
      return $this->doCopy($source);
    } // save

    /**
    * Delete specific object (and related objects if necessary)
    *
    * @access public
    * @param void
    * @return boolean
    * @throws DBQueryError
    */
    function delete() {
      if ($this->isNew() || $this->isDeleted()) {
        return false;
      } // if
      
      if ($this->doDelete()) {
        $this->setDeleted(true);
        $this->setLoaded(false);
        
        return true;
      } else {
        return false;
      } // if
    } // delete
    
    // -------------------------------------------------------------
    //  Loader methods
    // -------------------------------------------------------------
    
    /**
    * Load data from database row
    *
    * @access public
    * @param array $row Database row
    * @return boolean
    */
    function loadFromRow($row) {
      
      //if (isset($row['assigned_to_user_id'])) {
      //  pre_var_dump($this->columnExists('assigned_to_user_id'));
      //  pre_var_dump($row);
      //}
      
      // Check input array...
      if (is_array($row)) {
      
        // Loop fields...
        foreach ($row as $k => $v) {
          
          // If key exists set value
          if ($this->columnExists($k)) {
            $this->setColumnValue($k, $v);
          } // if
          
        } // foreach
        
        // Prepare stamps...
        $this->setLoaded(true);
        $this->notModified();
        
        // Job well done...
        return true;
        
      } // if
      
      // Error...
      return false;
      
    } // loadFromRow
    
    /**
    * Load lazy load column value
    *
    * @access private
    * @param string $column_name
    * @param mixed $default
    * @return mixed
    */
    private function loadLazyLoadColumnValue($column_name, $default = null) {
      return $default;
    } // loadLazyLoadColumnValue
    
    /**
    * Check if specific row exists in database
    *
    * @access public
    * @param mixed $value Primay key value that need to be checked
    * @return boolean
    */
    private function rowExists($value) {
      // Don't do COUNT(*) if we have one PK column
          $escaped_pk = is_array($pk_columns = $this->getPkColumns()) ? '*' : DB::escapeField($pk_columns);
      
      $sql = "SELECT count($escaped_pk) AS 'row_count' FROM " . $this->getTableName(true) . " WHERE " . $this->manager()->getConditionsById($value);
      $row = DB::executeOne($sql);
      return (boolean) array_var($row, 'row_count', false);
    } // rowExists
    
    /**
    * This function will call validate() method and handle errors
    *
    * @access public
    * @param void
    * @return array or NULL if there are no errors
    */
    private function doValidate() {
      
      // Prepare errors array and call validate() method
      $errors = array();
      $this->validate($errors);
      
      // If we have errors return them as array, else return NULL
      return count($errors) ? $errors : null;
      
    } // doValidate

    /**
    * Save data into database
    *
    * @access public
    * @param void
    * @return integer or false
    */
    private function doCopy(&$source) {
          trace(__FILE__, 'doCopy():begin');
      // Do we need to insert data or we need to save it...
      if (is_array($this->attr_acceptable)) {
        foreach ($this->attr_acceptable as $k => &$v) {
          $this->setColumnValue($v, $source->getColumnValue($v)); // column exists, set
        } // foreach
      } // if

          $this->setFromAttributes($source->attributes);
    } // doSave

    
    /**
    * Save data into database
    *
    * @access public
    * @param void
    * @return integer or false
    */
    private function doSave() {
          trace(__FILE__, 'doSave():begin');
      // Do we need to insert data or we need to save it...
          if ($this->isNew()) {
            return $this->doInsert();
      } else {
            return $this->doUpdate();
          }
    } // doSave
    
        /**
        * Insert data into database
        *
        * @access public
        * @param void
        * @return integer or false
        */
        private function doInsert() {
          trace(__FILE__, 'doInsert():begin');
          
          // Lets check if we have created_on and updated_on columns and if they are empty
          if ($this->columnExists('created_on') && !$this->isColumnModified('created_on')) {
            $this->setColumnValue('created_on', DateTimeValueLib::now());
          } // if
          if ($this->columnExists('updated_on') && !$this->isColumnModified('updated_on')) {
            $this->setColumnValue('updated_on', DateTimeValueLib::now());
          } // if
            
          if (function_exists('logged_user') && (logged_user() instanceof User)) {
            if ($this->columnExists('created_by_id') && !$this->isColumnModified('created_by_id') && (logged_user() instanceof User)) {
              $this->setColumnValue('created_by_id', logged_user()->getId());
            } // if
            if ($this->columnExists('updated_by_id') && !$this->isColumnModified('updated_by_id')) {
              $this->setColumnValue('updated_by_id', logged_user()->getId());
            } // if
          } // if
            
          // Get auto increment column name
          $autoincrement_column = $this->getAutoIncrementColumn();
          $autoincrement_column_modified = $this->columnExists($autoincrement_column) && $this->isColumnModified($autoincrement_column);
              
          // Get SQL
          $sql = $this->getInsertQuery();
          if (!DB::execute($sql)) {
            return false;
          } // if
            
          // If we have an autoincrement field load it...
          if (!$autoincrement_column_modified && $this->columnExists($autoincrement_column)) {
            $this->setColumnValue($autoincrement_column, DB::lastInsertId());
          } // if
       
          // Loaded...
          $this->setLoaded(true);
        
          // Done...
          return true;
          
        } // doInsert
      
    /**
    * Update data into database
    *
    * @access public
    * @param void
    * @return integer or false
    */
    private function doUpdate() {
      trace(__FILE__, 'doUpdate():begin');

      // Set value of updated_on column...
      if ($this->columnExists('updated_on') && !$this->isColumnModified('updated_on')) {
        $this->setColumnValue('updated_on', DateTimeValueLib::now());
      } // if

      if (function_exists('logged_user') && (logged_user() instanceof User)) {
        if ($this->columnExists('updated_by_id') && !$this->isColumnModified('updated_by_id')) {
          $this->setColumnValue('updated_by_id', logged_user()->getId());
        } // if
      } // if

      // Get update SQL
      $sql = $this->getUpdateQuery();

      // Nothing to update...
      if (is_null($sql)) {
        return true;
      } // if

      // Save...
      if (!DB::execute($sql)) {
        return false;
      } // if
      $this->setLoaded(true);

      // Done!
      return true;

    } // doUpdate
    
    /**
    * Delete object row from database
    *
    * @access public
    * @param void
    * @return boolean
    * @throws DBQueryError
    */
    private function doDelete() {
      return DB::execute("DELETE FROM " . $this->getTableName(true) . " WHERE " . $this->manager()->getConditionsById( $this->getInitialPkValue() ));
    } // doDelete
    
    /**
    * Prepare insert query
    *
    * @access private
    * @param void
    * @return string
    */
    private function getInsertQuery() {
    
      // Prepare data
      $columns = array();
      $values = array();
      
      // Loop fields
      foreach ($this->getColumns() as $column) {
        
        // If this field autoincrement?
        $auto_increment = $this->isAutoIncrementColumn($column);
        
        // If not add it...
        if (!$auto_increment || $this->isColumnModified($column)) {
          
          // Add field...
          $columns[] = DB::escapeField($column);
          $values[] = DB::escape($this->phpToRaw($this->getColumnValue($column), $this->getColumnType($column)));
          
          // Switch type...
          //switch ($this->getColumnType($column)) {
          //  case DATA_TYPE_BOOLEAN:
          //    $key_value = $this->getColumnValue($column) ? 1 : 0;
          //    break;
          //  default:
          //    $key_value = $this->getColumnValue($column);
          //} // switch

          // Add value...
          //$values[] = DB::escape($key_value);
          
        } // if
        
      } // foreach
      
      // And put it all together
      return sprintf("INSERT INTO %s (%s) VALUES (%s)", 
        $this->getTableName(true), 
        implode(', ', $columns), 
        implode(', ', $values)
      ); // sprintf
      
    } // getInsertQuery
    
    /**
    * Prepare update query
    *
    * @access private
    * @param void
    * @return string
    */
    private function getUpdateQuery() {
    
      // Prepare data...
      $columns = array();
      
      // Check number of modified fields
      if (!$this->isObjectModified()) return null;
      
      // Loop fields
      foreach ($this->getColumns() as $column) {
        
        // Is this field modified?
        if ($this->isColumnModified($column)) {
          $columns[] = sprintf('%s = %s', DB::escapeField($column), DB::escape($this->phpToRaw($this->getColumnValue($column), $this->getColumnType($column))));
        } // if
        
      } // foreach
      
      // Prepare update SQL
      return sprintf("UPDATE %s SET %s WHERE %s", $this->getTableName(true), implode(', ', $columns), $this->manager()->getConditionsById( $this->getInitialPkValue() ));
      
    } // getUpdateQuery
    
    /**
    * Return field type value
    *
    * @access private
    * @param string $field Field name
    * @return string
    */
    function getColumnValueType($field) {
      return isset($this->__fields[$field]['type']) ? $this->__fields[$field]['type'] : DATA_TYPE_NONE;
    } // getColumnValueType
    
    /**
    * Convert raw value from database to PHP value
    *
    * @access public
    * @param mixed $value
    * @param string $type
    * @return mixed
    */
    function rawToPHP($value, $type = DATA_TYPE_STRING) {
      
      // NULL!
      if (is_null($value)) {
            if ($type == DATA_TYPE_BOOLEAN) return false;
        return null;
      } // if
      
      // Switch type...
      switch ($type) {
        
        // String
        case DATA_TYPE_STRING:
          return strval($value);
        
        // Integer
        case DATA_TYPE_INTEGER:
          return intval($value);
          
        // Float
        case DATA_TYPE_FLOAT:
          return floatval($value);
          
        // Boolean
        case DATA_TYPE_BOOLEAN:
          return (boolean) $value;
          
        // Date and time
        case DATA_TYPE_DATETIME:
        case DATA_TYPE_DATE:
        case DATA_TYPE_TIME:
          if ($value instanceof DateTimeValue) {
            return $value;
          } else {
            if ($value == EMPTY_DATETIME) {
              return null;
            } // if
            return DateTimeValueLib::makeFromString($value);
          } // if
          
      } // switch
      
    } // rawToPHP
    
    /**
    * Convert PHP value to value for database
    *
    * @access public
    * @param mixed $value
    * @param string $type
    * @return string
    */
    function phpToRaw($value, $type = DATA_TYPE_STRING) {
      
      // Switch type...
      switch ($type) {
        
        // String
        case DATA_TYPE_STRING:
          return strval($value);
          
        // Integer
        case DATA_TYPE_INTEGER:
          return intval($value);
        
        // Float
        case DATA_TYPE_FLOAT:
          return floatval($value);
          
        // Boolean
        case DATA_TYPE_BOOLEAN:
          return (boolean) $value ? 1 : 0;
        
        // Date and time
        case DATA_TYPE_DATETIME:
        case DATA_TYPE_DATE:
        case DATA_TYPE_TIME:
          if (empty($value)) {
            return EMPTY_DATETIME;
          } // if
          if ($value instanceof DateTimeValue) {
            return $value->toMySQL();
          } elseif (is_numeric($value)) {
            return date(DATE_MYSQL, $value);
          } else {
            return EMPTY_DATETIME;
          } // if
          
      } // switch
      
    } // phpToRaw
    
    // ---------------------------------------------------------------
    //  Flags
    // ---------------------------------------------------------------
    
    /**
    * Return value of $is_new variable
    *
    * @access public
    * @param void
    * @return boolean
    */
    function isNew() {
      return (boolean) $this->is_new;
    } // isNew
    
    /**
    * Set new stamp value
    *
    * @access public
    * @param boolean $value New value
    * @return void
    */
    function setNew($value) {
      $this->is_new = (boolean) $value;
    } // setNew
    
    /**
    * Returns true if this object has modified columns
    *
    * @access public
    * @param void
    * @return boolean
    */
    function isModified() {
      return is_array($this->modified_columns) && (boolean) count($this->modified_columns);
    } // isModified
    
    /**
    * Return value of $is_deleted variable
    *
    * @access public
    * @param void
    * @return boolean
    */
    function isDeleted() {
      return (boolean) $this->is_deleted;
    } // isDeleted
    
    /**
    * Set deleted stamp value
    *
    * @access public
    * @param boolean $value New value
    * @return void
    */
    function setDeleted($value) {
      $this->is_deleted = (boolean) $value;
    } // setDeleted
    
    /**
    * Return value of $is_loaded variable
    *
    * @access public
    * @param void
    * @return boolean
    */
    function isLoaded() {
      return (boolean) $this->is_loaded;
    } // isLoaded
    
    /**
    * Set loaded stamp value
    *
    * @access public
    * @param boolean $value New value
    * @return void
    */
    function setLoaded($value) {
      $this->is_loaded = (boolean) $value;
      $this->setNew(!$this->is_loaded);
      //$this->is_new = !$this->is_loaded;
      //if ($this->is_loaded) $this->setNew(false);
    } // setLoaded
    
    /**
    * Check if this object is modified (one or more column value are modified)
    *
    * @access public
    * @param void
    * @return boolean
    */
    function isObjectModified() {
      return (boolean) count($this->modified_columns);
    } // isObjectModified
    
    /**
    * Check if specific column is modified
    *
    * @access public
    * @param string $column_name Column name
    * @return boolean
    */
    function isColumnModified($column_name) {
      return in_array($column_name, $this->modified_columns);
    } // isColumnModified
    
    /**
    * Report modified column
    *
    * @access public
    * @param string $column_name
    * @return null
    */
    protected function addModifiedColumn($column_name) {
      if (!in_array($column_name, $this->modified_columns)) {
        $this->modified_columns[] = $column_name;
      } // if
    } // addModifiedColumn
    
    /**
    * Returns true if PK column value is updated
    *
    * @access public
    * @param void
    * @return boolean
    */
    function isPkUpdated() {
      return count($this->updated_pks);
    } // isPkUpdated
    
    /**
    * Reset modification idicators. Usefull when you use setXXX functions
    * but you don't want to modify anything (just loading data from database
    * in fresh object using setColumnValue function)
    *
    * @access public
    * @param void
    * @return void
    */
    function notModified() {
      $this->modified_columns = array();
      $this->updated_pks = array();
    } // notModified
    
    /**
    * Returns an array of protected attributes
    *
    * @param void
    * @return array
    */
    function getProtectedAttributes() {
      return $this->attr_protected;
    } // getProtectedAttributes
    
    /**
    * Add one or multiple protected attributes
    *
    * @param void
    * @return null
    */
    function addProtectedAttribute() {
      $args = func_get_args();
      if (is_array($args)) {
        foreach ($args as $arg) {
          if (!in_array($arg, $this->attr_protected)) {
            if ($this->columnExists($arg)) {
              $this->attr_protected[] = $arg;
            } // if
          } // if
        } // foreach
      } // if
    } // addProtectedAttribute
    
    /**
    * Return an array of acceptable attributes
    *
    * @param void
    * @return array
    */
    function getAcceptableAttributes() {
      return $this->attr_acceptable;
    } // getAcceptAttributes
    
    /**
    * Add one or many acceptable attributes
    *
    * @param void
    * @return null
    */
    function addAcceptableAttribute() {
      $args = func_get_args();
      if (is_array($args)) {
        foreach ($args as $arg) {
          if (!in_array($arg, $this->attr_acceptable)) {
            if ($this->columnExists($arg)) {
              $this->attr_acceptable[] = $arg;
            } // if
          } // if
        } // foreach
      } // if
    } // addAcceptableAttribute
    
    // ---------------------------------------------------------------
    //  Validators
    // ---------------------------------------------------------------
    
    /**
    * Validates presence of specific field. Presence of value is determined 
    * by the empty function
    *
    * @access public
    * @param string $field Field name
    * @param boolean $trim_string If value is string trim it before checks to avoid
    *   returning true for strings like ' '.
    * @return boolean
    */
    function validatePresenceOf($field, $trim_string = true) {
      $value = $this->getColumnValue($field);
      if (is_string($value) && $trim_string) {
        $value = trim($value);
      } // if
      return !empty($value);
    } // validatePresenceOf
    
    /**
    * This validator will return true if $value is unique (there is no row with such value in that field)
    *
    * @access public
    * @param string $field Filed name
    * @param mixed $value Value that need to be checked
    * @return boolean
    */
    function validateUniquenessOf() {
      // Don't do COUNT(*) if we have one PK column
          $escaped_pk = is_array($pk_columns = $this->getPkColumns()) ? '*' : DB::escapeField($pk_columns);
      
      // Get columns
      $columns = func_get_args();
      if (!is_array($columns) || count($columns) < 1) {
        return true;
      } // if
      
      // Check if we have existsing columns
      foreach ($columns as $column) {
        if (!$this->columnExists($column)) {
          return false;
        } // if
      } // foreach
      
      // Get where parets
      $where_parts = array();
      foreach ($columns as $column) {
        $where_parts[] = DB::escapeField($column) . ' = ' . DB::escape($this->getColumnValue($column));
      } // if
      
      // If we have new object we need to test if there is any other object
      // with this value. Else we need to check if there is any other EXCEPT
      // this one with that value
      if ($this->isNew()) {
        $sql = sprintf("SELECT COUNT($escaped_pk) AS 'row_count' FROM %s WHERE %s", $this->getTableName(true), implode(' AND ', $where_parts));
      } else {
        
        // Prepare PKs part...
        $pks = $this->getPkColumns();
        $pk_values = array();
        if (is_array($pks)) {
          foreach ($pks as $pk) {
            $pk_values[] = sprintf('%s <> %s', DB::escapeField($pk), DB::escape($this->getColumnValue($pk)));
          } // foreach
        } else {
          $pk_values[] = sprintf('%s <> %s', DB::escapeField($pks), DB::escape($this->getColumnValue($pks)));
        } // if

        // Prepare SQL
        $sql = sprintf("SELECT COUNT($escaped_pk) AS 'row_count' FROM %s WHERE (%s) AND (%s)", $this->getTableName(true), implode(' AND ', $where_parts), implode(' AND ', $pk_values));
        
      } // if
      
      $row = DB::executeOne($sql);
      return array_var($row, 'row_count', 0) < 1;
    } // validateUniquenessOf
    
    /**
    * Validate max value of specific field. If that field is string time 
    * max lenght will be validated
    *
    * @access public
    * @param string $column
    * @param integer $max Maximal value
    * @return null
    */
    function validateMaxValueOf($column, $max) {
      
      // Field does not exists
      if (!$this->columnExists($column)) {
        return false;
      } // if
      
      // Get value...
      $value = $this->getColumnValue($column);
      
      // Integer and float...
      if (is_int($value) || is_float($column)) {
        return $column <= $max;
        
      // String...
      } elseif (is_string($value)) {
        return strlen($value) <= $max;
        
      // Any other value...
      } else {
        return $column <= $max;
      } // if
      
    } // validateMaxValueOf
    
    /**
    * Valicate minimal value of specific field. If string minimal lenght is checked
    *
    * @access public
    * @param string $column
    * @param integer $min Minimal value
    * @return boolean
    */
    function validateMinValueOf($column, $min) {
      
      // Field does not exists
      if (!$this->columnExists($column)) {
        return false;
      } // if
      
      // Get value...
      $value = $this->getColumnValue($column);
      
      // Integer and float...
      if (is_int($value) || is_float($value)) {
        return $column >= $min;
        
      // String...
      } elseif (is_string($value)) {
        return strlen($value) >= $min;
        
      // Any other value...
      } else {
        return $column >= $min;
      } // if
      
    } // validateMinValueOf
    
    /**
    * This function will validate format of specified columns value
    *
    * @access public
    * @param string $column Column name
    * @param string $pattern
    * @return boolean
    */
    function validateFormatOf($column, $pattern) {
      if (!$this->columnExists($column)) {
        return false;
      } // if
      $value = $this->getColumnValue($column);
      return preg_match($pattern, $value);
    } // validateFormatOf

    // -----------------------------------------------------
    //  Magic access method
    //  NB: this replaces the need for other setters/getters
    // -----------------------------------------------------
    function __call($method, $args) {
      if( preg_match('/(set|get)(.*)/', $method, $matches) ) {
        // to get the column name translate every capital 
        // into an underscore followed by lowercase of the capital
        $column = strtolower(preg_replace('/(?!^[A-Z])([A-Z])/', '_${0}', $matches[2]));
        if (!$this->columnExists($column)) {
          throw new Exception('Call to undefined method DataObject::'.$method.'() or column '.$column);
        }
        if($matches[1] == "get") {
          return $this->getColumnValue($column);
        }
        if($matches[1] == "set" && count($args)) {
          return $this->setColumnValue($column, $args[0]);
        }
      }
      // me no understand!
      throw new Exception('Call to undefined method DataObject::'.$method.'()');
      return false;
    }
    
  } // end class DataObject

?>