<?php
  add_stylesheet_to_page('project/comments.css');
?>
<div id="objectComments">
  <h2><?php echo lang('comments') ?></h2>
<?php $comments = $__comments_object->getComments() ?>
<?php if (is_array($comments) && count($comments)) { ?>
<?php $counter = 0; ?>
<?php foreach ($comments as $comment) { ?>
<?php $counter++; ?>
  <div class="comment block <?php echo $counter % 2 ? 'even' : 'odd';  ?>" id="comment<?php echo $comment->getId() ?>">
<?php if ($comment->isPrivate()) { ?>
    <div class="private" title="<?php echo lang('private comment') ?>"><span><?php echo lang('private comment') ?></span></div>
<?php } // if ?>
<?php $createdBy = $comment->getCreatedBy(); ?>
<?php if ($createdBy instanceof User) { ?>
    <div class="commentHead header"><span><a href="<?php echo $comment->getViewUrl() ?>" title="<?php echo lang('permalink') ?>">#<?php echo $counter ?></a>:</span> <?php echo lang('comment posted on by', format_datetime($comment->getUpdatedOn()), $comment->getCreatedByCardUrl(), clean($comment->getCreatedByDisplayName())) ?>:</div>
<?php } else { ?>
    <div class="commentHead header"><span><a href="<?php echo $comment->getViewUrl() ?>" title="<?php echo lang('permalink') ?>">#<?php echo $counter ?></a>:</span> <?php echo lang('comment posted on', format_datetime($comment->getUpdatedOn())) ?>:</div>
<?php } // if ?>
    <div class="commentBody content">
<?php if (($createdBy instanceof User) && ($createdBy->getContact()->hasAvatar())) { ?>
      <div class="commentUserAvatar"><img src="<?php echo $createdBy->getContact()->getAvatarUrl() ?>" alt="<?php echo clean($createdBy->getContact()->getDisplayName()) ?>" /></div>
<?php } // if ?>
      <div class="commentText"><?php echo plugin_manager()->apply_filters('comment_text', do_textile($comment->getText())) ?></div>
      <div class="clear"></div>
      <?php echo render_object_files($comment, $comment->canEdit(logged_user())) ?>
    </div>
<?php
  $options = array();
  if ($comment->canEdit(logged_user())) {
    $options[] = '<a href="' . $comment->getEditUrl() . '">' . lang('edit') . '</a>';
  }
  if ($comment->canDelete(logged_user())) {
    $options[] = '<a href="' . $comment->getDeleteUrl() . '" onclick="return confirm(\'' . lang('confirm delete comment') . '\')">' . lang('delete') . '</a>';
  }
?>
<?php if (count($options)) { ?>
    <div class="options"><?php echo implode(' | ', $options) ?></div>
<?php } // if ?>
  </div>
<?php } // foreach ?>
<?php } else { ?>
<p><?php echo lang('no comments associated with object') ?></p>
<?php } // if ?>

<?php if ($__comments_object->canComment(logged_user())) { ?>
<?php echo render_comment_form($__comments_object) ?>
<?php } // if ?>

</div>