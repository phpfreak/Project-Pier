<?php 
  trace(__FILE__,':begin');
  set_page_title(lang('copy project'));
  dashboard_tabbed_navigation();
  trace(__FILE__,':crumbs');
  project_crumbs(lang('copy project'));
  trace(__FILE__,':build page');
?>
<form action="<?php echo get_url('project', 'copy') ?>" method="post">

<?php tpl_display(get_template_path('form_errors')) ?>

  <div>
    <?php echo label_tag(lang('projects copy source'), 'projectSource', true) ?>
    <?php echo select_project('project[source]', '', array_var($project_data, 'copy_source'), array('id' => 'projectFormSource')) ?>
  </div>

  <div>
    <?php echo label_tag(lang('projects shift dates'), 'projectFormShiftDates') ?>
    <?php echo checkbox_field('project[shift_dates]', true, array_var($project_data, 'shift_dates'), array('id' => 'projectFormShiftDates')) ?>
  </div>

  <div>
    <?php echo label_tag(lang('add days'), 'projectFormAddDaysFromNow') ?>
    <?php echo input_field('project[add_days]', array_var($project_data, 'add_days'), array('class' => 'short', 'id' => 'projectFormAddDays')) ?>
  </div>

  <div>
    <?php echo label_tag(lang('projects copy details'), 'projectFormCopyDetails') ?>
    <?php echo checkbox_field('project[copy_details]', true, array_var($project_data, 'copy_details'), array('id' => 'projectFormCopyDetails')) ?>
  </div>

  <div>
    <?php echo label_tag(lang('projects copy milestones'), 'projectFormCopyMilestones') ?>
    <?php echo checkbox_field('project[copy_milestones]', true, array_var($project_data, 'copy_milestones'), array('id' => 'projectFormCopyMilestones')) ?>
  </div>

  <div>
    <?php echo label_tag(lang('projects copy tasks'), 'projectFormCopyTasks') ?>
    <?php echo checkbox_field('project[copy_tasks]', true, array_var($project_data, 'copy_tasks'), array('id' => 'projectFormCopyTasks')) ?>
  </div>

  <div>
    <?php echo label_tag(lang('projects copy messages'), 'projectFormCopyComments') ?>
    <?php echo checkbox_field('project[copy_messages]', true, array_var($project_data, 'copy_messages'), array('id' => 'projectFormCopyMessages')) ?>
  </div>

<?php if (plugin_active('files')) { ?>
  <div>
    <?php echo label_tag(lang('projects copy files'), 'projectFormCopyFiles') ?>
    <?php echo checkbox_field('project[copy_files]', true, array_var($project_data, 'copy_files'), array('id' => 'projectFormCopyFiles')) ?>
  </div>
<?php } // if ?>

<?php if (plugin_active('links')) { ?>
  <div>
    <?php echo label_tag(lang('projects copy links'), 'projectFormCopyLinks') ?>
    <?php echo checkbox_field('project[copy_links]', true, array_var($project_data, 'copy_links'), array('id' => 'projectFormCopyLinks')) ?>
  </div>
<?php } // if ?>

<?php if (plugin_active('wiki')) { ?>
  <div>
    <?php echo label_tag(lang('projects copy pages'), 'projectFormCopyPages') ?>
    <?php echo checkbox_field('project[copy_pages]', true, array_var($project_data, 'copy_pages'), array('id' => 'projectFormCopyPages')) ?>
  </div>
<?php } // if ?>

  <?php echo submit_button(lang('copy project')) ?>
</form>
<?php trace(__FILE__,':end'); ?>