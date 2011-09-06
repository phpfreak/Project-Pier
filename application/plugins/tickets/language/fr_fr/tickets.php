<?php

  return array(
  
    // source: actions.php

    // Bug Trac
    'open tickets' => 'Incidents ouverts',  
    'closed tickets' => 'Incidents fermés',
    'add ticket' => 'Ajouter un incident',  
    'edit ticket' => 'Modifier un incident',  
    'view ticket' => 'Visualiser un incident',  
    'open ticket' => 'Ouvrir l\'incident', 
    'close ticket' => 'Fermer l\'incident',  
    'delete ticket' => 'Supprimer un incident',  
    'add ticket category' => 'Ajouter une catégorie',
    'add default ticket categories' => 'Ajouter des catégories par défaut',
    'edit ticket category' => 'Modifier une catégorie',
    'ticket categories' => 'Catégories d\'incident',
    'update ticket options' => 'Mettre à jour les options',

    // source: administration.php

    'config category name tickets' => 'Incidents',  
    'config category desc tickets' => 'Ces paramètres permettent de configurer les options des incidents. Actuellement seules les catégories par défaut sont paramétrables.',
    'config option name tickets_types' => 'Types d\'incident autorisés',
    'config option name tickets_default_categories' => 'Catégories d\'incident par défaut pour un projet',

    // source: emails.php

    'new ticket' => 'Nouvel incident',

    'new ticket posted' => 'Un nouvel incident "%s" a été posté dans le projet "%s"',
    'ticket edited' => 'L\'incident "%s" a été modifié dans le projet "%s"',
    'ticket closed' => 'L\'incident "%s" a été fermé dans le projet "%s"',
    'ticket opened' => 'L\'incident "%s" a été ouvert dans le projet "%s"',
    'attached files to ticket' => 'Des fichiers ont été ajoutés à l\'incident "%s" dans le projet "%s"',
    'view new ticket' => 'Visualiser cet incident',


    // source: errors.php

    // Add category
    'category name required' => 'Le nom de la catégorie est obligatoire',
    
    // Add ticket
    'ticket summary required' => 'Le resumé est obligatoire',
    'ticket description required' => 'La description est obligatoire',

    // source: messages.php
    // Empty, dnx etc
    'no ticket subscribers' => 'Aucun utilisateur ne s\'est abonné à cet incident',

    'ticket dnx' => 'L\'incident demandé n\'existe pas',
    'no tickets in project' => 'Aucun incident dans ce projet',
    'no my tickets' => 'Aucun incident ne vous est assigné',
    'no changes in ticket' => 'Aucune modification dans cet incident',
    'category dnx' => 'La catégorie demandée n\'existe pas',
    'no categories in project' => 'Aucune catégorie dans ce projet',

    // Success
    'success add ticket' => 'L\'incident \'%s\' a été ajouté avec succès',
    'success edit ticket' => 'L\'incident \'%s\' a été modifié avec succès',
    'success deleted ticket' => 'L\'incident \'%s\' et tous ses commentaires ont été supprimés avec succès',
    'success close ticket' => 'L\'incident sélectionné a été fermé',
    'success open ticket' => 'L\'incident sélectionné a été réouvert',
    'success add category' => 'La catégorie \'%s\' a été ajoutée avec succès',
    'success edit category' => 'La catégorie \'%s\' a été modifiée avec succès',
    'success deleted category' => 'La catégorie \'%s\' et tous ses commentaires ont été supprimés avec succès',
    
    'success subscribe to ticket' => 'Vous vous êtes abonné(e) à cet incident avec succès',
    'success unsubscribe to ticket' => 'Vous vous êtes désabonné(e) de cet incident avec succès',

    // Failures
    'error update ticket options' => 'Erreur lors de la mise à jour des options de l\'incident',
    'error close ticket' => 'Impossible de fermer l\'incident sélectionné',
    'error open ticket' => 'Impossible de réouvrir l\'incident sélectionné',
    'error subscribe to ticket' => 'Erreur lors de l\'abonnement à l\'incident sélectionné',
    'error unsubscribe to ticket' => 'Erreur lors du désabonnement de l\'incident sélectionné',
    'error delete ticket' => 'Erreur lors de la suppression de l\'incident sélectionné',

    // Confirmation
    'confirm delete ticket' => 'Êtes-vous sûr(e) de vouloir supprimer cet incident ?',
    'confirm unsubscribe' => 'Êtes-vous sûr(e) de vouloir vous désabonner ?',
    'confirm subscribe ticket' => 'Êtes-vous sûr(e) de vouloir vous abonner à cet incident ? Vous recevrez un email chaque fois que quelqu\'un (excepté vous) postera un commentaire sur cet incident.',

    // Log
    'log add projectcategories' => '\'%s\' ajoutée',
    'log edit projectcategories' => '\'%s\' modifiée',
    'log delete projectcategories' => '\'%s\' supprimée',
    'log add projecttickets' => '\'%s\' ajouté',
    'log edit projecttickets' => '\'%s\' modifié',
    'log delete projecttickets' => '\'%s\' supprimé',
    'log close projecttickets' => '\'%s\' fermé',
    'log open projecttickets' => '\'%s\' ouvert',
  
    // source: general.php


    // source: objects.php

    'ticket' => 'Incident',
    'tickets' => 'Incidents',
    'private ticket' => 'Incident privé',

    // source: project_interface.php

    'email notification ticket desc' => 'Envoyer une notification aux personnes sélectionnées par mail au sujet de cet incident',
    'subscribers ticket desc' => 'Les abonnés recevront un message de notification à chaque fois que quelqu\'un (exceptés eux) feront une modification ou un commentaire au sujet de cet incident',
    
    // Tickets
    'summary' => 'Résumé',
    'category' => 'Catégorie',
    'priority' => 'Priorité',
    'state' => 'Etat',
    'assigned to' => 'Assigné à',
    'reported by' => 'Remonté par',
    'closed' => 'Fermé',
    'open' => 'Ouvert',
    'critical' => 'Critique',
    'major' => 'Majeur',
    'minor' => 'Mineur',
    'trivial' => 'Trivial',
    'opened' => 'Ouvert',
    'confirmed' => 'Confirmé',
    'not reproducable' => 'Non reproductible',
    'test and confirm' => 'Testé et confirmé',
    'fixed' => 'Réglé',
    'defect' => 'Defectueux',
    'enhancement' => 'Amélioration',
    'feature request' => 'Caractéristique',
    'legend' => 'Légende',
    'ticket #' => 'Incident #%s',
    'updated on by' => '%s | <a href="%s">%s</a> | %s',
    'history' => 'Historique des modifications',
    'field' => 'Champ',
    'old value' => 'Ancienne valeur',
    'new value' => 'Nouvelle valeur',
    'change date' => 'Date de modification',

    'private ticket desc' => 'Les tickets privés ne sont visibles que par les membre de la société propriétaire. Les membres des sociétés clientes ne pourront pas les voir.',

    // source: site_interface.php
    
    // Tickets
    'my tickets' => 'Mes incidents',

  ); // array

?>