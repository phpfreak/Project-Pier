<?php

  if ($company->isOwner()) {
    set_page_title(lang('edit company'));
    administration_tabbed_navigation(ADMINISTRATION_TAB_COMPANY);
    administration_crumbs(array(
      array(lang('company'), get_url('administration', 'company')),
      array(lang('edit company'))
    ));
  } else {
    set_page_title($company->isNew() ? lang('add client') : lang('edit client'));
    administration_tabbed_navigation(ADMINISTRATION_TAB_CLIENTS);
    administration_crumbs(array(
      array(lang('clients'), get_url('administration', 'clients')),
      array($company->isNew() ? lang('add client') : lang('edit client'))
    ));
  } // if

?>
<?php if ($company->isNew()) { ?>
<form action="<?php echo get_url('company', 'add_client') ?>" method="post">
<?php } else { ?>
<form action="<?php echo $company->getEditUrl() ?>" method="post">
<?php } // if ?>

<?php tpl_display(get_template_path('form_errors')) ?>

  <div>
    <?php echo label_tag(lang('name'), 'clientFormName', true) ?>
    <?php echo text_field('company[name]', array_var($company_data, 'name'), array('id' => 'clientFormName')) ?>
  </div>
  
  <div>
    <?php echo label_tag(lang('timezone'), 'clientFormTimezone', true)?>
    <?php echo select_timezone_widget('company[timezone]', array_var($company_data, 'timezone'), array('id' => 'clientFormTimezone', 'class' => 'long')) ?>
  </div>
    
  <div>
    <?php echo label_tag(lang('description'), 'clientFormDescription') ?>
    <?php echo textarea_field('company[description]', array_var($company_data, 'description'), array('id' => 'clientFormDescription')) ?>
  </div>
  
  <fieldset>
    <legend><?php echo lang('company online') ?></legend>
    
    <div>
      <?php echo label_tag(lang('email address'), 'clientFormEmail') ?>
      <?php echo text_field('company[email]', array_var($company_data, 'email'), array('id' => 'clientFormEmail')) ?>
    </div>
    
    <div>
      <?php echo label_tag(lang('homepage'), 'clientFormHomepage') ?>
      <?php echo text_field('company[homepage]', array_var($company_data, 'homepage'), array('id' => 'clientFormHomepage')) ?>
    </div>
  </fieldset>

  <fieldset>
    <legend><?php echo lang('phone numbers') ?></legend>
    
    <div>
      <?php echo label_tag(lang('phone number'), 'clientFormPhoneNumber') ?>
      <?php echo text_field('company[phone_number]', array_var($company_data, 'phone_number'), array('id' => 'clientFormPhoneNumber')) ?>
    </div>
    
    <div>
      <?php echo label_tag(lang('fax number'), 'clientFormFaxNumber') ?>
      <?php echo text_field('company[fax_number]', array_var($company_data, 'fax_number'), array('id' => 'clientFormFaxNumber')) ?>
    </div>
    
  </fieldset>

  <fieldset>
    <legend><?php echo lang('address') ?></legend>
    
    <div>
      <?php echo label_tag(lang('address'), 'clientFormAddress') ?>
      <?php echo text_field('company[address]', array_var($company_data, 'address'), array('id' => 'clientFormAddress')) ?>
    </div>
    
    <div>
      <?php echo label_tag(lang('address2'), 'clientFormAddress2') ?>
      <?php echo text_field('company[address2]', array_var($company_data, 'address2'), array('id' => 'clientFormAddress2')) ?>
    </div>
    
    <div>
      <?php echo label_tag(lang('city'), 'clientFormCity') ?>
      <?php echo text_field('company[city]', array_var($company_data, 'city'), array('id' => 'clientFormCity')) ?>
    </div>
    
    <div>
      <?php echo label_tag(lang('state'), 'clientFormState') ?>
      <?php echo text_field('company[state]', array_var($company_data, 'state'), array('id' => 'clientFormState')) ?>
    </div>
    
    <div>
      <?php echo label_tag(lang('zipcode'), 'clientFormZipcode') ?>
      <?php echo text_field('company[zipcode]', array_var($company_data, 'zipcode'), array('id' => 'clientFormZipcode')) ?>
    </div>
    
    <div>
      <?php echo label_tag(lang('country'), 'clientFormCountry') ?>
      <?php echo select_country_widget('company[country]', array_var($company_data, 'country'), array('id' => 'clientFormCountry')) ?>
    </div>
    
  </fieldset>
  
<?php if (!$company->isNew() && $company->isOwner()) { ?>
  <?php echo submit_button(lang('edit company')) ?>
<?php } else { ?>
  <?php echo submit_button($company->isNew() ? lang('add client') : lang('edit company')) ?>
<?php } // if ?>

</form>