<?php 
  trace(__FILE__,':begin');
  set_page_title(lang('move task list'));
  dashboard_tabbed_navigation('tasks');
  trace(__FILE__,':crumbs');
  project_crumbs(lang('move task list'));
  trace(__FILE__,':build page');
?>
<form action="<?php echo $task_list->getMoveUrl(); ?>" method="post">

<?php tpl_display(get_template_path('form_errors')) ?>

  <div><?php echo lang('about to move') ?> <?php echo lc(lang('task list')) ?> <b><?php echo clean($task_list->getName()) ?></b></div>

  <div>
    <?php echo label_tag(lang('task list target project'), 'moveTaskListFormTargetProjectId', true) ?>
    <?php echo select_project('move_data[target_project_id]', '', array_var($move_data, 'target_project_id'), array('id' => 'moveTaskListFormTargetProjectId')) ?>
  </div>

  <?php echo submit_button(lang('move task list')) ?> <span id="cancel"><a href="<?php echo $task_list->getViewUrl() ?>"><?php echo lang('cancel') ?></a></span>
</form>
<?php trace(__FILE__,':end'); ?>