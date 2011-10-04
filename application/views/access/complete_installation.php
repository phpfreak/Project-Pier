<?php set_page_title(lang('complete installation')) ?>
<form action="<?php echo get_url('access', 'complete_installation') ?>" method="post">
<?php tpl_display(get_template_path('form_errors')) ?>

  <p><?php echo lang('complete installation desc') ?></p>

  <h2><?php echo lang('administrator') ?></h2>

  <div>
    <?php echo label_tag(lang('username'), 'adminUsername', true) ?>
    <?php echo text_field('form[admin_username]', array_var($form_data, 'admin_username'), array('id' => 'adminUsername', 'class' => 'medium')) ?>
  </div>
  <div>
    <?php echo label_tag(lang('email address'), 'adminEmail', true) ?>
    <?php echo text_field('form[admin_email]', array_var($form_data, 'admin_email'), array('id' => 'adminEmail', 'class' => 'long')) ?>
  </div>
  <div>
    <?php echo label_tag(lang('password'), 'adminPassword', true) ?>
    <?php echo password_field('form[admin_password]', null, array('id' => 'adminPassword', 'class' => 'medium')) ?>
  </div>
  <div>
    <?php echo label_tag(lang('password again'), 'adminPasswordA', true) ?>
    <?php echo password_field('form[admin_password_a]', null, array('id' => 'adminPasswordA', 'class' => 'medium')) ?>
  </div>
  
  <h2><?php echo lang('company') ?></h2>
  
  <div>
    <?php echo label_tag(lang('name'), 'companyName', true) ?>
    <?php echo text_field('form[company_name]', array_var($form_data, 'company_name'), array('id' => 'companyName', 'class' => 'long')) ?>
  </div>
  
  <input type="hidden" name="form[submitted]" value="submitted" />
  
  <?php echo submit_button('submit') ?>
  
</form>