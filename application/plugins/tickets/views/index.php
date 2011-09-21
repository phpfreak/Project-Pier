<?php 

  // Set page title and set crumbs to index
  $title = 'tickets';
  set_page_title(lang($title));
  project_tabbed_navigation(PROJECT_TAB_TICKETS);
  project_crumbs(array(
    array(lang('tickets'), get_url('tickets')),
    array(lang($title))
  ));
  if(ProjectTicket::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add ticket'), get_url('tickets', 'add_ticket'));  
  }
  add_page_action(lang('download'), get_url('tickets', 'download'));  
  add_stylesheet_to_page('project/tickets.css');

  $options_pagination = array('page' => '#PAGE#');
?>
<div id="tickets">
<fieldset id="ticketsFilters">
<?php
      $this->assign('tickets', $tickets);
      $this->assign('categories', $categories);
      $this->assign('grouped_users', $grouped_users);
      $this->assign('filtered', $filtered);
      $this->assign('params', $params);
      $this->includeTemplate(get_template_path('tickets_filters', 'tickets'))
?>
</fieldset>
<?php if(isset($tickets) && is_array($tickets) && count($tickets)) { ?>
  <div id="messagesPaginationTop"><?php echo advanced_pagination($tickets_pagination, get_url('tickets', 'index', $options_pagination)) ?></div>
<?php
  //$this->assign('ticketsheader', lang('tickets'));
  $this->assign('tickets', $tickets);
  $this->includeTemplate(get_template_path('view_tickets', 'tickets'));
?>
  <div id="messagesPaginationBottom"><?php echo advanced_pagination($tickets_pagination, get_url('tickets', 'index', $options_pagination)) ?></div>
<?php } else { ?>
<p><?php echo lang('no tickets in project') ?></p>
<?php } // if ?>
</div>