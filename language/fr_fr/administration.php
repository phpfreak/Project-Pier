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

    'config option name character_set' => 'Character set to use',
    'config option name collation' => 'Character sort order',

    'config option name session_lifetime' => 'Durée de la session',
    'config option name default_controller' => 'Page principale par défaut',
    'config option name default_action' => 'Default subpage',

    'config option name logs_show_icons' => 'Montrer les icônes dansShow icons in the application log',
    'config option name default_private' => 'Paramétrage par défaut pour l\'option privé',
  ); // array

?>