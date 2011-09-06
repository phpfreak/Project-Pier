<?php

  return array(

    // source: actions.php

    // Files
    'add file' => 'Ajouter un fichier',
    'edit file' => 'Modifier le fichier',
    'delete file' => 'Supprimer le fichier',
    
    'add folder' => 'Ajouter un dossier',
    'edit folder' => 'Modifier le dossier',
    'delete folder' => 'Supprimer le dossier',
    
    'files add revision' => 'Ajouter une révision',
    'files edit revision' => 'Modifier la révision %s',
    'delete file revision' => 'Supprimer la révision %s',
    
    'attach file' => 'Attacher un fichier',
    'attach files' => 'Attacher des fichiers',
    'attach more files' => 'Attacher d\'autres fichiers',
    'detach file' => 'Détacher ce fichier',
    'detach files' => 'Détacher ces fichiers',

    // source: administration.php

    'config option name files_show_icons' => 'Afficher les icônes des fichiers',
    'config option name files_show_thumbnails' => 'Afficher les vignettes lorsque c\'est possible',

    // source: errors.php

    // Validate project folder
    'folder name required' => 'Le nom du dossier est obligatoire',
    'folder name unique' => 'Le nom du dossier doit être unique dans ce projet',
    
    // Validate add / edit file form
    'folder id required' => 'Please select folder',
    'filename required' => 'Filename is required',
    
    // File revisions (internal)
    'file revision file_id required' => 'Une révision doit être liée à un fichier',
    'file revision filename required' => 'Le nom de fichier est obligatoire',
    'file revision type_string required' => 'Type de fichier inconnu',

    // source: messages.php

    // Empty, dnx etc
    'no files on the page' => 'Aucun fichier sur cette page',
    'folder dnx' => 'Le dossier demandé n\'existe pas dans la base de données',
    'define project folders' => 'Aucun dossier dans ce projet. Créez un ou plusieurs dossiers pour pouvoir continuer',
    'file dnx' => 'Le fichier demandé n\'existe pas dans la base de données',
    'file revision dnx' => 'La révision demandée n\existe pas dans la base de données',
    'no file revisions in file' => 'Aucune révision n\'est associée à ce fichier',
    'cant delete only revision' => 'Vous ne pouvez pas supprimer cette révision. Chaque fichier doit avoir au moins une révision',

    'no attached files' => 'Aucun fichier n\'est attaché à cet objet',
    'file not attached to object' => 'Le fichier sélectionné n\'est pas attaché à l\'objet sélectionné',
    'no files to attach' => 'Sélectionnez les fichiers à attacher',

    // Success
    'success add folder' => 'Le dossier \'%s\' a été ajouté',
    'success edit folder' => 'Le dossier \'%s\' a été modifié',
    'success delete folder' => 'Le dossier \'%s\' a été supprimé',
    
    'success add file' => 'Le fichier \'%s\' a été ajouté',
    'success edit file' => 'Le fichier \'%s\' a été modifié',
    'success delete file' => 'Le fichier \'%s\' a été supprimé',
    
    'success add revision' => 'Révision %s ajoutée',
    'success edit file revision' => 'La révision a été modifiée',
    'success delete file revision' => 'La révision du fichier a été supprimée',
    
    'success attach files' => 'Le(s) fichier(s %s ont été attaché(s) avec succès',
    'success detach file' => 'Le(s) fichier(s) ont été détachés avec succès',

    // Failures
    'error upload file' => 'Erreur lors de la mise en ligne du fichier',
    'error file download' => 'Erreur lors du téléchargement du fichier spécifié',
    'error attach file' => 'Erreur lors de l\'attachement du(des) fichier(s)',

    'error delete folder' => 'Erreur lors de la suppression du dossier sélectionné',
    'error delete file' => 'Erreur lors de la suppression du fichier sélectionné',
    'error delete file revision' => 'Erreur lors de la suppression de la révision de fichier',
    'error attach file' => 'Erreur lors de l\'attachement du(des) fichier(s)',
    'error detach file' => 'Erreur lors du détachement du(des) fichier(s)',
    'error attach files max controls' => 'Vous ne pouvez pas attacher plus de %s fichiers.',

    // Confirmation
    'confirm delete folder' => 'Êtes-vous sûr(e) de vouloir supprimer ce dossier ?',
    'confirm delete file' => 'Êtes-vous sûr(e) de vouloir supprimer ce fichier ?',
    'confirm delete revision' => 'Êtes-vous sûr(e) de vouloir supprimer cette révision ?',
    'confirm detach file' => 'Êtes-vous sûr(e) de vouloir détacher ce fichier ?',

    // Log
    'log add projectfolders' => '\'%s\' ajouté',
    'log edit projectfolders' => '\'%s\' modifié',
    'log delete projectfolders' => '\'%s\' supprimé',
    
    'log add projectfiles' => '\'%s\' uploadé',
    'log edit projectfiles' => '\'%s\' modifié',
    'log delete projectfiles' => '\'%s\' supprimé',
    
    'log edit projectfilerevisions' => '%s modifié',
    'log delete projectfilerevisions' => '%s supprimé',

    // source: objects.php

    'file' => 'Fichier',
    'files' => 'Fichiers',
    'file revision' => 'Révision de fichier',
    'file revisions' => 'Révisions de fichier',
    'revision' => 'Révision',
    'revisions' => 'Révisions',
    'folder' => 'Dossier',
    'folders' => 'Dossiers',
    'attached file' => 'Fichier attaché',
    'attached files' => 'Fichiers attachés',
    'important file' => 'Fichier important',
    'important files' => 'Fichiers importants',
    'private file' => 'Fichier privé',
    'attachment' => 'Fichier joint',
    'attachments' => 'Fichiers joints',

    // source: project_interface.php

    'attach existing file' => 'Attacher un fichier existant (dans la page Fichiers du projet)',
    'upload and attach' => 'Mettre en ligne un nouveau fichier et l\'attacher au message',

    'new file' => 'Nouveau fichier',
    'existing file' => 'Fichier existant',
    'replace file description' => 'Vous pouvez remplacer un fichier existant en spécifiant un nouveau fichier. Si vous ne voulez pas remplacer l\'ancien fichier, ne cochez pas la case.',
    'download history' => 'Historique des téléchargements',
    'download history for' => 'Historique des téléchargements pour <a href="%s">%s</a>',
    'downloaded by' => 'Téléchargé par',
    'downloaded on' => 'Téléchargé le',

    'revisions on file' => '%s révision(s)',
    'order by filename' => 'Nom de fichier (a-z)',
    'order by posttime' => 'Date et heure',
    'all files' => 'Tous les fichiers',
    'upload file desc' => 'Vous pouvez uploader tout type de fichier dont la taille est inférieure ou égale à %s.',
    'file revision info short' => 'Révision #%s <span>(créée le %s)</span>',
    'file revision info long' => 'Révision #%s <span>(par <a href="%s">%s</a> le %s)</span>',
    'file revision title short' => '<a href="%s">Révision #%s</a> <span>(créée le %s)</span>',
    'file revision title long' => '<a href="%s">Révision #%s</a> <span>(par <a href="%s">%s</a> le %s)</span>',
    'update file' => 'Mettre à jour le fichier',
    'version file change' => 'Enregistrer le changement de version (l\'ancien fichier sera conservé)',
    'last revision' => 'Dernière révision',
    'revision comment' => 'Commentaire de révision',
    'initial versions' => '-- version initiale --',
    'file details' => 'Détails du fichier',
    'view file details' => 'Voir les détails du fichier',
    
    'add attach file control' => 'Ajouter un fichier',
    'remove attach file control' => 'Supprimer le fichier',
    'attach files to object desc' => 'Utilisez ce formulaire pour attacher des fichiers à <strong><a href="%s">%s</a></strong>. Vous pouvez attacher un ou plusieurs fichiers. Vous pouvez sélectionner un fichier de la page Fichiers du projet ou en uploader de nouveaux. <strong>Les nouveaux fichiers seront également disponibles depuis la page Fichiers après avoir été uploadés.</strong>.',
    'select file' => 'Sélectionnez un fichier',

    'important file desc' => 'Les fichiers importants sont listés dans la barre latérale sur la page Fichiers du projet',
    'private file desc' => 'Les fichiers privés ne sont visibles que par les utilisateurs de la société propriétaire. Les utilisateurs des sociétés clientes ne peuvent pas les voir.',
    
  ); // array

?>