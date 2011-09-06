<?php

/**
 * Wiki
 * 
 * @package ProjectPier Wiki
 * @author Alex Mayhew
 * @copyright 2008
 * @version $Id$
 * @access public
 */
class Wiki extends BaseWiki {
	
  /*
  * Get a wiki page by its ID
  * 
  * @param mixed Page Id
  * @param mixed Active project
  * @return
  */
  function getPageById($wiki_page_id, Project $project)
  {
    $params = array(
	'conditions' => array(
	'`id` = ? AND `project_id` = ?', 
	$wiki_page_id, 
	$project->getId()
      ),											
    );
    return parent::findOne($params);		
  }
	
  /**
   * Get the index page of a project
   * 
   * @param mixed Instance of project
   * @return
   */
	function getProjectIndex(Project $project)
	{
		$params = array(
			'conditions'	=>	array(
													'project_id = ? AND project_index = 1',
													$project->getId()
												)
							);
		return parent::findOne($params);
	}
	
  /**
   * Get the sidebar for a project
   * 
   * @param mixed $project
   * @return
   */
	function getProjectSidebar($project = null)
	{
		$params = array(
			'conditions'	=>	array(
													'project_id = ? AND project_sidebar = 1',
													(instance_of($project, 'Project') ? $project->getId() : 0)
													)
							);
		
		return parent::findOne($params);
	}
	
  /**
   * Get a list of pages for a project
   * 
   * @param mixed $project
   * @return
   */
  function getPagesList(Project $project)
  {
    $sql = 'SELECT p.id, r.name FROM ' . Wiki::instance()->getTableName(true) . ' AS p, ' . Revisions::instance()->getTableName(true) . ' AS r WHERE p.project_id = ' . $project->getId() . ' AND p.id = r.page_id AND r.revision = p.revision AND p.project_sidebar = 0 ORDER BY 2'; 
    $return = array();
      foreach(((array) DB::executeAll($sql)) as $page){
        $return[] = array(
          'name' => $page['name'],	
	  'view_url' => get_url('wiki', 'view', array('id' => $page['id'])
        )
      );
    }
    return $return;
  }

    /**
    * Return array of all pages for project
    *
    * @param Project
    * @return ProjectLinks
    */
    static function getAllProjectPages(Project $project) {
      trace(__FILE__,'getAllProjectPages():begin');
      
      $conditions = array('`project_id` = ?', $project->getId());
      
      return self::findAll(array(
        'conditions' => $conditions,
        'order' => '`id` ASC',
      )); // findAll
      trace(__FILE__,'getAllProjectPages():end');
    } // getAllProjectPages
	
}

?>