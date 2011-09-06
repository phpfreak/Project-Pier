<?php

  /**
  * Application logs manager class
  *
  * @http://www.projectpier.org/
  */
  class ApplicationLogs extends BaseApplicationLogs {
    
    const ACTION_ADD    = 'add';
    const ACTION_EDIT   = 'edit';
    const ACTION_DELETE = 'delete';
    const ACTION_CLOSE  = 'close';
    const ACTION_OPEN   = 'open';
  
    /**
    * Create new log entry and return it
    * 
    * Delete actions are automaticly marked as silent if $is_silent value is not provided (not NULL)
    *
    * @param ApplicationDataObject $object
    * @param Project $project
    * @param DataManager $manager
    * @param boolean $save Save log object before you save it
    * @return ApplicationLog
    */
    static function createLog(ApplicationDataObject $object, $project, $action = null, $is_private = false, $is_silent = null, $save = true) {
      if (is_null($action)) {
        $action = self::ACTION_ADD;
      } // if
      if (!self::isValidAction($action)) {
        throw new Error("'$action' is not valid log action");
      } // if
      
      if (is_null($is_silent)) {
        $is_silent = $action == self::ACTION_DELETE;
      } else {
        $is_silent = (boolean) $is_silent;
      } // if
      
      $manager = $object->manager();
      if (!($manager instanceof DataManager)) {
        throw new Error('Invalid object manager');
      } // if
      
      $log = new ApplicationLog();
      
      if ($project instanceof Project) {
        $log->setProjectId($project->getId());
      } // if
      $log->setTakenById(logged_user()->getId());
      $log->setRelObjectId($object->getObjectId());
      $log->setObjectName($object->getObjectName());
      $log->setRelObjectManager(get_class($manager));
      $log->setAction($action);
      $log->setIsPrivate($is_private);
      $log->setIsSilent($is_silent);
      
      if ($save) {
        $log->save();
      } // if
      
      // Update is private for this object
      if ($object instanceof ProjectDataObject) {
        ApplicationLogs::setIsPrivateForObject($object);
      } // if
      
      return $log;
    } // createLog
    
    /**
    * Update is_private flag value for all previous related log entries related with specific object
    * 
    * This method is called whenever we need to add new log entry. It will keep old log entries related to that specific 
    * object with current is_private flag value by updating all of the log entries to new value.
    *
    * @param ProjectDataObject $object
    * @return boolean
    */
    static function setIsPrivateForObject(ProjectDataObject $object) {
      return DB::execute('UPDATE ' . ApplicationLogs::instance()->getTableName(true) . ' SET `is_private` = ? WHERE `rel_object_id` = ? AND `rel_object_manager` = ?',
        $object->isPrivate(), 
        $object->getObjectId(), 
        get_class($object->manager()
      )); // execute
    } // setIsPrivateForObject
    
    /**
    * Mass set is_private for a given type. If $ids is present limit update only to object with given ID-s
    *
    * @param boolean $is_private
    * @param string $type
    * @parma array $ids
    * @return boolean
    */
    static function setIsPrivateForType($is_private, $type, $ids = null) {
      $limit_ids = null;
      if (is_array($ids)) {
        $limit_ids = array();
        foreach ($ids as $id) {
          $limit_ids[] = DB::escape($id);
        } // if
        
        $limit_ids = count($limit_ids) > 0 ? implode(',', $limit_ids) : null;
      } // if
      
      $sql = DB::prepareString('UPDATE ' . ApplicationLogs::instance()->getTableName(true) . ' SET `is_private` = ?  WHERE `rel_object_manager` = ?', array($is_private, $type));
      if ($limit_ids !== null) {
        $sql .= " AND `rel_object_id` IN ($limit_ids)";
      } // if
      
      return DB::execute($sql);
    } // setIsPrivateForType
    
    /**
    * Return entries related to specific project
    * 
    * If $include_private is set to true private entries will be included in result. If $include_silent is set to true 
    * logs marked as silent will also be included. $limit and $offset are there to control the range of the result, 
    * usually we don't want to pull the entire log but just the few most recent entries. If NULL they will be ignored
    *
    * @param Project $project
    * @param boolean $include_private
    * @param boolean $include_silent
    * @param integer $limit
    * @param integer $offset
    * @return array
    */
    static function getProjectLogs(Project $project, $include_private = false, $include_silent = false, $limit = null, $offset = null) {
      $private_filter = $include_private ? 1 : 0;
      $silent_filter = $include_silent ? 1 : 0;
      
      return self::findAll(array(
        'conditions' => array('`is_private` <= ? AND `is_silent` <= ? AND `project_id` = (?)', $private_filter, $silent_filter, $project->getId()),
        'order' => '`created_on` DESC',
        'limit' => $limit,
        'offset' => $offset,
      )); // findAll
    } // getProjectLogs
    
    /**
    * Return overall (for dashboard or RSS)
    *
    * This function will return array of application logs that match the function arguments. Entries can be filtered by 
    * type (prvivate, silent), projects (if $project_ids is array, if NULL project ID is ignored). Result set can be 
    * also limited using $limit and $offset params
    * 
    * @param boolean $include_private
    * @param boolean $include_silent
    * @param mixed $project_ids
    * @param integer $limit
    * @param integer $offset
    * @return array
    */
    static function getOverallLogs($include_private = false, $include_silent = false, $project_ids = null, $limit = null, $offset = null) {
      $private_filter = $include_private ? 1 : 0;
      $silent_filter = $include_silent ? 1 : 0;
      
      if (is_array($project_ids)) {
        $conditions = array('`is_private` <= ? AND `is_silent` <= ? AND `project_id` IN (?)', $private_filter, $silent_filter, $project_ids);
      } else {
        $conditions = array('`is_private` <= ? AND `is_silent` <= ?', $private_filter, $silent_filter);
      } // if
      
      return self::findAll(array(
        'conditions' => $conditions,
        'order' => '`created_on` DESC',
        'limit' => $limit,
        'offset' => $offset,
      )); // findAll
    } // getOverallLogs
    
    /**
    * Clear all logs related with specific project
    *
    * @param Project $project
    * @return boolean
    */
    static function clearByProject(Project $project) {
      return self::delete(array('`project_id` = ?', $project->getId()));
    } // clearByProject
    
    /**
    * Check if specific action is valid
    *
    * @param string $action
    * @return boolean
    */
    static function isValidAction($action) {
      static $valid_actions = null;
      
      if (!is_array($valid_actions)) {
        $valid_actions = array(
          self::ACTION_ADD, 
          self::ACTION_EDIT, 
          self::ACTION_DELETE, 
          self::ACTION_CLOSE, 
          self::ACTION_OPEN
        ); // array
      } // if
      
      return in_array($action, $valid_actions);
    } // isValidAction
    
  } // ApplicationLogs 

?>
