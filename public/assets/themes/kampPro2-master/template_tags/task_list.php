<?php

require_once dirname( __FILE__ ).'/theme.php';

// The if checks in the following 4 functions should probably become more similar

function task_list_edit_link() {
  global $the_task_list;
  if ( $the_task_list->canEdit( logged_user() ) ) {
    action_link( $the_task_list->getEditUrl(), '/icons/edit.png', 'edit' );
  }
}

function task_list_copy_link() {
  global $the_task_list;
  if ( ProjectTaskList::canAdd( logged_user(), active_project() ) ) {
    action_link( $the_task_list->getCopyUrl(), '/icons/copy.png', 'copy' );
  }
}

function task_list_move_link() {
  global $the_task_list;

  // This check is probably insufficient, since it "deletes" the task listfrom this project, and adds it to another project, so those checks might be better.
  if ( ProjectTaskList::canAdd( logged_user(), active_project() ) ) {
    action_link( $the_task_list->getMoveUrl(), '/icons/move.png', 'move' );
  }
}

function task_list_delete_link() {
  global $the_task_list;
  if ( $the_task_list->canDelete( logged_user() ) ) {
    action_link( $the_task_list->getDeleteUrl(), '/icons/delete.png', 'delete' );
  }
}

function task_list_view_link() {
  global $the_task_list;
?>
  <a class="task-list-title" href="<?php echo $the_task_list->getViewUrl() ?>">
    <?php echo clean($the_task_list->getName()) ?>
  </a>
<?php
}

function task_list_due_date() {
  global $the_task_list;
  if ( ! is_null( $the_task_list->getDueDate() ) ) {
    formatted_date( 'dueDate', $the_task_list->getDueDate(), 'due date' );
  }
}

function task_list_description() {
  global $the_task_list;
  if ( $the_task_list->getDescription() ): ?>
  <div class="desc">
    <?php echo ( do_textile( $the_task_list->getDescription() ) ) ?>
  </div>
  <?php endif;
}

function task_list_score() {
  global $the_task_list;
  if ( $the_task_list->getScore() > 0 ): ?>
    <div class="score">
      <span><?php echo lang( 'score' ) ?>:</span>
      <?php echo $the_task_list->getScore() ?>
    </div>
  <?php endif;
}

function task_list_tags() {
  global $the_task_list;
  if ( plugin_active( 'tags' ) ): ?>
    <div class="taskListTags">
      <span><?php echo lang( 'tags' ) ?>:</span>
      <?php echo project_object_tags( $the_task_list, $the_task_list->getProject() ) ?>
    </div>
  <?php endif;
}
