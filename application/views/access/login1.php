<?php trace(__FILE__,'begin') ?>
<?php set_page_title(lang('login')) ?>
<?php trace(__FILE__,'get_url') ?>
<script type="text/javascript">
  showOptions = function() {
    var options1 = document.getElementById("options1");
    var options2 = document.getElementById("options2");
    var show = document.getElementById("showOptionsLink");
    var hide = document.getElementById("hideOptionsLink");
    hide.style.position = "relative";
    show.style.position = "relative";
    hide.style.display = "inline";
    show.style.display = "none";
    options1.style.display = "block";
    options2.style.display = "block";
    hide.style.left = 0;
    show.style.left = "-999em";
    options1.style.left = 0;
    options2.style.left = 0;
  }
  hideOptions = function() {
    var options1 = document.getElementById("options1");
    var options2 = document.getElementById("options2");
    var show = document.getElementById("showOptionsLink");
    var hide = document.getElementById("hideOptionsLink");
    hide.style.position = "relative";
    show.style.position = "relative";
    hide.style.display = "none";
    show.style.display = "inline";
    options1.style.display = "none";
    options2.style.display = "none";
    hide.style.left = "-999em";
    show.style.left = 0;
    options1.style.left = "-999em";
    options2.style.left = "-999em";
    document.forms[0].loginUsername.focus();
  }
</script>
<form action="<?php echo get_url('access', 'login') ?>" method="post">

<?php trace(__FILE__,'form_errors') ?>
<?php tpl_display(get_template_path('form_errors')) ?>

<div class="container">
  <div><?php echo config_option('installation_welcome_logo', '<img src="'.get_image_url('projectpier-logo.png').'">'); ?></div>
  <div class="left">
    <div id="loginUsernameDiv">
      <label for="loginUsername"><?php echo lang('username') ?>:</label>
      <?php echo text_field('login[username]', array_var($login_data, 'username'), array('id' => 'loginUsername', 'class' => 'medium', 'tabindex' => 1)) ?>
    </div>
    <div id="loginOptionsLink"><label for="showOptionsLink"><a id="showOptionsLink" href="javascript:showOptions()"><?php echo lang('options'); ?></a>
     <a id="hideOptionsLink" class="hidden" href="javascript:hideOptions()"><?php echo lang('hide options'); ?></a></label></div>
    <div id="options1" class="hidden">
      <ul>
        <li>
          <label for="loginLanguage"><?php echo lang('language'); ?></label><select name="loginLanguage" id="loginLanguage">
<?php
$base_language = config_option('installation_base_language', 'en_us');
include(ROOT . '/language/locales.php');
if ($handle = opendir(ROOT . '/language')) {
  while (false !== ($file = readdir($handle))) {
    if ($file != "." && $file != "..") {
      if (array_key_exists( $file, $locales)) {
        if ($file == $base_language) {
          echo "<option value=\"$file\" selected=\"selected\">{$locales[$file]}</option>";
        } else {
          echo "<option value=\"$file\">{$locales[$file]}</option>";
        }
      }
    }
  }
  closedir($handle);
}
?>
          </select>
        </li>
        <li>
          <label for="loginTheme"><?php echo lang('theme'); ?></label><select name="loginTheme" id="loginTheme">
<?php
$base_theme = config_option('theme', 'redbase');
if ($handle = opendir(ROOT . '/public/assets/themes')) {
  while (false !== ($file = readdir($handle))) {
    if ($file != "." && $file != "..") {
      if ($file == $base_theme) {
        echo "<option value=\"$file\" selected=\"selected\">{$file}</option>";
      } else {
        echo "<option value=\"$file\">{$file}</option>";
      }
    }
  }
  closedir($handle);
}
?>
          </select>
        </li>
     </ul>
    </div>
  </div>
  <div class="right">
    <div id="loginPasswordDiv">
      <label for="loginPassword"><?php echo lang('password') ?>:</label>
      <?php echo password_field('login[password]', null, array('id' => 'loginPassword', 'class' => 'medium', 'tabindex' => 2)) ?>
    </div>
    <div id="loginSubmit"><?php echo submit_button(lang('login'), null, array('tabindex' => 3) ) ?></div>
    <div id="options2" class="hidden">
      <ul>
        <li id="loginClearCookies"><a href="<?php echo get_url('access', 'clear_cookies') ?>"><?php echo lang('clear cookies') ?></a></li>
        <li id="loginForgotPassword"><a href="<?php echo get_url('access', 'forgot_password') ?>"><?php echo lang('forgot password') ?></a></li>  
        <li>
          <label class="checkbox" for="loginRememberMe"><?php echo lang('remember me', duration(config_option('remember_login_lifetime'))) ?></label>
          <?php echo checkbox_field('login[remember]', (array_var($login_data, 'remember') == 'checked'), array('id' => 'loginRememberMe')) ?>
        </li>
        <li>
          <label class="checkbox" for="trace"><?php echo lang('enable trace') ?></label>
          <?php echo checkbox_field('trace', false, array('id' => 'trace')) ?>
        </li>
      </ul>
    </div>
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

<script type="text/javascript">hideOptions();</script>
<script type="text/javascript">document.forms[0].loginUsername.focus();</script>
<?php trace(__FILE__,'end') ?>