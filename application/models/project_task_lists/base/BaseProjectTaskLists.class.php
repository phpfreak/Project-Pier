<?php 

  
  /**
  * ProjectTaskLists class
  *
  * @http://www.projectpier.org/
  */
  abstract class BaseProjectTaskLists extends DataManager {
  
    /**
    * Column name => Column type map
    *
    * @var array
    * @static
    */
    static private $columns = array(
      'id' => DATA_TYPE_INTEGER,
       'milestone_id' => DATA_TYPE_INTEGER,
       'project_id' => DATA_TYPE_INTEGER, 
       'name' => DATA_TYPE_STRING, 
       'description' => DATA_TYPE_STRING, 
       'start_date' => DATA_TYPE_DATETIME, 
       'due_date' => DATA_TYPE_DATETIME, 
       'priority' => DATA_TYPE_INTEGER, 
       'score' => DATA_TYPE_INTEGER, 
       'is_private' => DATA_TYPE_BOOLEAN, 
       'completed_on' => DATA_TYPE_DATETIME, 
       'completed_by_id' => DATA_TYPE_INTEGER, 
       'created_on' => DATA_TYPE_DATETIME, 
       'created_by_id' => DATA_TYPE_INTEGER, 
       'updated_on' => DATA_TYPE_DATETIME, 
       'updated_by_id' => DATA_TYPE_INTEGER, 
       'order' => DATA_TYPE_INTEGER
    );
  
    /**
    * Construct
    *
    * @return BaseProjectTaskLists 
    */
    function __construct() {
      parent::__construct('ProjectTaskList', 'project_task_lists', true);
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
    * Return name of first auto_increment column if it exists
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
    * @return one or ProjectTaskLists objects
    * @throws DBQueryError
    */
    function find($arguments = null) {
      if (isset($this) && instance_of($this, 'ProjectTaskLists')) {
        return parent::find($arguments);
      } else {
        return ProjectTaskLists::instance()->find($arguments);
        //$instance =& ProjectTaskLists::instance();
        //return $instance->find($arguments);
      } // if
    } // find
    
    /**
    * Find all records
    *
    * @access public
    * @param array $arguments
    * @return one or ProjectTaskLists objects
    */
    function findAll($arguments = null) {
      if (isset($this) && instance_of($this, 'ProjectTaskLists')) {
        return parent::findAll($arguments);
      } else {
        return ProjectTaskLists::instance()->findAll($arguments);
        //$instance =& ProjectTaskLists::instance();
        //return $instance->findAll($arguments);
      } // if
    } // findAll
    
    /**
    * Find one specific record
    *
    * @access public
    * @param array $arguments
    * @return ProjectTaskList 
    */
    function findOne($arguments = null) {
      if (isset($this) && instance_of($this, 'ProjectTaskLists')) {
        return parent::findOne($arguments);
      } else {
        return ProjectTaskLists::instance()->findOne($arguments);
        //$instance =& ProjectTaskLists::instance();
        //return $instance->findOne($arguments);
      } // if
    } // findOne
    
    /**
    * Return object by its PK value
    *
    * @access public
    * @param mixed $id
    * @param boolean $force_reload If true cache will be skipped and data will be loaded from database
    * @return ProjectTaskList 
    */
    function findById($id, $force_reload = false) {
      if (isset($this) && instance_of($this, 'ProjectTaskLists')) {
        return parent::findById($id, $force_reload);
      } else {
        return ProjectTaskLists::instance()->findById($id, $force_reload);
        //$instance =& ProjectTaskLists::instance();
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
      if (isset($this) && instance_of($this, 'ProjectTaskLists')) {
        return parent::count($condition);
      } else {
        return ProjectTaskLists::instance()->count($condition);
        //$instance =& ProjectTaskLists::instance();
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
      if (isset($this) && instance_of($this, 'ProjectTaskLists')) {
        return parent::delete($condition);
      } else {
        return ProjectTaskLists::instance()->delete($condition);
        //$instance =& ProjectTaskLists::instance();
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
    * @param array $arguments Query arguments (@see find()) Limit and offset are ignored!
    * @param integer $items_per_page Number of items per page
    * @param integer $current_page Current page number
    * @return array
    */
    function paginate($arguments = null, $items_per_page = 10, $current_page = 1) {
      if (isset($this) && instance_of($this, 'ProjectTaskLists')) {
        return parent::paginate($arguments, $items_per_page, $current_page);
      } else {
        return ProjectTaskLists::instance()->paginate($arguments, $items_per_page, $current_page);
        //$instance =& ProjectTaskLists::instance();
        //return $instance->paginate($arguments, $items_per_page, $current_page);
      } // if
    } // paginate
    
    /**
    * Return manager instance
    *
    * @return ProjectTaskLists 
    */
    function instance() {
      static $instance;
      if (!instance_of($instance, 'ProjectTaskLists')) {
        $instance = new ProjectTaskLists();
      } // if
      return $instance;
    } // instance
  
  } // ProjectTaskLists 

?>