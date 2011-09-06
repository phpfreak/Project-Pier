<?php
  trace(__FILE__,'begin');
  $login_show_options = config_option('login_show_options', false);
  if ($login_show_options) {
    tpl_display(get_template_path('login1', 'access'));
  } else {
    tpl_display(get_template_path('login2', 'access'));
  }
  trace(__FILE__,'end');
?>