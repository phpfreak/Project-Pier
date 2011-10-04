<?php
  function trace() { }

  require_once dirname(__FILE__) . '/include.php';
  
  // Prepare and execute
  require_once INSTALLER_PATH . '/installation/installation.php'; 
  if (!isset($installer) || !is_object($installer)) {
    die('Installer not prepared.');
  } // if
  
  $installer->executeStep(array_var($_GET, 'step', 1))

?>