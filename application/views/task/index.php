<?php

  set_page_title(lang('tasks'));
  project_tabbed_navigation(PROJECT_TAB_TASKS);
  project_crumbs(array(
    array(lang('tasks'), get_url('task')),
    array(lang('index'))
  ));
  if (ProjectTaskList::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add task list'), get_url('task', 'add_list'));
  } // if
  //add_javascript_to_page('task_related.js');

?>
<script type="text/javascript" src="<?php echo get_javascript_url('modules/addTaskForm.js') ?>"></script>
<?php if (isset($open_task_lists) && is_array($open_task_lists) && count($open_task_lists)) { ?>
<div id="openTaskLists">
<?php 
  foreach ($open_task_lists as $task_list) {
    $this->assign('task_list', $task_list);
    $this->assign('on_list_page', false);
    $this->includeTemplate(get_template_path('task_list', 'task'));
  } // foreach
?>
</div>
<script type="text/javascript">
  App.modules.addTaskForm.hideAllAddTaskForms();
</script>
<?php } else { ?>
<p><?php echo lang('no open task lists in project') ?></p>
<?php } // if ?>
