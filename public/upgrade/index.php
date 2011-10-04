<?php

  require_once dirname(__FILE__) . '/include.php';
  
  $upgrader = new ScriptUpgrader(new Output_Html(), 'Upgrade ProjectPier', 'Upgrade your ProjectPier installation');
  $form_data = array_var($_POST, 'form_data');
      
  tpl_assign('upgrader', $upgrader);
  tpl_assign('form_data', $form_data);
  if (is_array($form_data)) {
    ob_start();
    $upgrader->executeScript(trim(array_var($form_data, 'script_class')));
    $status_messages = explode("\n", trim(ob_get_clean()));
    
    tpl_assign('status_messages', $status_messages);
  } // if
  
  tpl_display(get_template_path('layout'));

?>