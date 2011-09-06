<?php

  set_page_title($contact->isNew() ? lang('add contact') : lang('edit contact'));
  if ($company instanceof Company && $company->isOwner()) {
    administration_tabbed_navigation(ADMINISTRATION_TAB_COMPANY);
    administration_crumbs(array(
      array(lang('company'), $company->getViewUrl()),
      ($contact->isNew() ? null : array($contact->getDisplayName(), $contact->getCardUrl())),
      array($contact->isNew() ? lang('add contact') : lang('edit contact'))
    ));
  } elseif (!logged_user()->isMemberOfOwnerCompany() && ($contact->canEdit(logged_user()))) {
    set_page_title(lang('update profile'));
    account_tabbed_navigation();
    account_crumbs(lang('update profile'));
  } else {
    administration_tabbed_navigation(ADMINISTRATION_TAB_CLIENTS);
    administration_crumbs(array(
      array(lang('clients'), get_url('administration', 'clients')),
      ($company instanceof Company ? array($company->getName(), $company->getViewUrl()) : null),
      ($contact->isNew() ? null : array($contact->getDisplayName(), $contact->getCardUrl())),
      array($contact->isNew() ? lang('add contact') : lang('edit contact'))
    ));
  } // if
  add_stylesheet_to_page('admin/user_permissions.css');

?>
<script type="text/javascript" src="<?php echo get_javascript_url('modules/addContactForm.js') ?>"></script>
<form action="<?php if ($contact->isNew()) { echo ($company instanceof Company ? $company->getAddContactUrl() : get_url('contacts', 'add')); } else { echo $contact->getEditUrl(); } ?>" method="post" enctype="multipart/form-data">

<?php tpl_display(get_template_path('form_errors')) ?>

  <div>
    <?php echo label_tag(lang('name'), 'contactFormDisplayName', true) ?>
    <?php echo text_field('contact[display_name]', array_var($contact_data, 'display_name'), array('class' => 'medium', 'id' => 'contactFormDisplayName')) ?>
  </div>
  
<?php if (logged_user()->isAdministrator()) { ?>
<?php if (!$contact->isAdministrator()) { ?>
  <fieldset>
    <legend><?php echo label_tag(lang('company'), 'contactFormCompany', true) ?></legend>
    <div>
      <?php echo radio_field('contact[company][what]', array_var(array_var($contact_data, 'company'), 'what') != 'new', array('value' => 'existing', 'id'=>'contactFormExistingCompany', 'onclick' => 'App.modules.addContactForm.toggleCompanyForms()')); ?>
      <?php echo label_tag(lang('existing company'), 'contactFormExistingCompany', false, array('class' => 'checkbox')) ?>
    </div>
    <div id="contactFormExistingCompanyControls">
      <?php echo select_company('contact[company_id]', array_var($contact_data, 'company_id'), array('id' => 'contactFormCompany', 'class' => 'combobox')) ?>
    </div>
  
    <div>
      <?php echo radio_field('contact[company][what]', array_var(array_var($contact_data, 'company'), 'what') == 'new', array('value' => 'new', 'id'=>'contactFormNewCompany', 'onclick' => 'App.modules.addContactForm.toggleCompanyForms()')); ?>
      <?php echo label_tag(lang('new company'), 'contactFormNewCompany', false, array('class'=>'checkbox'))?>
    </div>
    <div id="contactFormNewCompanyControls">
      <?php echo label_tag(lang('company name'), 'contactFormNewCompanyName', true) ?>
      <?php echo text_field('contact[company][name]', null, array('id' => 'contactFormNewCompanyName')) ?>
      <?php echo label_tag(lang('timezone'), 'contactFormNewCompanyTimezone', true)?>
      <?php echo select_timezone_widget('contact[company][timezone]', owner_company()->getTimezone(), array('id' => 'contactFormNewCompanyTimezone', 'class' => 'long combobox')) ?>
    </div>
    <script type="text/javascript">
    App.modules.addContactForm.toggleCompanyForms();
    </script>
  </fieldset>

<?php } else { ?>
  <div>
    <?php echo label_tag(lang('company name'), 'contactFormCompany', false) ?>
    <span><?php echo $company->getName()." (".lang('administrator').")"; ?></span>
  </div>
<?php } // if ?>
<?php } else { ?>
  <input type="hidden" name="contact[company_id]" value="<?php echo $company->getId()?>" />
<?php } // if ?>
  
  <div>
    <?php echo label_tag(lang('title'), 'contactFormTitle') ?>
    <?php echo text_field('contact[title]', array_var($contact_data, 'title'), array('id' => 'contactFormTitle')) ?>
  </div>

  <div>
    <?php echo label_tag(lang('email address'), 'contactFormEmail', false) ?>
    <?php echo text_field('contact[email]', array_var($contact_data, 'email'), array('class' => 'long', 'id' => 'contactFormEmail')) ?>
  </div>
  
  <div>
    <fieldset>
      <legend><?php echo lang('current avatar') ?></legend>
