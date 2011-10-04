<?php

  /**
  * Container class
  * 
  * Basic, abstract conainer with IContainer implemented
  *
  * @package turtle.base
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class Container implements IContainer, Iterator, ArrayAccess {
    
    /**
    * Data array
    *
    * @var array
    */
    private $__data = array();
    
    /**
    * Checks if there is specific var in container
    *
    * @access public
    * @param string $var Variable name
    * @return boolean
    */
    public function has($var) {
      return isset($this->__data[$var]);
    } // has
    
    /**
    * Return value of specific variable. If value is not found $default is returned
    *
    * @access public
    * @param string $var Variable name
    * @param mixed $default Default value, returned if var is not found
    * @return mixed
    */
    public function get($var, $default = null) {
      return $this->has($var) ? $this->__data[$var] : $default;
    } // get
    
    /**
    * Set value of specific variable
    *
    * @access public
    * @param string $var Variable name
    * @param string $value Variable value
    * @return null
    */
    public function set($var, $value) {
      $this->__data[$var] = $value;
      return $this->__data[$var];
    } // set
    
    /**
    * Unset / drop specific variable
    *
    * @access public
    * @param string $var
    * @return null
    */
    public function drop($var) {
      if ($this->has($var)) {
        unset($this->__data[$var]);
      }
    } // drop
    
    /**
    * Return number of items in container
    *
    * @param void
    * @return integer
    */
    function count() {
      return count($this->__data);
    } // count
    
    /**
    * Clear content of container
    *
    * @access public
    * @param void
    * @return null
    */
    public function clear() {
      $this->__data = array();
    } // clear
    
    /**
    * Import array into container
    *
    * @access public
    * @param array $data
    * @return void
    */
    function import($data) {
      $this->__data = is_array($data) ? $data : array();
    } // import
    
    /**
    * Append $data array of existing data in container. It uses array merge so 
    * it have this behavior:
    *
    * @access public
    * @param array $data Data that need to be appended
    * @return null
    */
    function append($data) {
      if (is_array($data)) {
        $this->__data = array_merge($this->__data, $data);
      }
    } // append
    
    /**
    * Export data...
    *
    * @access public
    * @param void
    * @return array
    */
    function export() {
      return $this->__data;
    } // export
    
    // Implement Iterator
    public function current() { return current($this->__data); }
    public function key() { return key($this->__data); }
    public function next() { return next($this->__data); }
    public function rewind() { return reset($this->__data); }
    public function valid() { return current($this->__data) !== false; }
    
    // Implement ArrayAccess
    public function offsetExists($offset) { return isset($this->__data[$offset]); }
    public function offsetSet($offset, $value) { return $this->set($offset, $value); }
    public function offsetGet($offset) { return $this->get($offset); }
    public function offsetUnset($offset) { unset($this->__data[$offset]); } 
    
  } // Container

?>