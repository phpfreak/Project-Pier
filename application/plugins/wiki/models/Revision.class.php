<?php

/**
 * Revision
 * 
 * @package ProjectPier Wiki
 * @author Alex Mayhew
 * @copyright 2008
 * @version $Id$
 * @access public
 */
Class Revision extends BaseRevision {
	
	
	
		/**
    * Validate before save
    *
    * @access public
    * @param array $errors
    * @return null
    */
    function validate(&$errors) {
      if (!$this->validatePresenceOf('name')) { 
        $errors[] = lang('wiki page name required');
      }
      if (!$this->validatePresenceOf('content')) {
        $errors[] = lang('wiki page content required');
      }
      if(!$this->validatePresenceOf('project_id')){
				$errors[] = lang('wiki project id required');
			}
			if(!$this->validatePresenceOf('page_id')){
				$errors[] = lang('wiki page id required');
			}			
			
    } // validate
    
    
  /**
   * Get url to revert to this revision
   * 
   * @return
   */
    function getRevertUrl()
    {
			return get_url('wiki', 'revert', array('id' => $this->getPageId(), 'revision' => $this->getRevision()));
		}
		
  /**
   * Get url to view this revision
   * 
   * @return
   */
		function getViewUrl()
		{
			return get_url('wiki', 'view', array('id' => $this->getPageId(), 'revision' => $this->getRevision()));
		}
	
}

?>