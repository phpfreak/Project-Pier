<?php set_page_title(lang('login')) ?>
<form action="<?php echo get_url('access', 'login') ?>" method="post">

<?php tpl_display(get_template_path('form_errors')) ?>

  <div id="loginUsernameDiv">
    <label for="loginUsername"><?php echo lang('username') ?>:</label>
    <?php echo text_field('login[username]', array_var($login_data, 'username'), array('id' => 'loginUsername', 'class' => 'medium')) ?>
  </div>
  <div id="loginPasswordDiv">
    <label for="loginPassword"><?php echo lang('password') ?>:</label>
    <?php echo password_field('login[password]', null, array('id' => 'loginPassword', 'class' => 'medium')) ?>
  </div>
  <div class="clean"></div>
  <div style="margin-top: 6px">
    <?php echo checkbox_field('login[remember]', (array_var($login_data, 'remember') == 'checked'), array('id' => 'loginRememberMe')) ?>
    <label class="checkbox" for="loginRememberMe"><?php echo lang('remember me') ?></label>
  </div>
  
<?php if (isset($login_data) && is_array($login_data) && count($login_data)) { ?>
<?php foreach ($login_data as $k => $v) { ?>
<?php if (str_starts_with($k, 'ref_')) { ?>
  <input type="hidden" name="login[<?php echo $k ?>]" value="<?php echo clean($login_data[$k]) ?>" />
<?php } // if ?>
<?php } // foreach ?>
<?php } // if ?>
  
  <div id="loginSubmit"><?php echo submit_button(lang('login')) ?><span>(<a href="<?php echo get_url('access', 'forgot_password') ?>"><?php echo lang('forgot password') ?>?</a>)</span></div>
  <!-- <p><a href="<?php echo get_url('access', 'forgot_password') ?>"><?php echo lang('forgot password') ?></a></p> -->
</form>
