<?php

  set_page_title(lang('overview'));
  project_tabbed_navigation();
  project_crumbs(lang('overview'));
  if (ProjectMessage::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add message'), get_url('message', 'add'));
  } // if
  if (ProjectTaskList::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add task list'), get_url('task', 'add_list'));
  } // if
  if (ProjectMilestone::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add milestone'), get_url('milestone', 'add'));
  } // if
  if (ProjectFile::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add file'), get_url('files', 'add_file'));
  } // if
  
  add_stylesheet_to_page('project/project_log.css');

?>
<?php if (trim(active_project()->getDescription()) && active_project()->getShowDescriptionInOverview()) { ?>
<div class="hint">
  <div class="header"><?php echo clean(active_project()->getName()) ?></div>
  <div class="content"><?php echo do_textile(active_project()->getDescription()) ?></div>
</div>
<?php } // if ?>

<?php if ($late_milestones || $today_milestones || $upcoming_milestones) { ?>
<h2><?php echo lang('milestones') ?></h2>
<?php } // if ?>

<?php if ((is_array($late_milestones) && count($late_milestones)) || (is_array($today_milestones) && count($today_milestones))) { ?>
<div id="lateMilestones" class="important">
  <div class="header"><?php echo lang('late milestones') ?> / <?php echo lang('today milestones') ?></div>
  <div class="content">
    <ul>
<?php if (is_array($late_milestones) && count($late_milestones)) { ?>
<?php foreach ($late_milestones as $late_milestone) { ?>
<?php if ($late_milestone->getAssignedTo() instanceof ApplicationDataObject) { ?>
    <li><?php echo clean($late_milestone->getAssignedTo()->getObjectName()) ?>: <a href="<?php echo $late_milestone->getViewUrl() ?>"><?php echo clean($late_milestone->getName()) ?></a> (<?php echo format_descriptive_date($late_milestone->getDueDate()) ?> - <?php echo lang('days late', $late_milestone->getLateInDays()) ?>)</li>
<?php } else { ?>
    <li><a href="<?php echo $late_milestone->getViewUrl() ?>"><?php echo clean($late_milestone->getName()) ?></a> (<?php echo format_descriptive_date($late_milestone->getDueDate()) ?> - <?php echo lang('days late', $late_milestone->getLateInDays()) ?>)</li>
<?php } // if ?>
<?php } // foreach ?>
<?php } // if ?>

<?php if (is_array($today_milestones) && count($today_milestones)) { ?>
<?php foreach ($today_milestones as $today_milestone) { ?>
<?php if ($today_milestone->getAssignedTo() instanceof ApplicationDataObject) { ?>
    <li><?php echo clean($today_milestone->getAssignedTo()->getObjectName()) ?>: <a href="<?php echo $today_milestone->getViewUrl() ?>"><?php echo clean($today_milestone->getName()) ?></a> (<?php echo lang('today') ?>)</li>
<?php } else { ?>
    <li><a href="<?php echo $today_milestone->getViewUrl() ?>"><?php echo clean($today_milestone->getName()) ?></a> (<?php echo lang('today') ?>)</li>
<?php } // if ?>
<?php } // foreach ?>
<?php } // if ?>

    </ul>
  </div>
</div>
<?php } // if ?>

<?php if (isset($upcoming_milestones) && is_array($upcoming_milestones) && count($upcoming_milestones)) { ?>
<div class="block">
  <div class="header"><?php echo lang('upcoming milestones in next 30 days') ?></div>
  <div class="content">
    <ul>
<?php foreach ($upcoming_milestones as $upcoming_milestone) { ?>

<?php if ($upcoming_milestone->getLeftInDays() <= 30) { ?>

<?php if ($upcoming_milestone->getAssignedTo() instanceof ApplicationDataObject) { ?>
    <li><?php echo clean($upcoming_milestone->getAssignedTo()->getObjectName()) ?>: <a href="<?php echo $upcoming_milestone->getViewUrl() ?>"><?php echo clean($upcoming_milestone->getName()) ?></a> (<?php echo format_descriptive_date($upcoming_milestone->getDueDate()) ?> - <?php echo lang('days left', $upcoming_milestone->getLeftInDays()) ?>)</li>
<?php } else { ?>
    <li><a href="<?php echo $upcoming_milestone->getViewUrl() ?>"><?php echo clean($upcoming_milestone->getName()) ?></a> (<?php echo format_descriptive_date($upcoming_milestone->getDueDate()) ?> - <?php echo lang('days left', $upcoming_milestone->getLeftInDays()) ?>)</li>
<?php } // if ?>

<?php } else { ?>
    </ul>
    <p><a href="<?php echo active_project()->getMilestonesUrl() ?>#upcomingMilestones">&raquo; <?php echo lang('show all upcoming milestones', count($upcoming_milestones)) ?></a></p>
<?php break; ?>
<?php } // foreach ?>

<?php } // if?>
    </ul>
  </div>
</div>
<?php } // if ?>

<h2><?php echo lang('recent activities') ?></h2>
<?php if (isset($project_log_entries) && is_array($project_log_entries) && count($project_log_entries)) { ?>
<?php echo render_application_logs($project_log_entries, array('show_project_column' => false)) ?>
<?php } else { ?>
<?php echo lang('no activities in project') ?>
<?php } // if ?>
