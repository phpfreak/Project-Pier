<?php trace(__FILE__,''); ?>
------------------------------------------------------------
<?php echo lang('do not reply warning') ?> 
------------------------------------------------------------
<?php echo lang('task assigned', $task_assigned->getObjectName()) ?>. 
<?php
/* Send the task text body unless the configuration file specifically says not to:
** to prevent sending the body of email messages add the following to config.php
** For config.php:  define('SHOW_MILESTONE_BODY', false);
*/
if ((!defined('SHOW_MILESTONE_BODY')) or (SHOW_MILESTONE_BODY == true)) {
  echo "\n----------------\n";
  echo '[' .$task->getId() . '] ' .$task->getText();
  echo "\n----------------\n\n";
}
?>
<?php echo lang('view assigned tasks') ?>:
<?php echo str_replace('&amp;', '&', externalUrl($task_assigned->getViewUrl())) ?> 

<?php echo lang('company') ?>: <?php echo owner_company()->getName() ?> 
<?php echo lang('project') ?>: <?php echo $task->getProject()->getName() ?> 
<?php echo lang('author') ?>: <?php echo $task->getCreatedByDisplayName() ?> 

--
<?php echo ''.lang('login').': '.externalUrl(ROOT_URL) ?>