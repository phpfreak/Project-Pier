<?php

  /**
  * ProjectLinks
  *
  * @http://www.activeingredient.com.au
  */
  class ProjectLinks extends BaseProjectLinks {
  
    /**
    * Return array of all links for project
    *
    * @param Project
    * @return ProjectLinks
    */
    static function getAllProjectLinks(Project $project) {
      trace(__FILE__,'getAllProjectLinks():begin');
      
      $conditions = array('`project_id` = ?', $project->getId());
      
      return self::findAll(array(
        'conditions' => $conditions,
        'order' => '`created_on` DESC',
      )); // findAll
      trace(__FILE__,'getAllProjectLinks():end');
    } // getAllProjectLinks

  } // ProjectLinks 

?>