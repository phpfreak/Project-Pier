<?php
  trace(__FILE__,'ProjectMessage::project_tabbed_navigation()');
  project_tabbed_navigation();
  trace(__FILE__,'ProjectMessage::canAdd');
  if (ProjectMessage::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add message'), get_url('message', 'add'));
  } // if
  trace(__FILE__,'ProjectTaskList::canAdd');
  if (ProjectTaskList::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add task list'), get_url('task', 'add_list'));
  } // if
  trace(__FILE__,'ProjectMilestone::canAdd');
  if (ProjectMilestone::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add milestone'), get_url('milestone', 'add'));
  } // if
  //trace(__FILE__,'project.canChangePermissions()');
  //if (active_project()->canChangePermissions(logged_user())) {
  //  add_page_action(lang('permissions'), get_url('project', 'permissions'));
  //} // if
  trace(__FILE__,'plugin hook');
  // PLUGIN HOOK
  plugin_manager()->do_action('project_overview_page_actions');
  // PLUGIN HOOK
  if (use_permitted(logged_user(), active_project(), 'tasks')) {
    add_page_action(lang('download task lists'), get_url('project', 'download_task_lists'));
  }
?>