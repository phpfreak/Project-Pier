<?php 
  $canEdit = $ticket->canEdit(logged_user());

  // Set page title and set crumbs to index
  $title = $canEdit ? 'edit ticket' : 'view ticket';
  set_page_title(lang($title));
  project_tabbed_navigation(PROJECT_TAB_TICKETS);
  $crumbs = array(array(lang('tickets'), get_url('tickets')));
  if ($ticket->isClosed()) {
    $crumbs[] = array(lang('closed tickets'), ProjectTickets::getIndexUrl(true));
  }
  $crumbs[] = array(lang($title));
  project_crumbs($crumbs);
  
  if ($ticket->canChangeStatus(logged_user())) {
    if ($ticket->isClosed()) {
      add_page_action(lang('open ticket'), $ticket->getOpenUrl());
    } else {
      add_page_action(lang('close ticket'), $ticket->getCloseUrl());
    }
  }
  add_stylesheet_to_page('project/tickets.css');
?>
<?php if($ticket->isPrivate()) { ?>
    <div class="private" title="<?php echo lang('private ticket') ?>"><span><?php echo lang('private ticket') ?></span></div>
<?php } // if ?>
<h2><?php echo lang('ticket #', $ticket->getId()); ?></h2>
<h3 class="status"><?php echo lang('status') ?>: <strong><?php echo lang($ticket->getStatus()); ?></strong></h3>

<form action="<?php echo $ticket->getEditUrl() ?>" method="post">

<?php tpl_display(get_template_path('form_errors')) ?>


<div id="ticket">

<?php if ($canEdit) { ?>
  <div>
    <?php echo label_tag(lang('summary'), 'ticketFormSummary', $canEdit) ?>
    <?php echo text_field('ticket[summary]', array_var($ticket_data, 'summary'), array('id' => 'ticketFormSummary', 'class' => 'title')) ?>
  </div>
  <br />
<?php } else { ?>
  <h2 class="summary"><?php echo clean($ticket->getSummary()); ?></h2>
<?php } // if?>
  
  <table class="properties">
    <tr>
      <th><span class="bold"><?php echo lang('reported by'); ?>:</span></th>
      <td><a href="<?php echo $ticket->getCreatedBy()->getCardUrl(); ?>"><?php echo $ticket->getCreatedByDisplayName(); ?></a></td>

      <th><span class="bold"><?php echo lang('edit by'); ?>:</span></th>
      <td>
<?php if ($ticket->getUpdated()) { ?>
        <?php echo lang('updated on by', format_datetime($ticket->getUpdatedOn()), $ticket->getUpdatedBy()->getCardUrl(), $ticket->getUpdatedByDisplayName(), lang($ticket->getUpdated())); ?>
<?php } // if?>
      </td>
    </tr>
    
    <tr>
      <th><?php echo label_tag(lang('assigned to'), 'ticketFormAssignedTo') ?></th>
<?php if ($canEdit) { ?>
      <td><?php echo assign_to_select_box("ticket[assigned_to]", active_project(), array_var($ticket_data, 'assigned_to'), array('id' => 'ticketFormAssignedTo')) ?></td>
<?php } else { ?>
      <td>
<?php if($ticket->getAssignedTo()) { ?>
          <?php echo clean($ticket->getAssignedTo()->getObjectName()) ?>
<?php } // if{ ?>
      </td>
<?php } // if?>

      <th><?php echo label_tag(lang('priority'), 'ticketFormPriority') ?></th>
<?php if ($canEdit) { ?>
      <td><?php echo select_ticket_priority("ticket[priority]", array_var($ticket_data, 'priority'), array('id' => 'ticketFormPriority')) ?></td>
<?php } else { ?>
      <td><?php echo lang($ticket->getPriority()); ?></td>
<?php } // if?>
    </tr>

     <tr>
      <th><?php echo label_tag(lang('state'), 'ticketFormState') ?></th>
<?php if ($canEdit) { ?>
      <td><?php echo select_ticket_state("ticket[state]", array_var($ticket_data, 'state'), array('id' => 'ticketFormState')) ?></td>
<?php } else { ?>
      <td><?php echo lang($ticket->getState()); ?></td>
<?php } // if?>
	<th><td></td></th>
    </tr>
    
    <tr>
      <th><?php echo label_tag(lang('type'), 'ticketFormType') ?></th>
<?php if ($canEdit) { ?>
      <td><?php echo select_ticket_type("ticket[type]", array_var($ticket_data, 'type'), array('id' => 'ticketFormType')) ?></td>
<?php } else { ?>
      <td><?php echo lang($ticket->getType()); ?></td>
<?php } // if?>

      <th><?php echo label_tag(lang('category'), 'ticketFormCategory') ?></th>
<?php if ($canEdit) { ?>
      <td><?php echo select_ticket_category("ticket[category_id]", $ticket->getProject(), array_var($ticket_data, 'category_id'), array('id' => 'ticketFormCategory')) ?></td>
<?php } else { ?>
    <td>
<?php if($ticket->getCategory()) { ?>
          <?php echo clean($ticket->getCategory()->getName()) ?>
<?php } // if{ ?>
    </td>
<?php } // if?>
    </tr>
  </table>
  
  <br />
  <div>
    <span class="bold"><?php echo lang('description') ?>:</span>
    <div class="desc"><?php echo do_textile($ticket->getDescription()); ?></div>
  </div>
</div>

<?php if ($canEdit) { ?>
  <?php echo submit_button($ticket->isNew() ? lang('add ticket') : lang('save')) ?>
<?php } // if?>
</form>
<br />
<div>
  <?php echo render_object_files($ticket, $ticket->canEdit(logged_user())) ?>
</div>

<div id="messageComments"><?php echo render_object_comments($ticket, $ticket->getViewUrl()) ?></div>

<h2><?php echo lang('history') ?></h2>
<?php if(isset($changes) && is_array($changes) && count($changes)) { ?>
<div id="changelog">
  <table>
    <tr>
      <th><?php echo lang('field') ?></th>
      <th><?php echo lang('old value') ?></th>
      <th><?php echo lang('new value') ?></th>
      <th><?php echo lang('user') ?></th>
      <th><?php echo lang('change date') ?></th>
    </tr>
<?php foreach($changes as $change) { ?>
    <tr>
      <td><?php echo lang($change->getType()) ?></td>
<?php if ($change->dataNeedsTranslation()) { ?>
      <td><?php echo lang($change->getFromData()) ?></td>
      <td><?php echo lang($change->getToData()) ?></td>
<?php } else { ?>
      <td><?php echo $change->getFromData() ?></td>
      <td><?php echo $change->getToData() ?></td>
<?php } // if ?>
      <td><?php echo $change->getCreatedByDisplayName() ?></td>
      <td><?php echo format_datetime($change->getCreatedOn()) ?></td>
    </tr>
<?php } // foreach ?>
  </table>
</div>
<?php } else { ?>
<p><?php echo lang('no changes in ticket') ?></p>
<?php } // if ?>
