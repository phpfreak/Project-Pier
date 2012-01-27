<?php

  set_page_title($contact->isNew() ? lang('add contact') : lang('edit contact'));
  $user = $contact->getUserAccount();
  if ($user instanceof User && $user->getId() == logged_user()->getId()) {
    set_page_title(lang('edit contact'));
    account_tabbed_navigation();
    account_crumbs(lang('edit contact'));
  } else {
    set_page_title(lang('edit contact'));
    if ($company instanceof Company && $company->isOwner()) {
      if (logged_user()->isAdministrator()) {
        administration_tabbed_navigation(ADMINISTRATION_TAB_COMPANY);
        administration_crumbs(array(
          array(lang('company'), $company->getViewUrl()),
          array(lang('edit contact'))
        ));
      } else {
        set_page_title(lang('edit contact'));
        account_tabbed_navigation('contact');
        account_crumbs(lang('update profile'));
      }
    } else {
       if ($contact->canEdit(logged_user())) {
         set_page_title(lang('edit contact'));
         account_tabbed_navigation('contact');
         account_crumbs(lang('edit contact'));
      } else {
        administration_tabbed_navigation(ADMINISTRATION_TAB_CLIENTS);
        administration_crumbs(array(
          array(lang('clients'), get_url('administration', 'clients')),
          array($company->getName(), $company->getViewUrl()),
          array($user->getDisplayName(), $user->getCardUrl()),
          array(lang('edit contact'))
        ));
      } // if
    } // if
  } // if
  
  if ($user instanceof User && $user->canEdit(logged_user())) {
    add_page_action(array(
      lang('edit user account')  => $user->getEditUrl(),
      lang('change password') => $user->getEditPasswordUrl()
    ));
  } // if
  
  if ($user instanceof User && $user->canUpdatePermissions(logged_user())) {
    add_page_action(array(
      lang('permissions')  => $user->getUpdatePermissionsUrl()
    ));
  } // if

  add_stylesheet_to_page('admin/user_permissions.css');

?>
<form action="<?php if ($contact->isNew()) { echo ($company instanceof Company ? $company->getAddContactUrl() : get_url('contacts', 'add')); } else { echo $contact->getEditUrl(); } ?>" method="post" enctype="multipart/form-data">

<?php tpl_display(get_template_path('form_errors')) ?>

  <fieldset>
    <legend><?php echo label_tag(lang('name'), 'contactFormName', true) ?></legend>
    <div>
      <?php echo label_tag(lang('display name'), 'contactFormDisplayName', true) ?>
      <?php echo text_field('contact[display_name]', array_var($contact_data, 'display_name'), array('class' => 'medium', 'id' => 'contactFormDisplayName')) ?>
    </div>

    <div>
      <?php echo label_tag(lang('first name'), 'contactFormFirstName', false) ?>
      <?php echo text_field('contact[first_name]', array_var($contact_data, 'first_name'), array('class' => 'medium', 'id' => 'contactFormFirstName')) ?>
    </div>

    <div>
      <?php echo label_tag(lang('middle name'), 'contactFormMiddleName', false) ?>
      <?php echo text_field('contact[middle_name]', array_var($contact_data, 'middle_name'), array('class' => 'medium', 'id' => 'contactFormMiddleName')) ?>
    </div>

    <div>
      <?php echo label_tag(lang('last name'), 'contactFormLastName', false) ?>
      <?php echo text_field('contact[last_name]', array_var($contact_data, 'last_name'), array('class' => 'medium', 'id' => 'contactFormLastName')) ?>
    </div>
  </fieldset>
  
