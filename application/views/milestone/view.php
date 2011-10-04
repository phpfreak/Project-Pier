<?php

  set_page_title($milestone->getName());
  project_tabbed_navigation('milestones');
  project_crumbs(array(
    array(lang('milestones'), get_url('milestone', 'index')),
    array($milestone->getName())
  ));
  
  if (!$milestone->isCompleted()) {
    if (ProjectMessage::canAdd(logged_user(), $milestone->getProject())) {
      add_page_action(lang('add message'), $milestone->getAddMessageUrl());
    } // if
    if (ProjectTaskList::canAdd(logged_user(), $milestone->getProject())) {
      add_page_action(lang('add task list'), $milestone->getAddTaskListUrl());
    } //if
  } // if

?>
<div id="milestones">
<?php $this->includeTemplate(get_template_path('view_milestone', 'milestone')) ?>
</div>