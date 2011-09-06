<?php

  set_page_title($message->isNew() ? lang('add message') : lang('edit message'));
  project_tabbed_navigation(PROJECT_TAB_MESSAGES);
  project_crumbs(array(
    array(lang('messages'), get_url('message', 'index')),
    array($message->isNew() ? lang('add message') : lang('edit message'))
  ));
  add_stylesheet_to_page('project/messages.css');
?>
<script type="text/javascript">
$(document).ready(function() {
 // hides the slickbox as soon as the DOM is ready
 // (a little sooner than page load)
  $('#messageFormAdditionalText').hide();

  // toggles the slickbox on clicking the noted link 
  $('#messageFormAdditionalTextLink').click(function() {
    $('#messageFormAdditionalText').slideToggle(400);
    $(this).text($(this).text() == 'Expand' ? 'Collapse' : 'Expand');
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
<?php if (!$message->isNew() && trim($message->getAdditionalText())) { ?>
    <label for="messageFormAdditionalText"><?php echo lang('additional text') ?>: <span class="desc">- (<?php echo lang('additional message text desc') ?>)</span></label>
    <?php echo editor_widget('message[additional_text]', array_var($message_data, 'additional_text'), array('id' => 'messageFormAdditionalText')) ?>
<?php } else { ?>
    <label for="messageFormAdditionalText"><?php echo lang('additional text') ?> (<a id="messageFormAdditionalTextLink" href="#"><?php echo lang('expand additional text') ?></a>): <span class="desc">- <?php echo lang('additional message text desc') ?></span></label>
    <?php echo editor_widget('message[additional_text]', array_var($message_data, 'additional_text'), array('id' => 'messageFormAdditionalText')) ?>
<?php } // if ?>
  </div>
  
  <fieldset>
    <legend><?php echo lang('milestone') ?></legend>
    <?php echo select_milestone('message[milestone_id]', active_project(), array_var($message_data, 'milestone_id'), array('id' => 'messageFormMilestone')) ?>
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
    <?php echo project_object_tags_widget('message[tags]', active_project(), array_var($message_data, 'tags'), array('id' => 'messageFormTags', 'class' => 'long')) ?>
  </fieldset>
<?php } // if ?>
<?php if ($message->isNew()) { ?>
  <fieldset id="emailNotification">
    <legend><?php echo lang('email notification') ?></legend>
    <p><?php echo lang('email notification desc') ?></p>
<?php foreach (active_project()->getCompanies() as $company) { ?>

<?php if (is_array($users = $company->getUsersOnProject(active_project())) && count($users)) { ?>
    <div class="companyDetails">
      <div class="companyName"><?php echo checkbox_field('message[notify_company_' . $company->getId() . ']', array_var($message_data, 'notify_company_' . $company->getId()), array('id' => 'notifyCompany' . $company->getId(), 'onclick' => 'App.modules.addMessageForm.emailNotifyClickCompany(' . $company->getId() . ')')) ?> <label for="notifyCompany<?php echo $company->getId() ?>" class="checkbox"><?php echo clean($company->getName()) ?></label></div>
      <div class="companyMembers">
        <ul>
<?php foreach ($users as $user) { ?>
          <li><?php echo checkbox_field('message[notify_user_' . $user->getId() . ']', array_var($message_data, 'notify_user_' . $user->getId()), array('id' => 'notifyUser' . $user->getId(), 'onclick' => 'App.modules.addMessageForm.emailNotifyClickUser(' . $company->getId() . ', ' . $user->getId() . ')')) ?> <label for="notifyUser<?php echo $user->getId() ?>" class="checkbox"><?php echo clean($user->getDisplayName()) ?></label></li>
<?php } // foreach ?>
        </ul>
      </div>
    </div>
<?php } // if ?>
<?php } // foreach ?>
  </fieldset>
<?php if (function_exists('files_activate')) { ?>   
<?php if ($message->canAttachFile(logged_user(), active_project())) { ?>
  <?php echo render_attach_files() ?>
<?php } // if ?>
<?php } // if ?>

<?php } // if ?>
  
  <?php echo submit_button($message->isNew() ? lang('add message') : lang('edit message')) ?>
</form>
