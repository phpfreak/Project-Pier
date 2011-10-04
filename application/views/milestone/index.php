<?php

  set_page_title(lang('milestones'));
  project_tabbed_navigation('milestones');
  project_crumbs(array(
    array(lang('milestones'), get_url('milestone', 'index')),
    array(lang('index'))
  ));
  if (ProjectMilestone::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add milestone'), get_url('milestone', 'add'));
  } // if
  $view_image = $view_type=="list" ? "icons/list_on.png" : "icons/list_off.png";
  add_view_option(lang('list'), get_image_url( $view_image ), get_url('milestone', 'index', array("view" => "list") ));
  $view_image = $view_type=="card" ? "icons/excerpt_on.png" : "icons/excerpt_off.png";
  add_view_option(lang('card'), get_image_url( $view_image ), get_url('milestone', 'index', array("view" => "details") ) );
  add_view_option(lang('calendar'), get_image_url( "icons/calendar_off.png" ), get_url('milestone', 'calendar'));
?>
<?php if ($all_visible_milestones) { ?>
  <div id="filter_assigned">
<?php $attributes = array( 'onchange' => 'window.location = \'' . get_url('milestone', 'index', array('assigned'=>'')) . '\'+this.value' ); ?>
<?php echo select_assignee('assignedTo', $assigned_to_milestones, $filter_assigned, $attributes); ?>
  </div>
  <div id="milestones">
<?php   if ($view_type == 'list') { ?>
    <table id="shortMilestones">
      <tr class="milestone short header"><th class="milestoneCompleted"></th><th class="milestoneDueDate"><?php echo lang('due date'); ?></th><th class="milestoneTitle"><?php echo lang('title'); ?></th><th class="milestoneDaysLeft"><?php echo lang('days') ?></th><th class="milestoneCommentsCount"><img src="<?php echo get_image_url("icons/comments.png"); ?>" title="Comments" alt="Comments"/></th></tr>
<?php
  foreach ($all_visible_milestones as $milestone) {
    $display = true;
    if ($filter_assigned>'') {
      if (is_null($milestone->getAssignedTo())) {
        $display = ($filter_assigned == 'all') || ($filter_assigned == '0:0');
      } else {
        $display = ($filter_assigned == 'all') || ($filter_assigned == $milestone->getAssignedTo()->getId());
      }
    }
    if ($display) {
      $this->assign('milestone', $milestone);
      $this->includeTemplate(get_template_path('view_milestone_short', 'milestone'));
    }
  } // foreach
?>
    </table>
<?php   } else { ?>
<?php if (is_array($late_milestones) && count($late_milestones)) { ?>
  <div id="lateMilestones">
  <h2><?php echo lang('late milestones') ?></h2>
<?php 
  foreach ($late_milestones as $milestone) {
    $display = true;
    if ($filter_assigned>='0:0') {
      if (is_null($milestone->getAssignedTo())) {
        $display = ($filter_assigned == 'all') || ($filter_assigned == '0:0');
      } else {
        $display = ($filter_assigned == 'all') || ($filter_assigned == $milestone->getAssignedTo()->getId());
      }
    }
    if ($display) {
      $this->assign('milestone', $milestone);
      $this->includeTemplate(get_template_path('view_milestone', 'milestone'));
    }
  } // foreach 
?>
  </div>
<?php } // if ?>

<?php if (is_array($today_milestones) && count($today_milestones)) { ?>
  <div id="todayMilestones">
  <h2><?php echo lang('today milestones') ?></h2>
<?php 
  foreach ($today_milestones as $milestone) {
    $display = true;
    if ($filter_assigned>='0:0') {
      if (is_null($milestone->getAssignedTo())) {
        $display = ($filter_assigned == 'all') || ($filter_assigned == '0:0');
      } else {
        $display = ($filter_assigned == 'all') || ($filter_assigned == $milestone->getAssignedTo()->getId());
      }
    }
    if ($display) {
      $this->assign('milestone', $milestone);
      $this->includeTemplate(get_template_path('view_milestone', 'milestone'));
    }
  } // foreach 
?>
  </div>
<?php } // if ?>

<?php if (is_array($upcoming_milestones) && count($upcoming_milestones)) { ?>
  <div id="upcomingMilestones">
  <h2><?php echo lang('upcoming milestones') ?></h2>
<?php 
  foreach ($upcoming_milestones as $milestone) {
    $display = true;
    if ($filter_assigned>='0:0') {
      if (is_null($milestone->getAssignedTo())) {
        $display = ($filter_assigned == 'all') || ($filter_assigned == '0:0');
      } else {
        $display = ($filter_assigned == 'all') || ($filter_assigned == $milestone->getAssignedTo()->getId());
      }
    }
    if ($display) {
      $this->assign('milestone', $milestone);
      $this->includeTemplate(get_template_path('view_milestone', 'milestone'));
    }
  } // foreach 
?>
  </div>
<?php } // if ?>

<?php if (is_array($completed_milestones) && count($completed_milestones)) { ?>
  <div id="completedMilestones">
  <h2><?php echo lang('completed milestones') ?></h2>
<?php 
  foreach ($completed_milestones as $milestone) {
    $display = true;
    if ($filter_assigned>='0:0') {
      if (is_null($milestone->getAssignedTo())) {
        $display = ($filter_assigned == 'all') || ($filter_assigned == '0:0');
      } else {
        $display = ($filter_assigned == 'all') || ($filter_assigned == $milestone->getAssignedTo()->getId());
      }
    }
    if ($display) {
      $this->assign('milestone', $milestone);
      $this->includeTemplate(get_template_path('view_milestone', 'milestone'));
    }
  } // foreach 
?>
  </div>
<?php } // if ?>

<?php   } ?>
</div>
<?php } else { ?>
<p><?php echo clean(lang('no active milestones in project')) ?></p>
<?php } // if ?>