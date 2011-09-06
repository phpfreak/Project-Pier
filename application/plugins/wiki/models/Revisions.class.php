<?php



/**
 * Revisions
 * 
 * @package ProjectPier Wiki
 * @author Alex Mayhew
 * @copyright 2008
 * @version $Id$
 * @access public
 */
Class Revisions extends BaseRevisions {
	
	
  /**
   * Build revision history of a page
   * 
   * @param mixed $id
   * @param mixed $project
   * @return
   */
	function buildPageHistory($id, Project $project)
	{
		return self::findAll(array( 'conditions' => array('`page_id` = ? AND `project_id` = ?', $id, $project->getId()), 'order' => '`revision` DESC'));
	}
	
  /**
   * Get a specific revision
   * 
   * @param mixed $page_id
   * @param mixed $revision
   * @return
   */
	function getRevision($page_id, $revision = null)
	{
		if($revision === null){
			//If the user wants the latest page
			$params = array(
				'conditions'	=>	array('page_id = ?', $page_id),
				'order'				=>	'revision DESC');
				
		} else {
			$revision = (int) $revision;
			//They want a specific revision
			$params = array(
				'conditions'	=>	array('page_id = ? AND revision = ?', $page_id, $revision));
				
		}
		//Return the revision object
		return parent::findone($params);
	}
	
}

?>