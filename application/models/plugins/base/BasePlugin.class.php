<?php

  /**
  * BasePlugin class
  *
  * @http://www.projectpier.org/
  */
  abstract class BasePlugin extends DataObject {
  
    // -------------------------------------------------------
    //  Access methods
    // -------------------------------------------------------
  
    /**
    * Return value of 'plugin_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getPluginId() {
      return $this->getColumnValue('plugin_id');
    } // getPluginId()
    
    /**
    * Set value of 'plugin_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setPluginId($value) {
      return $this->setColumnValue('plugin_id', $value);
    } // setPluginId() 
    
    /**
    * Return value of 'name' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getName() {
      return $this->getColumnValue('name');
    } // getName()
    
    /**
    * Set value of 'name' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setName($value) {
      return $this->setColumnValue('name', $value);
    } // setName() 
    
    /**
    * Tell if a plugin is installed
    *
    * @access public   
    * @return boolean
    */
    function isInstalled()
    {
      return $this->getColumnValue('installed');
    }
    
    /**
    * Set the value of installed property
    *
    * @access public   
    * @return boolean
    */
    function setInstalled($value)
    {
      return $this->setColumnValue('installed', $value);
    }
   
    /**
    * Return manager instance
    *
    * @access protected
    * @param void
    * @return Plugins 
    */
    function manager() {
      if (!($this->manager instanceof Plugins)) {
        $this->manager = Plugins::instance();
      }
      return $this->manager;
    } // manager
  
  } // BasePlugin 

?>