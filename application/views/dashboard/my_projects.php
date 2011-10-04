<?php 

  set_page_title(lang('my projects'));
  dashboard_tabbed_navigation(DASHBOARD_TAB_MY_PROJECTS);
  dashboard_crumbs(lang('my projects'));
  add_stylesheet_to_page('dashboard/my_projects.css');
  
  if (logged_user()->canManageProjects()) {
    add_page_action(lang('add project'), get_url('project', 'add'));
    add_page_action(lang('copy project'), get_url('project', 'copy'));
  } // if

  add_page_action(lang('order by name'), get_url('dashboard', 'my_projects_by_name'));
  add_page_action(lang('order by priority'), get_url('dashboard', 'my_projects_by_priority'));
  add_page_action(lang('order by milestone'), get_url('dashboard', 'my_projects_by_milestone'));
?>
<?php if (isset($active_projects) && is_array($active_projects) && count($active_projects)) { ?>
<?php $show_icon = (config_option('files_show_icons', '1') == '1'); ?>
<?php foreach ($active_projects as $project) { ?>
<div class="expand-container-all block">
  <div class="header">
<?php if ($show_icon) { ?>
<?php if ($project->hasLogo()) { ?>
    <div class="projectLogo"><img src="<?php echo $project->getLogoUrl() ?>" alt="<?php echo $project->getName() ?>" /></div>
<?php } // if ?>
<?php } // if ?>
<?php $this->assign('project', $project); $this->includeTemplate(get_template_path('view_progressbar', 'project')); ?>
  <h2><a href="<?php echo $project->getOverviewUrl() ?>"><?php echo clean($project->getName()) ?></a></h2>
<div style="clear:both"></div>
</div>
  <div class="content expand-block-all">
<?php if ($project->getShowDescriptionInOverview() && trim($project->getDescription())) { ?>
    <div class="description"><?php echo do_textile($project->getDescription()) ?></div>
<?php } // if ?>
<?php if (is_array($project_companies = $project->getCompanies())) { ?>
<?php 
  $project_company_names = array();
  foreach ($project_companies as $project_company) {
    $project_company_names[] = '<a href="' . $project_company->getCardUrl() . '">' . clean($project_company->getName()) . '</a>';
  } // foreach
?>
    <div class="involvedCompanies"><em><?php echo lang('companies involved in project') ?>:</em> <?php echo implode(', ', $project_company_names) ?></div>

<?php if(is_array($project_times = $project->getAllTimes())) { ?>
<?php 
  $project_time_total = 0;
  foreach($project_times as $project_time) {
    $project_time_total += $project_time->getHours();
  } // foreach
?>
    <div class="timeProject"><em><?php echo lang('time spent on project') ?>:</em> <?php echo '<a href="' . $project->getTimeReportUrl() . '">' . $project_time_total . ' ' . lang('hour(s)') . '</a>' ?></div>
<?php } ?>

<?php if ($project->getCreatedBy() instanceof User) { ?>
    <div class="startedOnBy"><em><?php echo lang('project started on') ?>:</em> <?php echo lang('started on by', format_date($project->getCreatedOn()), $project->getCreatedByCardUrl(), clean($project->getCreatedByDisplayName())) ?></div>
<?php } else { ?>
    <div class="startedOnBy"><em><?php echo lang('project started on') ?>:</em> <?php echo lang('n/a') ?></div>
<?php } // if ?>
<?php } // if ?>
  </div>
</div>
<?php } // foreach ?>
<?php } else { ?>
<p><?php echo lang('no active projects in db') ?></p>
<?php } // if ?>