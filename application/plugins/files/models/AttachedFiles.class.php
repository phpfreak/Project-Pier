<?php

  /**
  * AttachedFiles, generated on Wed, 26 Jul 2006 11:18:14 +0200 by 
  * DataObject generation tool
  *
  * @http://www.projectpier.org/
  */
  class AttachedFiles extends BaseAttachedFiles {
  
    /**
    * Return all relation objects (AttachedFile) for specific object
    *
    * @param ProjectDataObject $object
    * @return array
    */
    static function getRelationsByObject(ProjectDataObject $object) {
      return self::findAll(array(
        'conditions' => array('`rel_object_manager` = ? AND `rel_object_id` = ?', get_class($object->manager()), $object->getObjectId()),
        'order' => '`created_on`'
      )); // findAll
    } // getRelationsByObject
    
    /**
    * Return relations by file
    *
    * @param ProjectFile $file
    * @return array
    */
    static function getRelationsByFile(ProjectFile $file) {
      return self::findAll(array(
        'conditions' => array('`file_id` = ?', $file->getId()),
        'order' => '`created_on`'
      )); // findAll
    } // getRelationsByFile
    
    /**
    * Return related by files by object
    *
    * @param ProjectDataObject $object
    * @param boolean $exclude_private Exclude private files
    * @return array
    */
    static function getFilesByObject(ProjectDataObject $object, $exclude_private = false) {
      return self::getFilesByRelations(self::getRelationsByObject($object), $exclude_private);
    } // getFilesByObject
    
    /**
    * Return related object by file
    *
    * @param ProjectFile $file
    * @param boolean $exclude_private Exclude private objects
    * @return array
    */
    function getObjectsByFile(ProjectFile $file, $exclude_private = false) {
      return self::getObjectsByRelations(self::getRelationsByFile($file), $exclude_private);
    } // getObjectsByFile
    
    /**
    * Return files by array of object - file relations
    *
    * @param array $relations
    * @param boolean $exclude_private Exclude private files from the listing
    * @return array
    */
    static function getFilesByRelations($relations, $exclude_private = false) {
      if (!is_array($relations)) {
        return null;
      }
      
      $files = array();
      foreach ($relations as $relation) {
        $file = $relation->getFile();
        if ($file instanceof ProjectFile) {
          if (!($exclude_private && $file->isPrivate())) {
            $files[] = $file;
          } // if
        } // if
      } // if
      return count($files) ? $files : null;
    } // getFilesByRelations
    
    /**
    * Return objects by array of object - file relations
    *
    * @param array $relations
    * @param boolean $exclude_private Exclude private objects
    * @return array
    */
    static function getObjectsByRelations($relations, $exclude_private = false) {
      if (!is_array($relations)) {
        return null;
      }
      
      $objects = array();
      foreach ($relations as $relation) {
        $object = $relation->getObject();
        if ($object instanceof ProjectDataObject) {
          if (!($exclude_private && $object->isPrivate())) {
            $objects[] = $object;
          } // if
        } // if
      } // if
      return count($objects) ? $objects : null;
    } //getObjectsByRelations
    
    /**
    * Clear all relations by object
    *
    * @param ProjectDataObject
    * @return boolean
    */
    static function clearRelationsByObject(ProjectDataObject $object) {
      return self::delete(array('`rel_object_manager` = ? AND `rel_object_id` = ?', get_class($object->manager()), $object->getObjectId()));
    } // clearRelationsByObject
    
    /**
    * Remove all relations by file
    *
    * @param ProjectFile $file
    * @return boolean
    */
    static function clearRelationsByFile(ProjectFile $file) {
      return self::delete(array('`file_id` = ?', $file->getId()));
    } // clearRelationsByFile
    
  } // AttachedFiles 

?>