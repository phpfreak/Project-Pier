<?php

  set_page_title($message->isNew() ? lang('add message') : lang('edit message'));
  project_tabbed_navigation('messages');
  project_crumbs(array(
    array(lang('messages'), get_url('message', 'index')),
    array($message->isNew() ? lang('add message') : lang('edit message'))
  ));
  add_stylesheet_to_page('project/messages.css');
  $project = active_project();
?>
<script type="text/javascript">
$(document).ready(function() {
 // hides the slickbox as soon as the DOM is ready
 // (a little sooner than page load)
  $('#messageFormAdditionalText').hide();

  // toggles the slickbox on clicking the noted link 
  $('#messageFormAdditionalTextLink').click(function() {
    $('#messageFormAdditionalText').slideToggle(400);
    $(this).text($(this).text() == '<?php echo lang('expand') ?>' ? '<?php echo lang('collapse') ?>' : '<?php echo lang('expand') ?>' );
    return false;
  });
});
</script>
<?php if ($message->isNew()) { ?>
<form action="<?php echo get_url('message', 'add') ?>" method="post" enctype="multipart/form-data">
<?php } else { ?>
<form action="<?php echo $message->getEditUrl() ?>" method="post">
<?php } // if?>

<?php tpl_display(get_template_path('form_errors')) ?>

  <div>
    <?php echo label_tag(lang('title'), 'messageFormTitle', true) ?>
    <?php echo text_field('message[title]', array_var($message_data, 'title'), array('id' => 'messageFormTitle', 'class' => 'title')) ?>
  </div>
  
  <div>
    <?php echo label_tag(lang('text'), 'messageFormText', true) ?>
    <?php echo editor_widget('message[text]', array_var($message_data, 'text'), array('id' => 'messageFormText')) ?>
  </div>
  
  <div>
    <label for="messageFormAdditionalText"><?php echo lang('additional text') ?> (<a id="messageFormAdditionalTextLink" href="#"><?php echo lang('expand additional text') ?></a>): <span class="desc">- <?php echo lang('additional message text desc') ?></span></label>
    <?php echo editor_widget('message[additional_text]', array_var($message_data, 'additional_text'), array('id' => 'messageFormAdditionalText')) ?>
  </div>
  
  <fieldset>
    <legend><?php echo lang('milestone') ?></legend>
    <?php echo select_milestone('message[milestone_id]', $project, array_var($message_data, 'milestone_id'), array('id' => 'messageFormMilestone')) ?>
  </fieldset>
  
<?php if (logged_user()->isMemberOfOwnerCompany()) { ?>
  <fieldset>
    <legend><?php echo lang('options') ?></legend>
    
    <div class="objectOption odd">
      <div class="optionLabel"><label><?php echo lang('private message') ?>:</label></div>
      <div class="optionControl"><?php echo yes_no_widget('message[is_private]', 'messageFormIsPrivate', array_var($message_data, 'is_private'), lang('yes'), lang('no')) ?></div>
      <div class="optionDesc"><?php echo lang('private message desc') ?></div>
    </div>
    
    <div class="objectOption even">
      <div class="optionLabel"><label><?php echo lang('important message')?>:</label></div>
      <div class="optionControl"><?php echo yes_no_widget('message[is_important]', 'messageFormIsImportant', array_var($message_data, 'is_important'), lang('yes'), lang('no')) ?></div>
      <div class="optionDesc"><?php echo lang('important message desc') ?></div>
    </div>
    
    <div class="objectOption odd">
    <div class="optionLabel"><label><?php echo lang('enable comments') ?>:</label></div>
    <div class="optionControl"><?php echo yes_no_widget('message[comments_enabled]', 'fileFormEnableComments', array_var($message_data, 'comments_enabled', true), lang('yes'), lang('no')) ?></div>
    <div class="optionDesc"><?php echo lang('enable comments desc') ?></div>
  </div>
  
  <div class="objectOption even">
    <div class="optionLabel"><label><?php echo lang('enable anonymous comments') ?>:</label></div>
    <div class="optionControl"><?php echo yes_no_widget('message[anonymous_comments_enabled]', 'fileFormEnableAnonymousComments', array_var($message_data, 'anonymous_comments_enabled', false), lang('yes'), lang('no')) ?></div>
    <div class="optionDesc"><?php echo lang('enable anonymous comments desc') ?></div>
  </div>
  </fieldset>
<?php } // if ?>
<?php if (function_exists('tags_activate')) { ?>  
  <fieldset>
    <legend><?php echo lang('tags') ?></legend>
    <?php echo project_object_tags_widget('message[tags]', $project, array_var($message_data, 'tags'), array('id' => 'messageFormTags', 'class' => 'long')) ?>
  </fieldset>
<?php } // if ?>
<?php if ($message->isNew()) { 
  $this->assign('project', $project);
  $this->assign('object', $message);
  $this->assign('post_data_name', 'message');
  $this->assign('post_data', $message_data);
  $this->includeTemplate(get_template_path('select_receivers', 'notifier'));
?>
<?php if (function_exists('files_activate')) { ?>   
<?php if (!is_null($project)) { ?>
<?php if ($message->canAttachFile(logged_user(), $project)) { ?>
  <?php echo render_attach_files() ?>
<?php } // if canAttach ?>
<?php } // if !is_null ?>
<?php } // if function_exists ?>
<?php } // if ?>
  <?php echo submit_button($message->isNew() ? lang('add message') : lang('edit message')) ?>
</form>