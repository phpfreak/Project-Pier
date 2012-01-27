<?php

  return array(
  
    // ---------------------------------------------------
    //  Administration tools
    // ---------------------------------------------------
    
    'administration tool name test_mail_settings' => 'Test mail settings',
    'administration tool desc test_mail_settings' => 'Use this simple tool to send test emails to check if the ProjectPier mailer is configured properly',
    'administration tool name mass_mailer' => 'Mass mailer',
    'administration tool desc mass_mailer' => 'Simple tool that lets you send plain text messages to any group of users registered in the system',
    'administration tool name system_info' => 'System information',
    'administration tool desc system_info' => 'Simple tool that shows you system details',
    'administration tool name browse_log' => 'Browse system log',
    'administration tool desc browse_log' => 'Use this tool to browse the system log and detect errors',

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
    'config category name authentication' => 'Authentication',
    'config category desc authentication' => 'Access to all authentication settings',
    
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
    'config option name dashboard action index' => 'Overview',
    'config option name dashboard action my_projects' => 'My Projects',
    'config option name dashboard action my_tasks' => 'My tasks',
    'config option name dashboard action my_projects_by_name' => 'My Projects - ordered by name',
    'config option name dashboard action my_projects_by_priority' => 'My Projects - ordered by priority',
    'config option name dashboard action my_projects_by_milestone' => 'My Projects - ordered by milestone',
    'config option name dashboard action my_tasks_by_name' => 'My Tasks - ordered by name',
    'config option name dashboard action my_tasks_by_priority' => 'My Tasks - ordered by priority',
    'config option name dashboard action my_tasks_by_milestone' => 'My Tasks - ordered by milestone',
    'config option name dashboard action contacts' => 'Contacts',
    'config option name dashboard action search_contacts' => 'Search contacts',

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
    'config option name default_action' => 'Page to show after login',

    'config option name logs_show_icons' => 'Show icons in the application log',
    'config option name default_private' => 'Default setting for private option',
    'config option name send_notification_default' => 'Default setting for Send notification',
    'config option name enable_efqm' => 'Enable EFQM options',
    'config option name login_show_options' => 'Show options on the login page',
    'config option desc login_show_options' => 'If yes, options for setting language and theme are shown.',
    'config option name display_application_logs' => 'Display application logs',
    'config option desc display_application_logs' => 'If no, logging still occurs but it is not displayed anymore.',
    'config option name dashboard_logs_count' => 'Max. number of application log lines to show',
    'config option desc dashboard_logs_count' => 'Limits the number of log lines to show on the dashboard',

    // Authentication
    'config option name authdb server' => 'Database server',
    'config option desc authdb server' => 'The ip address or DNS name of the database server for authentication. Port number can be included.',
    'config option name authdb username' => 'Database user name',
    'config option desc authdb username' => 'The user name to access the database',
    'config option name authdb password' => 'Database user name',
    'config option desc authdb password' => 'The password corresponding to the user',
    'config option name authdb database' => 'Database name',
    'config option desc authdb database' => 'Name of the database in the database server',
    'config option name authdb sql' => 'Select SQL',
    'config option desc authdb sql' => 'The SQL to retrieve a single row from the table containing the user details. At least 1 field should be returned named email. $username/$password is the placeholder for the user name/password during login.',

    'config option name parking space reservation url' => 'Parking space url',
    'config option desc parking space reservation url' => 'Enter the complete url to start the parking space reservation web application',

    'config option name map url' => 'Display map url',
    'config option desc map url' => 'The url to display a map showing the location of a contact or company. $location is the placeholder for the location details.',
    'config option name route url' => 'Display route url',
    'config option desc route url' => 'The url to display a route showing a route from the current user (contact) to the location of a contact or company. $from/$to is the placeholder for the from address/to address.',

  ); // array

?>