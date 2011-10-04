<?php
  trace(__FILE__,"set_page_title(lang('overview')");
  set_page_title(lang('overview'));
  trace(__FILE__,"project_crumbs(lang('overview'))");
  project_crumbs(lang('overview'));
  add_stylesheet_to_page('project/project_log.css');
  trace(__FILE__,'stylesheet added');
?>
<?php $this->includeTemplate(get_template_path('project/pageactions')); ?>
<?php if (active_project()->getParent()) { ?>
  <div class="block">
  <div class="header parent">
    <?php echo lang('parent project') ?>: <a href="<?php echo active_project()->getParent()->getOverviewUrl() ?>"><?php echo clean(active_project()->getParent()->getName()) ?></a>
 </div>
 </div>
<?php } // if ?>
<?php if (trim(active_project()->getDescription()) && active_project()->getShowDescriptionInOverview()) { ?>
<div id="project">
<?php $show_icon = (config_option('files_show_icons', '1') == '1'); ?>
<?php if ($show_icon) { ?>
 <div class="icon"><img src="<?php echo active_project()->getLogoUrl() ?>" alt="<?php echo active_project()->getName() ?>" /></div>
<?php } // if ?>
 <div class="block hint">
<?php $this->includeTemplate(get_template_path('view_progressbar', 'project')); ?>
  <div class="header"><?php echo clean(active_project()->getName()) ?></div>
  <div class="content"><?php echo plugin_manager()->apply_filters('project_description', do_textile(active_project()->getDescription())) ?>
  <div class="clear"></div>
  <div id="pageAttachments">
  <?php
  if (is_array($page_attachments) && count($page_attachments)) {
    foreach ($page_attachments as $page_attachment) {
      tpl_assign('attachment', $page_attachment);
      if ($page_attachment->getRelObjectManager() != '') {
        if (file_exists(get_template_path('view_'.$page_attachment->getRelObjectManager(), 'page_attachment'))) {
          $this->includeTemplate(get_template_path('view_'.$page_attachment->getRelObjectManager(), 'page_attachment'));
        } else {
          $this->includeTemplate(get_template_path('view_DefaultObject', 'page_attachment'));
        }
      } else {
        $this->includeTemplate(get_template_path('view_EmptyAttachment', 'page_attachment'));
      }
    } // foreach
  } // if ?>
  </div></div>
 </div>
</div>
<?php } // if ?>
<div class="clear"></div>
<?php if (isset($subprojects) && is_array($subprojects) && count($subprojects)) { ?>
<div class="block">
  <div class="header"><?php echo lang('subprojects') ?></div>
  <div class="content">
    <ul>
<?php foreach ($subprojects as $subproject) { ?>
<?php tpl_assign('project', $subproject); ?>
    <li><a href="<?php echo $subproject->getOverviewUrl() ?>"><?php echo clean($subproject->getName()) ?></a> <?php $this->includeTemplate(get_template_path('view_progressbar', 'project')); ?></li>
<?php } // foreach ?>
    </ul>
  </div>
</div>
<?php } // if ?>

<?php if ($late_milestones || $today_milestones || $upcoming_milestones) { ?>
<h2><?php echo lang('milestones') ?></h2>
<?php } // if ?>

<?php if ((is_array($late_milestones) && count($late_milestones)) || (is_array($today_milestones) && count($today_milestones))) { ?>
<div id="lateMilestones" class="important block">
  <div class="header"><?php echo lang('late milestones') ?> / <?php echo lang('today milestones') ?></div>
  <div class="content">
    <ul>
<?php if (is_array($late_milestones) && count($late_milestones)) { ?>
<?php foreach ($late_milestones as $late_milestone) { ?>
<?php if ($late_milestone->getAssignedTo() instanceof ApplicationDataObject) { ?>
    <li><?php echo clean($late_milestone->getAssignedTo()->getObjectName()) ?>: <a href="<?php echo $late_milestone->getViewUrl() ?>"><?php echo clean($late_milestone->getName()) ?></a> (<?php echo format_descriptive_date($late_milestone->getDueDate()) ?> - <?php echo format_days('days late', $late_milestone->getLateInDays()) ?>)</li>
<?php } else { ?>
    <li><a href="<?php echo $late_milestone->getViewUrl() ?>"><?php echo clean($late_milestone->getName()) ?></a> (<?php echo format_descriptive_date($late_milestone->getDueDate()) ?> - <?php echo format_days('days late', $late_milestone->getLateInDays()) ?>)</li>
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
    <li><?php echo clean($upcoming_milestone->getAssignedTo()->getObjectName()) ?>: <a href="<?php echo $upcoming_milestone->getViewUrl() ?>"><?php echo clean($upcoming_milestone->getName()) ?></a> (<?php echo format_descriptive_date($upcoming_milestone->getDueDate()) ?> - <?php echo format_days('days left', $upcoming_milestone->getLeftInDays()) ?>)</li>
<?php } else { ?>
    <li><a href="<?php echo $upcoming_milestone->getViewUrl() ?>"><?php echo clean($upcoming_milestone->getName()) ?></a> (<?php echo format_descriptive_date($upcoming_milestone->getDueDate()) ?> - <?php echo format_days('days left', $upcoming_milestone->getLeftInDays()) ?>)</li>
<?php } // if ?>

<?php } else { ?>
    </ul>
    <p><a href="<?php echo active_project()->getMilestonesUrl() ?>#upcomingMilestones"> <?php echo lang('show all upcoming milestones', count($upcoming_milestones)) ?></a></p>
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
<?php trace(__FILE__,'end'); ?>