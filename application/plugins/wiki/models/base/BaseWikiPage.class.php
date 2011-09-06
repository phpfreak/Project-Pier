<?php

/**
 * BaseWikiPage
 * 
 * @package ProjectPier Wiki
 * @author Alex Mayhew
 * @copyright 2008
 * @version $Id$
 * @access public
 */
Abstract Class BaseWikiPage extends ProjectDataObject {
	
	protected $project;
	
  /**
   * Taken from Project links plugin
   * Modified slightly
	 *    
   * @param mixed $method
   * @param mixed $args
   * @return
   */
	function __call($method, $args) {
			//If we have a getter or setter call
      if( preg_match('/(set|get)(_)?/', $method, $type) ) {
  			
	    	//Get the name of the column it wants to get / set
      	$col = substr(strtolower(preg_replace('([A-Z])', '_$0', $method)), 4);
  			
        if($type[1] == 'get') {
        	
					//If we want to get a value
					return $this->getColumnValue($col);
					  
        } elseif($type[1] == 'set' && count($args)) {
        	//Else if we want to set a value, and we have an arguement
          return $this->setColumnValue($col, $args[0]);
          
        }// if
      } //if
      
      // me no understand!
      return false;
		} //__call
	

	/**
    * Return manager instance
    *
    * @access protected
    * @param void
    * @return ProjectLinks 
    */
    function manager() 
		{
      if (!instance_of($this->manager, 'Wiki')) {
        $this->manager = Wiki::instance();
      }
      return $this->manager;
    } // manager
    
  /**
   * This function saves the wiki page 
   *
   * @return void
   */
	function save()
  {
		if(instance_of($this->new_revision, 'Revision')){
			
			//Increase the page revision number
			$this->setColumnValue('revision', $this->getColumnValue('revision') + 1);
			
			//Remove any other pages in this project which have the default page status
			if(($this->isColumnModified('project_index') && $this->getColumnValue('project_index') == 1)){
				$sql = 'UPDATE ' . $this->getTableName(true) . ' SET `project_index` = 0 WHERE `project_id` = ' . $this->getProjectId();
				DB::execute($sql);
			}

			//Remove any other pages in this project which have sidebar status
			if(($this->isColumnModified('project_sidebar') && $this->getColumnValue('project_sidebar') == 1)){
				$sql = 'UPDATE ' . $this->getTableName(true) . ' SET `project_sidebar` = 0 WHERE `project_id` = ' . $this->getProjectId();
				DB::execute($sql);
			}

			//Save this page with the new revision id
			parent::save();
			
			//Set the revisions's page Id
			$this->new_revision->setPageId($this->getId());
			
			//Set the project Id
			$this->new_revision->setProjectId($this->getProjectId());			
			
			//Set the revision number in the revision object
			$this->new_revision->setRevision($this->getColumnValue('revision'));
			
			//If we have made a new revision of this page, then save the revision
			$this->new_revision->save();
			
		}	else {
			//We haven't made a new revision, so we shouldn't update this page
			return false;
		} 		
	}//save
} 

?>