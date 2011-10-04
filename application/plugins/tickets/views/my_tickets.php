<?php 
  // Set page title and set crumbs to index
  set_page_title(lang('my tickets'));
  dashboard_tabbed_navigation(DASHBOARD_TAB_MY_TICKETS);
  dashboard_crumbs(lang('my tickets')); 
  add_stylesheet_to_page('project/tickets.css');
?>
<?php 
  // If user have any assigned task or milestone this variable will be changed to TRUE
  // else it will remain false
  $has_assigned_tickets = false; 
?>
<?php if (isset($active_projects) && is_array($active_projects) && count($active_projects)) { ?>
<div id="tickets">
<?php
  foreach ($active_projects as $active_project) {
    $tickets = $active_project->getUsersTickets(logged_user());
    $project_url = $active_project->getOverviewUrl();
?>
<?php if (is_array($tickets) && count($tickets)) { ?>
<?php
  $has_assigned_tickets = true;
  $project_name = clean($active_project->getName());
  $tickets_header = "<a href=\"$project_url\">$project_name</a>";
  $this->assign('ticketsheader', $tickets_header);
  $this->assign('tickets', $tickets);
  $this->includeTemplate(get_template_path('view_tickets', 'tickets'));
?>
<?php } // if ?>

<?php } // foreach ?>
</div>
<?php } else { ?>
<p><?php echo lang('no active projects in db') ?></p>
<?php } // if  ?>

<?php if(!$has_assigned_tickets) { ?>
<p><?php echo lang('no my tickets') ?></p>
<?php } // if ?>