<?php

  /**
  * ProjectMessages, generated on Sat, 04 Mar 2006 12:21:44 +0100 by 
  * DataObject generation tool
  *
  * @http://www.projectpier.org/
  */
  class ProjectMessages extends BaseProjectMessages {
    
    /**
    * Return messages that belong to specific project
    *
    * @param Project $project
    * @param boolean $include_private Include private messages in the result
    * @return array
    */
    static function getProjectMessages(Project $project, $include_private = false) {
      if ($include_private) {
        $conditions = array('`project_id` = ?', $project->getId());
      } else {
        $conditions = array('`project_id` = ? AND `is_private` = ?', $project->getId(), false);
      } // if
      
      return self::findAll(array(
        'conditions' => $conditions,
        'order' => '`created_on` DESC',
      )); // findAll
    } // getProjectMessages
    
    /**
    * Return project messages that are marked as important for specific project
    *
    * @param Project $project
    * @param boolean $include_private Include private messages
    * @return array
    */
    static function getImportantProjectMessages(Project $project, $include_private = false) {
      if ($include_private) {
        $conditions = array('`project_id` = ? AND `is_important` = ?', $project->getId(), true);
      } else {
        $conditions = array('`project_id` = ? AND `is_important` = ? AND `is_private` = ?', $project->getId(), true, false);
      } // if
      
      return self::findAll(array(
        'conditions' => $conditions,
        'order' => '`created_on` DESC',
      )); // findAll
    } // getImportantProjectMessages
    
  } // ProjectMessages 

?>