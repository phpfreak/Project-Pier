<?php 

  set_page_title($comment->isNew() ? lang('add comment') : lang('edit comment'));
  project_tabbed_navigation(PROJECT_TAB_MESSAGES);
  project_crumbs(array(
    array(lang('messages'), get_url('message', 'index')),
    array($message->getTitle(), $message->getViewUrl()),
    array($comment->isNew() ? lang('add comment') : lang('edit comment'))
  ));
  
?>
<?php if ($comment->isNew()) { ?>
<form action="<?php echo $message->getAddCommentUrl() ?>" method="post">
<?php } else { ?>
<form action="<?php echo $comment->getEditUrl() ?>" method="post">
<?php } // if?>

<?php tpl_display(get_template_path('form_errors')) ?>

    <div class="formAddCommentText">
      <?php echo label_tag(lang('text'), 'addCommentText', true) ?>
      <?php echo textarea_field("comment[text]", array_var($comment_data, 'text'), array('class' => 'comment', 'id' => 'addCommentText')) ?>
    </div>
    
<?php if (logged_user()->isMemberOfOwnerCompany()) { ?>
  <div class="formBlock">
    <label><?php echo lang('private comment') ?>: <span class="desc">(<?php echo lang('private comment desc') ?>)</span></label>
    <?php echo yes_no_widget('comment[is_private]', 'addCommentIsPrivate', array_var($comment_data, 'is_private'), lang('yes'), lang('no')) ?>
  </div>
<?php } // if ?>
    
    <?php echo submit_button($comment->isNew() ? lang('add comment') : lang('edit comment')) ?>
</form>
