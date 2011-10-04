<?php

  set_page_title($comment->isNew() ? lang('add comment') : lang('edit comment'));
  project_tabbed_navigation(PROJECT_TAB_OVERVIEW);
  project_crumbs(array(
    $comment->isNew() ? lang('add comment') : lang('edit comment')
  )); // project_crumbs

?>
<?php if ($comment->isNew()) { ?>
<form action="<?php echo Comment::getAddUrl($comment_form_object) ?>" method="post">
<?php } else { ?>
<form action="<?php echo $comment->getEditUrl() ?>" method="post">
<?php } // if ?>

<?php tpl_display(get_template_path('form_errors')) ?>

<?php if ($comment_form_object->columnExists('comments_enabled') && !$comment_form_object->getCommentsEnabled() && logged_user()->isAdministrator()) { ?>
<p class="error"><?php echo lang('admins can post comments on locked objects desc') ?></p>
<?php } // if ?>

  <div class="formAddCommentText">
    <?php echo label_tag(lang('text'), 'addCommentText', true) ?>
    <?php echo textarea_field("comment[text]", array_var($comment_data, 'text'), array('class' => 'comment', 'id' => 'addCommentText')) ?>
  </div>
    
<?php if (logged_user()->isMemberOfOwnerCompany() && !$comment_form_object->getIsPrivate()) { ?>
  <fieldset>
    <legend><?php echo lang('options') ?></legend>
    
    <div class="objectOption">
      <div class="optionLabel"><label><?php echo lang('private comment') ?>:</label></div>
      <div class="optionControl"><?php echo yes_no_widget('comment[is_private]', 'addCommentIsPrivate', array_var($comment_data, 'is_private'), lang('yes'), lang('no')) ?></div>
      <div class="optionDesc"><?php echo lang('private comment desc') ?></div>
    </div>
  </fieldset>
<?php } // if ?>
<?php if ($comment->columnExists('comments_enabled') && !$comment->getCommentsEnabled() && logged_user()->isAdministrator()) { ?>
<p class="error"><?php echo lang('admins can post comments on locked objects desc') ?></p>
<?php } // if ?>
<?php if ($comment_form_object->canAttachFile(logged_user(), active_project())) { ?>
  <?php echo render_attach_files() ?>
<?php } // if ?>
<?php 
  $this->assign('project', active_project());
  $this->assign('object', $comment);
  $this->assign('post_data_name', 'comment_data');
  $this->assign('post_data', $comment_data);
  $this->includeTemplate(get_template_path('select_receivers', 'notifier'));
?>
   
    <?php echo submit_button($comment->isNew() ? lang('add comment') : lang('edit comment')) ?>
</form>