<?php if ($contact->hasAvatar()) { ?>
      <img src="<?php echo $contact->getAvatarUrl() ?>" alt="<?php echo clean($contact->getDisplayName()) ?> avatar" />
      <p><?php echo checkbox_field('contact[delete_avatar]', false, array('id'=>'contactDeleteAvatar', 'class' => 'checkbox')) ?> <?php echo label_tag(lang('delete current avatar'), 'contactDeleteAvatar', false, array('class' => 'checkbox'), '') ?></p>
<?php } else { ?>
      <p><?php echo lang('no current avatar') ?></p>
<?php } // if ?>
    </fieldset>
    <?php echo label_tag(lang('avatar'), 'contactFormAvatar', false) ?>
    <?php echo file_field('new avatar', null, array('id' => 'contactFormAvatar')) ?>
<?php if ($contact->hasAvatar()) { ?>
    <p class="desc"><?php echo lang('new avatar notice') ?></p>
<?php } // if ?>
  </div>

  <fieldset>
    <legend><?php echo lang('phone numbers') ?></legend>
    
    <div>
      <?php echo label_tag(lang('office phone number'), 'contactFormOfficeNumber') ?>
      <?php echo text_field('contact[office_number]', array_var($contact_data, 'office_number'), array('id' => 'contactFormOfficeNumber')) ?>
    </div>
    
    <div>
      <?php echo label_tag(lang('fax number'), 'contactFormFaxNumber') ?>
      <?php echo text_field('contact[fax_number]', array_var($contact_data, 'fax_number'), array('id' => 'contactFormFaxNumber')) ?>
    </div>
    
    <div>
      <?php echo label_tag(lang('mobile phone number'), 'contactFormMobileNumber') ?>
      <?php echo text_field('contact[mobile_number]', array_var($contact_data, 'mobile_number'), array('id' => 'contactFormMobileNumber')) ?>
    </div>
    
    <div>
      <?php echo label_tag(lang('home phone number'), 'contactFormHomeNumber') ?>
      <?php echo text_field('contact[home_number]', array_var($contact_data, 'home_number'), array('id' => 'contactFormHomeNumber')) ?>
    </div>
    
  </fieldset>

<?php if (is_array($im_types) && count($im_types)) { ?>
  <fieldset>
    <legend><?php echo lang('instant messengers') ?></legend>
    <table class="blank">
      <tr>
        <th colspan="2"><?php echo lang('im service') ?></th>
        <th><?php echo lang('value') ?></th>
        <th><?php echo lang('primary im service') ?></th>
      </tr>
<?php foreach ($im_types as $im_type) { ?>
      <tr>
        <td style="vertical-align: middle"><img src="<?php echo $im_type->getIconUrl() ?>" alt="<?php echo $im_type->getName() ?> icon" /></td>
        <td style="vertical-align: middle"><label class="checkbox" for="<?php echo 'profileFormIm' . $im_type->getId() ?>"><?php echo $im_type->getName() ?></label></td>
        <td style="vertical-align: middle"><?php echo text_field('contact[im_' . $im_type->getId() . ']', array_var($contact_data, 'im_' . $im_type->getId()), array('id' => 'profileFormIm' . $im_type->getId())) ?></td>
        <td style="vertical-align: middle"><?php echo radio_field('contact[default_im]', array_var($contact_data, 'default_im') == $im_type->getId(), array('value' => $im_type->getId())) ?></td>
      </tr>
<?php } // foreach ?>
    </table>
    <p class="desc"><?php echo lang('primary im description') ?></p>
  </fieldset>
<?php } // if ?>

<fieldset>
<?php if (plugin_active('tags')) { ?>
  <legend><?php echo lang('tags') ?></legend>
  <?php echo project_object_tags_widget('contact[tags]', active_project(), array_var($contact_data, 'tags'), array('id' => 'contactFormTags', 'class' => 'long')) ?>
</fieldset>
<?php } // if ?>

