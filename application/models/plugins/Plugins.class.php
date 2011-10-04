<?php

  /**
  * Plugins class
  *
  * @http://www.projectpier.org/
  */
  class Plugins extends BasePlugins {
  
    /**
    * Return array of all plugins based on plugin files on filesystem
    *
    * @param none
    * @return array
    */
    static function getAllPlugins() {
      trace(__FILE__,'getAllPlugins()');
      $results = array();
      $dir = APPLICATION_PATH.'/plugins';
      $dirs = get_dirs($dir,false);

      foreach( (array)$dirs as $plugin) {
        if (file_exists($dir.'/'.$plugin.'/init.php') && is_file($dir.'/'.$plugin.'/init.php')) {
          $results[$plugin] = '-';
        }
      }
      // now sort by name
      ksort($results);
      // now get activated plugins
      $conditions = array('`installed` = 1');
      $plugins = Plugins::findAll(array(
        'conditions' => $conditions
        ));
      trace(__FILE__,'getAllPlugins() - all plugins retrieved from database');
      foreach((array)$plugins as $plugin) {
        trace(__FILE__,'getAllPlugins() - foreach: '.$plugin->getName());
        if( array_key_exists($plugin->getName(),$results) ) {
          $results[$plugin->getName()] = $plugin->getPluginId();
        } else {
          // TODO : remove from DB here??
        }
      }
      
      return $results;
    
    } // getAllPlugins
    
    /**
    * Return array of all activated plugins based on plugin files on filesystem
    *
    * @param none
    * @return array
    */
    static function getActivatedPlugins() {
      
      $results = Plugins::getAllPlugins();
      
      foreach($results as $name => $id) {
        if( '-' == $id )
          unset($results[$name]);
      }
      
      return $results;
    
    } // getActivatedPlugins
    
    /**
    * Return array of all activated plugins
    *
    * @param none
    * @return array
    */
    static function getNamesFromDB() {
      $names = array();
      $plugins = Plugins::findAll(array()); // findAll
      if (is_array($plugins)) {
        foreach ($plugins as $plugin) {
          $names[] = $plugin->getName();
        } // foreach
      } // if
      return $names;
    } // getActivatedPlugins
    
  } // Plugins 

?>