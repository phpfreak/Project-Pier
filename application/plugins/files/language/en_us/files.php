<?php

  return array(

    // source: actions.php

    // Files
    'add file' => 'Add file',
    'edit file' => 'Edit file',
    'move file' => 'Move file',
    'delete file' => 'Delete file',
    
    'add folder' => 'Add folder',
    'edit folder' => 'Edit folder',
    'delete folder' => 'Delete folder',
    
    'files add revision' => 'Add revision',
    'files edit revision' => 'Edit revision %s',
    'delete file revision' => 'Delete revision %s',
    
    'attach' => 'Attach',
    'attach file' => 'Attach file',
    'attach files' => 'Attach files',
    'attach more files' => 'Attach more files',
    'detach file' => 'Detach file',
    'detach files' => 'Detach files',

    // source: administration.php

    'config option name files_show_icons' => 'Display file icons',
    'config option name files_show_thumbnails' => 'Display file thumbnails when possible',

    // source: errors.php

    // Validate project folder
    'folder name required' => 'Folder name is required',
    'folder name unique' => 'Folder name needs to be unique in this project',
    
    // Validate add / edit file form
    'folder id required' => 'Please select folder',
    'filename required' => 'Filename is required',
    
    // File revisions (internal)
    'file revision file_id required' => 'Revision needs to be connected with a file',
    'file revision filename required' => 'Filename required',
    'file revision type_string required' => 'Unknown file type',

    // source: messages.php

    // Empty, dnx etc
    'no files on the page' => 'There are no files on this page',
    'folder dnx' => 'The folder you have requested does not exist in database',
    'define project folders' => 'There are no folders in this project. Please define folders in order to continue',
    'file dnx' => 'Requested file does not exists in the database',
    'file revision dnx' => 'Requested revision does not exists in the database',
    'no file revisions in file' => 'Invalid file - there are no revisions associated with this file',
    'cant delete only revision' => 'You can\'t delete this revision. Every file need to have at least one revision posted',

    'no attached files' => 'There are no files attached to this object',
    'file not attached to object' => 'Selected file is not attached to selected object',
    'no files to attach' => 'Please select files that need to be attached',

    // Success
    'success add folder' => 'Folder \'%s\' has been added',
    'success edit folder' => 'Folder \'%s\' has been updated',
    'success delete folder' => 'Folder \'%s\' has been deleted',
    
    'success add file' => 'File \'%s\' has been added',
    'success edit file' => 'File \'%s\' has been updated',
    'success move file' => 'File \'%s\' has been moved from project %s to project %s',
    'success delete file' => 'File \'%s\' has been deleted',
    
    'success add revision' => 'Revision %s has been added',
    'success edit file revision' => 'Revision has been updated',
    'success delete file revision' => 'File revision has been deleted',
    
    'success attach files' => '%s file(s) has been successfully attached',
    'success detach file' => 'File(s) has been successfully detached',

    // Failures
    'error upload file' => 'Failed to upload file',
    'error file download' => 'Failed to download specified file',
    'error attach file' => 'Failed to attach file',

    'error delete folder' => 'Failed to delete selected folder',
    'error move file' => 'Failed to move selected file %s',
    'error delete file' => 'Failed to delete selected file',
    'error delete file revision' => 'Failed to delete file revision',
    'error attach file' => 'Failed to attach file(s)',
    'error detach file' => 'Failed to detach file(s)',
    'error attach files max controls' => 'You can not add more file attachments. The limit is %s',

    // Confirmation
    'confirm delete folder' => 'Are you sure that you want to delete this folder?',
    'confirm delete file' => 'Are you sure that you want to delete this file?',
    'confirm delete revision' => 'Are you sure that you want to delete this revision?',
    'confirm detach file' => 'Are you sure that you want to detach this file?',

    // Log
    'log add projectfolders' => '\'%s\' added',
    'log edit projectfolders' => '\'%s\' updated',
    'log delete projectfolders' => '\'%s\' deleted',
    
    'log add projectfiles' => '\'%s\' uploaded',
    'log edit projectfiles' => '\'%s\' updated',
    'log delete projectfiles' => '\'%s\' deleted',
    
    'log edit projectfilerevisions' => '%s updated',
    'log delete projectfilerevisions' => '%s deleted',

    // source: objects.php

    'file' => 'File',
    'files' => 'Files',
    'file revision' => 'File revision',
    'file revisions' => 'File revisions',
    'revision' => 'Revision',
    'revisions' => 'Revisions',
    'folder' => 'Folder',
    'folders' => 'Folders',
    'no folder' => '(no folder)',
    'attached file' => 'Attached file',
    'attached files' => 'Attached files',
    'important file'     => 'Important file',
    'important files'    => 'Important files',
    'private file' => 'Private file',
    'attachment' => 'Attachment',
    'attachments' => 'Attachments',
    'parent folder' => 'Parent Folder',

    // source: project_interface.php

    'attach existing file' => 'Attach an existing file (from the Files section)',
    'upload and attach' => 'Upload a new file and attach it to the message',

    'new file' => 'New file',
    'existing file' => 'Existing file',
    'replace file description' => 'You can replace an existing file by specifying a new one. If you don\'t want to replace it simply leave this field blank.',
    'download history' => 'Download history',
    'download history for' => 'Download history for <a href="%s">%s</a>',
    'downloaded by' => 'Downloaded by',
    'downloaded on' => 'Downloaded on',

    'revisions on file' => '%s revision(s)',
    'order by filename' => 'filename (a-z)',
    'order by posttime' => 'date and time',
    'order by folder' => 'folder',
    'all files' => 'All files',
    'upload file desc' => 'You can upload files of any type. The max file size you are allowed to upload is %s',
    'file revision info short' => 'Revision #%s <span>(created on %s)</span>',
    'file revision info long' => 'Revision #%s <span>(by <a href="%s">%s</a> on %s)</span>',
    'file revision title short' => '<a href="%s">Revision #%s</a> <span>(created on %s)</span>',
    'file revision title long' => '<a href="%s">Revision #%s</a> <span>(by <a href="%s">%s</a> on %s)</span>',
    'update file' => 'Update file',
    'version file change' => 'Remember this change (the old file will be saved for reference)',
    'last revision' => 'Last revision',
    'revision comment' => 'Revision comment',
    'initial versions' => '-- Initial version --',
    'file details' => 'File details',
    'view file details' => 'View file details',
    
    'add attach file control' => 'Add file',
    'remove attach file control' => 'Remove',
    'attach files to object desc' => 'Use this form to attach files to <strong><a href="%s">%s</a></strong>. You can attach one or many files. You can select any existing files from files section or upload new ones. <strong>New files will also be available through files section when you upload them</strong>.',
    'select file' => 'Select a file',

    'important file desc' => 'Important files are listed in the sidebar of files section in the "Important files" block',
    'private file desc' => 'Private files are visible only to the members of the owner company. Members of client companies will not be able to see them',
    
  ); // array

?>