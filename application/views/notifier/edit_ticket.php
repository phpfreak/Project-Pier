------------------------------------------------------------
<?php echo lang('do not reply warning')."\n" ?> 
------------------------------------------------------------

<?php echo lang('ticket edited', $ticket->getSummary(), $ticket->getProject()->getName()) ?>. 

<?php
/* Send the message body unless the configuration file specifically says not to:
** to prevent sending the body of email messages add the following to config.php
** For config.php:  define('SHOW_MESSAGE_BODY', false);
*/
if ((!defined('SHOW_TICKET_BODY')) or (SHOW_TICKET_BODY == true)) {
  echo "\n----------------\n";
  if($ticket->getAssignedTo()) {
    echo lang('assigned to').': '.clean($ticket->getAssignedTo()->getObjectName())."\n";
  }
  echo lang('priority').': '.lang($ticket->getPriority())."\n";
  echo lang('state').': '.lang($ticket->getState())."\n";
  echo lang('type').': '.lang($ticket->getType())."\n";
  if($ticket->getCategory()) {
    echo lang('category').': '.clean($ticket->getCategory()->getName())."\n";
  }
  echo "\n";
  echo $ticket->getDescription();
  echo "\n----------------\n\n";

  $changes = $changeset->getChanges();
  foreach ($changes as $change) {
    if (trim($change->getFromData()) == "") {
      if ($change->dataNeedsTranslation()) {
        echo strip_tags(lang('change set to', lang($change->getType()), lang($change->getToData())));
      } else {
        echo strip_tags(lang('change set to', lang($change->getType()), $change->getToData()));
      } // if
    } elseif (trim($change->getToData()) == "") {
      if ($change->dataNeedsTranslation()) {
        echo strip_tags(lang('change from to', lang($change->getType()), lang($change->getFromData()), lang('n/a')));
      } else {
        echo strip_tags(lang('change from to', lang($change->getType()), $change->getFromData(), lang('n/a')));
      } // if
    } else {
      if ($change->dataNeedsTranslation()) {
        echo strip_tags(lang('change from to', lang($change->getType()), lang($change->getFromData()), lang($change->getToData())));
      } else {
        echo strip_tags(lang('change from to', lang($change->getType()), $change->getFromData(), $change->getToData()));
      } // if
    } // if
    echo "\n";
  } // foreach
  echo "\n";
  if (trim($changeset->getComment())) {
    echo lang('comment').":\n";
    echo $changeset->getComment();
  } // if
  echo "\n----------------\n\n";
} // if
?>

<?php echo lang('view new ticket').":\n" ?>

- <?php echo str_replace('&amp;', '&', externalUrl($ticket->getViewUrl()))."\n" ?> 

<?php echo lang('company') ?>: <?php echo owner_company()->getName()."\n" ?> 
<?php echo lang('project') ?>: <?php echo $ticket->getProject()->getName()."\n" ?> 
<?php echo lang('author') ?>: <?php echo $ticket->getCreatedByDisplayName()."\n" ?> 

--
<?php echo ''.lang('login').': '.externalUrl(ROOT_URL) ?>