------------------------------------------------------------
 <?php echo lang('do not reply warning') ?> 
------------------------------------------------------------

<?php echo lang('new task posted', $new_task->getObjectName(), $new_task->getProject()->getName()) ?>. 

<?php
/* Send the message body unless the configuration file specifically says not to:
** to prevent sending the body of email messages add the following to config.php
** For config.php:  define('SHOW_MESSAGE_BODY', false);
*/
if ((!defined('SHOW_MESSAGE_BODY')) or (SHOW_MESSAGE_BODY == true)) {
  echo "\n----------------\n";
  echo $new_task->getText();
  echo "\n----------------\n\n";
}
?>

<?php echo lang('view new task') ?>:

- <?php echo str_replace('&amp;', '&', externalUrl($new_task->getViewUrl())) ?> 

<?php echo lang('company') ?>: <?php echo owner_company()->getName() ?> 
<?php echo lang('project') ?>: <?php echo $new_task->getProject()->getName() ?> 
<?php echo lang('author') ?>: <?php echo $new_task->getCreatedByDisplayName() ?> 

--
<?php echo externalUrl(ROOT_URL) ?>