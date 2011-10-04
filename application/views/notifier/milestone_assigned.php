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
  echo $milestone_assigned->getDescription();
  echo "\n----------------\n\n";
}
?>

<?php echo lang('view assigned milestones') ?>:

- <?php echo str_replace('&amp;', '&', externalUrl($milestone_assigned->getViewUrl())) ?> 
 
<?php echo lang('company') ?>: <?php echo owner_company()->getName() ?> 
<?php echo lang('project') ?>: <?php echo $milestone_assigned->getProject()->getName() ?> 
<?php echo lang('author') ?>: <?php echo $milestone_assigned->getCreatedByDisplayName() ?> 

--
<?php echo externalUrl(ROOT_URL) ?>