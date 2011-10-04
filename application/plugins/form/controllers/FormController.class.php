<?php

  class FormController extends ApplicationController {
    
    /**
    * Construct the MessageController
    *
    * @access public
    * @param void
    * @return MessageController
    */
    function __construct() {
      parent::__construct();
      prepare_company_website_controller($this, 'project_website');
    } // __construct
  
    /**
    * List all project forms
    *
    * @param void
    * @return null
    */
    function index() {
      $this->addHelper('textile');
      
      if (!ProjectForm::canAdd(logged_user(), active_project())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(active_project()->getOverviewUrl());
      } // if
      
      tpl_assign('forms', active_project()->getAllForms());
    } // index
    
    /**
    * Submit specific project form
    *
    * @param void
    * @return null
    */
    function submit() {
      $this->addHelper('textile');
      
      $project_form = ProjectForms::findById(get_id());
      if (!($project_form instanceof ProjectForm)) {
        flash_error(lang('project form dnx'));
        $this->redirectToUrl(active_project()->getOverviewUrl());
      } // if
      
      $in_object = $project_form->getInObject();
      if (!($in_object instanceof ProjectMessage) && !($in_object instanceof ProjectTaskList)) {
        flash_error(lang('related project form object dnx'));
        $this->redirectToUrl(active_project()->getOverviewUrl());
      } // if
      
      if (!$project_form->canSubmit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToUrl(active_project()->getOverviewUrl());
      } // if
      
      $project_form_data = array_var($_POST, 'project_form_data');
      
      tpl_assign('visible_forms', active_project()->getVisibleForms(true));
      tpl_assign('project_form', $project_form);
      tpl_assign('project_form_data', $project_form_data);
      
      $this->setSidebar(get_template_path('submit_sidebar', 'form'));
      
      if (is_array($project_form_data)) {
        $content = trim(array_var($project_form_data, 'content'));
        if ($content == '') {
          tpl_assign('error', new Error(lang('form content required')));
          $this->render();
        } // if
        
        try {
          DB::beginWork();
          if ($in_object instanceof ProjectMessage) {
            $comment = $in_object->addComment($content, false);
            ApplicationLogs::createLog($comment, active_project(), ApplicationLogs::ACTION_ADD, $comment->isPrivate());
          } elseif ($in_object instanceof ProjectTaskList) {
            $task = $in_object->addTask($content);
            ApplicationLogs::createLog($task, active_project(), ApplicationLogs::ACTION_ADD, $in_object->isPrivate());
          } // if
          DB::commit();
          
          flash_success($project_form->getSuccessMessage());
          $this->redirectToUrl($project_form->getSubmitUrl());
        } catch(Exception $e) {
          tpl_assign('error', $e);
          DB::rollback();
        } // try
        
      } // if
    } // submit
    
    /**
    * Add new project form
    *
    * @param void
    * @return null
    */
    function add() {
      $this->setTemplate('add_project_form');
      
      if (!ProjectForm::canAdd(logged_user(), active_project())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(active_project()->getOverviewUrl());
      } // if
      
      $project_form = new ProjectForm();
      $project_form_data = array_var($_POST, 'project_form');
      if (!is_array($project_form_data)) {
        $project_form_data = array(
          'action' => ProjectForm::ADD_COMMENT_ACTION,
          'is_enabled' => true,
          'is_visible' => true,
        ); // array
      } // if
      
      tpl_assign('project_form', $project_form);
      tpl_assign('project_form_data', $project_form_data);
      
      if (is_array(array_var($_POST, 'project_form'))) {
        $project_form->setFromAttributes($project_form_data);
        
        if ($project_form->getAction() == ProjectForm::ADD_COMMENT_ACTION) {
          $in_object = ProjectMessages::findById(get_id('message_id', $project_form_data));
          $relation_error_message = lang('project form select message');
        } else {
          $in_object = ProjectTaskLists::findById(get_id('task_list_id', $project_form_data));
          $relation_error_message = lang('project form select task lists');
        } // if
        
        if (!($in_object instanceof ProjectDataObject)) {
          tpl_assign('error', new Error($relation_error_message));
          $this->render();
        } // if
        
        $project_form->setInObjectId($in_object->getObjectId()); // set related object ID
        $project_form->setProjectId(active_project()->getId());
        
        try {
          DB::beginWork();
          $project_form->save();
          ApplicationLogs::createLog($project_form, active_project(), ApplicationLogs::ACTION_ADD, true);
          DB::commit();
          
          flash_success(lang('success add project form', $project_form->getName()));
          $this->redirectTo('form');
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      } // if
      
    } // add
    
    /**
    * Edit existing project form
    *
    * @param void
    * @return null
    */
    function edit() {
      $this->setTemplate('add_project_form');
      
      $project_form = ProjectForms::findById(get_id());
      if (!($project_form instanceof ProjectForm)) {
        flash_error(lang('project form dnx'));
        if (ProjectForm::canAdd(logged_user(), active_project())) {
          $this->redirectTo('form');
        } else {
          $this->redirectToUrl(active_project()->getOverviewUrl());
        } // if
      } // if
      
      if (!$project_form->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        if (ProjectForm::canAdd(logged_user(), active_project())) {
          $this->redirectTo('form');
        } else {
          $this->redirectToUrl(active_project()->getOverviewUrl());
        } // if
      } // if
      
      $project_form_data = array_var($_POST, 'project_form');
      if (!is_array($project_form_data)) {
        $project_form_data = array(
          'name' => $project_form->getName(),
          'description' => $project_form->getDescription(),
          'success_message' => $project_form->getSuccessMessage(),
          'action' => $project_form->getAction(),
          'is_enabled' => $project_form->getIsEnabled(),
          'is_visible' => $project_form->getIsVisible(),
        ); // array
        if ($project_form->getAction() == ProjectForm::ADD_COMMENT_ACTION) {
          $project_form_data['message_id'] = $project_form->getInObjectId();
        } else {
          $project_form_data['task_list_id'] = $project_form->getInObjectId();
        } // if
      } // if
      
      tpl_assign('project_form', $project_form);
      tpl_assign('project_form_data', $project_form_data);
      
      if (is_array(array_var($_POST, 'project_form'))) {
        $project_form->setFromAttributes($project_form_data);
        
        if ($project_form->getAction() == ProjectForm::ADD_COMMENT_ACTION) {
          $in_object = ProjectMessages::findById(get_id('message_id', $project_form_data));
          $relation_error_message = lang('project form select message');
        } else {
          $in_object = ProjectTaskLists::findById(get_id('task_list_id', $project_form_data));
          $relation_error_message = lang('project form select task lists');
        } // if
        
        if (!($in_object instanceof ProjectDataObject)) {
          tpl_assign('error', new Error($relation_error_message));
          $this->render();
        } // if
        
        $project_form->setInObjectId($in_object->getObjectId()); // set related object ID
        
        try {
          DB::beginWork();
          $project_form->save();
          ApplicationLogs::createLog($project_form, active_project(), ApplicationLogs::ACTION_EDIT, true);
          DB::commit();
          
          flash_success(lang('success edit project form', $project_form->getName()));
          $this->redirectTo('form');
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      } // if
    } // edit
    
    /**
    * Delete specific project form
    *
    * @param void
    * @return null
    */
    function delete() {
      $project_form = ProjectForms::findById(get_id());
      if (!($project_form instanceof ProjectForm)) {
        flash_error(lang('project form dnx'));
        if (ProjectForm::canAdd(logged_user(), active_project())) {
          $this->redirectTo('form');
        } else {
          $this->redirectToUrl(active_project()->getOverviewUrl());
        } // if
      } // if
      
      if (!$project_form->canDelete(logged_user())) {
        flash_error(lang('no access permissions'));
        if (ProjectForm::canAdd(logged_user(), active_project())) {
          $this->redirectTo('form');
        } else {
          $this->redirectToUrl(active_project()->getOverviewUrl());
        } // if
      } // if
      
      if ($project_form->delete()) {
        ApplicationLogs::createLog($project_form, active_project(), ApplicationLogs::ACTION_DELETE, true);
        flash_success(lang('success delete project form', $project_form->getName()));
      } else {
        flash_error(lang('error delete project form'));
      } // if
      $this->redirectTo('form');
    } // delete
  
  } // FormController

?>