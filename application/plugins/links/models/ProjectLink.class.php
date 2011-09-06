<?php

  /**
  * ProjectLink class
  *
  * @http://www.activeingredient.com.au
  */
  class ProjectLink extends BaseProjectLink {
    
    /**
    * asUrl
    *
    * @param void
    * @return null
    */
    function asUrl() {
      $url = trim($this->getUrl());
      if (strlen($url)>0) {
        if (substr($url, 0, 1) == '/') return $url;
        $i = strpos($url, '://');
        if ($i === false ) {
          $url = "http://$url";
        }
      } 
      return $url;
    }

    /**
    * Return parent project instance
    *
    * @param void
    * @return Project
    */
    function getProject() {
      if (is_null($this->project)) {
        $this->project = Projects::findById($this->getProjectId());
      } // if
      return $this->project;
    } // getProject
    
    /**
    * Add new link
    *
    * @param void
    * @return null
    */
    function canAdd(User $user, Project $project) {
      return $user->isAdministrator() || $user->isMemberOfOwnerCompany();
    }
    
    /**
    * Edit link
    *
    * @param void
    * @return null
    */
    function canEdit(User $user) {
      return $user->isAdministrator() || $user->isMemberOfOwnerCompany();
    }
    
    /**
    * Delete link
    *
    * @param void
    * @return null
    */
    function canDelete(User $user) {
      return $user->isAdministrator() || $user->isMemberOfOwnerCompany();
    }
    
    /**
    * Does user have view access
    *
    * @param void
    * @return boolean
    */
    function canView(User $user) {
      if ($user->isAdministrator() || $user->isMemberOfOwnerCompany()) {
        return true;
      } // if
      if ($user->isProjectUser($this->getProject())) {
        return true;
      } // if
      return false;
    } // canView
    
    /**
    * Return edit link URL
    *
    * @param void
    * @return string
    */
    function getEditUrl() {
      return get_url('links', 'edit_link', array('id' => $this->getId(), 'active_project' => active_project()->getId()));
    } // getEditUrl
    
    /**
    * Return delete link URL
    *
    * @param void
    * @return string
    */
    function getDeleteUrl() {
      return get_url('links', 'delete_link', array('id' => $this->getId(), 'active_project' => active_project()->getId()));
    } // getEditUrl
    
    /**
    * Return object name
    *
    * @param void
    * @return string
    */
    function getObjectName() {
      return $this->getTitle();
    }
    
    /**
    * Return object type name
    *
    * @param void
    * @return string
    */
    function getObjectTypeName() {
      return lang('link');
    } // getObjectTypeName
    
  } // ProjectLink 

?>
