<?php

  set_page_title(lang('milestones'));
  project_tabbed_navigation('milestones');
  project_crumbs(array(
    array(lang('milestones'), get_url('milestone', 'index')),
    array(lang('view calendar'))
  ));
  if (ProjectMilestone::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add milestone'), get_url('milestone', 'add'));
  } // if
  add_stylesheet_to_page('project/calendar.css');
  $view_image = $view_type=="list" ? "icons/list_on.png" : "icons/list_off.png";
  add_view_option(lang('list'), get_image_url( $view_image ), get_url('milestone', 'index', array("view" => "list") ));
  $view_image = $view_type=="card" ? "icons/excerpt_on.png" : "icons/excerpt_off.png";
  add_view_option(lang('card'), get_image_url( $view_image ), get_url('milestone', 'index', array("view" => "details") ) );
  add_view_option(lang('calendar'), get_image_url( "icons/calendar_off.png" ), get_url('milestone', 'calendar'));
?>
<div class="calendar">
  <h2><?php echo clean(lang(sprintf('month %u', $month))); ?> <?php echo $year; ?></h2>
<?php
  $calendar = array();
  if (is_array($milestones) && count($milestones)) {
    foreach ($milestones as $milestone) {
      $due = $milestone->getDueDate();
      if ($due->getYear() != $year or $due->getMonth() != $month) {
        continue;
      }
      $calendar[$due->getDay()][] = $milestone;
    }
  } // if
  trace(__FILE__,'task lists:begin');
  if (is_array($task_lists) && count($task_lists)) {
    foreach ($task_lists as $task_list) {
      $due = $task_list->getDueDate();
      if ($due->getYear() != $year or $due->getMonth() != $month) {
        continue;
      }
      $calendar[$due->getDay()][] = $task_list;
      $tasks = $task_list->getTasks();
      if (is_array($tasks)) {
        foreach($tasks as $task) {
          $due = $task_list->getDueDate();
          if (is_null($due)) continue;
          if ($due->getYear() != $year or $due->getMonth() != $month) {
            continue;
          }
          $calendar[$due->getDay()][] = $task;
        }
      }
    }
  } // if
  trace(__FILE__,'task lists: end');

  $thisMonth = gmmktime(0, 0, 0, $month, 2, $year, 0);
  //echo date('Y m d H i s', $thisMonth);
  $prevMonth = strtotime('-1 month', $thisMonth);
  $nextMonth = strtotime('+1 month', $thisMonth);
  $daysInMonth = gmdate('t', $thisMonth);
  $firstDayOfWeek = config_option('calendar_first_day_of_week', 1);
  $daysInWeek = 7; // in case you live on another planet...
  $lastDayOfWeek = 8;
  $firstDayOfMonth = gmdate('w', $thisMonth);  // Sunday = 0, Monday = 1, ... Saturday = 6
  if ($firstDayOfMonth == 0) {
    $firstDayOfMonth = 7;  // Monday = 1, ... Saturday = 6, Sunday = 7
  }
?>
  <table width="100%">
    <tr valign="top">
<?php
  for ($dow = 1; $dow < 8; $dow++) {
    if ($dow > 5) {
      $dow_class = "weekend";
    } else {
      $dow_class = "weekday";
    }
?>
      <th class="<?php echo $dow_class; ?>"><?php echo clean(lang(sprintf('weekday short %u', $dow ))); ?></th>
<?php
  } // for
?>
    </tr>
    <tr valign="top">
<?php

  /*
   * Skip days from previous month.
   */

  for ($dow = 1; $dow < $firstDayOfMonth; $dow++) {
    if ($dow % $daysInWeek > 5) {
      $dow_class = "weekend";
    } else {
      $dow_class = "weekday";
    }
?>
      <td class="<?php echo $dow_class; ?>">&nbsp;</td>
<?php
  } // for

  /*
   * Render the month's calendar.
   */
  $dow = $firstDayOfMonth;
  for ($dom = 1; $dom <= $daysInMonth;) {
    for (; ($dow < $lastDayOfWeek) && ($dom <= $daysInMonth); $dow++, $dom++) {
      if ($dow > 5) {
        $dow_class = "weekend";
      } else {
        $dow_class = "weekday";
      }
?>
      <td class="<?php echo $dow_class; ?>">
        <div class="date"><?php echo $dom; ?></div>
<?php
      if (isset($calendar[$dom]) 
        && is_array($calendar[$dom])
        && count($calendar[$dom])) {
?>
        <ul class="entries">
<?php
          foreach ($calendar[$dom] as $obj) {
            if (use_permitted(logged_user(), active_project(), 'tasks')) {
              printf('<li class="%s"><a href="%s">%s</a></li>'."\n",
                strtr(lc($obj->getObjectTypeName()), ' ', '_'),
                $obj->getViewUrl(),
                clean($obj->getObjectName())
              );
            } else {
              printf('<li class="%s">%s</li>'."\n",
                strtr(lc($obj->getObjectTypeName()), ' ', '_'),
                clean($obj->getObjectName())
              );
            }
          }
?>
        <ul>
<?php
        } // if
?>
      </td>
<?php
    } // for
?>
    </tr>
<?php if ($dom <= $daysInMonth) { ?>
    <tr valign="top">
<?php
      $dow = 1;
    } // if
  } // for

  /*
   * Skip days from next month.
   */

  if ($dow < $lastDayOfWeek) {
    for (; $dow < $lastDayOfWeek; $dow++) {
      if ($dow % $daysInWeek > 5) {
        $dow_class = "weekend";
      } else {
        $dow_class = "weekday";
      }
?>
      <td class="<?php echo $dow_class; ?>">&nbsp;</td>
<?php
    } // for
?>
    </tr>
<?php
  } // if
?>
  </table>
  <div class="month-nav">
    <div class="prev-month"><a href="<?php echo get_url('milestone', 'calendar', gmdate('Ym', $prevMonth)); ?>"><?php echo clean(lang(sprintf('month %u', gmdate('m', $prevMonth)))); ?> <?php echo gmdate('Y', $prevMonth); ?></a></div>
    <div class="next-month"><a href="<?php echo get_url('milestone', 'calendar', gmdate('Ym', $nextMonth)); ?>"><?php echo clean(lang(sprintf('month %u', gmdate('m', $nextMonth)))); ?> <?php echo gmdate('Y', $nextMonth); ?></a></div>
  </div>
</div>