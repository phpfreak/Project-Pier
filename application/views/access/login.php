<?php trace(__FILE__,'begin') ?>
<?php set_page_title(lang('login')) ?>
<?php trace(__FILE__,'get_url') ?>
<script>
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
            <option value="da_dk">Dansk</option>
            <option value="de_de">Deutsch</option>
            <option selected="selected" value="en_us">English (U.S.)</option>
            <option value="es_es">Español</option>
            <option value="fr_fr">Français</option>
            <option value="is_is">Islenska</option>
            <option value="it_it">Italiano</option>
            <option value="nl_nl">Nederlands</option>
            <option value="no_nb">Norsk Bokmål</option>
            <option value="ru_ru">Russian</option>
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
          <label class="checkbox" for="trace"><?php echo lang('enable trace') ?></label><br>
          <?php echo checkbox_field('trace', false, array('id' => 'trace')) ?>
        </li>
      </ul>
    </div>
  </div>
  <div style="clear:both"></div>
  <div id="welcome_text"><?php echo config_option('installation_welcome_text', ''); ?></div>
  <div id="changes"><h3>Changes to standard 0.8.6</h3>
  <div id="language_packs"><h4>Language packs</h4>
  <ol>
  <li>Danish language by Michael Hansen Buur <a href=/pp086addons/language/da_dk_0_8_6.zip>Download</a></li>
  <li>Icelandic language by Björn Guðmundsson <a href=/pp086addons/language/is_is_0_8_6.zip>Download</a></li>
  <li>Italian language by Marco Torresendi <a href=/pp086addons/language/it_it_0_8_6.zip>Download</a></li>
  <li>Norwegian language by Egil Hansen <a href=/pp086addons/language/no_nb_0_8_6.zip>Download</a></li>
  <li>Russian language by Alexander Selifonov <a href=/pp086addons/language/ru_ru_0_8_6.zip>Download</a></li>
  </ol>
  <div id="patches"><h4>Patches</h4>
  <ol>
  <li>Global search <a href=http://www.projectpier.org/node/130>Details</a> <a href=/pp086patches/130-global-search.zip>Download</a></li>
  <li>Wiki pages sorted <a href=http://www.projectpier.org/node/1915#comment-5043>Details</a> <a href=/pp086patches/1915-wiki-ordering.zip>Download</a></li>
  <li>Log icons <a href=https://github.com/dbernar1/Project-Pier/tree/master/public/assets/themes/marine/images/logtypes>Download page</a></li>
  <li>Error clicking tags <a href=http://www.projectpier.org/node/2044>Details</a> <a href=/pp086patches/2044-error-clicking-tags.zip>Download</a></li>
  <li>Search form <a href=http://www.projectpier.org/node/2047>Details</a> <a href=/pp086patches/2047-search-form.zip>Download</a></li>
  <li>Crashed message comments display <a href=http://www.projectpier.org/node/2048>Details</a> <a href=/pp086patches/2048-private-comments-overlap.zip>Download</a></li>
  <li>Lowercase accented characters <a href=http://www.projectpier.org/node/2053>Details</a> <a href=/pp086patches/2053-lowercase.zip>Download</a></li>
  <li>Tickets change localized <a href=http://www.projectpier.org/node/2054>Details</a> <a href=/pp086patches/2054-ticket-change-localized.zip>Download</a></li>
  <li>Localized expand collapse <a href=http://www.projectpier.org/node/2064>Details</a> <a href=/pp086patches/2064-localized-expand-collapse.zip>Download</a></li>
  <li>Short tags getText() <a href=http://www.projectpier.org/node/2103>Details</a> <a href=/pp086patches/2058-missing-icons-for-logtypes.zip>Download</a></li>
  <li>kampPro broken layout tasks <a href=http://www.projectpier.org/node/2107>Details</a> <a href=/pp086patches/2107-kampPro-broken-layout-tasks.zip>Download</a></li>
  <li>Sidebar Css <a href=http://www.projectpier.org/node/2167>Details</a> <a href=/pp086patches/2167-sidebar-size.zip>Download</a></li>
  <li>Tickets <a href=http://www.projectpier.org/node/2180>Details</a> <a href=/pp086patches/2180-tickets.zip>Download</a></li>
  <li>Google Maps <a href=http://www.projectpier.org/node/2186>Details</a> <a href=/pp086patches/2186-postalcode-google-map.zip>Download</a></li>
  <li>Download all tasks <a href=http://www.projectpier.org/node/2205>Details</a> <a href=/pp086patches/2205-download-all-tasks.zip>Download</a></li>
  <li>Milestone progress, hide private items <a href=http://www.projectpier.org/node/2220>Details</a> <a href=/pp086patches/2220-milestone-progress-hide-private.zip>Download</a></li>
  <li>Project progress <a href=http://www.projectpier.org/node/2224>Details</a> <a href=/pp086patches/2224-project-progress.zip>Download</a></li>
  <li>Dates translated <a href=http://www.projectpier.org/node/672>Details</a> <a href=/pp086patches/672-dates-translated.zip>Download</a></li>
  </ol>
  </div>
</div>

<?php if (isset($login_data) && is_array($login_data) && count($login_data)) { ?>
<?php   foreach ($login_data as $k => $v) { ?>
<?php     if (str_starts_with($k, 'ref_')) { ?>
  <input type="hidden" name="login[<?php echo $k ?>]" value="<?php echo clean($login_data[$k]) ?>" />
<?php     } // if ?>
<?php   } // foreach ?>
<?php } // if ?>
</form>

<script>document.forms[0].loginUsername.focus()</script>
<?php trace(__FILE__,'end') ?>
