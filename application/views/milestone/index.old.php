<?php

  set_page_title(lang('milestones'));
  project_tabbed_navigation(PROJECT_TAB_MILESTONES);
  project_crumbs(array(
    array(lang('milestones'), get_url('milestone', 'index')),
    array(lang('index'))
  ));
  if (ProjectMilestone::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add milestone'), get_url('milestone', 'add'));
  } // if
  add_page_action(lang('view calendar'), get_url('milestone', 'calendar'));

?>
<?php if ($late_milestones || $today_milestones || $upcoming_milestones) { ?>
<div id="milestones">
<?php if (is_array($late_milestones) && count($late_milestones)) { ?>
  <div id="lateMilestones">
  <h2><?php echo lang('late milestones') ?></h2>
<?php 
  foreach ($late_milestones as $milestone) {
    $this->assign('milestone', $milestone);
    $this->includeTemplate(get_template_path('view_milestone', 'milestone'));
  } // foreach 
?>
  </div>
<?php } // if ?>

<?php if (is_array($today_milestones) && count($today_milestones)) { ?>
  <div id="todayMilestones">
  <h2><?php echo lang('today milestones') ?></h2>
<?php 
  foreach ($today_milestones as $milestone) {
    $this->assign('milestone', $milestone);
    $this->includeTemplate(get_template_path('view_milestone', 'milestone'));
  } // foreach 
?>
  </div>
<?php } // if ?>

<?php if (is_array($upcoming_milestones) && count($upcoming_milestones)) { ?>
  <div id="upcomingMilestones">
  <h2><?php echo lang('upcoming milestones') ?></h2>
<?php 
  foreach ($upcoming_milestones as $milestone) {
    $this->assign('milestone', $milestone);
    $this->includeTemplate(get_template_path('view_milestone', 'milestone'));
  } // foreach 
?>
  </div>
<?php } // if ?>
</div>
<?php } else { ?>
<p><?php echo clean(lang('no active milestones in project')) ?></p>
<?php } // if ?>
