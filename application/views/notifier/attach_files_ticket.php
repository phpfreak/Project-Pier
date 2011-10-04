------------------------------------------------------------
<?php echo lang('do not reply warning') ?> 
------------------------------------------------------------

<?php echo lang('attached files to ticket', $ticket->getSummary(), $ticket->getProject()->getName()) ?>. 

<?php
/* Send the message body unless the configuration file specifically says not to:
** to prevent sending the body of email messages add the following to config.php
** For config.php:  define('SHOW_MESSAGE_BODY', false);
*/
if ((!defined('SHOW_TICKET_BODY')) or (SHOW_TICKET_BODY == true)) {
  echo "\n----------------\n";
  foreach($attached_files as $attached_file) {
    echo lang('file').': '.$attached_file->getFilename()."\n";
  }
  echo "\n----------------\n\n";
}
?>

<?php echo lang('view new ticket') ?>:

- <?php echo str_replace('&amp;', '&', externalUrl($ticket->getViewUrl())) ?> 

<?php echo lang('company') ?>: <?php echo owner_company()->getName() ?> 
<?php echo lang('project') ?>: <?php echo $ticket->getProject()->getName() ?> 
<?php echo lang('author') ?>: <?php echo $ticket->getCreatedByDisplayName() ?> 

--
<?php echo ''.lang('login').': '.externalUrl(ROOT_URL) ?>
--
<?php echo externalUrl(ROOT_URL) ?>