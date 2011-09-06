------------------------------------------------------------
<?php echo lang('do not reply warning') ?> 
------------------------------------------------------------

<?php echo lang('milestone assigned', $milestone_assigned->getName()) ?>. 

<?php
/* Send the milestone body unless the configuration file specifically says not to:
** to prevent sending the body of email messages add the following to config.php
** For config.php:  define('SHOW_MILESTONE_BODY', false);
*/
if ((!defined('SHOW_MILESTONE_BODY')) or (SHOW_MILESTONE_BODY == true)) {
  echo "\n----------------\n";
  echo $milestone->getDescription();
  echo "\n----------------\n\n";
}
?>

<?php echo lang('view assigned milestones') ?>:


- <?php echo str_replace('&amp;', '&', externalUrl($milestone_assigned->getViewUrl())) ?> 

Company: <?php echo owner_company()->getName() ?> 
Project: <?php echo $milestone_assigned->getProject()->getName() ?> 

--
<?php echo externalUrl(ROOT_URL) ?>
