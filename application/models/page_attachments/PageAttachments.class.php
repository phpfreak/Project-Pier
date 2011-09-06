<?php

  /**
  * PageAttachments
  *
  * @http://www.projectpier.org/
  */
  class PageAttachments extends BasePageAttachments {
    
    /**
    * Return all page attachments for specific project
    *
    * @param Project $project
    * @return array
    */
    function getAllByProject(Project $project) {
      return self::findAll(array('conditions' => array('`project_id` = ?', $this->getId())));
    } // getAllByProject
    
    /**
    * Return attachments by object manager, object id, and project
    *
    * @param string $rel_object_manager
    * @param integer $rel_object_id
    * @param integer $project_id
    * @return array
    */
    function getAttachmentsByManagerIdAndProject($rel_object_manager, $rel_object_id, $project_id) {
      return self::findAll(array(
        'conditions' => array('`rel_object_manager` = ? AND `rel_object_id` = ? AND `project_id` = ?', $rel_object_manager, $rel_object_id, $project_id)));
    } // getAttachmentsByManagerIdAndProject
    
    /**
    * Return attachments by page name and project
    *
    * @param string
    * @param Project $project
    * @return array
    */
    function getAttachmentsByPageNameAndProject($page_name, Project $project) {
      if (trim($page_name) == '' || !($project instanceof Project)) {
        return null;
      } // if
      
      return self::findAll(array(
        'conditions' => array('`page_name` = ? AND `project_id` = ?', $page_name, $project->getId()),
        'order' => '`order` ASC'));
    } // getAttachmentsByPageNameAndProject
    
    /**
    * Return all attachments of a certain type for a specific project
    *
    * @param array
    * @param Project $project
    * @return array
    */
    function getAttachmentsByTypeAndProject($types, Project $project) {
      if (!($project instanceof Project)) {
        return null;
      } // if
      
      if (!is_array($types)) {
        $types = array($types);
      } // if
      
      return self::findAll(array(
        'conditions' => array('`rel_object_manager` IN (?) AND `project_id` = ?', $types, $project->getId()),
        'order' => '`order` ASC'));
    } // getAttachmentsByTypeAndProject
    
    /**
    * Clear all attachments by object
    *
    * @param ApplicationDataObject
    * @return boolean
    */
    static function clearAttachmentsByObject(ApplicationDataObject $object) {
      return self::delete(array('`rel_object_manager` = ? AND `rel_object_id` = ?', get_class($object->manager()), $object->getObjectId()));
    } // clearAttachmentsByObject
    
    /**
    * Renumbers the order of the attachments
    *
    * @param string $page_name
    * @param Project $project
    * @return void
    */
    function reorder($page_name, Project $project) {
      $page_attachments = PageAttachments::getAttachmentsByPageNameAndProject($page_name, $project);
      $order = 0;
      
      if (is_array($page_attachments) && count($page_attachments)) {
        foreach ($page_attachments as $page_attachment) {
          $order++;
          $page_attachment->setOrder($order);
          $page_attachment->save();
        } // foreach
      } // if
    } // reorder
  } // PageAttachments 

?>