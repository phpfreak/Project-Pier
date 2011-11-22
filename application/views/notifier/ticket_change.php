------------------------------------------------------------
 <?php echo lang('do not reply warning') ?> 
------------------------------------------------------------

<?php echo lang('new comment posted', $ticket->getSummary()) ?>. 

<?php
/* Send the message body unless the configuration file specifically says not to:
** to prevent sending the body of email messages add the following to config.php
** For config.php:  define('SHOW_MESSAGE_BODY', false);
*/
if ((!defined('SHOW_TICKET_BODY')) or (SHOW_TICKET_BODY == true)) {
  echo "\n----------------\n";
?>
<?php $changes = $changeset->getChanges();
  if (is_array($changes)) {
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
  } // if
  echo "\n";
  if (trim($changeset->getComment())) {
    echo lang('comment').":\n";
    echo $changeset->getComment();
  } // if
  echo "\n----------------\n\n";
}
?>

<?php echo lang('view new ticket') ?>:

- <?php echo str_replace('&amp;', '&', $ticket->getViewUrl()) ?> 

Company: <?php echo owner_company()->getName() ?> 
Project: <?php echo $ticket->getProject()->getName() ?> 

--
<?php echo ROOT_URL ?>