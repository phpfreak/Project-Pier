<?php

  return array(
  
    // ---------------------------------------------------
    //  Administration tools
    // ---------------------------------------------------
    
    'administration tool name test_mail_settings' => 'Test mail instellingen',
    'administration tool desc test_mail_settings' => 'Gebruik dit simpel gereedschap om te testen of alle mail instellingen correct zijn',
    'administration tool name mass_mailer' => 'Massa mailer',
    'administration tool desc mass_mailer' => 'Simpel gereedschap dat je toelaat om gewone tekst berichten te sturen naar gebruikersgroepen',
    'administration tool name system_info' => 'Systeem informatie',
    'administration tool desc system_info' => 'Simpel gereedschap dat je de systeem details laat zien',
    'administration tool name browse_log' => 'Blader door de systeem log',
    'administration tool desc browse_log' => 'Gebruik dit gereedschap om door de systeemlog te bladeren om fouten te ontdekken',

    // ---------------------------------------------------
    //  Configuration categories and options
    // ---------------------------------------------------
  
    'configuration' => 'Configuratie',
    
    'mail transport mail()' => 'Standaard PHP instellingen',
    'mail transport smtp' => 'SMTP server',
    
    'secure smtp connection no'  => 'Nee',
    'secure smtp connection ssl' => 'Ja, gebruik SSL',
    'secure smtp connection tls' => 'Ja, gebruik TLS',
    
    'file storage file system' => 'Bestandssysteem',
    'file storage mysql' => 'Database (MySQL)',
    
    // Categories
    'config category name general' => 'Algemeen',
    'config category desc general' => 'Algemene ProjectPier instellingen',
    'config category name mailing' => 'Mailing',
    'config category desc mailing' => 'Gebruik deze instellingen om op te geven hoe ProjectPier e-mails moet versturen. Je kan de configuratie opties gebruiken die zijn opgegeven in je php.ini of stel een SMTP server in.',
    'config category name features' => 'Features',
    'config category desc features' => 'Gebruik deze reeks instellingen om verschillende mogelijkheden in/uit te schakelen en kies tussen verschillende manieren om project data weer te geven.',
    'config category name database' => 'Database',
    'config category desc database' => 'Gebruik deze reeks instellingen om de database in te stellen',
    'config category name authentication' => 'Authenticatie',
    'config category desc authentication' => 'Toegang tot alle authenticatie instellingen',
    
    // ---------------------------------------------------
    //  Options
    // ---------------------------------------------------
    
    // General
    'config option name site_name' => 'Site naam',
    'config option desc site_name' => 'Deze waarde zal getoond worden als de sitenaam!',
    'config option name file_storage_adapter' => 'Bestandsbeheer',
    'config option desc file_storage_adapter' => 'Selecteer waar je avatars, logo\'s en andere documenten wil opslaan. <strong>Database storage engine is aanbevolen</strong>.',
    'config option name default_project_folders' => 'Standaard folders',
    'config option desc default_project_folders' => 'Folders die bij elk project aangemaakt zullen worden. Elke Foldernaam moet op een nieuwe regel beginnen. Dubbele ingaves of lege lijnen zullen genegeerd worden.',
    'config option name theme' => 'Thema',
    'config option desc theme' => 'Dankzij de verschillende thema keuzes kan je ProjectPier aanpassen naar je eigen zin',
    'config option name calendar_first_day_of_week' => 'Eerste dag van de week',
    'config option name check_email_unique' => 'Email adres moet uniek zijn',
    'config option name remember_login_lifetime' => 'Aantal seconden om aangemeld te blijven',
    'config option name installation_root' => 'Het pad naar de website',
    'config option name installation_welcome_logo' => 'Logo op de login pagina',
    'config option name installation_welcome_text' => 'Text op de login pagina',
    'config option name installation_base_language' => 'Basistaal (ook voor op de login pagina)',
    'config option name dashboard action index' => 'Overzicht',
    'config option name dashboard action my_projects' => 'Mijn Projecten',
    'config option name dashboard action my_tasks' => 'Mijn taken',
    'config option name dashboard action my_projects_by_name' => 'Mijn Projecten - geordend op naam',
    'config option name dashboard action my_projects_by_priority' => 'Mijn Projecten - geordend naar prioriteit',
    'config option name dashboard action my_projects_by_milestone' => 'Mijn Projecten - geordend op mijlpaal',
    'config option name dashboard action my_tasks_by_name' => 'Mijn taken - geordend op naam',
    'config option name dashboard action my_tasks_by_priority' => 'Mijn taken - geordend naar prioriteit',
    'config option name dashboard action my_tasks_by_milestone' => 'Mijn taken - geordend op mijlpaal',
    'config option name dashboard action contacts' => 'Contactpersonen',
    'config option name dashboard action search_contacts' => 'Zoek contactpersonen',

    // LDAP authentication support
    'config option name ldap_domain' => 'LDAP domein',
    'config option desc ldap_domain' => 'Je active directory domein',
    'config option name ldap_host' => 'LDAP host',
    'config option desc ldap_host' => 'Je active directory hostnaam/IP',
    'secure ldap connection no' => 'Nee',
    'secure ldap connection tls' => 'Ja, gebruik TLS',
    'config option name ldap_secure_connection' => 'Gebruik een beveiligde LDAP verbinding',
    
    // ProjectPier
    'config option name upgrade_check_enabled' => 'Upgrade controle inschakelen',
    'config option desc upgrade_check_enabled' => 'Indien \'Ja\' zal het systeem 1 keer per dag controleren of er een nieuwere versie van ProjectPier beschikbaar is voor download',
    'config option name logout_redirect_page' => 'Redirect pagina naar ... na afmelden',
    'config option desc logout_redirect_page' => 'Stel een pagina in om Gebruikers heen te sturen na het uitloggen.  Verander naar standaard om de standaardinstellingen te gebruiken.',
    
    // Mailing
    'config option name exchange_compatible' => 'Microsoft Exchange compatibiliteits mode',
    'config option desc exchange_compatible' => 'Als je Microsoft Exchange Server gebruikt stel deze optie dan in op ja om enkele gekende problemen op te lossen.',
    'config option name mail_transport' => 'Mail transport',
    'config option desc mail_transport' => 'Je kan de standaard instellingen van PHP gebruiken om mail te versturen of je kan een SMTP¨server instellen.',
    'config option name mail_from' => 'Mail Van adres',
    'config option name mail_use_reply_to' => 'Gebruik Reply-Naar voor Van',
    'config option name smtp_server' => 'SMTP server',
    'config option name smtp_port' => 'SMTP poort',
    'config option name smtp_authenticate' => 'Gebruik SMTP authenticatie',
    'config option name smtp_username' => 'SMTP gebruikersnaam',
    'config option name smtp_password' => 'SMTP paswoord',
    'config option name smtp_secure_connection' => 'Gebruik een beveiligde SMTP verbinding',

    'config option name per_project_activity_logs' => 'Per-project activiteitenlogboek',
    'config option name categories_per_page' => 'aantal categorieen per pagina',

    'config option name character_set' => 'Gebruik ... karakter set',
    'config option name collation' => 'karakter sorteer orde',

    'config option name session_lifetime' => 'Sessie levensduur',
    'config option name default_controller' => 'Standaard hoofd pagina',
    'config option name default_action' => 'Laat na aanmelden deze pagina zien',

    'config option name logs_show_icons' => 'Toon iconen in de applicatie logboek',
    'config option name default_private' => 'Standaard instellingen voor private opties',
    'config option name send_notification_default' => 'Standaard instellingen voor Verstuur notificatiie',
    'config option name enable_efqm' => 'EFQM opties inschakelen',
    'config option name login_show_options' => 'Toon oties op de login pagina',
    'config option desc login_show_options' => 'Zoja, opties om de taal en het thema te kiezern zijn zichtbaar.',
    'config option name display_application_logs' => 'Toon aplicatie logboeken',
    'config option desc display_application_logs' => 'Zoniet, Logboek wordt nog steeds bijgehouden maar niet meer getoond.',
    'config option name dashboard_logs_count' => 'Max. aantal applicatie logboek lijnen te tonen',
    'config option desc dashboard_logs_count' => 'Limiteert het aantal logboek lijnen die getoond worden op het dashboard',

    // Authentication
    'config option name authdb server' => 'Database server',
    'config option desc authdb server' => 'Het ip adres oo de DNS naam van de database server voor authenticatie. Poort nummer kan toegevoegd worden.',
    'config option name authdb username' => 'Database Gebruikersnaam',
    'config option desc authdb username' => 'De Gebruikersnaam waarmee verbinding met de database wordt gemaakt',
    'config option name authdb password' => 'Database Paswoord',
    'config option desc authdb password' => 'Paswoord dat bij de Gebruiker hoort',
    'config option name authdb database' => 'Database naam',
    'config option desc authdb database' => 'Naam van de database op de database server',
    'config option name authdb sql' => 'Selecteer SQL',
    'config option desc authdb sql' => 'De SQL om een enkele rij uit de tabel met de gebruikersgegevens op te halen. Minstens één veld moet worden geretourneerd genaamd e-mail. $username /$password is de plaatshouder voor de gebruikersnaam/wachtwoord tijdens het inloggen.',

    'config option name parking space reservation url' => 'Parkeerplaats url',
    'config option desc parking space reservation url' => 'Geef de volledige URL naar de "parkeerplaats reserveren webapplicatie" om deze te starten',

    'config option name map url' => 'Toon kaart url',
    'config option desc map url' => 'De url om een kaart met de locatie van een contactpersoon of bedrijf weer te geven. $locatie is een plaatshouder voor de locatie details.',
    'config option name route url' => 'Toon wegbeschrijving url',
    'config option desc route url' => 'De url om een wegbeschrijving weer te geven, waarop een route van de locatie van de huidige gebruiker (contactpersoon) naar de locatie van een contactpersoon of bedrijf is weergegeven. $from/$to, is de plaatshouder voor het van/naar adres.',

  ); // array

?>