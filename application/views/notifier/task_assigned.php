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
  echo $task->getText();
  echo "\n----------------\n\n";
}
?>
<?php echo lang('view assigned tasks') ?>:
<?php echo str_replace('&amp;', '&', externalUrl($task_assigned->getViewUrl())) ?> 

Company: <?php echo owner_company()->getName() ?> 
Project: <?php echo $task_assigned->getProject()->getName() ?> 
--
<?php echo lang('login') . ': '. externalUrl(ROOT_URL) ?>