<?php if ($contact->isNew() && logged_user()->isAdministrator()) { ?>
  <fieldset>
    <legend><?php echo lang('user account'); ?></legend>
    
    <div>
      <?php echo radio_field('contact[user][add_account]', array_var($user_data, 'add_account') != 'yes', array('value' => 'no', 'id'=>'contactFormNoUserAccount', 'onclick' => 'App.modules.addContactForm.toggleUserAccountForm()')); ?>
      <?php echo label_tag(lang('no'), 'contactFormNoUserAccount', false, array('class' => 'checkbox'), '') ?>
    </div>
    
    <div>
      <?php echo radio_field('contact[user][add_account]', array_var($user_data, 'add_account') == 'yes', array('value' => 'yes', 'id'=>'contactFormAddUserAccount', 'onclick' => 'App.modules.addContactForm.toggleUserAccountForm()')); ?>
      <?php echo label_tag(lang('yes'), 'contactFormAddUserAccount', false, array('class' => 'checkbox'), '') ?>
    </div>

    <div id="contactFormUserAccountControls">
      <div>
        <?php echo label_tag(lang('username'), 'contactFormUsername', true) ?>
        <?php echo text_field('contact[user][username]', array_var($user_data, 'username'), array('class' => 'medium', 'id' => 'contactFormUsername')) ?>
      </div>

      <div>
        <?php echo label_tag(lang('email address'), 'contactFormUserEmail', true) ?>
        <?php echo text_field('contact[user][email]', array_var($user_data, 'email'), array('class' => 'long', 'id' => 'contactFormUserEmail')) ?>
      </div>

      <div>
        <?php echo label_tag(lang('timezone'), 'contactFormUserTimezone', true)?>
        <?php echo select_timezone_widget('contact[user][timezone]', array_var($user_data, 'timezone') ? array_var($user_data, 'timezone') : owner_company()->getTimezone(), array('id' => 'contactFormUserTimezone', 'class' => 'long combobox')) ?>
      </div>

      <fieldset>
        <legend><?php echo lang('password') ?></legend>
        <div>
          <?php echo radio_field('contact[user][password_generator]', array_var($user_data, 'password_generator') == 'random', array('value' => 'random', 'class' => 'checkbox', 'id' => 'userFormRandomPassword', 'onclick' => 'App.modules.addContactForm.generateRandomPasswordClick()')) ?> <?php echo label_tag(lang('user password generate'), 'userFormRandomPassword', false, array('class' => 'checkbox'), '') ?>
        </div>
        <div>
          <?php echo radio_field('contact[user][password_generator]', array_var($user_data, 'password_generator') == 'specify', array('value' => 'specify', 'class' => 'checkbox', 'id' => 'userFormSpecifyPassword', 'onclick' => 'App.modules.addContactForm.generateSpecifyPasswordClick()')) ?> <?php echo label_tag(lang('user password specify'), 'userFormSpecifyPassword', false, array('class' => 'checkbox'), '') ?>
        </div>
        <div id="userFormPasswordInputs">
          <div>
            <?php echo label_tag(lang('password'), 'userFormPassword', true) ?>
            <?php echo password_field('contact[user][password]', null, array('id' => 'userFormPassword')) ?>
          </div>

          <div>
            <?php echo label_tag(lang('password again'), 'userFormPasswordA', true) ?>
            <?php echo password_field('contact[user][password_a]', null, array('id' => 'userFormPasswordA')) ?>
          </div>
        </div>
      </fieldset>
      <script type="text/javascript">
        App.modules.addContactForm.generateRandomPasswordClick();
      </script>

      <div class="formBlock">
        <?php echo label_tag(lang('send new account notification'), null, true) ?>
        <?php echo yes_no_widget('contact[user][send_email_notification]', 'userFormEmailNotification', array($user_data, 'send_email_notification'), lang('yes'), lang('no')) ?>
        <br /><span class="desc"><?php echo lang('send new account notification desc') ?></span>
      </div>
    </div>
    <script type="text/javascript">
      App.modules.addContactForm.toggleUserAccountForm();
    </script>
<?php } // if ?>
  </fieldset>

  <?php echo submit_button($contact->isNew() ? lang('add contact') : lang('edit contact')) ?>
</form>