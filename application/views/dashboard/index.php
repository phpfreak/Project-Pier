<?php 

  // Set page title and set crumbs to index
  set_page_title(lang('dashboard'));
  dashboard_tabbed_navigation();
  dashboard_crumbs(lang('overview'));
  
  if (Project::canAdd(logged_user())) {
    add_page_action(lang('add project'), get_url('project', 'add'));
  } // if
  
  add_stylesheet_to_page('project/project_log.css');

?>
<?php if (logged_user()->isMemberOfOwnerCompany() && !owner_company()->getHideWelcomeInfo()) { ?>
<div class="hint">

  <div class="header"><?php echo lang('welcome to new account') ?></div>
  <div class="content"><?php echo lang('welcome to new account info', clean(logged_user()->getDisplayName()), ROOT_URL) ?></div>
  
<?php if (owner_company()->isInfoUpdated()) { ?>
  <div class="header"><del><?php echo lang('new account step1') ?></del></div>
  <div class="content"><del><?php echo lang('new account step1 info', get_url('company', 'edit')) ?></del></div>
<?php } else { ?>
  <div class="header"><?php echo lang('new account step1') ?></div>
  <div class="content"><?php echo lang('new account step1 info', get_url('company', 'edit')) ?></div>
<?php } // if ?>
  
<?php if (owner_company()->countUsers() > 1) { ?>
  <div class="header"><del><?php echo lang('new account step2') ?></del></div>
  <div class="content"><del><?php echo lang('new account step2 info', owner_company()->getAddUserUrl()) ?></del></div>
<?php } else { ?>
  <div class="header"><?php echo lang('new account step2') ?></div>
  <div class="content"><?php echo lang('new account step2 info', owner_company()->getAddUserUrl()) ?></div>
<?php } // if?>
  
<?php if (owner_company()->countClientCompanies() > 0) { ?>
  <div class="header"><del><?php echo lang('new account step3') ?></del></div>
  <div class="content"><del><?php echo lang('new account step3 info', get_url('company', 'add_client')) ?></del></div>
<?php } else { ?>
  <div class="header"><?php echo lang('new account step3') ?></div>
  <div class="content"><?php echo lang('new account step3 info', get_url('company', 'add_client')) ?></div>
<?php } // if ?>
  
<?php if (owner_company()->countProjects() > 0) { ?>
  <div class="header"><del><?php echo lang('new account step4') ?></del></div>
  <div class="content"><del><?php echo lang('new account step4 info', get_url('project', 'add')) ?></del></div>
<?php } else { ?>
  <div class="header"><?php echo lang('new account step4') ?></div>
  <div class="content"><?php echo lang('new account step4 info', get_url('project', 'add')) ?></div>
<?php } // if?>
  
  <p><a href="<?php echo get_url('company', 'hide_welcome_info') ?>"><?php echo lang('hide welcome info') ?></a></p>
  
</div>
<?php } // if ?>

<?php if ((isset($today_milestones) && is_array($today_milestones) && count($today_milestones)) || (isset($late_milestones) && is_array($late_milestones) && count($late_milestones))) { ?>
<div id="lateOrTodayMilestones" class="important">
<?php if (isset($late_milestones) && is_array($late_milestones) && count($late_milestones)) { ?>
  <div class="header"><?php echo lang('late milestones') ?></div>
  <ul>
<?php foreach ($late_milestones as $milestone) { ?>
<?php if ($milestone->getAssignedTo() instanceof ApplicationDataObject) { ?>
    <li><?php echo clean($milestone->getAssignedTo()->getObjectName()) ?>: <a href="<?php echo $milestone->getViewUrl() ?>"><?php echo clean($milestone->getName()) ?></a> <?php echo strtolower(lang('in')) ?> <a href="<?php echo $milestone->getProject()->getOverviewUrl() ?>"><?php echo clean($milestone->getProject()->getName()) ?></a> (<?php echo lang('days late', $milestone->getLateInDays()) ?>)</li>
<?php } else { ?>
    <li><a href="<?php echo $milestone->getViewUrl() ?>"><?php echo clean($milestone->getName()) ?></a> <?php echo strtolower(lang('in')) ?> <a href="<?php echo $milestone->getProject()->getOverviewUrl() ?>"><?php echo clean($milestone->getProject()->getName()) ?></a> (<?php echo lang('days late', $milestone->getLateInDays()) ?>)</li>
<?php } // if ?>
<?php } // foreach ?>
  </ul>
<?php } // if ?>

<?php if (isset($today_milestones) && is_array($today_milestones) && count($today_milestones)) { ?>
  <div class="header"><?php echo lang('today') ?></div>
  <ul>
<?php foreach ($today_milestones as $milestone) { ?>
<?php if ($milestone->getAssignedTo() instanceof ApplicationDataObject) { ?>
    <li><?php echo clean($milestone->getAssignedTo()->getObjectName()) ?>: <a href="<?php echo $milestone->getViewUrl() ?>"><?php echo clean($milestone->getName()) ?></a> <?php echo strtolower(lang('in')) ?> <a href="<?php echo $milestone->getProject()->getOverviewUrl() ?>"><?php echo clean($milestone->getProject()->getName()) ?></a></li>
<?php } else { ?>
    <li><a href="<?php echo $milestone->getViewUrl() ?>"><?php echo clean($milestone->getName()) ?></a> <?php echo strtolower(lang('in')) ?> <a href="<?php echo $milestone->getProject()->getOverviewUrl() ?>"><?php echo clean($milestone->getProject()->getName()) ?></a></li>
<?php } // if ?>
<?php } // foreach ?>
  </ul>
<?php } // if ?>
</div>
<?php } // if ?>

<?php if (isset($activity_log) && is_array($activity_log) && count($activity_log)) { ?>
<?php echo render_application_logs($activity_log, array('show_project_column' => true)) ?>
<?php } else { ?>
<?php echo lang('no recent activities') ?>
<?php } // if ?>
