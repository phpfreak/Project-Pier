<?php

  set_page_title(lang('delete task list'));
  project_tabbed_navigation('tasks');
  project_crumbs(lang('delete task list'));

?>
<form action="<?php echo $task_list->getDeleteUrl() ?>" method="post">
  <?php tpl_display(get_template_path('form_errors')) ?>

  <div><?php echo lang('about to delete') ?> <?php echo lc(lang('task list')) ?> <b><?php echo clean($task_list->getName()) ?></b></div>
    
  <div>
    <label><?php echo lang('confirm delete task list') ?></label>
    <?php echo yes_no_widget('deleteTaskList[really]', 'deleteTaskListReallyDelete', false, lang('yes'), lang('no')) ?>
  </div>
    
  <div>
    <?php echo label_tag(lang('password')) ?>
    <?php echo password_field('deleteTaskList[password]', null, array('id' => 'loginPassword', 'class' => 'medium')) ?>
  </div>
    
  <?php echo submit_button(lang('delete task list')) ?> <a href="<?php echo $task_list->getViewUrl() ?>"><?php echo lang('cancel') ?></a>
</form>