<?php

  /**
  * SearchableObjects, generated on Tue, 13 Jun 2006 12:15:44 +0200 by 
  * DataObject generation tool
  *
  * @http://www.projectpier.org/
  */
  class SearchableObjects extends BaseSearchableObjects {
    
    /**
    * Search for specific search string ($search_for) in specific project
    *
    * @param string $search_for Search string
    * @param Project $project Search in this project
    * @param boolean $include_private
    * @return array
    */
    static function search($search_for, Project $project, $include_private = false) {
      return SearchableObjects::doSearch(SearchableObjects::getSearchConditions($search_for, $project, $include_private));
    } // search
    
    /**
    * Search paginated
    *
    * @param string $search_for Search string
    * @param Project $project Search in this project
    * @param boolean $include_private
    * @param integer $items_per_page
    * @param integer $current_page
    * @return array
    */
    static function searchPaginated($search_for, Project $project, $include_private = false, $items_per_page = 10, $current_page = 1) {
      $conditions = SearchableObjects::getSearchConditions($search_for, $project, $include_private);
      $pagination = new DataPagination(SearchableObjects::countUniqueObjects($conditions), $items_per_page, $current_page);
      
      $items = SearchableObjects::doSearch($conditions, $pagination->getItemsPerPage(), $pagination->getLimitStart());
      return array($items, $pagination);
    } // searchPaginated
    
    /**
    * Prepare search conditions string based on input params
    *
    * @param string $search_for Search string
    * @param Project $project Search in this project
    * @return array
    */
    function getSearchConditions($search_for, Project $project, $include_private = false) {
      if (logged_user()->isAdministrator()) {
        return DB::prepareString('MATCH (`content`) AGAINST (? IN BOOLEAN MODE)', array($search_for));
      }
      if ($include_private) {
        return DB::prepareString('MATCH (`content`) AGAINST (? IN BOOLEAN MODE) AND `project_id` = ?', array($search_for, $project->getId()));
      } else {
        return DB::prepareString('MATCH (`content`) AGAINST (? IN BOOLEAN MODE) AND `project_id` = ? AND `is_private` = ?', array($search_for, $project->getId(), false));
      } // if
    } // getSearchConditions
    
    /**
    * Do the search
    *
    * @param string $conditions
    * @param integer $limit
    * @param integer $offset
    * @return array
    */
    function doSearch($conditions, $limit = null, $offset = null) {
      $table_name = SearchableObjects::instance()->getTableName(true);
      
      $limit_string = '';
      if ((integer) $limit > 0) {
        $offset = (integer) $offset > 0 ? (integer) $offset : 0;
        $limit_string = " LIMIT $offset, $limit";
      } // if
      
      $where = '';
      if (trim($conditions) <> '') {
        $where = "WHERE $conditions";
      }
      
      $sql = "SELECT `rel_object_manager`, `rel_object_id` FROM $table_name $where $limit_string";
      $result = DB::executeAll($sql);
      
      if (!is_array($result)) {
        return null;
      }
      
      $loaded = array();
      $objects = array();
      foreach ($result as $row) {
        $manager_class = array_var($row, 'rel_object_manager');
        $object_id = array_var($row, 'rel_object_id');
        
        if (!isset($loaded[$manager_class . '-' . $object_id]) || !($loaded[$manager_class . '-' . $object_id])) {
          if (class_exists($manager_class)) {
            $object = get_object_by_manager_and_id($object_id, $manager_class);
            if ($object instanceof ProjectDataObject) {
              $loaded[$manager_class . '-' . $object_id] = true;
              $objects[] = $object;
            } // if
          } // if
        } // if
      } // foreach
      
      return count($objects) ? $objects : null;
    } // doSearch
    
    /**
    * Return number of unique objects
    *
    * @param string $conditions
    * @return integer
    */
    function countUniqueObjects($conditions) {
      $table_name = SearchableObjects::instance()->getTableName(true);
      $where = '';
      if (trim($conditions <> '')) {
        $where = "WHERE $conditions";
      }
      
      $sql = "SELECT `rel_object_manager`, `rel_object_id` FROM $table_name $where";
      $result = DB::executeAll($sql);
      if (!is_array($result) || !count($result)) {
        return 0;
      }
      
      $counted = array();
      $counter = 0;
      foreach ($result as $row) {
        if (!isset($counted[array_var($row, 'rel_object_manager') . array_var($row, 'rel_object_id')])) {
          $counted[array_var($row, 'rel_object_manager') . array_var($row, 'rel_object_id')] = true;
          $counter++;
        } // if
      } // foreach
      
      return $counter;
    } // countUniqueObjects
    
    /**
    * Drop all content from table related to $object
    *
    * @param ProjectDataObject $object
    * @return boolean
    */
    static function dropContentByObject(ProjectDataObject $object) {
      return SearchableObjects::delete(array('`rel_object_manager` = ? AND `rel_object_id` = ?', get_class($object->manager()), $object->getObjectId()));
    } // dropContentByObject
    
  } // SearchableObjects 

?>