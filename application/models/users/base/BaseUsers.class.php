<?php 

  
  /**
  * Users class
  *
  * @http://www.projectpier.org/
  */
  abstract class BaseUsers extends DataManager {
  
    /**
    * Column name => Column type map
    *
    * @var array
    * @static
    */
    static private $columns = array(
      'id' => DATA_TYPE_INTEGER, 
      'username' => DATA_TYPE_STRING, 
      'email' => DATA_TYPE_STRING, 
      'token' => DATA_TYPE_STRING, 
      'salt' => DATA_TYPE_STRING, 
      'twister' => DATA_TYPE_STRING, 
      'created_on' => DATA_TYPE_DATETIME, 
      'created_by_id' => DATA_TYPE_INTEGER, 
      'updated_on' => DATA_TYPE_DATETIME, 
      'updated_by_id' => DATA_TYPE_INTEGER, 
      'last_login' => DATA_TYPE_DATETIME, 
      'last_visit' => DATA_TYPE_DATETIME, 
      'last_activity' => DATA_TYPE_DATETIME, 
      'is_admin' => DATA_TYPE_BOOLEAN, 
      'auto_assign' => DATA_TYPE_BOOLEAN, 
      'use_LDAP' => DATA_TYPE_BOOLEAN,
    );
  
    /**
    * Construct
    *
    * @return BaseUsers 
    */
    function __construct() {
      parent::__construct('User', 'users', true);
    } // __construct
    
    // -------------------------------------------------------
    //  Description methods
    // -------------------------------------------------------
    
    /**
    * Return array of object columns
    *
    * @access public
    * @param void
    * @return array
    */
    function getColumns() {
      return array_keys(self::$columns);
    } // getColumns
    
    /**
    * Return column type
    *
    * @access public
    * @param string $column_name
    * @return string
    */
    function getColumnType($column_name) {
      if (isset(self::$columns[$column_name])) {
        return self::$columns[$column_name];
      } else {
        return DATA_TYPE_STRING;
      } // if
    } // getColumnType
    
    /**
    * Return array of PK columns. If only one column is PK returns its name as string
    *
    * @access public
    * @param void
    * @return array or string
    */
    function getPkColumns() {
      return 'id';
    } // getPkColumns
    
    /**
    * Return name of first auto_incremenent column if it exists
    *
    * @access public
    * @param void
    * @return string
    */
    function getAutoIncrementColumn() {
      return 'id';
    } // getAutoIncrementColumn
    
    // -------------------------------------------------------
    //  Finders
    // -------------------------------------------------------
    
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
    * @return one or Users objects
    * @throws DBQueryError
    */
    function find($arguments = null) {
      if (isset($this) && instance_of($this, 'Users')) {
        return parent::find($arguments);
      } else {
        return Users::instance()->find($arguments);
        //$instance =& Users::instance();
        //return $instance->find($arguments);
      } // if
    } // find
    
    /**
    * Find all records
    *
    * @access public
    * @param array $arguments
    * @return one or Users objects
    */
    function findAll($arguments = null) {
      if (isset($this) && instance_of($this, 'Users')) {
        return parent::findAll($arguments);
      } else {
        return Users::instance()->findAll($arguments);
        //$instance =& Users::instance();
        //return $instance->findAll($arguments);
      } // if
    } // findAll
    
    /**
    * Find one specific record
    *
    * @access public
    * @param array $arguments
    * @return User 
    */
    function findOne($arguments = null) {
      if (isset($this) && instance_of($this, 'Users')) {
        return parent::findOne($arguments);
      } else {
        return Users::instance()->findOne($arguments);
        //$instance =& Users::instance();
        //return $instance->findOne($arguments);
      } // if
    } // findOne
    
    /**
    * Return object by its PK value
    *
    * @access public
    * @param mixed $id
    * @param boolean $force_reload If true cache will be skipped and data will be loaded from database
    * @return User 
    */
    function findById($id, $force_reload = false) {
      trace(__FILE__,"findById($id, $force_reload)");
      if (isset($this) && instance_of($this, 'Users')) {
        return parent::findById($id, $force_reload);
      } else {
        return Users::instance()->findById($id, $force_reload);
        //$instance =& Users::instance();
        //return $instance->findById($id, $force_reload);
      } // if
    } // findById
    
    /**
    * Return number of rows in this table
    *
    * @access public
    * @param string $conditions Query conditions
    * @return integer
    */
    function count($condition = null) {
      if (isset($this) && instance_of($this, 'Users')) {
        return parent::count($condition);
      } else {
        return Users::instance()->count($condition);
        //$instance =& Users::instance();
        //return $instance->count($condition);
      } // if
    } // count
    
    /**
    * Delete rows that match specific conditions. If $conditions is NULL all rows from table will be deleted
    *
    * @access public
    * @param string $conditions Query conditions
    * @return boolean
    */
    function delete($condition = null) {
      if (isset($this) && instance_of($this, 'Users')) {
        return parent::delete($condition);
      } else {
        return Users::instance()->delete($condition);
        //$instance =& Users::instance();
        //return $instance->delete($condition);
      } // if
    } // delete
    
    /**
    * This function will return paginated result. Result is an array where first element is 
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
      if (isset($this) && instance_of($this, 'Users')) {
        return parent::paginate($arguments, $items_per_page, $current_page);
      } else {
        return Users::instance()->paginate($arguments, $items_per_page, $current_page);
        //$instance =& Users::instance();
        //return $instance->paginate($arguments, $items_per_page, $current_page);
      } // if
    } // paginate
    
    /**
    * Return manager instance
    *
    * @return Users 
    */
    function instance() {
      static $instance;
      if (!instance_of($instance, 'Users')) {
        $instance = new Users();
      } // if
      return $instance;
    } // instance
  
  } // Users 

?>