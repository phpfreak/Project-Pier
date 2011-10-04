<fieldset>
  <legend><?php echo lang('add status update') ?></legend>

<form action="<?php echo Comment::getAddUrl($comment_form_object) ?>" method="post" enctype="multipart/form-data">
<?php tpl_display(get_template_path('form_errors')) ?>

<?php if ($comment_form_object->columnExists('comments_enabled') && !$comment_form_object->getCommentsEnabled() && logged_user()->isAdministrator()) { ?>
  <p class="error"><?php echo lang('admin notice comments disabled') ?></p>
<?php } // if ?>

  <div class="formAddCommentText">
    <?php echo textarea_field("comment[text]", '', array('class' => 'short', 'id' => 'addCommentText')) ?>
  </div>
    
<?php if (logged_user()->isMemberOfOwnerCompany() && !$comment_form_object->getIsPrivate()) { ?>
  <fieldset>
    <legend><?php echo lang('options') ?></legend>
    
    <div class="objectOption">
      <div class="optionLabel"><label><?php echo lang('private comment') ?>:</label></div>
      <div class="optionControl"><?php echo yes_no_widget('comment[is_private]', 'addCommentIsPrivate', $comment_form_object->getIsPrivate(), lang('yes'), lang('no')) ?></div>
      <div class="optionDesc"><?php echo lang('private comment desc') ?></div>
    </div>
  </fieldset>
<?php } // if ?>

  <?php echo submit_button(lang('add status update')) ?>
</form>
</fieldset>