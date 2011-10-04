<?php
  set_page_title($tool->getDisplayName());
  administration_tabbed_navigation(ADMINISTRATION_TAB_TOOLS);
  administration_crumbs(array(
    array(lang('administration tools'), get_url('administration', 'tools')),
    array($tool->getDisplayName())
  ));
  add_stylesheet_to_page('admin/massmailer.css');
?>
<div id="massMailer">
  <form action="<?php echo $tool->getToolUrl() ?>" method="post">
<?php tpl_display(get_template_path('form_errors')) ?>
  
    <div>
      <?php echo label_tag(lang('massmailer subject'), 'massmailerFormRecipient', true) ?>
      <?php echo text_field('massmailer[subject]', array_var($massmailer_data, 'subject'), array('id' => 'massmailerFormRecipient', 'class' => 'title')) ?>
    </div>
    
    <div>
      <?php echo label_tag(lang('massmailer message'), 'massmailerFormMessage', true) ?>
      <?php echo textarea_field('massmailer[message]', array_var($massmailer_data, 'message'), array('id' => 'massmailerFormMessage', 'class' => 'editor')) ?>
    </div>
    
    <h2><?php echo lang('massmailer recipients') ?></h2>
    
<?php foreach ($grouped_users as $company_name => $company_details) { ?>
<?php $company_id = $company_details['details']->getId() ?>  
    <fieldset>
      <legend><?php echo checkbox_field('massmailer[company_' . $company_id . ']', array_var($massmailer_data, 'company_' . $company_id), array('id' => 'massmailerFormCompany' . $company_id, 'class' => 'checkbox selectall' ) ) ?> <label for="massmailerFormCompany<?php echo $company_id ?>" class="checkbox"><?php echo clean($company_name) ?></label></legend>
      <div>
        <div class="massmailercompanyLogo"><img src="<?php echo $company_details['details']->getLogoUrl() ?>" alt="<?php echo clean($company_name) ?>" /></div>
        <div class="massmailerRecipients">
<?php foreach ($company_details['users'] as $user) { ?>
          <div class="massmailerRecipient"><?php echo checkbox_field('massmailer[user_' . $user->getId() . ']', array_var($massmailer_data, 'user_' . $user->getId()), array('id' => 'massmailerFormCompany'. $company_id .'-User' . $user->getId(), 'class' => 'checkbox selectone' )) ?> <label for="massmailerFormCompanyUser<?php echo $user->getId() ?>" class="checkbox"><?php echo clean($user->getDisplayName()) ?> <span class="desc">(<?php echo clean($user->getEmail()) ?>)</span></label></div>
<?php } // foreach ?>
        </div>
        <div class="clear"></div>
      </div>
    </fieldset>
<?php } // foreach ?>
    
    <?php echo submit_button(lang('submit')) ?>
  </form>
</div>