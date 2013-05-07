<?php

require_once dirname( __FILE__ ).'/theme.php';

function task_text() {
  global $the_task;
  echo do_textile( $the_task->getText() );
}

function task_edit_link() {
  global $the_task;
  if ( $the_task->canEdit( logged_user() ) ) {
    action_link( $the_task->getEditUrl(), 'icons/edit.png', 'edit' );
  }
}

function task_delete_link() {
  global $the_task;
  if ( $the_task->canDelete( logged_user() ) ) {
    action_link( '#', 'icons/delete.png', 'delete', 'task-delete-link', array( 'data-task-id' => $the_task->getId() ) );
  }
}

function task_view_link( $on_list_page ) {
  global $the_task;
  // Check probably not needed, as we're already viewing the task.
  if ( $the_task->canView( logged_user() ) ) {
    action_link( $the_task->getViewUrl( $on_list_page ), 'icons/view.png', 'view' );
  }
}

function task_comments_link() {
  global $the_task;
  if ( $num_comments = $the_task->countComments() ): ?>
    <a href="<?php echo $the_task->getViewUrl() ?>#objectComments">
      <?php echo lang('comments'), '(',  $cc, ')' ?>
    </a>
  <?php endif;
}

function task_complete_link() {
  global $the_task;
  if ( $the_task->canChangeStatus( logged_user() ) ) {
    action_link( $the_task->getCompleteUrl(), 'icons/check.png', 'mark task as completed' );
  }
}

function task_start_date() {
  global $the_task;
  if ( !is_null( $the_task->getStartDate() ) ) {
    formatted_date( 'startDate', $the_task->getStartDate(), 'start date' );
  }
}

function task_due_date() {
  global $the_task;
  if ( !is_null( $the_task->getDueDate() ) ) {
    formatted_date( 'dueDate', $the_task->getDueDate(), 'due date' );
  }
}

function task_assignee() {
  global $the_task;
  if ( $the_task->getAssignedTo() ): ?>
  <div class="task-assigned-to">
    <span class="assignedTo">
      <?php echo clean( $the_task->getAssignedTo()->getContact()->getDisplayName() ) ?>
    </span>
  </div>
  <?php endif;
}

function task_completed_by() {
  global $the_task; ?>
  <span class="taskCompletedOnBy">
    <?php
    if ( $the_task->getCompletedBy() ) {
      echo lang(
        'completed on by',
        format_date( $the_task->getCompletedOn() ),
        $the_task->getCompletedBy()->getCardUrl(),
        clean( $the_task->getCompletedBy()->getDisplayName() )
      );
    } else { 
      echo lang(
        'completed on',
        format_date( $the_task->getCompletedOn() )
      );
    }
    ?>
  </span>
<?php
}

function task_uncomplete_link() {
  global $the_task;
  if ($the_task->canChangeStatus(logged_user())): ?>
    <a href="<?php echo $the_task->getOpenUrl() ?>">
      <?php echo lang('mark task as open') ?>
    </a>
  <?php else: ?>
    <span><?php echo lang('completed task')  ?></span>
  <?php endif;
}
