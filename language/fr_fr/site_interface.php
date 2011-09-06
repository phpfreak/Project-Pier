<?php

  /**
  * Dashboard interface langs
  *
  * @http://www.projectpier.org/
  */
  
  // Return langs
  return array(
    'new version available' => 'Une nouvelle version de ProjectPier est disponible. <a href="%s">Plus d\'informations</a>.',
    
    'my tasks' => 'Mes tâches',
    'welcome back' => 'Bienvenue <strong>%s</strong>',
    
    'online users' => 'Utilisateurs connectés',
    'online users desc' => 'Utilisateurs actifs dans les 15 dernières minutes :',
    
    'dashboard' => 'Tableau de bord',
    'administration' => 'Administration',
    'my account' => 'Mon compte',
    'my settings' => 'Mes paramètres',
    
    'my projects' => 'Mes projets',
    'my projects archive desc' => 'Liste des projets terminés (archivés). Toutes les actions de ces projets sont verrouillées, mais vous pouvez toujours les parcourir.',
    
    'company online' => 'Entreprises connectées',
    
    'enable javascript' => 'Activez Javascript dans votre navigateur pour utiliser cette fonctionnalité',
    
    'user password generate' => 'Générer un mot de passe aléatoire',
    'user password specify' => 'Spécifier un mot de passe',
    'is administrator' => 'Administrateur',
    'is auto assign' => 'Auto-inclure dans les nouveaux projets ?',
    'auto assign' => 'Auto-inclure',
    'administrator update profile notice' => 'Options d\'administration (disponible pour les Administrateurs seulement !)',
    
    'project completed on by' => 'Terminé le %s par %s',

    'use LDAP' => 'Authentification par LDAP',
    'LDAP' => 'Authentification LDAP',
    
    'im service' => 'Service',
    'primary im service' => 'Messagerie instantanée préférée',
    'primary im description' => 'Toutes les adresses de messagerie instantanée saisies seront listées sur la fiche de l\'Utilisateur. Seule l\'adresse de messagerie instantanée préférée sera affichée sur les autres pages (comme la page \'Acteurs\').',
    'contact online' => 'Contact online',
    'contact offline' => 'Contact offline',
    
    'avatar' => 'Avatar',
    'current avatar' => 'Avatar actuel',
    'current logo' => 'Logo actuel',
    'new avatar' => 'Nouvel avatar',
    'new logo' => 'Nouveau logo',
    'new avatar notice' => 'L\'avatar actuel sera supprimé et remplacé par un nouveau !',
    'new logo notice' => 'Le logo actuel sera supprimé et remplacé par un nouveau !',
    
    'days late' => '%s jours de retard',
    'day late' => '%s jour de retard',
    'days left' => '%s jours restants',
    'day left' => '%s jour restant',
    
    'user card of' => 'Utilisateur %s',
    'company card of' => 'Société %s',
    
    // Upgrade
    'upgrade is not available' => 'Il n\'y a pas de nouvelle version de ProjectPier à télécharger.',
    'check for upgrade now' => 'Vérifier maintenant',
    
    // Forgot password
    'forgot password' => 'Mot de passe oublié',
    'email me my password' => 'Envoyer mot de passe',
    
    // Complete installation
    'complete installation' => 'Terminer l\'installation',
    'complete installation desc' => 'La dernière étape de l\'installation vous permettra de créer un compte Administrateur et de fournir quelques informations sur votre entreprise.',
    
    // Administration
    'welcome to administration' => 'Bienvenue',
    'welcome to administration info' => 'Bienvenue sur le panneau d\'Administration. Cet outil permet de gérer les informations sur votre société, les membres, les Clients et les projets auxquels vous participez.',
    
    'send new account notification' => 'Envoyer une notification par email ?',
    'send new account notification desc' => 'Si vous sélectionnez "Oui", l\'utilisateur recevra un email de bienvenue contenant ses informations de connexion',
    
    // Tools
    'administration tools' => 'Outils',
    
    'test mail recepient' => 'Destinataire du message de test',
    'test mail message' => 'Texte du message de test',
    'test mail message subject' => 'Objet du message de test',
    
    'massmailer subject' => 'Objet',
    'massmailer message' => 'Message',
    'massmailer recipients' => 'Destinataires',
    
    // Dashboard
    'welcome to new account' => 'Bienvenue sur le compte nouvellement créé',
    'welcome to new account info' => '%s, bienvenue sur votre nouveau compte. Il sera toujours disponible à partir de maintenant à l\'URL %s (vous pouvez ajouter ce lien aux Favoris). Vous pouvez commencer à utiliser ProjectPier en quelques minutes en suivant ces 4 étapes simples:',
    'new account step1' => 'Etape 1: Compléter les informations de votre entreprise',
    'new account step1 info' => '<a href="%s">Saisissez les informations de votre entreprise</a> comme les numéros de téléphone, de fax, l\'adresse, l\'email, le site web, etc.',
    'new account step2' => 'Etape 2: Ajouter des membres à l\'équipe',
    'new account step2 info' => 'Vous pouvez <a href="%s">Créez des comptes utilisateurs</a> pour tous les membres de votre équipe (nombre illimité). Chaque utilisateur aura un login et un mot de passe pour accéder au système.',
    'new account step3' => 'Etape 3: Ajouter des sociétés Clients et leurs utilisateurs',
    'new account step3 info' => 'Maintenant il est temps de <a href="%s">définir des sociétés Clients</a> (nombre illimité). Lorsque vous avez créé une société Client, vous pouvez lui ajouter des utilisateurs ou laisser à son administrateur le loisir de le faire. Les utilisateurs des sociétés Clients sont comme ceux de votre entreprise, mais ils ont des accès limités aux contenus et aux fonctions (vous pouvez spécifier leurs permissions par projet et par utilisateur).',
    'new account step4' => 'Etape 4: Démarrer un projet',
    'new account step4 info' => 'Définir un <a href="%s">nouveau projet</a> est vraiment très simple: donnez-lui un nom et une description (facultatif) puis, cliquez sur Envoyer. Vous pouvez ensuite définir les permissions pour les membres de votre équipe et ceux des sociétés Clients.',
    'add welcome task text' => 'Bonjour %s, bienvenue sur votre nouveau compte. Veuillez mettre à jour votre profil d\'ici à 7 jours %s.',
    'add welcome task' => 'Ajouter une tâche au projet Bienvenue',
    'add welcome task desc' => 'Une tâche a été ajoutée à la liste de tâches du projet Bienvenue avec un message de bienvenue et des instructions pour mettre à jour le profil.',
    
    // Application log
    'application log type column name' => 'Type',
    'application log date column name' => 'Date',
    'application log details column name' => 'Détails',
    'application log project column name' => 'Projet',
    'application log taken on column name' => 'Fait le, par',
    'application log by column name' => 'Par',
    
    // RSS
    'rss feeds' => 'Flux RSS',
    'recent activities feed' => 'Activités récentes',
    'recent project activities feed' => 'Activités récentes sur le projet %s',
    
    // Update company permissions
    'update company permissions hint' => 'Sélectionnez un projet pour définir les permissions de cette société. Notez que vous devrez également spécifier les permissions pour les membres de l\'entreprise qui auront accès et pourront gérer les projets sélectionnés (Vous pouvez le faire depuis la page participants du projet ou à travers les profils utilisateurs).',

    'footer copy with homepage' => '&copy; %s <a href="%s">%s</a>. Tous droits réservés.',
    'footer copy without homepage' => '&copy; %s %s. Tous droits réservés',
    'footer powered' => 'Propulsé par <a href="%s">%s</a>',
    
  ); // array

?>