<?php if (logged_user()->isAdministrator()) { ?>
<?php if (!$contact->isAdministrator()) { ?>
  <fieldset>
    <legend><?php echo label_tag(lang('company'), 'contactFormCompany', true) ?></legend>
    <div>
      <?php echo radio_field('contact[company][what]', array_var(array_var($contact_data, 'company'), 'what') != 'new', array('value' => 'existing', 'id'=>'contactFormExistingCompany')); ?>
      <?php echo label_tag(lang('existing company'), 'contactFormExistingCompany', false, array('class' => 'checkbox')) ?>
    </div>
    <div id="contactFormExistingCompanyControls">
      <?php echo select_company('contact[company_id]', array_var($contact_data, 'company_id'), array('id' => 'contactFormCompany', 'class' => 'combobox')) ?>
    </div>
  
    <div>
      <?php echo radio_field('contact[company][what]', array_var(array_var($contact_data, 'company'), 'what') == 'new', array('value' => 'new', 'id'=>'contactFormNewCompany')); ?>
      <?php echo label_tag(lang('new company'), 'contactFormNewCompany', false, array('class'=>'checkbox'))?>
    </div>
    <div id="contactFormNewCompanyControls">
      <?php echo label_tag(lang('company name'), 'contactFormNewCompanyName', true) ?>
      <?php echo text_field('contact[company][name]', null, array('id' => 'contactFormNewCompanyName')) ?>
      <?php echo label_tag(lang('timezone'), 'contactFormNewCompanyTimezone', true)?>
      <?php echo select_timezone_widget('contact[company][timezone]', owner_company()->getTimezone(), array('id' => 'contactFormNewCompanyTimezone', 'class' => 'long combobox')) ?>
    </div>
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
      <legend><?php echo lang('avatar') ?></legend>
<?php if ($contact->hasAvatar()) { ?>
      <img src="<?php echo $contact->getAvatarUrl() ?>" alt="<?php echo clean($contact->getDisplayName()) ?> avatar" />
      <p><?php echo checkbox_field('contact[delete_avatar]', false, array('id'=>'contactDeleteAvatar', 'class' => 'checkbox')) ?> <?php echo label_tag(lang('delete current avatar'), 'contactDeleteAvatar', false, array('class' => 'checkbox'), '') ?></p>
<?php } else { ?>
      <p><?php echo lang('no current avatar') ?></p>
<?php } // if ?>
    <?php echo label_tag(lang('avatar'), 'contactFormAvatar', false) ?>
    <?php echo file_field('new avatar', null, array('id' => 'contactFormAvatar')) ?>
<?php if ($contact->hasAvatar()) { ?>
    <p class="desc"><?php echo lang('new avatar notice') ?></p>
<?php } // if ?>
    <?php echo label_tag(lang('use gravatar'), 'contactFormUseGravatar', true) ?>
    <?php echo yes_no_widget('contact[use_gravatar]', 'contactFormUseGravatar', array_var($contact_data, 'use_gravatar'), lang('yes'), lang('no')) ?>
    </fieldset>
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

  <fieldset>
    <legend><?php echo lang('additional') ?></legend>

    <div>
      <?php echo label_tag(lang('language preferences'), 'contactFormLanguagePreferences') ?>
      <?php echo text_field('contact[language_preferences]', array_var($contact_data, 'language_preferences'), array('id' => 'contactFormLanguagePreferences')) ?>
    </div>
   
    <div>
      <?php echo label_tag(lang('food preferences'), 'contactFormFoodPreferences') ?>
      <?php echo text_field('contact[food_preferences]', array_var($contact_data, 'food_preferences'), array('id' => 'contactFormFoodPreferences')) ?>
    </div>
    
    <div>
      <?php echo label_tag(lang('license plate'), 'contactFormLicensePlate') ?>
      <?php echo text_field('contact[license_plate]', array_var($contact_data, 'license_plate'), array('id' => 'contactFormLicensePlate')) ?>
    </div>
    
    <div>
      <?php echo label_tag(lang('department details'), 'contactFormDepartmentDetails') ?>
      <?php echo text_field('contact[department_details]', array_var($contact_data, 'department_details'), array('id' => 'contactFormDepartmentDetails')) ?>
    </div>
    
    <div>
      <?php echo label_tag(lang('location details'), 'contactFormLocationDetails') ?>
      <?php echo text_field('contact[location_details]', array_var($contact_data, 'location_details'), array('id' => 'contactFormLocationDetails')) ?>
    </div>
    
  </fieldset>



<?php if (is_array($im_types) && count($im_types)) { ?>
  <fieldset>
    <legend><?php echo lang('instant messengers') ?></legend>
    <table id="im" class="blank">
      <tr>
        <th colspan="2"><?php echo lang('im service') ?></th>
        <th><?php echo lang('value') ?></th>
        <th><?php echo lang('primary im service') ?></th>
      </tr>
<?php foreach ($im_types as $im_type) { ?>
      <tr>
        <td><img src="<?php echo $im_type->getIconUrl() ?>" alt="<?php echo $im_type->getName() ?> icon" /></td>
        <td><label class="checkbox" for="<?php echo 'profileFormIm' . $im_type->getId() ?>"><?php echo $im_type->getName() ?></label></td>
        <td><?php echo text_field('contact[im_' . $im_type->getId() . ']', array_var($contact_data, 'im_' . $im_type->getId()), array('id' => 'profileFormIm' . $im_type->getId())) ?></td>
        <td><?php echo radio_field('contact[default_im]', array_var($contact_data, 'default_im') == $im_type->getId(), array('value' => $im_type->getId())) ?></td>
      </tr>
<?php } // foreach ?>
    </table>
    <p class="desc"><?php echo lang('primary im description') ?></p>
  </fieldset>
<?php } // if ?>

  <?php echo submit_button($contact->isNew() ? lang('add contact') : lang('edit contact')) ?>
</form>