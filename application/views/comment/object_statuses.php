<?php
  add_stylesheet_to_page('project/comments.css');
?>
<div>
<h2><?php echo lang('status updates') ?></h2>
<?php $comments = $__comments_object->getComments() ?>
<?php if (is_array($comments) && count($comments)) { ?>
<?php $counter = 0; ?>
<table id="objectStatuses">
<tr class="comment short header"><th class="statusPrivate"></th><th class="statusDate">Date</th><th class="statusContent">Update</th><th class="statusAuthor">Author</th></tr>
<?php // foreach ($comments as $comment) { ?>
<?php for ($i = count($comments); $i > 0; $i--) {
  $comment = $comments[$i-1];?>
<?php $counter++; ?>
<tr class="comment short <?php echo $counter % 2 ? 'even' : 'odd'; ?> <?php if ($comment->getCreatedOn()->isToday()) { echo "msgToday"; } else if ($comment->getCreatedOn()->isYesterday()) { echo "msgYesterday"; } else { echo "msgOlder"; }?>">
<td>
<?php if ($comment->isPrivate()) { ?>
<div class="private" title="<?php echo lang('private comment') ?>"><span><?php echo lang('private comment') ?></span></div>
<?php } // if ?>
    </td>
    <td>
      <?php echo format_datetime($comment->getCreatedOn(), "m/d/Y, h:ia"); ?>
</td>
<td>
<?php echo plugin_manager()->apply_filters('comment_text', do_textile($comment->getText())) ?>
</td>
<td>
<a href="<?php echo $comment->getCreatedBy()->getCardUrl() ?>"><?php echo clean($comment->getCreatedBy()->getDisplayName()) ?></a>
</td>
</tr>
<?php } // foreach ?>
</table>
<?php } else { ?>
<p><?php echo lang('no status updates associated with object') ?></p>
<?php } // if ?>

<?php if ($__comments_object->canComment(logged_user())) { ?>
<?php echo render_status_update_form($__comments_object) ?>
<?php } // if ?>

</div>