<?php trace(__FILE__,'begin') ?>
<?php set_page_title(lang('login')) ?>
<?php trace(__FILE__,'get_url') ?>

<form action="<?php echo get_url('access', 'login') ?>" method="post">

<?php trace(__FILE__,'form_errors') ?>
<?php tpl_display(get_template_path('form_errors')) ?>

<div class="container">
  <div><?php echo config_option('installation_welcome_logo', ''); ?></div>
  <div class="left">
    <div id="loginUsernameDiv">
      <label for="loginUsername"><?php echo lang('username') ?>:</label>
      <?php echo text_field('login[username]', array_var($login_data, 'username'), array('id' => 'loginUsername', 'class' => 'medium', 'tabindex' => 1)) ?>
    </div>
  </div>
  <div class="right">
    <div id="loginPasswordDiv">
      <label for="loginPassword"><?php echo lang('password') ?>:</label>
      <?php echo password_field('login[password]', null, array('id' => 'loginPassword', 'class' => 'medium', 'tabindex' => 2)) ?>
    </div>
    <div id="loginSubmit"><?php echo submit_button(lang('login'), null, array('tabindex' => 3) ) ?></div>
  </div>
  <div style="clear:both"></div>
  <div id="welcome_text"><?php echo config_option('installation_welcome_text', ''); ?></div>
</div>

<?php if (isset($login_data) && is_array($login_data) && count($login_data)) { ?>
<?php   foreach ($login_data as $k => $v) { ?>
<?php     if (str_starts_with($k, 'ref_')) { ?>
  <input type="hidden" name="login[<?php echo $k ?>]" value="<?php echo clean($login_data[$k]) ?>" />
<?php     } // if ?>
<?php   } // foreach ?>
<?php } // if ?>
</form>

<script type="text/javascript">document.forms[0].loginUsername.focus();</script>
<?php trace(__FILE__,'end') ?>