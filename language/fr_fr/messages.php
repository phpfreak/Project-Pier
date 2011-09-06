<?php

  /**
  * Array of messages file (error, success message, status...)
  *
  * @http://www.projectpier.org/
  */

  return array(
  
    // Empty, dnx etc
    'project dnx' => 'Le projet demandé n\'existe pas dans la base de données',
    'message dnx' => 'Le message demandé n\'existe pas',
    'no comments in message' => 'Aucun commentaire pour ce message',
    'no comments associated with object' => 'Aucun commentaire n\'a été posté pour cet objet',
    'no messages in project' => 'Aucun message dans ce projet',
    'no subscribers' => 'Aucun utilisateur ne s\'est abonné à ce message',

    'no activities in project' => 'Aucune activité enregistrée pour ce projet',
    'comment dnx' => 'Le commentaire demandé n\'existe pas',
    'milestone dnx' => 'Le jalon demandé n\'existe pas',
    'time dnx' => 'Le temps passé demandé n\'existe pas',
    'task list dnx' => 'La liste de tâches demandée n\'existe pas',
    'task dnx' => 'La tâche demandée n\'existe pas',
    'no milestones in project' => 'Aucun jalon pour ce projet',
    'no active milestones in project' => 'Aucun jalon actif pour ce projet',
    'empty milestone' => 'Ce jalon est vide. Vous pouvez y ajouter un <a href="%s">message</a> ou <a href="%s">une liste de tâches</a> à tout moment',
    'no logs for project' => 'Aucune activité pour ce projet',
    'no recent activities' => 'Aucune activité récente enregistrée dans la base de données',
    'no open task lists in project' => 'Aucune liste de tâches ouverte pour ce projet',
    'no completed task lists in project' => 'Aucune liste de tâches terminée pour ce projet',
    'no open task in task list' => 'Aucune tâche dans cette liste de tâches',
    'no projects in db' => 'Aucun projet enregistré dans la base de données',
    'no projects owned by company' => 'Aucun projet pour cette société',
    'no projects started' => 'Aucun projet démarré',
    'no active projects in db' => 'Aucun projet actif',
    'no new objects in project since last visit' => 'Aucun nouvel objet dans ce projet depuis votre dernière visite',
    'no clients in company' => 'Votre société n\'a pas de clients enregistrés',
    'no users in company' => 'Aucun utilisateur dans cette société',
    'client dnx' => 'La société cliente sélectionnée n\'existe pas',
    'company dnx' => 'La société sélectionnée n\'existe pas',
    'user dnx' => 'L\'utilisateur demandé n\'existe pas dans la base de données',
    'avatar dnx' => 'L\'avatar n\'existe pas',
    'no current avatar' => 'L\'avatar n\'a pas été uploadé',
    'no current logo' => 'Le logo n\'a pas été uploadé',
    'user not on project' => 'L\'utilisateur sélectionné n\'est pas impliqué dans le projet sélecionné',
    'company not on project' => 'La société sélectionnée n\'est pas impliquée dans le projet sélectionné',
    'user cant be removed from project' => 'L\'utilisateur sélectionné ne peut pas être enlevé du projet',
    'tag dnx' => 'Le tag demandé n\'existe pas',
    'no tags used on projects' => 'Aucun tag pour ce projet',
    'no forms in project' => 'Aucun formulaire n\'a été créé dans ce projet',
    'project form dnx' => 'Le formulaire demandé n\'existe pas dans la base de données',
    'related project form object dnx' => 'L\'objet relatif à ce formulaire n\'existe pas dans la base de données',
    'no my tasks' => 'Aucune tâche ne vous a été assignée',
    'no search result for' => 'Aucun objet ne correspond à "<strong>%s</strong>"',
    'config category dnx' => 'La catégorie de configuration demandée n\'existe pas',
    'config category is empty' => 'La catégorie de configuration sélectionnée est vide',
    'email address not in use' => '%s n\'est pas utilisée',
    'no administration tools' => 'Aucun outil d\'administration enregistré dans la base de données',
    'administration tool dnx' => 'L\'outil d\'administration "%s" n\'existe pas',
    'about to delete' => 'Vous êtes sur le point de supprimer',
    'about to move' => 'Vous êtes sur le point de déplacer',
    
    // Success
    'success add project' => 'Le projet %s a été ajouté avec succès',
    'success copy project' => 'Le projet %s a été copié vers %s',
    'success edit project' => 'Le projet %s a été modifié',
    'success delete project' => 'Le projet %s a été supprimé',
    'success complete project' => 'Le projet %s est terminé',
    'success open project' => 'Le projet %s a été ré-ouvert',
    'success edit project logo' => 'Le logo du projet à été mis à jour',
    'success delete project logo' => 'Le logo du projet à été supprimé',
    
    'success add milestone' => 'Le jalon \'%s\' a été créé avec succès',
    'success edit milestone' => 'Le jalon \'%s\' a été modifié avec succès',
    'success deleted milestone' => 'Le jalon \'%s\' a été supprimé avec succès',

    'success add time' => 'Le temps passé \'%s\' a été créé avec succès',
    'success edit time' => 'Le temps passé \'%s\' a été modifié avec succès',
    'success deleted time' => 'Le temps passé \'%s\' a été supprimé avec succès',
    
    'success add message' => 'Le message %s a été ajouté avec succès',
    'success edit message' => 'Le message %s a été modifié avec succès',
    'success deleted message' => 'Le message \'%s\' et tous ses commentaires ont été supprimés avec succès',
    
    'success add comment' => 'Le commentaire a été posté avec succès',
    'success edit comment' => 'Le commentaire a été modifié avec succès',
    'success delete comment' => 'Le commentaire a été supprimé avec succès',
    
    'success add task list' => 'La liste de tâches \'%s\' a été ajoutée',
    'success edit task list' => 'La liste de tâches \'%s\' a été modifiée',
    'success copy task list' => 'La liste de tâches \'%s\' a été copiée vers \'%s\' avec %s tâches',
    'success move task list' => 'La liste de tâches \'%s\' a été déplacée du projet \'%s\' vers le projet \'%s\'',
    'success delete task list' => 'La liste de tâches \'%s\' a été supprimée',
    
    'success add task' => 'La tâche sélectionnée a été ajoutée',
    'success edit task' => 'La tâche sélectionnée a été modifiée',
    'success delete task' => 'La tâche sélectionnée a été supprimée',
    'success complete task' => 'La tâche sélectionnée est terminée',
    'success open task' => 'La tâche sélectionnée a été ré-ouverte',
    'success n tasks updated' => '%s tâches mises à jour',
     
    'success add client' => 'La société cliente %s a été ajoutée',
    'success edit client' => 'La société cliente %s a été modifiée',
    'success delete client' => 'La société cliente %s a été supprimée',
    
    'success edit company' => 'Les informations de la société ont été modifiées',
    'success edit company logo' => 'Le logo de la société a été modifié',
    'success delete company logo' => 'Le logo de la société a été supprimé',
    
    'success add user' => 'L\'utilisateur %s a été ajouté avec succès',
    'success edit user' => 'L\'utilisateur %s a été modifié avec succès',
    'success delete user' => 'L\'utilisateur %s a été supprimé avec succès',
    
    'success update project permissions' => 'Les permissions du projet ont été modifiées avec succès',
    'success remove user from project' => 'L\'utilisateur a été enlevé du projet avec succès',
    'success remove company from project' => 'La société a été enlevée du projet avec succès',
    
    'success update profile' => 'Le profil a été modifié avec succès',
    'success edit avatar' => 'L\'avatar a été modifié avec succès',
    'success delete avatar' => 'L\'avatar a été supprimé avec succès',
    
    'success hide welcome info' => 'Le message d\'informations de bienvenue a été masquée avec succès',
    
    'success complete milestone' => 'Le jalon \'%s\' est terminé',
    'success open milestone' => 'Le jalon \'%s\' a été ré-ouvert',
    
    'success subscribe to message' => 'Vous vous êtes abonné(e) à ce message avec succès',
    'success unsubscribe to message' => 'Vous vous êtes désabonné(e) de ce message avec succès',
    
    'success add project form' => 'Le formulaire \'%s\' a été ajouté',
    'success edit project form' => 'Le formulaire \'%s\' a été modifié',
    'success delete project form' => 'Le formulaire \'%s\' a été supprimé',
    
    'success update config category' => 'Les paramètres de configuration %s ont été modifiés',
    'success forgot password' => 'Votre mot de passe vous a été envoyé',
    
    'success test mail settings' => 'L\'email de test a été envoyé avec succès',
    'success massmail' => 'L\'email a été envoyé',
    
    'success update company permissions' => 'Les permissions de la société ont été modifiées avec succès. %s enregistrements mis à jour.',
    'success user permissions updated' => 'Les permissions de l\'utilisateur ont été modifiées',
    
    // Failures
    'error form validation' => 'Impossible d\'enregistrer l\'objet parce que certains paramètres sont invalides',
    'error delete owner company' => 'Impossible de supprimer la société propriétaire',
    'error delete message' => 'Erreur lors de la suppression du message sélectionné',
    'error update message options' => 'Erreur lors de la mise à jour des options du message',
    'error delete comment' => 'Erreur lors de la suppression du commentaire sélectionné',
    'error delete milestone' => 'Erreur lors de la suppression du jalon sélectionné',
    'error delete time' => 'Failed to delete selected time',							// à traduire
    'error complete task' => 'Erreur lors la fermeture de la tâche sélectionnée',
    'error open task' => 'Erreur lors de la réouverture de la tâche sélectionnée',
    'error delete project' => 'Erreur lors de la suppression du projet',
    'error complete task' => 'Erreur lors la fermeture de la tâche sélectionnée',
    'error open task' => 'Erreur lors de la réouverture de la tâche sélectionnée',
    'error edit project logo' => 'Erreur lors de la mise à jour du logo du projet',
    'error delete project logo' => 'Erreur lors de la suppression du logo du projet',
    'error delete client' => 'Erreur lors de la suppression de la société cliente',
    'error delete user' => 'Erreur lors de la suppression de l\'utilisateur sélectionné',
    'error update project permissions' => 'Erreur lors de la  mise à jour des permissions du projet',
    'error remove user from project' => 'Erreur lors de la suppression de l\'utilisateur du projet',
    'error remove company from project' => 'Erreur lors de la suppression de la société du projet',
    'error edit avatar' => 'Erreur lors de la modification de l\'avatar',
    'error delete avatar' => 'Erreur lors de la suppression de l\'avatar',
    'error hide welcome info' => 'Erreur lors du masquage de la boîte d\'informations de bienvenue',
    'error complete milestone' => 'Erreur lors de la fermeture du jalon',
    'error open milestone' => 'Erreur lors de la réouverture du jalon',
    'error edit company logo' => 'Erreur lors de la mise à jour du logo de la société',
    'error delete company logo' => 'Erreur lors de la suppression du logo de la société',
    'error subscribe to message' => 'Erreur lors de l\'abonnement au message sélectionné',
    'error unsubscribe to message' => 'Erreur lors du désabonnement du message sélectionné',

    'error delete task list' => 'Erreur lors de la suppression de la liste de tâches sélectionnée',
    'error delete task' => 'Erreur lors de la suppression de la tâche sélectionnée',
    'error delete category' => 'Erreur lors de la suppression de la catégorie sélectionnée',
    'error check for upgrade' => 'Erreur lors de la détection d\'une nouvelle version de ProjectPier',
    'error test mail settings' => 'Erreur lors de l\'envoi de l\'email de test',
    'error massmail' => 'Erreur lors de l\'envoi de l\'email',
    'error owner company has all permissions' => 'La société propriétaire a toutes les permissions',
    
    // Access or data errors
    'no access permissions' => 'Vous n\'avez pas les permissions nécessaires pour accéder à la page demandée',
    'invalid request' => 'Requête invalide !',
    
    // Confirmation
    'confirm delete message' => 'Êtes-vous sûr(e) de vouloir supprimer ce message ?',
    'confirm delete milestone' => 'Êtes-vous sûr(e) de vouloir supprimer ce jalon ?',
    'confirm delete task list' => 'Êtes-vous sûr(e) de vouloir supprimer cette liste de tâches et toutes ses tâches ?',
    'confirm delete task' => 'Êtes-vous sûr(e) de vouloir supprimer cette tâche ?',
    'confirm delete comment' => 'Êtes-vous sûr(e) de vouloir supprimer ce commentaire ?',
    'confirm delete category' => 'Êtes-vous sûr(e) de vouloir supprimer cette catégorie ?',
    'confirm delete project' => 'Êtes-vous sûr(e) de vouloir supprimer ce projet et toutes les données qui s\'y rapportent (messages, tâches, jalons, fichiers, etc.) ?',
    'confirm delete project logo' => 'Êtes-vous sûr(e) de vouloir supprimer ce logo ?',
    'confirm complete project' => 'Êtes-vous sûr(e) de vouloir marquer ce projet comme terminé ? Toutes les actions du projet seront verrouillées',
    'confirm open project' => 'Êtes-vous sûr(e) de vouloir marquer ce projet comme ouvert ? Toutes les actions du projet seront déverrouillées.',
    'confirm delete client' => 'Êtes-vous sûr(e) de vouloir supprimer la société cliente sélectionnée ainsi que tous ses utilisateurs ?',
    'confirm delete user' => 'Êtes-vous sûr(e) de vouloir supprimer ce compte utilisateur ?',
    'confirm reset people form' => 'Êtes-vous sûr(e) de vouloir effacer le contenu de ce formulaire ? Toutes les modifications que vous avez faites seront perdues !',
    'confirm remove user from project' => 'Êtes-vous sûr(e) de vouloir enlever cet utilisateur du projet ?',
    'confirm remove company from project' => 'Êtes-vous sûr(e) de vouloir enlever cette société du projet ?',
    'confirm logout' => 'Êtes-vous sûr(e) de vouloir vous déconnecter ?',
    'confirm delete current avatar' => 'Êtes-vous sûr(e) de vouloir supprimer cet avatar ?',
    'confirm delete company logo' => 'Êtes-vous sûr(e) de vouloir supprimer ce logo ?',
    'confirm subscribe' => 'Êtes-vous sûr(e) de vouloir vous abonner à ce message ? Vous recevrez un email chaque fois que quelqu\'un (excepté vous) postera un commentaire sur ce message.',
    'confirm reset form' => 'Êtes-vous sûr(e) de vouloir effacer ce formulaire ?',
    
    // Errors...
    'system error message' => 'Une erreur fatale empêche ProjectPier de fonctionner. Un rapport d\'erreur a été envoyé à l\'administrateur.',
    'execute action error message' => 'ProjectPier n\'est pas en mesure d\'exécuter votre requête. Un rapport d\'erreur a été envoyé à l\'administrateur.',
    
    // Log
    'log add projectmessages' => '\'%s\' ajouté',
    'log edit projectmessages' => '\'%s\' modifié',
    'log delete projectmessages' => '\'%s\' supprimé',
    
    'log add comments' => '%s ajouté',
    'log edit comments' => '%s modifié',
    'log delete comments' => '%s supprimé',
    
    'log add projectmilestones' => '\'%s\' ajouté',
    'log edit projectmilestones' => '\'%s\' modifié',
    'log delete projectmilestones' => '\'%s\' supprimé',
    'log close projectmilestones' => '\'%s\' terminé',
    'log open projectmilestones' => '\'%s\' réouvert',

    'log add projecttimes' => '\'%s\' ajouté',
    'log edit projecttimes' => '\'%s\' modifié',
    'log delete projecttimes' => '\'%s\' supprimé',
    
    'log add projecttasklists' => '\'%s\' ajoutée',
    'log edit projecttasklists' => '\'%s\' modifiée',
    'log delete projecttasklists' => '\'%s\' supprimée',
    'log close projecttasklists' => '\'%s\' fermée',
    'log open projecttasklists' => '\'%s\' ouverte',
    
    'log add projecttasks' => '\'%s\' ajoutée',
    'log edit projecttasks' => '\'%s\' modifiée',
    'log delete projecttasks' => '\'%s\' supprimée',
    'log close projecttasks' => '\'%s\' fermée',
    'log open projecttasks' => '\'%s\' ouverte',
    
    'log add projectforms' => '\'%s\' ajouté',
    'log edit projectforms' => '\'%s\' modifié',
    'log delete projectforms' => '\'%s\' supprimé',
  
  ); // array

?>