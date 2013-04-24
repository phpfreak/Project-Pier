<?php
  function load_template_tags() {
    foreach ( array( 'task_list', 'task' ) as $sys_object ) require dirname( dirname( dirname( __FILE__ ) ) ).'/template_tags/'.$sys_object.'.php';
  }

  load_template_tags();

  add_stylesheet_to_page('project/task_list.css');
  $task_list_options = array();
  if ($cc = $task_list->countComments()) {
    $task_list_options[] = '<span><a href="'. $task_list->getViewUrl() .'#objectComments">'. lang('comments') .'('. $cc .')</a></span>';
  }
  global $the_task_list;
  $the_task_list = $task_list;
?>
<div class="taskList">
<div class="block" id="taskList<?php echo $task_list->getId() ?>">
  <div class="header">
    <?php task_list_view_link() ?>
    <?php if ($task_list->isPrivate()): ?>
    <div class="private" title="<?php echo lang('private task list') ?>"><span><?php echo lang('private task list') ?></span></div>
    <?php endif ?>
    <div class="task-list-util">
      <?php task_list_edit_link() ?>
      <?php task_list_copy_link() ?>
      <?php task_list_move_link() ?>
      <?php task_list_delete_link() ?>
    </div>
  </div>
  <div class="content">
    <?php task_list_due_date() ?>

    <?php task_list_score() ?>
    <?php task_list_description() ?>
    <?php task_list_tags() ?>

    <?php if ( is_array($task_list->getOpenTasks() ) ): ?>
    <div class="openTasks">
      <table class="blank">
        <?php global $the_task; foreach ($task_list->getOpenTasks() as $task): $the_task = $task; ?>
        <tr id="task-id-<?php echo $task->getId() ?>" class="<?php odd_even_class($task_list_ln); ?>">
          <!-- Task text and options -->
          <td class="taskText">
            <div class="wrapper">
              <?php task_text() ?>
              <div class="options">
                <?php task_edit_link() ?>
	        <?php task_delete_link() ?>
	        <?php task_view_link( $on_list_page ) ?>
	        <?php task_comments_link() ?>
	        <?php task_complete_link() ?>
              </div>
          
              <?php task_start_date() ?>
	      <?php task_due_date() ?>
	      <?php task_assignee() ?>
            </div>
          </td>
      </tr>
      <?php endforeach ?>
    </table>
  </div>
  <?php endif ?>
<?php if ( count( $task_list_options ) || $task_list->canAddTask( logged_user() ) ): ?>
  <div class="options">
    <?php echo implode( ' | ', $task_list_options ) ?>
    <?php
    if ( $task_list->canAddTask( logged_user() ) ) {
      echo '<a href="#" class="add-to-task-list">' . lang( 'add task' ) . '</a>';
      // Data for adding a task through the task list page
      $task = new ProjectTask();
      $task_data = array_var( $_POST, 'task' );
      if ( !is_array( $task_data ) ) {
        $task_data = array();
      } // if
      tpl_assign( 'task', $task );
      tpl_assign( 'task_data', $task_data );
      tpl_assign( 'task_list', $task_list );
      tpl_assign( 'back_to_list', 1 );
      tpl_assign( 'inline_task_form', true );
      // End of data for adding a task through the task list page
      echo '<div class="add-to-task-list" id="add-task-to-list-'.$task_list->getID().'">';
      $this->includeTemplate( get_template_path( 'add_task', 'task' ) );
      echo '</div>';
    } // if
    ?>
  </div>
<?php endif ?>
  <?php if (is_array($task_list->getCompletedTasks())): ?>
  <div class="completedTasks expand-container-completed">
    <?php echo lang( $on_list_page ? 'completed tasks' : 'recently completed tasks' ), ':'; ?>
    <table class="blank expand-block-completed">
      <?php global $the_task; $counter = 0; foreach ($task_list->getCompletedTasks() as $task): $the_task = $task; ?>

      <?php if ( $on_list_page || ( ++$counter <= 5 ) ): ?>
      <tr>
        <td class="taskText">
	  <?php task_text() ?>
          <div class="options">
	    <?php task_completed_by() ?>
	    <?php task_edit_link() ?>
	    <?php task_delete_link() ?>
	    <?php task_view_link( $on_list_page ) ?>
	    <?php task_comments_link() ?>
	    <?php task_uncomplete_link() ?>
	  </div>
        </td>
      </tr>
      <?php endif ?>
<?php endforeach ?>
      <?php if (!$on_list_page && $counter > 5) { ?>
      <tr>
        <td colspan="2"><a href="<?php echo $task_list->getViewUrl() ?>"><?php echo lang('view all completed tasks', $counter) ?></a></td>
      </tr>
      <?php } // if ?>
    </table>
  </div>
<?php endif ?>
</div><?php // div class="taskListExpanded" ?>
</div>
</div>
