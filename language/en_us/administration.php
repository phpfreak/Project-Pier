<?php

  return array(
  
    // ---------------------------------------------------
    //  Administration tools
    // ---------------------------------------------------
    
    'administration tool name test_mail_settings' => 'Test mail settings',
    'administration tool desc test_mail_settings' => 'Use this simple tool to send test emails to check if the ProjectPier mailer is configured properly',
    'administration tool name mass_mailer' => 'Mass mailer',
    'administration tool desc mass_mailer' => 'Simple tool that lets you send plain text messages to any group of users registered in the system',

    // ---------------------------------------------------
    //  Configuration categories and options
    // ---------------------------------------------------
  
    'configuration' => 'Configuration',
    
    'mail transport mail()' => 'Default PHP settings',
    'mail transport smtp' => 'SMTP server',
    
    'secure smtp connection no'  => 'No',
    'secure smtp connection ssl' => 'Yes, use SSL',
    'secure smtp connection tls' => 'Yes, use TLS',
    
    'file storage file system' => 'File system',
    'file storage mysql' => 'Database (MySQL)',
    
    // Categories
    'config category name general' => 'General',
    'config category desc general' => 'General ProjectPier settings',
    'config category name mailing' => 'Mailing',
    'config category desc mailing' => 'Use these settings to set up how ProjectPier should handle the sending of emails. You can use the configuration options provided in your php.ini or set it so it uses any other SMTP server',
    'config category name features' => 'Features',
    'config category desc features' => 'Use this set of settings to enable/disable different features and choose between different methods of displaying project data',
    'config category name database' => 'Database',
    'config category desc database' => 'Use this set of settings to set database options',
    
    // ---------------------------------------------------
    //  Options
    // ---------------------------------------------------
    
    // General
    'config option name site_name' => 'Site name',
    'config option desc site_name' => 'This value will be displayed as the site name on the Dashboard page',
    'config option name file_storage_adapter' => 'File storage',
    'config option desc file_storage_adapter' => 'Select where you want to store attachments, avatars, logos and any other uploaded documents. <strong>Database storage engine is recommended</strong>.',
    'config option name default_project_folders' => 'Default folders',
    'config option desc default_project_folders' => 'Folders that will be created when a project is created. Every folder name should be on a new line. Duplicate or empty lines will be ignored',
    'config option name theme' => 'Theme',
    'config option desc theme' => 'Using themes you can change the default look and feel of ProjectPier',
    'config option name calendar_first_day_of_week' => 'First day of the week',
    'config option name check_email_unique' => 'Email address must be unique',
    'config option name remember_login_lifetime' => 'Seconds to stay logged in',
    'config option name installation_root' => 'The path to the web site',
    'config option name installation_welcome_logo' => 'Logo on login page',
    'config option name installation_welcome_text' => 'Text on login page',
    'config option name installation_base_language' => 'Base language (also for login page)',

    // LDAP authentication support
    'config option name ldap_domain' => 'LDAP domain',
    'config option desc ldap_domain' => 'Your active directory domain',
    'config option name ldap_host' => 'LDAP host',
    'config option desc ldap_host' => 'Your active directory host name/IP',
    'secure ldap connection no' => 'No',
    'secure ldap connection tls' => 'Yes, use TLS',
    'config option name ldap_secure_connection' => 'Use secure LDAP connection',
    
    // ProjectPier
    'config option name upgrade_check_enabled' => 'Enable upgrade check',
    'config option desc upgrade_check_enabled' => 'If \'Yes\' the system will once a day check if there are new versions of ProjectPier available for download',
    'config option name logout_redirect_page' => 'Redirect page on logout',
    'config option desc logout_redirect_page' => 'Set a page to redirect users to after logout.  Change to default to use default setting',
    
    // Mailing
    'config option name exchange_compatible' => 'Microsoft Exchange compatibility mode',
    'config option desc exchange_compatible' => 'If you are using Microsoft Exchange Server set this option to yes to avoid some known mailing problems.',
    'config option name mail_transport' => 'Mail transport',
    'config option desc mail_transport' => 'You can use the default PHP settings for sending emails or specify an SMTP server',
    'config option name mail_from' => 'Mail From: address',
    'config option name mail_use_reply_to' => 'Use Reply-To: for From',
    'config option name smtp_server' => 'SMTP server',
    'config option name smtp_port' => 'SMTP port',
    'config option name smtp_authenticate' => 'Use SMTP authentication',
    'config option name smtp_username' => 'SMTP username',
    'config option name smtp_password' => 'SMTP password',
    'config option name smtp_secure_connection' => 'Use secure SMTP connection',

    'config option name per_project_activity_logs' => 'Per-project activity logs',
    'config option name categories_per_page' => 'Number of categories per page',

    'config option name character_set' => 'Character set to use',
    'config option name collation' => 'Character sort order',

    'config option name session_lifetime' => 'Session lifetime',
    'config option name default_controller' => 'Default main page',
    'config option name default_action' => 'Default subpage',

    'config option name logs_show_icons' => 'Show icons in the application log',
    'config option name default_private' => 'Default setting for private option',
  ); // array

?>
