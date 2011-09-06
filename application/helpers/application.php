<?php

  /**
  * Application helpers. This helpers are injected into the controllers
  * through ApplicationController constructio so they are available in
  * whole application
  *
  * @http://www.projectpier.org/
  */
  
  /**
  * Render user box
  *
  * @param User $user
  * @return null
  */
  function render_user_box(User $user) {
    tpl_assign('_userbox_user', $user);
    tpl_assign('_userbox_projects', $user->getActiveProjects());
    return tpl_fetch(get_template_path('user_box', 'application'));
  } // render_user_box
  
  /**
  * This function will render system notices for this user
  *
  * @param User $user
  * @return string
  */
  function render_system_notices(User $user) {
    if (!$user->isAdministrator()) {
      return;
    }
    
    $system_notices = array();
    if (config_option('upgrade_check_enabled', false) && config_option('upgrade_last_check_new_version', false)) {
      $system_notices[] = lang('new version available', get_url('administration', 'upgrade'));
    }
    
    if (count($system_notices)) {
      tpl_assign('_system_notices', $system_notices);
      return tpl_fetch(get_template_path('system_notices', 'application'));
    } // if
  } // render_system_notices
  
  /**
  * Render select company box
  *
  * @param integer $selected ID of selected company
  * @param array $attributes Additional attributes
  * @return string
  */
  function select_company($name, $selected = null, $attributes = null) {
    $companies = Companies::getAll();
    $options = array(option_tag(lang('none'), 0));
    if (is_array($companies)) {
      foreach ($companies as $company) {
        $option_attributes = $company->getId() == $selected ? array('selected' => 'selected') : null;
        $company_name = $company->getName();
        if ($company->isOwner()) {
          $company_name .= ' (' . lang('owner company') . ')';
        }
        $options[] = option_tag($company_name, $company->getId(), $option_attributes);
      } // foreach
    } // if
    return select_box($name, $options, $attributes);
  } // select_company

  /**
  * Renders select project box
  *
  * @param string $name
  * @param Project $project
  * @param integer $selected ID of selected milestone
  * @param array $attributes Array of additional attributes
  * @return string
  * @throws InvalidInstanceError
  */
  function select_project($name, $projectname = null, $selected = null, $attributes = null) {
    if (is_array($attributes)) {
      if (!isset($attributes['class'])) {
        $attributes['class'] = 'select_project';
      }
    } else {
      $attributes = array('class' => 'select_project');
    } // if
    
    $options = array(option_tag(lang('none'), 0));
    if (is_null($projectname)) {
      $projects = Projects::getAll();
    } else {
      $projects = Projects::getAll();
    }
    if (is_array($projects)) {
      foreach ($projects as $project) {
        $option_attributes = $project->getId() == $selected ? array('selected' => 'selected') : null;
        $options[] = option_tag($project->getName(), $project->getId(), $option_attributes);
      } // foreach
    } // if
    
    return select_box($name, $options, $attributes);
  } // select_milestone
    
  /**
  * Render assign to SELECT
  *
  * @param string $list_name Name of the select control
  * @param Project $project Selected project, if NULL active project will be used
  * @param integer $selected ID of selected user
  * @param array $attributes Array of select box attributes, if needed
  * @return null
  */
  function assign_to_select_box($list_name, $project = null, $selected = null, $attributes = null) {
    if (is_null($project)) {
      $project = active_project();
    } // if
    if (!($project instanceof Project)) {
      throw new InvalidInstanceError('$project', $project, 'Project');
    } // if
    
    $logged_user = logged_user();
    
    $can_assign_to_owners = $logged_user->isMemberOfOwnerCompany() || $logged_user->getProjectPermission($project, PermissionManager::CAN_ASSIGN_TO_OWNERS);
    $can_assign_to_other = $logged_user->isMemberOfOwnerCompany() || $logged_user->getProjectPermission($project, PermissionManager::CAN_ASSIGN_TO_OTHER);
    
    $grouped_users = $project->getUsers(true);
    
    $options = array(option_tag(lang('anyone'), '0:0'));
    if (is_array($grouped_users) && count($grouped_users)) {
      foreach ($grouped_users as $company_id => $users) {
        $company = Companies::findById($company_id);
        if (!($company instanceof Company)) {
          continue;
        } // if
        
        // Check if $logged_user can assign task to members of this company
        if ($company_id <> $logged_user->getCompanyId()) {
          if ($company->isOwner()) {
            if (!$can_assign_to_owners) {
              continue;
            } // if
          } else {
            if (!$can_assign_to_other) {
              continue;
            } // if
          } // if
        } // if
        
        $options[] = option_tag('--', '0:0'); // separator
        
        $option_attributes = $company->getId() . ':0' == $selected ? array('selected' => 'selected') : null;
        $options[] = option_tag($company->getName(), $company_id . ':0', $option_attributes);
        
        if (is_array($users)) {
          foreach ($users as $user) {
            $option_attributes = $company_id . ':' . $user->getId() == $selected ? array('selected' => 'selected') : null;
            $options[] = option_tag($company->getName() . ': ' . $user->getDisplayName(), $company_id . ':' . $user->getId(), $option_attributes);
          } // foreach
        } // if
        
      } // foreach
    } // if
    
    return select_box($list_name, $options, $attributes);
  } // assign_to_select_box
  
  /**
  * Renders select milestone box
  *
  * @param string $name
  * @param Project $project
  * @param integer $selected ID of selected milestone
  * @param array $attributes Array of additional attributes
  * @return string
  * @throws InvalidInstanceError
  */
  function select_milestone($name, $project = null, $selected = null, $attributes = null) {
    if (is_null($project)) {
      $project = active_project();
    }
    if (!($project instanceof Project)) {
      throw new InvalidInstanceError('$project', $project, 'Project');
    }
    
    if (is_array($attributes)) {
      if (!isset($attributes['class'])) {
        $attributes['class'] = 'select_milestone';
      }
    } else {
      $attributes = array('class' => 'select_milestone');
    } // if
    
    $options = array(option_tag(lang('none'), 0));
    $milestones = $project->getOpenMilestones();
    if (is_array($milestones)) {
      foreach ($milestones as $milestone) {
        $option_attributes = $milestone->getId() == $selected ? array('selected' => 'selected') : null;
        $options[] = option_tag($milestone->getName(), $milestone->getId(), $option_attributes);
      } // foreach
    } // if
    
    return select_box($name, $options, $attributes);
  } // select_milestone
  
  /**
  * Render select task list box
  *
  * @param string $name Form control name
  * @param Project $project
  * @param integer $selected ID of selected object
  * @param boolean $open_only List only active task lists (skip completed)
  * @param array $attach_data Additional attributes
  * @return string
  */
  function select_task_list($name, $project = null, $selected = null, $open_only = false, $attributes = null) {
    if (is_null($project)) {
      $project = active_project();
    }
    if (!($project instanceof Project)) {
      throw new InvalidInstanceError('$project', $project, 'Project');
    }
    
    if (is_array($attributes)) {
      if (!isset($attributes['class'])) {
        $attributes['class'] = 'select_task_list';
      }
    } else {
      $attributes = array('class' => 'select_task_list');
    } // if
    
    $options = array(option_tag(lang('none'), 0));
    $task_lists = $open_only ? $project->getOpenTaskLists() : $project->getTaskLists();
    if (is_array($task_lists)) {
      foreach ($task_lists as $task_list) {
        $option_attributes = $task_list->getId() == $selected ? array('selected' => 'selected') : null;
        $options[] = option_tag($task_list->getName(), $task_list->getId(), $option_attributes);
      } // foreach
    } // if
    
    return select_box($name, $options, $attributes);
  } // select_task_list
  
  /**
  * Return select message control
  *
  * @param string $name Control name
  * @param Project $project
  * @param integer $selected ID of selected message
  * @param array $attributes Additional attributes
  * @return string
  */
  function select_message($name, $project = null, $selected = null, $attributes = null) {
    if (is_null($project)) {
      $project = active_project();
    }
    if (!($project instanceof Project)) {
      throw new InvalidInstanceError('$project', $project, 'Project');
    }
    
    if (is_array($attributes)) {
      if (!isset($attributes['class'])) {
        $attributes['class'] = 'select_message';
      }
    } else {
      $attributes = array('class' => 'select_message');
    } // if
    
    $options = array(option_tag(lang('none'), 0));
    $messages = $project->getMessages();
    if (is_array($messages)) {
      foreach ($messages as $messages) {
        $option_attributes = $messages->getId() == $selected ? array('selected' => 'selected') : null;
        $options[] = option_tag($messages->getTitle(), $messages->getId(), $option_attributes);
      } // foreach
    } // if
    
    return select_box($name, $options, $attributes);
  } // select_message
  
  /**
  * Select a single project file
  *
  * @param string $name Control name
  * @param Project $project
  * @param integer $selected ID of selected file
  * @param array $exclude_files Array of IDs of files that need to be excluded (already attached to object etc)
  * @param array $attributes
  * @return string
  */
  function select_project_file($name, $project = null, $selected = null, $exclude_files = null, $attributes = null) {
    if (is_null($project)) {
      $project = active_project();
    } // if
    if (!($project instanceof Project)) {
      throw new InvalidInstanceError('$project', $project, 'Project');
    } // if
    
    $all_options = array(option_tag(lang('none'), 0)); // array of options
    
    $folders = $project->getFolders();
    if (is_array($folders)) {
      foreach ($folders as $folder) {
        $files = $folder->getFiles();
        if (is_array($files)) {
          $options = array();
          foreach ($files as $file) {
            if (is_array($exclude_files) && in_array($file->getId(), $exclude_files)) {
              continue;
            }
            
            $option_attrbutes = $file->getId() == $selected ? array('selected' => true) : null;
            $options[] = option_tag($file->getFilename(), $file->getId(), $option_attrbutes);
          } // if
          
          if (count($options)) {
            $all_options[] = option_tag('', 0); // separator
            $all_options[] = option_group_tag($folder->getName(), $options);
          } // if
        } // if
      } // foreach
    } // if
    
    $orphaned_files = $project->getOrphanedFiles();
    if (is_array($orphaned_files)) {
      $all_options[] = option_tag('', 0); // separator
      foreach ($orphaned_files as $file) {
        if (is_array($exclude_files) && in_array($file->getId(), $exclude_files)) {
          continue;
        }
        
        $option_attrbutes = $file->getId() == $selected ? array('selected' => true) : null;
        $all_options[] = option_tag($file->getFilename(), $file->getId(), $option_attrbutes);
      } // foreach
    } // if
    
    return select_box($name, $all_options, $attributes);
  } // select_project_file
  
  /**
  * Return project object tags widget
  *
  * @param string $name
  * @param Project $project
  * @param string $value
  * @Param array $attributes Array of control attributes
  * @return string
  */
  function project_object_tags_widget($name, Project $project, $value, $attributes) {
    return text_field($name, $value, $attributes) . '<br /><span class="desc">' . lang('tags widget description') . '</span>';
  } // project_object_tag_widget
  
  /**
  * Render comma separated tags of specific object that link on project tag page
  *
  * @param ProjectDataObject $object
  * @param Project $project
  * @return string
  */
  function project_object_tags(ProjectDataObject $object, Project $project) {
    $tag_names = $object->getTagNames();
    if (!is_array($tag_names) || !count($tag_names)) {
      return '--';
    }

    $links = array();
    foreach ($tag_names as $tag_name) {
      $links[] = '<a href="' . $project->getTagUrl($tag_name) . '">' . clean($tag_name) . '</a>';
    } // foreach
    return implode(', ', $links);
  } // project_object_tags
  
  /**
  * Show object comments block
  *
  * @param ProjectDataObject $object Show comments of this object
  * @return null
  */
  function render_object_comments(ProjectDataObject $object) {
    if (!$object->isCommentable()) {
      return '';
    }
    tpl_assign('__comments_object', $object);
    return tpl_fetch(get_template_path('object_comments', 'comment'));
  } // render_object_comments
  
  /**
  * Render post comment form for specific project object
  *
  * @param ProjectDataObject $object
  * @param string $redirect_to
  * @return string
  */
  function render_comment_form(ProjectDataObject $object) {
    $comment = new Comment();
    
    tpl_assign('comment_form_comment', $comment);
    tpl_assign('comment_form_object', $object);
    return tpl_fetch(get_template_path('post_comment_form', 'comment'));
  } // render_post_comment_form
  
  /**
  * This function will render the code for file attachment section of the form. Note that 
  * this need to be part of the existing form
  *
  * @param string $prefix File input name prefix
  * @param integer $max_controls Max number of controls
  * @return string
  */
  function render_attach_files($prefix = 'attach_files', $max_controls = 5) {
    static $ids = array();
    static $js_included = false;
    
    $attach_files_id = 0;
    do {
      $attach_files_id++;
    } while (in_array($attach_files_id, $ids));
    
    $old_js_included = $js_included;
    $js_included = true;
    
    tpl_assign('attach_files_js_included', $old_js_included);
    tpl_assign('attach_files_id', $attach_files_id);
    tpl_assign('attach_files_prefix', $prefix);
    tpl_assign('attach_files_max_controls', (integer) $max_controls);
    return tpl_fetch(get_template_path('attach_files', 'files'));
  } // render_attach_files
  
  /**
  * List all fields attached to specific object
  *
  * @param ProjectDataObject $object
  * @param boolean $can_remove Logged user can remove attached files
  * @return string
  */
  function render_object_files(ProjectDataObject $object, $can_remove = false) {
    if (function_exists('files_activate')) {
      tpl_assign('attached_files_object', $object);
      tpl_assign('attached_files', $object->getAttachedFiles());
      return tpl_fetch(get_template_path('list_attached_files', 'files'));
    }
    return '';
  } // render_object_files
  
  /**
  * Render application logs
  * 
  * This helper will render array of log entries. Options array of is array of template options and it can have this 
  * fields:
  * 
  * - show_project_column - When we are on project dashboard we don't actually need to display project column because 
  *   all entries are related with current project. That is not the situation on dashboard so we want to have the 
  *   control over this. This option is true by default
  *
  * @param array $log_entries
  * @return null
  */
  function render_application_logs($log_entries, $options = null) {
    tpl_assign('application_logs_entries', $log_entries);
    tpl_assign('application_logs_show_project_column', array_var($options, 'show_project_column', true));
    return tpl_fetch(get_template_path('render_application_logs', 'application'));
  } // render_application_logs

  /**
  * Render one project's application logs
  * 
  * This helper will render array of log entries.
  *
  * @param array $project The project.
  * @param array $log_entries An array of entries for this project.
  * @return null
  */
  function render_project_application_logs($project, $log_entries) {
    tpl_assign('application_logs_project', $project);
    tpl_assign('application_logs_entries', $log_entries);
    return tpl_fetch(get_template_path('render_project_application_logs', 'application'));
  } // render_application_logs

  /**
  * Render text that says when action was taken and by who
  *
  * @param ApplicationLog $application_log_entry
  * @return string
  */
  function render_action_taken_on_by(ApplicationLog $application_log_entry) {
    if ($application_log_entry->isToday()) { 
      $result = lang('today') . ' ' . clean(format_time($application_log_entry->getCreatedOn()));
    } elseif ($application_log_entry->isYesterday()) { 
      $result =  lang('yesterday') . ' ' . clean(format_time($application_log_entry->getCreatedOn()));
    } else { 
      $result =  clean(format_date($application_log_entry->getCreatedOn()));
    } // if
    $result = "<span class=\"desc\">$result</span></td><td>";
    
    $taken_by = $application_log_entry->getTakenBy();
    return $taken_by instanceof User ? $result . '<a href="' . $taken_by->getCardUrl() . '">' . clean($taken_by->getDisplayName()) . '</a>' : $result;
  } // render_action_taken_on

?>
