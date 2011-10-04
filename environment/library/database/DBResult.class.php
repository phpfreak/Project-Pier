<?php

  /**
  * Query result
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class DBResult {
    
    /**
    * Adapter that produced this result object
    *
    * @var AbstractDBAdapter
    */
    private $adapter;
    
    /**
    * Query result
    *
    * @var resource
    */
    private $resource;
    
    /**
    * All rows, cached
    *
    * @var array
    */
    private $rows;
    
    /**
    * Construct result and set internal resource
    *
    * @access public
    * @param AbstractDBAdapter Adapter that produced this result
    * @param resource $resource
    * @return DBResult
    */
    function __construct(AbstractDBAdapter $adapter, $resource) {
      $this->setAdapter($adapter);
      $this->setResource($resource);
    } // __construct
    
    /**
    * Fetch current row
    *
    * @access public
    * @param void
    * @return array or false
    */
    function fetchRow() {
      $row = $this->getAdapter()->fetchRow($this->resource);
      if ($row) {
        $this->rows[] = $row;
        return $row;
      } // if
      return false;
    } // fetchRow
    
    /**
    * Return all rows
    *
    * @access public
    * @param void
    * @return array
    */
    function fetchAll() {
      while ($this->fetchRow()) {}
      return $this->rows;
    } // fetchAll
    
    /**
    * Return number of rows
    *
    * @access public
    * @param void
    * @return integer
    */
    function numRows() {
      return $this->getAdapter()->numRows($this->resource);
    } // numRows
    
    /**
    * Free this result
    *
    * @access public
    * @param void
    * @return null
    */
    function free() {
      $this->getAdapter()->freeResult($this->resource);
      $this->rows = null;
    } // free
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get adapter
    *
    * @access public
    * @param null
    * @return AbstractDBAdapter
    */
    function getAdapter() {
      return $this->adapter;
    } // getAdapter
    
    /**
    * Set adapter value
    *
    * @access private
    * @param AbstractDBAdapter $value
    * @return null
    */
    private function setAdapter($value) {
      $this->adapter = $value;
    } // setAdapter
    
    /**
    * Set resource
    *
    * @access public
    * @param resource $resource
    * @return null
    */
    function setResource($resource) {
      if (is_resource($resource)) {
        $this->resource = $resource;
      } // if
    } // setResource
  
  } // DBResult

?>