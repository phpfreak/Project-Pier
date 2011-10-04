<?php

  set_page_title(lang('delete task'));
  project_tabbed_navigation('tasks');
  project_crumbs(lang('delete task'));

?>
<form action="<?php echo $task->getDeleteUrl() ?>" method="post">
  <?php tpl_display(get_template_path('form_errors')) ?>

  <div><?php echo lang('about to delete') ?> <?php echo lc(lang('task')) ?> <b><?php echo clean($task->getText()) ?></b> from <?php echo strtolower(lang('task list')) ?> <b><?php echo clean($task_list->getName()) ?></div>

  <div>
    <label><?php echo lang('confirm delete task') ?></label>
    <?php echo yes_no_widget('deleteTask[really]', 'deleteTaskReallyDelete', false, lang('yes'), lang('no')) ?>
  </div>

  <div>
    <?php echo label_tag(lang('password')) ?>
    <?php echo password_field('deleteTask[password]', null, array('id' => 'loginPassword', 'class' => 'medium')) ?>
  </div>

  <?php echo submit_button(lang('delete task')) ?> <a href="<?php echo $task_list->getViewUrl() ?>"><?php echo lang('cancel') ?></a>
</form>