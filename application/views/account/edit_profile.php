<?php
  
  if ($user->getId() == logged_user()->getId()) {
    set_page_title(lang('update profile'));
    account_tabbed_navigation();
    account_crumbs(lang('update profile'));
  } else {
    set_page_title(lang('update profile'));
    if ($company->isOwner()) {
      administration_tabbed_navigation(ADMINISTRATION_TAB_COMPANY);
      administration_crumbs(array(
        array(lang('company'), $company->getViewUrl()),
        array(lang('update profile'))
      ));
    } else {
      administration_tabbed_navigation(ADMINISTRATION_TAB_CLIENTS);
      administration_crumbs(array(
        array(lang('clients'), get_url('administration', 'clients')),
        array($company->getName(), $company->getViewUrl()),
        array($user->getDisplayName(), $user->getCardUrl()),
        array(lang('update profile'))
      ));
    } // if
  } // if
  
  if ($user->canUpdateProfile(logged_user())) {
    add_page_action(array(
      lang('update profile')  => $user->getEditProfileUrl(),
      lang('change password') => $user->getEditPasswordUrl(),
      lang('update avatar')   => $user->getUpdateAvatarUrl()
    ));
  } // if
  
  if ($user->canUpdatePermissions(logged_user())) {
    add_page_action(array(
      lang('permissions')  => $user->getUpdatePermissionsUrl()
    ));
  } // if

?>
<form action="<?php echo $user->getEditProfileUrl($redirect_to) ?>" method="post">

  <?php tpl_display(get_template_path('form_errors')) ?>

<?php if (logged_user()->isAdministrator()) { ?>
  <div class="hint">
    <div class="header"><?php echo lang('administrator update profile notice') ?></div>
    <div class="content">
      <div>
        <?php echo label_tag(lang('username'), 'profileFormUsername', true) ?>
        <?php echo text_field('user[username]', array_var($user_data, 'username'), array('id' => 'profileFormUsername')) ?>
      </div>
      
      <div>
        <?php echo label_tag(lang('company'), 'userFormCompany', true) ?>
        <?php echo select_company('user[company_id]', array_var($user_data, 'company_id'), array('id' => 'userFormCompany')) ?>
      </div>
      
<?php if ($company->isOwner()) { ?>
      <fieldset>
        <legend><?php echo lang('options') ?></legend>
        
        <div>
          <?php echo label_tag(lang('is administrator'), null, true) ?>
          <?php echo yes_no_widget('user[is_admin]', 'userFormIsAdmin', array_var($user_data, 'is_admin'), lang('yes'), lang('no')) ?>
        </div>
        
        <div>
          <?php echo label_tag(lang('is auto assign'), null, true) ?>
          <?php echo yes_no_widget('user[auto_assign]', 'userFormAutoAssign', array_var($user_data, 'auto_assign'), lang('yes'), lang('no')) ?>
        </div>

        <div>
          <?php echo label_tag(lang('use LDAP'), null, true) ?>
          <?php echo yes_no_widget('user[use_LDAP]', 'userFormUseLDAP', array_var($user_data, 'use_LDAP'), lang('yes'), lang('no')) ?>
        </div>

        <div>
          <?php echo label_tag(lang('can manage projects'), null, true) ?>
          <?php echo yes_no_widget('user[can_manage_projects]', 'userFormCanManageProjects', array_var($user_data, 'can_manage_projects'), lang('yes'), lang('no')) ?>
        </div>
      </fieldset>
<?php } else { ?>
      <input type="hidden" name="user[is_admin]" value="0" />
      <input type="hidden" name="user[auto_assign]" value="0" />
      <input type="hidden" name="user[use_LDAP]" value="0" />
      <input type="hidden" name="user[can_manage_projects]" value="0" />
<?php } // if ?>
    </div>
  </div>
<?php } else { ?>
  <div>
    <?php echo label_tag(lang('username')) ?>
    <?php echo clean(array_var($user_data, 'username')) ?>
    <input type="hidden" name="user[username]" value="<?php echo clean(array_var($user_data, 'username')) ?>" />
  </div>
<?php } // if ?>
  
  <div>
    <?php echo label_tag(lang('display name'), 'profileFormDisplayName') ?>
    <?php echo text_field('user[display_name]', array_var($user_data, 'display_name'), array('id' => 'profileFormDisplayName', 'class' => 'long')) ?>
  </div>
  
  <div>
    <?php echo label_tag(lang('user title'), 'profileFormTitle') ?>
    <?php echo text_field('user[title]', array_var($user_data, 'title'), array('id' => 'profileFormTitle')) ?>
  </div>
  
  <div>
    <?php echo label_tag(lang('email address'), 'profileFormEmail', true) ?>
    <?php echo text_field('user[email]', array_var($user_data, 'email'), array('id' => 'profileFormEmail', 'class' => 'long')) ?>
  </div>
  
  <div>
    <?php echo label_tag(lang('homepage'), 'profileFormHomepage', false) ?>
    <?php echo text_field('user[homepage]', array_var($user_data, 'homepage'), array('id' => 'profileFormHomepage', 'class' => 'long')) ?>
  </div>
  
  <div>
    <?php echo label_tag(lang('timezone'), 'profileFormTimezone', true)?>
    <?php echo select_timezone_widget('user[timezone]', array_var($user_data, 'timezone'), array('id' => 'profileFormTimezone', 'class' => 'long')) ?>
  </div>

  <div>
    <?php echo label_tag(lang('use gravatar'), 'profileFormUseGravatar', true) ?>
    <?php echo yes_no_widget('user[use_gravatar]', 'profileFormUseGravatar', array_var($user_data, 'use_gravatar'), lang('yes'), lang('no')) ?>
  </div>
    
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
        <td style="vertical-align: middle"><?php echo text_field('user[im_' . $im_type->getId() . ']', array_var($user_data, 'im_' . $im_type->getId()), array('id' => 'profileFormIm' . $im_type->getId())) ?></td>
        <td style="vertical-align: middle"><?php echo radio_field('user[default_im]', array_var($user_data, 'default_im') == $im_type->getId(), array('value' => $im_type->getId())) ?></td>
      </tr>
<?php } // foreach ?>
    </table>
    <p class="desc"><?php echo lang('primary im description') ?></p>
  </fieldset>
<?php } // if ?>
  
  <fieldset>
    <legend><?php echo lang('phone numbers') ?></legend>
    
    <div>
      <?php echo label_tag(lang('office phone number'), 'profileFormOfficeNumber') ?>
      <?php echo text_field('user[office_number]', array_var($user_data, 'office_number'), array('id' => 'profileFormOfficeNumber')) ?>
    </div>
    
    <div>
      <?php echo label_tag(lang('fax number'), 'profileFormFaxNumber') ?>
      <?php echo text_field('user[fax_number]', array_var($user_data, 'fax_number'), array('id' => 'profileFormFaxNumber')) ?>
    </div>
    
    <div>
      <?php echo label_tag(lang('mobile phone number'), 'profileFormMobileNumber') ?>
      <?php echo text_field('user[mobile_number]', array_var($user_data, 'mobile_number'), array('id' => 'profileFormMobileNumber')) ?>
    </div>
    
    <div>
      <?php echo label_tag(lang('home phone number'), 'profileFormHomeNumber') ?>
      <?php echo text_field('user[home_number]', array_var($user_data, 'home_number'), array('id' => 'profileFormHomeNumber')) ?>
    </div>
    
  </fieldset>
  
  <?php echo submit_button(lang('update profile')) ?>

</form>