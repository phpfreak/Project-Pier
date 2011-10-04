<?php

  /**
  * Main installation file. Load specific steps and prepare the installation
  *
  * @package ScriptInstaller
  * @subpackage installation
  * @version 1.0
  * @http://www.projectpier.org/
  */
  
  // Include steps
  require_once INSTALLER_PATH . '/installation/steps/WelcomeStep.class.php';
  require_once INSTALLER_PATH . '/installation/steps/ChecksStep.class.php';
  require_once INSTALLER_PATH . '/installation/steps/SystemConfigStep.class.php';
  require_once INSTALLER_PATH . '/installation/steps/FinishStep.class.php';
  
  // Construct installer
  $installer = new ScriptInstaller('ProjectPier installation', 'This wizard will guide you through the ProjectPier installation process');
  
  // Add steps
  define('INSTALL_WELCOME', $installer->addStep(new WelcomeStep()));
  define('INSTALL_CHECKS', $installer->addStep(new ChecksStep()));
  define('INSTALL_SYSTEM_CONFIG', $installer->addStep(new SystemConfigStep()));
  define('INSTALL_FINISH', $installer->addStep(new FinishStep()));
  
?>