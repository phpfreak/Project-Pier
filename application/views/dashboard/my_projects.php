<?php 

  set_page_title(lang('my projects'));
  dashboard_tabbed_navigation(DASHBOARD_TAB_MY_PROJECTS);
  dashboard_crumbs(lang('my projects'));
  
  if (Project::canAdd(logged_user())) {
    add_page_action(lang('add project'), get_url('project', 'add'));
  } // if

?>
<?php if (isset($active_projects) && is_array($active_projects) && count($active_projects)) { ?>
<?php foreach ($active_projects as $project) { ?>
<div class="block">
  <div class="header"><h2><a href="<?php echo $project->getOverviewUrl() ?>"><?php echo clean($project->getName()) ?></a></h2></div>
  <div class="content">
<?php if (trim($project->getDescription())) { ?>
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
