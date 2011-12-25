<?php

  set_page_title(lang('add contact'));
  project_tabbed_navigation();
  project_crumbs(array(
    array(lang('people'), get_url('project','people')),
    lang('add contact')));
  
  add_stylesheet_to_page('project/people.css');
  add_stylesheet_to_page('project/attachments.css');

?>
<script type="text/javascript" src="<?php echo get_javascript_url('modules/addContactToProjectForm.js') ?>"></script>
<script type="text/javascript" src="<?php echo get_javascript_url('modules/addContactForm.js') ?>"></script>
<form action="<?php echo ($project_init ? $project->getAddContactUrl(array('project_init' => '1')) : $project->getAddContactUrl()); ?>" method="post" enctype="multipart/form-data">
<?php tpl_display(get_template_path('form_errors')) ?>
  
  <div>
    <?php echo radio_field('contact[what]', array_var($contact_data, 'what', 'existing') == 'existing', array('value' => 'existing', 'id' => 'contactFormExistingContact')); ?>
    <?php echo label_tag(lang('attach existing contact'), 'contactFormExistingContact', false, array('class'=>'checkbox')); ?>
  </div>
  
  <div id="contactFormExistingContactControls">
    <fieldset>
      <legend><?php echo lang('select contact'); ?></legend>
      <div>
        <?php echo text_field('contact[existing][text]', array_var($existing_contact_data, 'text', lang('description'))); ?>
        <?php echo select_contact('contact[existing][rel_object_id]', null, $already_attached_contacts_ids, array('id'=> 'contactFormSelectContact', 'class'=>'combobox')); ?>
        <input type="hidden" name="contact[existing][rel_object_manager]" value="Contacts"/>
      </div>
    </fieldset>
  </div>


  <div>
    <?php echo radio_field('contact[what]', array_var($contact_data, 'what', 'existing') == 'new', array('value' => 'new', 'id'=>'contactFormNewContact')); ?>
    <?php echo label_tag(lang('new contact'), 'contactFormNewContact', false, array('class'=>'checkbox'))?>
  </div>

  <div id="contactFormNewContactControls">
    <fieldset>
      <legend><?php echo lang('new contact'); ?></legend>

      <div>
        <?php echo label_tag(lang('description'), 'contactFormDescription', false) ?>
        <?php echo text_field('contact[new][text]', array_var($new_contact_data, 'text', lang('description'))); ?>
        <input type="hidden" name="contact[new][rel_object_manager]" value="Contacts"/>
      </div>
      
      <div>
        <?php echo label_tag(lang('name'), 'contactFormDisplayName', true) ?>
        <?php echo text_field('contact[new][display_name]', array_var($new_contact_data, 'display_name'), array('class' => 'medium', 'id' => 'contactFormDisplayName')) ?>
      </div>

      <fieldset>
        <legend><?php echo lang('company'); ?> <span class="label_required">*</span></legend>
        <div>
          <?php echo radio_field('contact[new][company][what]', array_var($company_data, 'what', 'existing') == 'existing', array('value' => 'existing', 'id'=>'contactFormExistingCompany')); ?>
          <?php echo label_tag(lang('existing company'), 'contactFormExistingCompany', false, array('class' => 'checkbox')) ?>
        </div>
        <div id="contactFormExistingCompanyControls">
          <?php echo select_company('contact[new][company_id]', array_var($new_contact_data, 'company_id'), array('id' => 'contactFormCompany', 'class' => 'combobox')) ?>
        </div>

        <div>
          <?php echo radio_field('contact[new][company][what]', array_var($company_data, 'what', 'existing') == 'new', array('value' => 'new', 'id'=>'contactFormNewCompany')); ?>
          <?php echo label_tag(lang('new company'), 'contactFormNewCompany', false, array('class'=>'checkbox'))?>
        </div>
        <div id="contactFormNewCompanyControls">
          <?php echo label_tag(lang('name'), 'contactFormNewCompanyName', true) ?>
          <?php echo text_field('contact[new][company][name]', array_var($company_data, 'name'), array('id' => 'contactFormNewCompanyName')) ?>
          <?php echo label_tag(lang('timezone'), 'contactFormNewCompanyTimezone', true)?>
          <?php echo select_timezone_widget('contact[new][company][timezone]', array_var($company_data, 'timezone', owner_company()->getTimezone()), array('id' => 'contactFormNewCompanyTimezone', 'class' => 'long combobox')) ?>
        </div>
      </fieldset>

      <div>
        <?php echo label_tag(lang('contact title'), 'contactFormTitle') ?>
        <?php echo text_field('contact[new][title]', array_var($new_contact_data, 'title'), array('id' => 'contactFormTitle')) ?>
      </div>

      <div>
        <?php echo label_tag(lang('email address'), 'contactFormEmail', false) ?>
        <?php echo text_field('contact[new][email]', array_var($new_contact_data, 'email'), array('class' => 'long', 'id' => 'contactFormEmail')) ?>
      </div>

      <div>
        <?php echo label_tag(lang('avatar'), 'contactFormAvatar', false) ?>
        <?php echo file_field('new avatar', null, array('id' => 'contactFormAvatar')) ?>
      </div>

      <fieldset>
        <legend><?php echo lang('phone numbers') ?></legend>

        <div>
          <?php echo label_tag(lang('office phone number'), 'contactFormOfficeNumber') ?>
          <?php echo text_field('contact[new][office_number]', array_var($new_contact_data, 'office_number'), array('id' => 'contactFormOfficeNumber')) ?>
        </div>

        <div>
          <?php echo label_tag(lang('fax number'), 'contactFormFaxNumber') ?>
          <?php echo text_field('contact[new][fax_number]', array_var($new_contact_data, 'fax_number'), array('id' => 'contactFormFaxNumber')) ?>
        </div>

        <div>
          <?php echo label_tag(lang('mobile phone number'), 'contactFormMobileNumber') ?>
          <?php echo text_field('contact[new][mobile_number]', array_var($new_contact_data, 'mobile_number'), array('id' => 'contactFormMobileNumber')) ?>
        </div>

        <div>
          <?php echo label_tag(lang('home phone number'), 'contactFormHomeNumber') ?>
          <?php echo text_field('contact[new][home_number]', array_var($new_contact_data, 'home_number'), array('id' => 'contactFormHomeNumber')) ?>
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
            <td style="vertical-align: middle"><?php echo text_field('contact[new][im_' . $im_type->getId() . ']', array_var($new_contact_data, 'im_' . $im_type->getId()), array('id' => 'profileFormIm' . $im_type->getId())) ?></td>
            <td style="vertical-align: middle"><?php echo radio_field('contact[new][default_im]', array_var($new_contact_data, 'default_im') == $im_type->getId(), array('value' => $im_type->getId())) ?></td>
          </tr>
        <?php } // foreach ?>
        </table>
        <p class="desc"><?php echo lang('primary im description') ?></p>
      </fieldset>
    <?php } // if ?>
    
    <fieldset>
      <legend><?php echo lang('tags') ?></legend>
      <?php echo project_object_tags_widget('contact[new][tags]', active_project(), array_var($new_contact_data, 'tags'), array('id' => 'contactFormTags', 'class' => 'long')) ?>
    </fieldset>

    <?php if ($contact->isNew() && logged_user()->isAdministrator()) { ?>
      <fieldset>
        <legend><?php echo lang('user account'); ?></legend>

        <div>
          <?php echo radio_field('contact[new][user][add_account]', array_var($user_data, 'add_account', 'no') == 'no', array('value' => 'no', 'id'=>'contactFormNoUserAccount')); ?>
          <?php echo label_tag(lang('no'), 'contactFormNoUserAccount', false, array('class' => 'checkbox'), '') ?>
        </div>

        <div>
          <?php echo radio_field('contact[new][user][add_account]', array_var($user_data, 'add_account', 'no') == 'yes', array('value' => 'yes', 'id'=>'contactFormAddUserAccount')); ?>
          <?php echo label_tag(lang('yes'), 'contactFormAddUserAccount', false, array('class' => 'checkbox'), '') ?>
        </div>

        <div id="contactFormUserAccountControls">
          <div>
            <?php echo label_tag(lang('username'), 'contactFormUsername', true) ?>
            <?php echo text_field('contact[new][user][username]', array_var($user_data, 'username'), array('class' => 'medium', 'id' => 'contactFormUsername')) ?>
          </div>

          <div>
            <?php echo label_tag(lang('email address'), 'contactFormUserEmail', true) ?>
            <?php echo text_field('contact[new][user][email]', array_var($user_data, 'email'), array('class' => 'long', 'id' => 'contactFormUserEmail')) ?>
          </div>

          <div>
            <?php echo label_tag(lang('timezone'), 'contactFormUserTimezone', true)?>
            <?php echo select_timezone_widget('contact[new][user][timezone]', array_var($user_data, 'timezone', owner_company()->getTimezone()), array('id' => 'contactFormUserTimezone', 'class' => 'long combobox')) ?>
          </div>

          <fieldset>
            <legend><?php echo lang('password') ?></legend>
            <div>
              <?php echo radio_field('contact[new][user][password_generator]', array_var($user_data, 'password_generator', 'random') == 'random', array('value' => 'random', 'class' => 'checkbox', 'id' => 'userFormRandomPassword')) ?> <?php echo label_tag(lang('user password generate'), 'userFormRandomPassword', false, array('class' => 'checkbox'), '') ?>
            </div>
            <div>
              <?php echo radio_field('contact[new][user][password_generator]', array_var($user_data, 'password_generator', 'random') == 'specify', array('value' => 'specify', 'class' => 'checkbox', 'id' => 'userFormSpecifyPassword')) ?> <?php echo label_tag(lang('user password specify'), 'userFormSpecifyPassword', false, array('class' => 'checkbox'), '') ?>
            </div>
            <div id="userFormPasswordInputs">
              <div>
                <?php echo label_tag(lang('password'), 'userFormPassword', true) ?>
                <?php echo password_field('contact[new][user][password]', null, array('id' => 'userFormPassword')) ?>
              </div>

              <div>
                <?php echo label_tag(lang('password again'), 'userFormPasswordA', true) ?>
                <?php echo password_field('contact[new][user][password_a]', null, array('id' => 'userFormPasswordA')) ?>
              </div>
            </div>
          </fieldset>

          <div class="formBlock">
            <?php echo label_tag(lang('send new account notification'), null, true) ?>
            <?php echo yes_no_widget('contact[new][user][send_email_notification]', 'userFormEmailNotification', array($user_data, 'send_email_notification'), lang('yes'), lang('no')) ?>
            <br /><span class="desc"><?php echo lang('send new account notification desc') ?></span>
          </div>
        </div>
    <?php } // if ?>
      </fieldset>
    
    </fieldset>
  </div>

  <?php echo submit_button(lang('add contact')) ?>
<?php if ($project_init) { ?>
  <button type="button" onclick="document.location='<?php echo $project->getPermissionsUrl(array('project_init' => 1)); ?>'" style="float: right;"><?php echo lang('done adding contacts') ?></button><div class="clear"></div>
<?php } // if ?>
</form>