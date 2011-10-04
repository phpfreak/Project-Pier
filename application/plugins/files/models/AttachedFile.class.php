<?php

  /**
  * AttachedFile class
  * Generated on Wed, 26 Jul 2006 11:18:14 +0200 by DataObject generation tool
  *
  * @http://www.projectpier.org/
  */
  class AttachedFile extends BaseAttachedFile {
  
    /**
    * Return file
    *
    * @param void
    * @return ProjectFile
    */
    function getFile() {
      return ProjectFiles::findById($this->getFileId());
    } // getFile
    
    /**
    * Return object connected with this action
    *
    * @access public
    * @param void
    * @return ProjectDataObject
    */
    function getObject() {
      return get_object_by_manager_and_id($this->getRelObjectId(), $this->getRelObjectManager());
    } // getObject
    
  } // AttachedFile 

?>