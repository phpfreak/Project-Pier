<?php

  return array(
  
    // ---------------------------------------------------
    //  Administration tools
    // ---------------------------------------------------
    
    'administration tool name test_mail_settings' => 'Tester les paramètres de messagerie électronique',
    'administration tool desc test_mail_settings' => 'Utiliser cet outil pour envoyer des emails de test et vérifier si le moteur de messagerie de ProjectPier est bien configuré',
    'administration tool name mass_mailer' => 'Envoi en masse',
    'administration tool desc mass_mailer' => 'Cet outil permet d\'envoyer un message en texte brut à un groupe d\'utilisateurs enregistrés dans le système',

    // ---------------------------------------------------
    //  Configuration categories and options
    // ---------------------------------------------------
  
    'configuration' => 'Configuration',
    
    'mail transport mail()' => 'Fonction mail de PHP',
    'mail transport smtp' => 'Serveur SMTP',
    
    'secure smtp connection no'  => 'Non',
    'secure smtp connection ssl' => 'Oui, utiliser SSL',
    'secure smtp connection tls' => 'Oui, utiliser TLS',
    
    'file storage file system' => 'Système de fichiers',
    'file storage mysql' => 'Base de données (MySQL)',
    
    // Categories
    'config category name general' => 'Général',
    'config category desc general' => 'Paramètres généraux de ProjectPier',
    'config category name mailing' => 'Messagerie électronique',
    'config category desc mailing' => 'Ces paramètres permettent de définir comment ProjectPier doit gérer l\'envoi d\'emails. Vous pouvez modifier les options de configuration présentes dans votre fichier php.ini ou paramétrer l\'utilisation d\'un serveur SMTP.',
    'config category name features' => 'Caractéristiques',
    'config category desc features' => 'Ces paramètres permettent d\'ativer/désactiver différents caractéristiques et choisir parmi différentes méthodes d\'affichage des données du projet',
    'config category name database' => 'Base de données',
    'config category desc database' => 'Ces paramètres permettent de configurer les options de base de données',
    
    // ---------------------------------------------------
    //  Options
    // ---------------------------------------------------
    
    // General
    'config option name site_name' => 'Nom du site',
    'config option desc site_name' => 'Cette valeur sera affichée comme nom du site dur la page tableau de bord',
    'config option name file_storage_adapter' => 'Stockage de fichiers',
    'config option desc file_storage_adapter' => 'Selectionnez l\'endroit où vous voulez stocker les pièces jointes, les avatars, les logos et tous les documents mis en ligne. <strong>Le stockage dans la base de données est recommandé</strong>',
    'config option name default_project_folders' => 'Dossiers par défaut',
    'config option desc default_project_folders' => 'Dossiers à créer avec le projet. Chaque nom de dossier doit figurer sur une nouvelle ligne. Les doublons ou les lignes vides seront ignorées',
    'config option name theme' => 'Thème',
    'config option desc theme' => 'En changeant de thème, vous pouvez changer l\'apparence de ProjectPier',
    'config option name calendar_first_day_of_week' => 'Premier jour de la semaine',
    'config option name check_email_unique' => 'Email address must be unique',
    'config option name remember_login_lifetime' => 'Seconds to stay logged in',
    'config option name installation_root' => 'The path to the web site',

    // LDAP authentication support
    'config option name ldap_domain' => 'Domaine LDAP',
    'config option desc ldap_domain' => 'Votre domaine active directory',
    'config option name ldap_host' => 'hôte LDAP',
    'config option desc ldap_host' => 'Le nom/l\'adresse IP de votre serveur LDAP',
    'secure ldap connection no' => 'Non',
    'secure ldap connection tls' => 'Oui, utiliser TLS',
    'config option name ldap_secure_connection' => 'Utiliser une connexion LDAP sécurisée',
    
    // ProjectPier
    'config option name upgrade_check_enabled' => 'Activer la vérification de mise à jour de ProjectPier',
    'config option desc upgrade_check_enabled' => 'Si vous sélectionnez "Oui", le système ira vérifier tous les jours s\'il existe une nouvelle version de ProjectPier à télécharger',
    'config option name logout_redirect_page' => 'Page de redirection après la déconnexion',
    'config option desc logout_redirect_page' => 'Spécifie une page où rediriger les utilisateurs après la déconnexion. Indiquer défaut pour utiliser la valeur par défaut',
    
    // Mailing
    'config option name exchange_compatible' => 'Compatiblité avec Microsoft Exchange',
    'config option desc exchange_compatible' => 'Si vous utilisez Microsoft Exchange Server, réglez cette option sur "Oui" pour éviter certains problèmes de messagerie connus.',
    'config option name mail_transport' => 'Méthode d\'envoi des messages électroniques',
    'config option desc mail_transport' => 'Vous pouvez utiliser les paramètres PHP ou indiquer un serveur SMTP pour envoyer les messages électroniques.',
    'config option name mail_from' => 'Mail From: address',
    'config option name mail_use_reply_to' => 'Use Reply-To: for From',
    'config option name smtp_server' => 'Serveur SMTP',
    'config option name smtp_port' => 'Port SMTP',
    'config option name smtp_authenticate' => 'Utiliser l\'authentification SMTP',
    'config option name smtp_username' => 'Nom d\'utilisateur SMTP',
    'config option name smtp_password' => 'Mot de passe SMTP',
    'config option name smtp_secure_connection' => 'Utiliser une connexion SMTP sécurisée',

    'config option name per_project_activity_logs' => 'Journalisation de l\'activité par project',
    'config option name categories_per_page' => 'Nombre de catégories par page',

    'config option name character_set' => 'Jeu de caractères à utiliser',
    'config option name collation' => 'Ordre des caractères',

    'config option name session_lifetime' => 'Durée de la session',
    'config option name default_controller' => 'Page principale par défaut',
    'config option name default_action' => 'Default subpage',

    'config option name logs_show_icons' => 'Montrer les icônes dansShow icons in the application log',
    'config option name default_private' => 'Paramétrage par défaut pour l\'option privé',

		'administration tool name system_info' => 'Informations Système',
		'administration tool desc system_info' => 'Un outil simple montrant les détails du système',
		'administration tool name browse_log' => 'Parcourir le rapport système',
		'administration tool desc browse_log' => 'Utilisez cet outil pour voir le rapport système afin de détecter des erreurs',
		'config category name authentication' => 'Authentification',
		'config category desc authentication' => 'Accès à tous les réglages d\'authentification',
		'config option name installation_welcome_logo' => 'Logo de la page d\'authentification',
		'config option name installation_welcome_text' => 'Texte de la page d\'authentification',
		'config option name installation_base_language' => 'Langage de base (aussi pour la page d\'authentification)',
		'config option name dashboard action index' => 'Vue d\'ensemble',
		'config option name dashboard action my_projects' => 'Mes Projets',
		'config option name dashboard action my_tasks' => 'Mes tâches',
		'config option name dashboard action my_projects_by_name' => 'Mes Projets - ordonnés par nom',
		'config option name dashboard action my_projects_by_priority' => 'Mes Projets - ordonnés par priorité',
		'config option name dashboard action my_projects_by_milestone' => 'Mes Projets - ordonnés par jalon',
		'config option name dashboard action my_tasks_by_name' => 'My tâches - ordonnés par nom',
		'config option name dashboard action my_tasks_by_priority' => 'My tâches - ordonnés par priorité',
		'config option name dashboard action my_tasks_by_milestone' => 'My tâches - ordonnés par jalon',
		'config option name dashboard action contacts' => 'Contacts',
		'config option name dashboard action search_contacts' => 'Recherche contacts',
		'config option name send_notification_default' => 'Réglages par défaut pour l\'envoi de notifications',
		'config option name enable_efqm' => 'Activer les options EFQM',
		'config option name login_show_options' => 'Montrer les options sur la page d\'authentification',
		'config option desc login_show_options' => 'Si oui, les options de langage et de thèmes sont visibles.',
		'config option name display_application_logs' => 'Voir le rapports d\'application',
		'config option desc display_application_logs' => 'Si non, le rapport se fait toujours mais n\'est plus affiché.',
		'config option name dashboard_logs_count' => 'Nombre de lignes max. à afficher du rapport d\'application',
		'config option desc dashboard_logs_count' => 'Limite le nombre de lignes du rapport d\'application à montrer sur le tableau de bord',
		'config option name authdb server' => 'Serveur de base de données',
		'config option desc authdb server' => 'L\'adresse IP ou le DNS du serveur de base de données pour l\'authentification. Le numéro de port peut etre inclus.',
		'config option name authdb username' => 'Nom d\'utilisateur de la base de données',
		'config option desc authdb username' => 'Le nom d\'utilisateur ayant accès à la base de données',
		'config option name authdb password' => 'Mot de passe de la base de données',
		'config option desc authdb password' => 'Le mot de passe correspondant à l\'utilisateur',
		'config option name authdb database' => 'Nom de la base de données',
		'config option desc authdb database' => 'Nom de la base de données sur le serveur',
		'config option name authdb sql' => 'SQL de Select',
		'config option desc authdb sql' => 'Le code SQL pour retrouver une seule ligne de la table contenant les détails de l\'utilisateur. Au moins 1 champ doit etre retourné et nommé email. $username/$password sont les emplacement du nom d\'utilisateur et du mot de passe lors de l\'authentification.',
		'config option name parking space reservation url' => 'URL de la place de parking',
		'config option desc parking space reservation url' => 'Entrez l\'URL complète pour lancer l\'aplication de réservation de places de parking',
		'config option name map url' => 'Voir l\'URL de carte',
		'config option desc map url' => 'L\'URL vers une carte montrant l\'emplacement d\'un contact ou d\'une société. $location est l\'emplacement pour l\'adresse.',
		'config option name route url' => 'Afficher l\'URL de la route',
		'config option desc route url' => 'L\'URL vers l\'itinéraire entre l\'utilisateur en cours (contact) et l\'emplacement de l\'autre contact ou société. $from/$to sont les emplacements pour l\'adresse de départ et celle d\'arrivée.',
  ); // array

?>