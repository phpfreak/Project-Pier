<?php
  trace(__FILE__,':begin');
  set_page_title(lang('copy task list'));
  project_tabbed_navigation('tasks');
  project_crumbs(lang('copy task'));

?>
<form action="<?php echo get_url('task', 'copy_list') ?>" method="post">
  <?php tpl_display(get_template_path('form_errors')) ?>

  <div><?php echo lang('about to delete') ?> <?php echo lc(lang('task')) ?> <b><?php echo clean($task->getText()) ?></b> from <?php echo strtolower(lang('task list')) ?> <b><?php echo clean($task_list->getName()) ?></div>

  <div>
    <?php echo label_tag(lang('tasklist copy source'), 'tasklistSource', true) ?>
    <?php echo select_project('tasklist[source]', '', array_var($project_data, 'copy_source'), array('id' => 'tasklistFormSource')) ?>
  </div>

  <div>
    <?php echo label_tag(lang('tasklist copy details'), 'tasklistFormCopyDetails') ?>
    <?php echo checkbox_field('tasklist[copy_details]', true, array_var($project_data, 'copy_details'), array('id' => 'tasklistFormCopyDetails')) ?>
  </div>

  <div>
    <?php echo label_tag(lang('tasklist copy milestones'), 'projectFormCopyMilestones') ?>
    <?php echo checkbox_field('tasklist[copy_milestones]', true, array_var($project_data, 'copy_milestones'), array('id' => 'tasklistFormCopyMilestones')) ?>
  </div>

  <?php echo submit_button(lang('copy task')) ?> <a href="<?php echo $task_list->getViewUrl() ?>"><?php echo lang('cancel') ?></a>
</form>
<?php  trace(__FILE__,':end'); ?>