<?php 
  add_stylesheet_to_page('project/tickets.css');
  $options_pagination = array('page' => '#PAGE#');
  if (isset($closed) && $closed) $options_pagination['closed'] = true;
?>
<?php if(isset($tickets) && is_array($tickets) && count($tickets)) { ?>
<div id="tickets" class="dashboard">
  <?php if (isset($tickets_pagination)): ?>
  <div id="ticketsPaginationTop"><?php echo advanced_pagination($tickets_pagination, get_url('tickets', 'index', $options_pagination)) ?></div>
  <?php endif ?>
  <?php
  $this->assign('tickets', $tickets);
  $this->includeTemplate(get_template_path('view_tickets', 'tickets'));
  ?>
  <?php if (isset($tickets_pagination)): ?>
  <div id="ticketsPaginationBottom"><?php echo advanced_pagination($tickets_pagination, get_url('tickets', 'index', $options_pagination)) ?></div>
  <?php endif ?>
</div>
<?php } else { ?>
<p><?php echo lang('no tickets in project') ?></p>
<?php } // if ?>