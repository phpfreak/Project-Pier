<?php
  
  /**
  * Data manager class
  *
  * This class implements methods for managing data objects, database rows etc. One 
  * of its features is automatic caching of loaded data.
  *
  * @package System
  * @version 1.0
  * @http://www.projectpier.org/
  * 
  */
  abstract class DataManager {
  
    /**
    * Database table where items are saved
    *
    * @var string
    */
    private $table_name;
    
    /**
    * Item cache array
    *
    * @var array
    */
    private $cache = array();
    
    /**
    * Class of items that this manager is handling
    *
    * @var string
    */
    private $item_class = '';
    
    /**
    * Cache items
    *
    * @var boolean
    */
    private $caching = true;
    
    /**
    * Construct and set item class
    *
    * @access public
    * @param string $item_class Value of class of items that this manager is handling
    * @param string $table Table where data is stored
    * @param boolean $caching Caching stamp value
    * @return DataManager
    */
    function __construct($item_class, $table_name, $caching = true) {
      $this->setItemClass($item_class);
      $this->setTableName($table_name);
      $this->setCaching($caching);
    } // end func __construct
    
    // ---------------------------------------------------
    //  Definition methods
    // ---------------------------------------------------
    
    /**
    * Return array of object columns
    *
    * @access public
    * @param void
    * @return array
    */
    abstract function getColumns();
    
    /**
    * Return column type
    *
    * @access public
    * @param string $column_name
    * @return string
    */
    abstract function getColumnType($column_name);
    
    /**
    * Return array of PK columns. If only one column is PK returns its name as string
    *
    * @access public
    * @param void
    * @return array or string
    */
    abstract function getPkColumns();
    
    /**
    * Return name of first auto_incremenent column if it exists
    *
    * @access public
    * @param void
    * @return string
    */
    abstract function getAutoIncrementColumn();
    
    /**
    * Return array of lazy load columns
    *
    * @access public
    * @param void
    * @return array
    */
    function getLazyLoadColumns() {
      return array();
    } // getLazyLoadColumnss
    
    /**
    * Check if specific column is lazy load column
    *
    * @access public
    * @param string $column_name
    * @return boolean
    */
    function isLazyLoadColumn($column_name) {
      return in_array($column_name, $this->getLazyLoadColumns());
    } // isLazyLoadColumn
    
    /**
    * Return all columns that are not martked as lazy load
    *
    * @access public
    * @param boolean $escape_column_names
    * @return array
    */
    function getLoadColumns($escape_column_names = false) {
      
      // Prepare
      $load_columns = array();
      
      // Loop...
      foreach ($this->getColumns() as $column) {
        if (!$this->isLazyLoadColumn($column)) {
          $load_columns[] = $escape_column_names ? DB::escapeField($column) : $column;
        } // if
      } // foreach
      
      // Done...
      return $load_columns;
      
    } // getLoadColumns
    
    // ---------------------------------------------------
    //  Finders
    // ---------------------------------------------------
    
    /**
    * Do a SELECT query over database with specified arguments
    *
    * @access public
    * @param array $arguments Array of query arguments. Fields:
    * 
    *  - one - select first row
    *  - conditions - additional conditions
    *  - order - order by string
    *  - offset - limit offset, valid only if limit is present
    *  - limit
    * 
    * @return one or many objects
    * @throws DBQueryError
    */
    function find($arguments = null) {
      trace(__FILE__,'find():begin');
      
      // Collect attributes...
      $one        = (boolean) array_var($arguments, 'one', false);
      $conditions = $this->prepareConditions( array_var($arguments, 'conditions', '') );
      $order_by   = array_var($arguments, 'order', '');
      $offset     = (integer) array_var($arguments, 'offset', 0);
      $limit      = (integer) array_var($arguments, 'limit', 0);
      
      // Prepare query parts
      $where_string = trim($conditions) == '' ? '' : "WHERE $conditions";
      $order_by_string = trim($order_by) == '' ? '' : "ORDER BY $order_by";
      $limit_string = $limit > 0 ? "LIMIT $offset, $limit" : '';
      
      // Prepare SQL
      $sql = "SELECT * FROM " . $this->getTableName(true) . " $where_string $order_by_string $limit_string";
      trace(__FILE__,'find():'.$sql);
      
      // Run!
      $rows = DB::executeAll($sql);
      
      // Empty?
      if (!is_array($rows) || (count($rows) < 1)) {
        trace(__FILE__,'find():found 0');
        return null;
      } // if
      
      // If we have one load it, else loop and load many
      if ($one) {
        trace(__FILE__,'find():found 1');
        return $this->loadFromRow($rows[0]);
      } else {
        trace(__FILE__,'find():found '.count($rows));
        $objects = array();
        foreach ($rows as $row) {
          $object = $this->loadFromRow($row);
          if (instance_of($object, $this->getItemClass())) {
            $objects[] = $object;
          } // if
        } // foreach
        return count($objects) ? $objects : null;
      } // if
      trace(__FILE__,'find():end (impossible)');
    } // find
    
    /**
    * Find all records
    *
    * @access public
    * @param array $arguments
    * @return array
    */
    function findAll($arguments = null) {
      trace(__FILE__,'findAll()');
      if (!is_array($arguments)) {
        $arguments = array();
      } // if
      $arguments['one'] = false;
      return $this->find($arguments);
    } // findAll
    
    /**
    * Find one specific record
    *
    * @access public
    * @param array $arguments
    * @return array
    */
    function findOne($arguments = null) {
      trace(__FILE__,'findOne()');
      if (!is_array($arguments)) {
        $arguments = array();
      } // if
      $arguments['one'] = true;
      return $this->find($arguments);
    } // findOne
    
    /**
    * Return object by its PK value
    *
    * @access public
    * @param mixed $id
    * @param boolean $force_reload If value of this variable is true cached value
    *   will be skipped and new data will be loaded from database
    * @return object
    */
    function findById($id, $force_reload = false) {
      trace(__FILE__,"findById($id, $force_reload)");
      return $this->load($id, $force_reload);
    } // findById
    
    /**
    * Return number of rows in this table
    *
    * @access public
    * @param string $conditions Query conditions
    * @return integer
    */
    function count($conditions = null) {
      // Don't do COUNT(*) if we have one PK column
      $escaped_pk = is_array($pk_columns = $this->getPkColumns()) ? '*' : DB::escapeField($pk_columns);
      
      $conditions = $this->prepareConditions($conditions);
      $where_string = trim($conditions) == '' ? '' : "WHERE $conditions";
      $row = DB::executeOne("SELECT COUNT($escaped_pk) AS 'row_count' FROM " . $this->getTableName(true) . " $where_string");
      return (integer) array_var($row, 'row_count', 0);
    } // count
    
    /**
    * Delete rows from this table that match specific conditions
    *
    * @access public
    * @param string $conditions Query conditions
    * @return boolean
    */
    function delete($conditions = null) {
      trace(__FILE__,"delete($conditions)");
      $conditions = $this->prepareConditions($conditions);
      $where_string = trim($conditions) == '' ? '' : "WHERE $conditions";
      $sql = "DELETE FROM " . $this->getTableName(true) . " $where_string";
      trace(__FILE__,"delete($conditions) sql=".$sql);
      return DB::execute($sql);
    } // delete
    
    /**
    * This function will return paginated result. Result is array where first element is 
    * array of returned object and second populated pagination object that can be used for 
    * obtaining and rendering pagination data using various helpers.
    * 
    * Items and pagination array vars are indexed with 0 for items and 1 for pagination
    * because you can't use associative indexing with list() construct
    *
    * @access public
    * @param array $arguments Query argumens (@see find()) Limit and offset are ignored!
    * @param integer $items_per_page Number of items per page
    * @param integer $current_page Current page number
    * @return array
    */
    function paginate($arguments = null, $items_per_page = 10, $current_page = 1) {
      if (!is_array($arguments)) {
        $arguments = array();
      } // if
      $conditions = array_var($arguments, 'conditions');
      $pagination = new DataPagination($this->count($conditions), $items_per_page, $current_page);
      
      $arguments['offset'] = $pagination->getLimitStart();
      $arguments['limit'] = $pagination->getItemsPerPage();
      
      $items = $this->findAll($arguments);
      return array($items, $pagination);
    } // paginate
    
    /**
    * Get conditions as argument and return them in the string (if array walk through and escape values)
    *
    * @param mixed $conditions
    * @return string
    */
    function prepareConditions($conditions) {
      if (is_array($conditions)) {
        $conditions_sql = array_shift($conditions);
        $conditions_arguments = count($conditions) ? $conditions : null;
        return DB::prepareString($conditions_sql, $conditions_arguments);
      } // if
      return $conditions;
    } // prepareConditions
    
    /**
    * Load specific item. If we can't load data return NULL, else return item object
    *
    * @access public
    * @param mixed $id Item ID
    * @param boolean $force_reload If this value is true cached value (if set) will be skipped
    *   and object data will be loaded from database
    * @return DataObject
    */
    function load($id, $force_reload = false) {
      trace(__FILE__,"load($id, $force_reload)");    
      // Is manager ready to do the job?
      if (!$this->isReady()) {
        return null;
      } // if

      trace(__FILE__,"cache check");    
      // If caching and we dont need to reload check the cache...
      if (!$force_reload && $this->getCaching()) {
        $item = $this->getCachedItem($id);
        if (instance_of($item, $this->getItemClass())) {
          return $item;
        } // if
      } // if
      
      trace(__FILE__,"get object from row");    
      // Get object from row...
      $object = $this->loadFromRow($this->loadRow($id));
      
      trace(__FILE__,"check item");    
      // Check item...
      if (!instance_of($object, $this->getItemClass())) {
        trace(__FILE__,"item not ".$this->getItemClass());    
        return null;
      } // if
      
      // If loaded cache and return...
      if ($object->isLoaded()) {
        if ($this->getCaching()) {
          $this->cacheItem($object);
        } // if
        return $object;
      } // if
      
      trace(__FILE__,"item not loaded");    
      // Item not loaded...
      return null;
      
    } // end func load
    
    /**
    * Load row from database based on ID
    *
    * @access public
    * @param mixed $id
    * @return array
    */
    function loadRow($id) {
      trace(__FILE__,"loadRow($id)");   
      $sql = sprintf("SELECT %s FROM %s WHERE %s", 
        implode(', ', $this->getLoadColumns(true)), 
        $this->getTableName(true), 
        $this->getConditionsById($id)
      ); // sprintf
      trace(__FILE__,"loadRow($id) sql=$sql");   
      
      return DB::executeOne($sql);
    } // loadRow
    
    /**
    * Load item from database row
    *
    * @access public
    * @param array $row Row from witch we need to load data...
    * @return DataObject
    */
    function loadFromRow($row) {
      trace(__FILE__,"loadFromRow(row):begin");   
    
      // Is manager ready?
      if (!$this->isReady()) {
        return null;
      } // if
      
      // OK, get class and construct item...
      $class = $this->getItemClass();
      $item = new $class();
      
      // If not valid item break
      if (!instance_of($item, 'DataObject')) {
        return null;
      } // if
      
      // Load item...
      if ($item->loadFromRow($row) && $item->isLoaded()) {
        if ($this->getCaching()) {
          $this->cacheItem($item);
        } // if
        return $item;
      } // if
      
      // Item not loaded, from some reason
      return null;
      
    } // end func loadFromRow
    
    /**
    * Return condition part of query by value(s) of PK column(s)
    *
    * @access public
    * @param array or string $id
    * @return string
    */
    function getConditionsById($id) {
      
      // Prepare data...
  	  $pks = $this->getPkColumns();
  	  
  	  // Multiple PKs?
  	  if (is_array($pks)) {
  	  	
  	  	// Ok, prepare it...
  	  	$where = array();
  	  	
  	  	// Loop PKs
  	  	foreach ($pks as $column) {
  	  	  if (isset($id[$column])) {
  	  	    $where[] = sprintf('%s = %s', DB::escapeField($column), DB::escape($id[$column]));
  	  	  } // if
  	  	} // foreach
  	  	
  	  	// Join...
  	  	if (is_array($where) && count($where)) {
  	  	  return count($where) > 1 ? implode(' AND ', $where) : $where[0];
  	  	} else {
  	  	  return '';
  	  	} // if
  	  	
  	  } else {
  	    return sprintf('%s = %s', DB::escapeField($pks), DB::escape($id));
  	  } // if
  	  
    } // getConditionsById
    
    // ----------------------------------------------------
    //  Caching
    // ----------------------------------------------------
    
    /**
    * Get specific item from cache
    *
    * @access public
    * @param mixed $id Item ID
    * @return DataObject
    */
    function getCachedItem($id) {
    
      // Multicolumn PK
      if (is_array($id)) {
        
        // Lock first cache level
        $array = $this->cache;
        
        // Loop IDs until we reach the end
        foreach ($id as $id_field) {
          if (is_array($array) && isset($array[$id_field])) {
            $array = $array[$id_field];
          } // if
        } // if
        
        // If we have valid instance return it
        if (instance_of($array, 'DataObject')) {
          return $array;
        } // if
        
      } else {
      
        // If we have it in cache return it...
        if (isset($this->cache[$id]) && instance_of($this->cache[$id], $this->getItemClass())) {
          return $this->cache[$id];
        } // if
        
      } // if
      
      // Item not cache...
      return null;
      
    } // end func getCacheItem
    
    /**
    * Add this item to cache
    *
    * @access public
    * @param DataObject $item Item that need to be cached
    * @return boolean
    */
    function cacheItem($item) {
      
      // Check item instance...
      if (!instance_of($item, 'DataObject') || !$item->isLoaded()) {
        return false;
      } // if
      
      // Get PK column(s)
      $id = $item->getPkColumns();
      
      // If array them we have item with multiple items...
      if (is_array($id)) {
        
        // First level is cahce
        $array = $this->cache;
        
        // Set counter
        $iteration = 0;
        
        // Loop fields
        foreach ($id as $id_field) {
          
          // Value of this field...
          $field_value = $item->getColumnValue($id_field);
          
          // Increment counter
          $iteration++;
          
          // Last field? Cache object here
          if ($iteration == count($id)) {
            $array[$field_value] = $item;
          
          // Prepare for next iteration and continue...
          } else {
            if (!isset($array[$field_value]) || !is_array($array[$field_value])) {
              $array[$field_value] = array();
            } // if
            $array =& $array[$field_value];
          } // if
          
        } // foreach
        
      } else {
        $this->cache[$item->getColumnValue($id)] = $item;
      } // if
      
      // Done...
      return true;
      
    } // end func setCacheItem
    
    /**
    * Clear the item cache
    *
    * @access public
    * @param void
    * @return void
    */
    function clearCache() {
      $this->cache = array();
    } // end func clearCache
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get the value of item class
    *
    * @access public
    * @param void
    * @return string
    */
    function getItemClass() {
      return $this->item_class;
    } // end func getItemClass
    
    /**
    * Set value of item class. This function will set the value only when item class is
    * defined, else it will return FALSE.
    *
    * @access public
    * @param string $value New item class value
    * @return null
    */
    function setItemClass($value) {
      $this->item_class = trim($value);
    } // end func setItemClass
    
    /**
    * Return table name. Options include adding table prefix in front of table name (true by 
    * default) and escaping resulting name, usefull for using in queries (false by default)
    *
    * @access public
    * @param boolean $escape Return escaped table name
    * @param boolean $with_prefix Include table prefix. This functionality is added when
    *   installer was built so user can set custom table prefix, not default 'pm_'
    * @return string
    */
    function getTableName($escape = false, $with_prefix = true) {
      $table_name = $with_prefix ? TABLE_PREFIX . $this->table_name : $this->table_name;
      return $escape ? DB::escapeField($table_name) : $table_name;
    } // end func getTableName
    
    /**
    * Set items table
    *
    * @access public
    * @param string $value Table name
    * @return void
    */
    function setTableName($value) {
      $this->table_name = trim($value);
    } // end func setTableName
    
    /**
    * Return value of caching stamp
    *
    * @access public
    * @param void
    * @return boolean
    */
    function getCaching() {
      return (boolean) $this->caching;
    } // end func getCaching
    
    /**
    * Set value of caching property
    *
    * @access public
    * @param boolean $value New caching value
    * @return void
    */
    function setCaching($value) {
      $this->caching = (boolean) $value;
    } // end func setCaching
    
    /**
    * Check if manager is ready to do the job
    *
    * @access private
    * @param void
    * @return boolean
    */
    function isReady() {
      trace(__FILE__,'isReady() = class_exists '.$this->item_class);    
      return class_exists($this->item_class);
    } // end func isReady

    /**
    * Get object type name of objects managed by this manager
    *
    * @access public
    * @param void
    * @return string
    */
    function getObjectTypeName() {
      return $this->getItemClass()->getObjectTypeName();
    } // getObjectTypeName
    
    /**
    * Define an action to take when an undefined method is called.
    *
    * @param name The name of the method that is undefined.
    * @param args Arguments passed to the undefined method.
    * @return throws UndefinedMethodException
    */
  function __call($name, $args) {
	  throw new UndefinedMethodException('Call to undefined method DataManager::'.$name.'()',$name,$args);
  }

  } // end func DataManager

?>