<?php

  set_page_title(lang('reorder tasks'));
  project_tabbed_navigation('tasks');
  project_crumbs(array(
    array(lang('tasks'), get_url('task')),
    array($task_list->getName(), $task_list->getViewUrl()),
    array(lang('reorder tasks'))
  ));
  
  add_stylesheet_to_page('project/reorder_tasks.css');

?>
<div id="reorderTasks">
  <form action="<?php echo $task_list->getReorderTasksUrl($back_to_list) ?>" method="post">
    <table class="blank">
      <tr>
        <th><?php echo lang('order') ?></th>
        <th><?php echo lang('task') ?></th>
      </tr>
<?php foreach ($tasks as $task) { ?>
      <tr>
        <td><?php echo text_field('task_' . $task->getId(), $task->getOrder(), array('class' => 'short')) ?></td>
        <td><?php echo clean($task->getText()) ?></td>
      </tr>
<?php } // foreach ?>
    </table>
    <input type="hidden" name="submitted" value="submitted" />
    <?php echo submit_button(lang('reorder tasks')) ?>
  </form>
</div>