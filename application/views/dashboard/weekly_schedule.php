<?php 

  // Set page title and set crumbs to index
  set_page_title(lang('weekly schedule'));
  dashboard_tabbed_navigation('weekly_schedule');
  dashboard_crumbs(lang('weekly schedule'));
  add_stylesheet_to_page('dashboard/weekly_schedule.css');
  add_stylesheet_to_page('project/calendar.css');
  add_stylesheet_to_page('project/tickets.css');

?>
<script type="text/javascript" src="<?php echo get_javascript_url('modules/calendar.js') ?>"></script>
<?php if ((isset($upcoming_milestones) && is_array($upcoming_milestones) && count($upcoming_milestones)) ||
(isset($upcoming_tickets) && is_array($upcoming_tickets) && count($upcoming_tickets)) ||
(isset($late_milestones) && is_array($late_milestones) && count($late_milestones)) ||
(isset($late_tickets) && is_array($late_tickets) && count($late_tickets))) { ?>
  <div id="viewToggle">
    <a href="<?php echo get_url('dashboard', 'weekly_schedule', array('view'=>'list')); ?>"><img src="<?php if ($view_type=="list") { echo get_image_url("icons/list_on.png"); } else { echo get_image_url("icons/list_off.png"); } ?>" title="<?php echo lang('list view'); ?>" alt="<?php echo lang('list view'); ?>"/></a>
    <a href="<?php echo get_url('dashboard', 'weekly_schedule', array('view'=>'detail')); ?>"><img src="<?php if ($view_type=="detail") { echo get_image_url("icons/excerpt_on.png"); } else { echo get_image_url("icons/excerpt_off.png"); } ?>" title="<?php echo lang('detail view'); ?>" alt="<?php echo lang('detail view'); ?>"/></a>
    <a href="<?php echo get_url('dashboard', 'weekly_schedule', array('view'=>'calendar')); ?>"><img src="<?php if ($view_type=="calendar") { echo get_image_url("icons/calendar_on.png"); } else { echo get_image_url("icons/calendar_off.png"); } ?>" title="<?php echo lang('view calendar'); ?>" alt="<?php echo lang('view calendar'); ?>"/></a>
  </div> <!-- // #viewToggle -->
<?php if ($view_type == 'list') { ?>
<?php if ($late_tickets && count($late_tickets)) { ?>
  <div id="lateTickets">
    <h2><?php echo lang('late tickets'); ?></h2>
    <div id="tickets">
  <?php 
    $this->assign('tickets', $late_tickets);
    $this->includeTemplate(get_template_path('view_tickets', 'tickets'));
  ?>
    </div>
  </div><br/>
<?php } // if ?>
<?php if ($late_milestones && count($late_milestones)) { ?>
  <div id="lateMilestones">
    <h2><?php echo lang('late milestones'); ?></h2>
    <table id="shortMilestones">
      <tr class="milestone short header"><th class="milestoneCompleted"></th><th class="milestoneDueDate"><?php echo lang('due date'); ?></th><th class="milestoneTitle"><?php echo lang('title'); ?></th><th class="milestoneDaysLeft"></th><th class="milestoneCommentsCount"><img src="<?php echo get_image_url("icons/comments.png"); ?>" title="Comments" alt="Comments"/></th></tr>
  <?php 
    foreach ($late_milestones as $milestone) {
      $this->assign('milestone', $milestone);
      $this->includeTemplate(get_template_path('view_milestone_short', 'milestone'));
    } // foreach 
  ?>
    </table>
  </div><br/>
<?php } // if ?>
<?php if (isset($upcoming_tickets) && is_array($upcoming_tickets) && count($upcoming_tickets)) { ?>
  <div id="tickets">
    <h2><?php echo lang('upcoming tickets'); ?></h2>
    <?php 
      $this->assign('tickets', $upcoming_tickets);
      $this->includeTemplate(get_template_path('view_tickets', 'tickets'));
    ?>
  </div>
<?php } // if ?>
<?php if (isset($upcoming_milestones) && is_array($upcoming_milestones) && count($upcoming_milestones)) { ?>
  <div id="milestones">
    <h2><?php echo lang('upcoming milestones') ?></h2>
    <table id="shortMilestones">
      <tr class="milestone short header"><th class="milestoneCompleted"></th><th class="milestoneDueDate"><?php echo lang('due date'); ?></th><th class="milestoneTitle"><?php echo lang('title'); ?></th><th class="milestoneDaysLeft"></th><th class="milestoneCommentsCount"><img src="<?php echo get_image_url("icons/comments.png"); ?>" title="Comments" alt="Comments"/></th></tr>
  <?php
    foreach ($upcoming_milestones as $milestone) {
      $this->assign('milestone', $milestone);
      $this->includeTemplate(get_template_path('view_milestone_short', 'milestone'));
    } // foreach
  ?>
    </table>
<?php } // if ?>
<?php } elseif ($view_type == 'detail') { ?>
<?php if ($late_tickets && count($late_tickets)) { ?>
  <div id="lateTickets">
    <h2><?php echo lang('late tickets'); ?></h2>
    <div id="tickets">
  <?php 
    $this->assign('tickets', $late_tickets);
    $this->includeTemplate(get_template_path('view_tickets', 'tickets'));
  ?>
    </div>
  </div><br/>
<?php } // if ?>
<?php if ($late_milestones && count($late_milestones)) { ?>
  <div id="lateMilestones">
    <h2><?php echo lang('late milestones'); ?></h2>
  <?php 
    foreach ($late_milestones as $milestone) {
      $this->assign('milestone', $milestone);
      $this->includeTemplate(get_template_path('view_milestone', 'milestone'));
    } // foreach 
  ?>
    </table>
  </div><br/>
<?php } // if ?>
<?php if (isset($upcoming_tickets) && is_array($upcoming_tickets) && count($upcoming_tickets)) { ?>
  <div id="tickets">
    <h2><?php echo lang('upcoming tickets'); ?></h2>
    <?php 
      $this->assign('tickets', $upcoming_tickets);
      $this->includeTemplate(get_template_path('view_tickets', 'tickets'));
    ?>
  </div>
<?php } // if ?>
<?php if (isset($upcoming_milestones) && is_array($upcoming_milestones) && count($upcoming_milestones)) { ?>
  <div id="milestones">
    <h2><?php echo lang('upcoming milestones') ?></h2>
<?php 
  foreach ($upcoming_milestones as $milestone) {
    $this->assign('milestone', $milestone);
    $this->includeTemplate(get_template_path('view_milestone', 'milestone'));
  } // foreach 
?>
<?php } // if ?>
<?php } else { ?>
<?php if ($late_tickets && count($late_tickets)) { ?>
  <div id="lateTickets">
    <h2><?php echo lang('late tickets'); ?></h2>
    <div id="tickets">
  <?php 
    $this->assign('tickets', $late_tickets);
    $this->includeTemplate(get_template_path('view_tickets', 'tickets'));
  ?>
    </div>
  </div><br/>
<?php } // if ?>
<?php if ($late_milestones && count($late_milestones)) { ?>
  <div id="lateMilestones">
    <h2><?php echo lang('late milestones'); ?></h2>
    <table id="shortMilestones">
      <tr class="milestone short header"><th class="milestoneCompleted"></th><th class="milestoneDueDate"><?php echo lang('due date'); ?></th><th class="milestoneTitle"><?php echo lang('title'); ?></th><th class="milestoneDaysLeft"></th><th class="milestoneCommentsCount"><img src="<?php echo get_image_url("icons/comments.png"); ?>" title="Comments" alt="Comments"/></th></tr>
  <?php 
    foreach ($late_milestones as $milestone) {
      $this->assign('milestone', $milestone);
      $this->includeTemplate(get_template_path('view_milestone_short', 'milestone'));
    } // foreach 
  ?>
    </table>
  </div><br/>
<?php } // if ?>
  <div class="calendar">
    <h2><?php echo clean(lang('month '.$from_date->format('n'))); ?> <?php echo $from_date->format('Y'); ?></h2>
<?php
$calendar = array();
if (is_array($upcoming_milestones) && count($upcoming_milestones)) {
  foreach ($upcoming_milestones as $milestone) {
    $due = $milestone->getDueDate();
    $calendar[$due->format('Ymd')][] = $milestone;
  }
} // if
if (is_array($upcoming_tickets) && count($upcoming_tickets)) {
  foreach ($upcoming_tickets as $ticket) {
    $due = $ticket->getDueDate();
    $calendar[$due->format('Ymd')][] = $ticket;
  }
} // if
$weekendDays = array(6,7);
?>
    <table>
      <tr>
<?php
for ($i = 1; $i <= 7; $i++) {
  if (in_array($i, $weekendDays)) {
    $cell_class = "weekend";
  } else {
    $cell_class = "weekday";
  } // if ?>
        <th class="<?php echo $cell_class; ?>"><?php echo clean(lang('weekday short '.$i)); ?></th>
<?php } // for ?>
      </tr>
<?php $current_date = $from_date; ?>
<?php
while ($current_date->getTimestamp() < $to_date->getTimestamp()) {
  if ($current_date->format('w') == 1) { ?>
      <tr>
<?php  } // if
  $cell_class = $current_date->isWeekend() ? "weekend" : "weekday";
  if ($current_date->isToday()) {
    $cell_class .= " today";
  } elseif ($current_date->isYesterday()) {
    $cell_class .= " yesterday";
  } elseif ($current_date->advance(7*24*60*60, false)->isToday()) {
    $cell_class .= " lastweek";
  }

?>
        <td class="<?php echo $cell_class;?>">
          <div class="date"><?php echo $current_date->format('j'); ?></div>
<?php
$current_date_str = $current_date->format('Ymd');
if (isset($calendar[$current_date_str])
    && is_array($calendar[$current_date_str])
    && count($calendar[$current_date_str])) {
          ?>
          <ul class="entries">
<?php
foreach ($calendar[$current_date_str] as $event) {
  if ($event instanceof ProjectMilestone) { ?>
            <li class="event milestone <?php echo "project".$event->getProjectId()." projectColor".$projects_index[$event->getProjectId()]%16 ;?>"><a href="<?php echo $event->getViewUrl(); ?>"><?php echo $event->getName(); ?></a></li>
<?php } elseif ($event instanceof ProjectTicket) { ?>
            <li class="event task <?php echo "project".$event->getProjectId()." projectColor".$projects_index[$event->getProjectId()]%16 ;?>"><a href="<?php echo $event->getViewUrl(); ?>"><?php echo $event->getSummary(); ?></a></li>
<?php } // if ?>
<?php } // foreach ?>
<?php } // if ?>
          </ul>
        </td>
<?php
  if ($current_date->format('w') == 0) { ?>
      </tr>
<?php } // if
  $current_date->advance(60*60*24);
} // while

?>
    </table>
    <div id="calendar_legend">
      <h2><?php echo lang('legend'); ?></h2>
      <ul>
<?php foreach ($projects as $project) { ?>
        <li id="projectLabel<?php echo $project->getId(); ?>" class="projectLabel projectColor<?php echo $projects_index[$project->getId()]%16 ?>" ><?php echo $project->getName(); ?></li>
<?php } // foreach ?>
      </ul>
    </div>
    <div class="clear"></div>
  </div>


<?php   } ?>
</div><!-- // #milestones -->
<?php } else { ?>
<p><?php echo clean(lang('no active milestones in project')) ?></p>
<?php } // if ?>
<div style="clear:both"></div>