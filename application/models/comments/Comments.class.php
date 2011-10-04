<?php

  /**
  * Comments, generated on Wed, 19 Jul 2006 22:17:32 +0200 by 
  * DataObject generation tool
  *
  * @http://www.projectpier.org/
  */
  class Comments extends BaseComments {
    
    /**
    * Return object comments
    *
    * @param ProjectDataObject $object
    * @param boolean $exclude_private Exclude private comments
    * @return array
    */
    static function getCommentsByObject(ProjectDataObject $object, $exclude_private = false) {
      if ($exclude_private) {
        return self::findAll(array(
          'conditions' => array('`rel_object_id` = ? AND `rel_object_manager` = ? AND `is_private` = ?', $object->getObjectId(), get_class($object->manager()), 0),
          'order' => '`created_on`'
        )); // array
      } else {
        return self::findAll(array(
          'conditions' => array('`rel_object_id` = ? AND `rel_object_manager` = ?', $object->getObjectId(), get_class($object->manager())),
          'order' => '`created_on`'
        )); // array
      } // if
    } // getCommentsByObject
    
    /**
    * Return number of comments for specific object
    *
    * @param ProjectDataObject $object
    * @param boolean $exclude_private Exclude private comments
    * @return integer
    */
    static function countCommentsByObject(ProjectDataObject $object, $exclude_private = false) {
      if ($exclude_private) {
        return self::count(array('`rel_object_id` = ? AND `rel_object_manager` = ? AND `is_private` = ?', $object->getObjectId(), get_class($object->manager()), 0));
      } else {
        return self::count(array('`rel_object_id` = ? AND `rel_object_manager` = ?', $object->getObjectId(), get_class($object->manager())));
      } // if
    } // countCommentsByObject
  
    /**
    * Drop comments by object
    *
    * @param ProjectDataObject
    * @return boolean
    */
    static function dropCommentsByObject(ProjectDataObject $object) {
      return Comments::delete(array('`rel_object_manager` = ? AND `rel_object_id` = ?', get_class($object->manager()), $object->getObjectId()));
    } // dropCommentsByObject
    
  } // Comments 

?>