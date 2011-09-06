<?php 

  if ($project->isNew()) {
    set_page_title(lang('add project'));
    dashboard_tabbed_navigation();
    project_crumbs(lang('add project'));
  } else {
    set_page_title(lang('edit project'));
    project_crumbs(lang('edit project'));
    $this->includeTemplate(get_template_path('project/pageactions'));
  } // if
  
?>
<?php if ($project->isNew()) { ?>
<form action="<?php echo get_url('project', 'add') ?>" method="post">
<?php } else { ?>
<form action="<?php echo $project->getEditUrl() ?>" method="post">
<?php } // if ?>

<?php tpl_display(get_template_path('form_errors')) ?>

  <div>
    <?php echo label_tag(lang('name'), 'projectFormName', true) ?>
    <?php echo text_field('project[name]', array_var($project_data, 'name'), array('class' => 'long', 'id' => 'projectFormName')) ?>
  </div>

  <div>
    <?php echo label_tag(lang('parent project'), 'projectSource', true) ?>
    <?php echo select_project('project[parent_id]', '', array_var($project_data, 'parent_id'), array('id' => 'projectFormParentId')) ?>
  </div>

  <div>
    <?php echo label_tag(lang('priority'), 'projectFormPriority') ?>
    <?php echo input_field('project[priority]', array_var($project_data, 'priority'), array('class' => 'short', 'id' => 'projectFormPriority')) ?>
  </div>
    
  <div>
    <?php echo label_tag(lang('description'), 'projectFormDescription') ?>
    <?php echo textarea_field('project[description]', array_var($project_data, 'description'), array('id' => 'projectFormDescription')) ?>
  </div>
  
  <div>
    <?php echo label_tag(lang('show project desciption in overview')) ?>
    <?php echo yes_no_widget('project[show_description_in_overview]', 'projectFormShowDescriptionInOverview', array_var($project_data, 'show_description_in_overview'), lang('yes'), lang('no')) ?>
  </div>
<?php if ($project->isNew() && (config_option('enable_efqm')=='yes')) { ?>
  <div>
    <?php echo label_tag(lang('efqm project')) ?>
    <?php echo yes_no_widget('project[efqm_project]', 'projectFormEfqmProject', array_var($project_data, 'efqm_project'), lang('yes'), lang('no')) ?>
  </div>
<?php } // if ?>
  
  <?php echo submit_button($project->isNew() ? lang('add project') : lang('edit project')) ?> <a href="<?php echo $project->getOverviewUrl() ?>"><?php echo lang('cancel') ?></a>
</form>
