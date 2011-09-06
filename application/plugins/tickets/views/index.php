<?php 

  // Set page title and set crumbs to index
  $title = ($closed ? 'closed' : 'open').' tickets';
  set_page_title(lang($title));
  project_tabbed_navigation(PROJECT_TAB_TICKETS);
  project_crumbs(array(
    array(lang('tickets'), get_url('tickets')),
    array(lang($title))
  ));
  if(ProjectTicket::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add ticket'), get_url('tickets', 'add_ticket'));  
  }
  add_stylesheet_to_page('project/tickets.css');

  $options_pagination = array('page' => '#PAGE#');
  if ($closed) $options_pagination['closed'] = true;
?>
<?php if(isset($tickets) && is_array($tickets) && count($tickets)) { ?>
<div id="tickets">
  <div id="messagesPaginationTop"><?php echo advanced_pagination($tickets_pagination, get_url('tickets', 'index', $options_pagination)) ?></div>
<?php
  $this->assign('tickets', $tickets);
  $this->includeTemplate(get_template_path('view_tickets', 'tickets'));
?>
  <div id="messagesPaginationBottom"><?php echo advanced_pagination($tickets_pagination, get_url('tickets', 'index', $options_pagination)) ?></div>
</div>
<?php } else { ?>
<p><?php echo lang('no tickets in project') ?></p>
<?php } // if ?>
