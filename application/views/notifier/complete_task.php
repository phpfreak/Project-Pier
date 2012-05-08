------------------------------------------------------------
 <?php echo lang('do not reply warning') ?> 
------------------------------------------------------------

<?php echo lang('task completed', $task->getObjectName(), $task->getProject()->getName()) ?>. 

<?php
/* Send the message body unless the configuration file specifically says not to:
** to prevent sending the body of email messages add the following to config.php
** For config.php:  define('SHOW_MESSAGE_BODY', false);
*/
if ((!defined('SHOW_MESSAGE_BODY')) or (SHOW_MESSAGE_BODY == true)) {
  echo "\n----------------\n";
  echo $task->getText();
  echo "\n----------------\n\n";
}
?>

<?php echo lang('view completed task') ?>:

- <?php echo str_replace('&amp;', '&', externalUrl($task->getViewUrl())) ?> 

Company: <?php echo owner_company()->getName() ?> 
Project: <?php echo $task->getProject()->getName() ?> 

--
<?php echo externalUrl(ROOT_URL) ?>
