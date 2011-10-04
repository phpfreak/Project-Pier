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
  <div><?php echo config_option('installation_welcome_logo', ''); ?></div>
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
            <option value="cs_cz">Čeština</option>
            <option value="de_de">Deutsch</option>
            <option value="el_gr">Ελληνικά</option>
            <option selected="selected" value="en_us">English (U.S.)</option>
            <option value="es_es">Español (España)</option>
            <option value="es_la">Español (Latinoamérica)</option>
            <option value="fr_fr">Français</option>
            <option value="hu_hu">Magyar</option>
            <option value="it_it">Italiano</option>
            <option value="ja_jp">日本語</option>
            <option value="ko_kr">한국어</option>
            <option value="nl_nl">Nederlands</option>
            <option value="pl_pl">Polski</option>
            <option value="pt_br">Português</option>
            <option value="ru_ru">Pусский</option>
            <option value="zh_cn">中文 (中国)</option>
            <option value="zh_tw">中文 (臺灣)</option>
          </select>
        </li>
        <li>
          <label for="loginTheme"><?php echo lang('theme'); ?></label><select name="loginTheme" id="loginTheme">
            <option selected="selected" value="marine">Marine</option>
            <option value="default">default</option>
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
          <label class="checkbox" for="loginRememberMe"><?php echo lang('remember me', duration(config_option('remember_login_lifetime'))) ?></label><br />
          <?php echo checkbox_field('login[remember]', (array_var($login_data, 'remember') == 'checked'), array('id' => 'loginRememberMe')) ?>
        </li>
        <li>
          <label class="checkbox" for="trace"><?php echo lang('enable trace') ?></label><br />
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

<script type="text/javascript">document.forms[0].loginUsername.focus()</script>
<?php trace(__FILE__,'end') ?>