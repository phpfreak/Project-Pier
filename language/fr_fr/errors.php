<?php

  /**
  * Error messages
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */

  // Return langs
  return array(
  
    // General
    'invalid email address' => 'Le format d\'adresse email n\'est pas valide',
    'id missing' => 'Il manque la valeur du champ ID',
   
    // Company validation errors
    'company name required' => 'Le nom de la société est obligatoire',
    'company homepage invalid' => 'La valeur saisie dans page d\'accueil n\'est pas une URL valide (http://www.exemple.com)',
    
    // User validation errors
    'username value required' => 'Le nom d\'utilisateur est obligatoire',
    'username must be unique' => 'Désolé, mais ce nom d\'utilisateur existe déjà',
    'email value is required' => 'L\'adresse email est obligatoire',
    'email address must be unique' => 'Désolé, l\'adresse email choisie est déjà utilisée',
    'company value required' => 'Un utilisateur doit appartenir à une société',
    'password value required' => 'Le mot de passe est obligatoire',
    'passwords dont match' => 'Les mots de passe saisis ne concordent pas',
    'old password required' => 'L\'ancien mot de passe est obligatoire',
    'invalid old password' => 'L\'ancien mot de passe n\'est pas valide',
    'user homepage invalid' => 'La valeur saisie dans page d\'accueil n\'est pas une URL valide (http://www.exemple.com)',
    
    // Avatar
    'invalid upload type' => 'Type de fichier invalide. Les types autorisés sont %s',
    'invalid upload dimensions' => 'Les dimensions de l\'image ne sont pas valides. La taille maximum est de %sx%s pixels',
    'invalid upload size' => 'La taille du fichier image n\'est pas valide. La taille maximum est de %s',
    'invalid upload failed to move' => 'Impossible de déplacer le fichier mis en ligne',
    
    // Registration form
    'terms of services not accepted' => 'Pour créer un compte, vous devez lire et accepter nos conditions d\'utilisation',
    
    // Init company website
    'failed to load company website' => 'Impossible d\'ouvrir le site web. Société propriétaire non trouvée',
    'failed to load project' => 'Impossible d\'ouvrir le projet actif',
    
    // Login form
    'username value missing' => 'Veuillez saisir votre nom d\'utilisateur',
    'password value missing' => 'Veuillez saisir votre mot de passe',
    'invalid login data' => 'Connexion impossible. Vérifiez vos informations de connexion et essayez à nouveau',
    
    // Add project form
    'project name required' => 'Le nom de projet est obligatoire',
    'project name unique' => 'Le nom de projet doit être unique',
    
    // Add message form
    'message title required' => 'Le titre du message est obligatoire',
    'message title unique' => 'Le titre du message doit être unique dans ce projet',
    'message text required' => 'Le texte du message est obligatoire',
    
    // Add comment form
    'comment text required' => 'Le texte du commentaire est obligatoire',
    
    // Add milestone form
    'milestone name required' => 'Le nom du jalon est obligatoire',
    'milestone due date required' => 'La date d\'échéance du jalon est obligatoire',

    // Add task list
    'task list name required' => 'Le nom de la liste de tâches est obligatoire',
    'task list name unique' => 'Le nom de la liste de tâches doit être unique dans ce projet',
    
    // Add task
    'task text required' => 'Le texte de la tâche est obligatoire',

    // Test mail settings
    'test mail recipient required' => 'L\'adresse du destinataire est obligatoire',
    'test mail recipient invalid format' => 'Le format de l\'adresse email du destinataire est invalide',
    'test mail message required' => 'Le corps du message est obligatoire',
    
    // Mass mailer
    'massmailer subject required' => 'L\'objet du message est obligatoire',
    'massmailer message required' => 'Le corps du message est obligatoire',
    'massmailer select recipients' => 'Sélectionnez les utilisateurs qui recevront ce message électronique',
    
  ); // array

?>