------------------------------------------------------------
<?php echo lang('do not reply warning') ?> 
------------------------------------------------------------

<?php echo lang('new file posted', $new_file->getFilename(), $new_file->getProject()->getName()) ?>. 

<?php
/* Send the message body unless the configuration file specifically says not to:
** to prevent sending the body of email messages add the following to config.php
** For config.php:  define('SHOW_MESSAGE_BODY', false);
*/
if ((!defined('SHOW_MESSAGE_BODY')) or (SHOW_MESSAGE_BODY == true)) {
  echo "\n----------------\n";
  echo $new_file->getDescription();
  echo "\n----------------\n\n";
}
?>

<?php echo lang('view new file') ?>:

- <?php echo str_replace('&amp;', '&', externalUrl($new_file->getViewUrl())) ?> 

<?php echo lang('company') ?>: <?php echo owner_company()->getName() ?> 
<?php echo lang('project') ?>: <?php echo $new_file->getProject()->getName() ?> 
<?php echo lang('author') ?>: <?php echo $new_file->getCreatedByDisplayName() ?> 

--
<?php echo externalUrl(ROOT_URL) ?>