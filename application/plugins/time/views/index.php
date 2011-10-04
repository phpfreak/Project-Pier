<?php

  set_page_title(lang('time'));
  project_tabbed_navigation('time');
  project_crumbs(array(
    array(lang('time'), get_url('time', 'index')),
    array(lang('index'))
  ));
  if(ProjectTime::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add time'), get_url('time', 'add'));
    add_page_action(lang('report by task'), get_url('time', 'bytask'));
  } // if

  add_stylesheet_to_page('project/time.css');
?>
<?php if($times) { ?>
<div id="time">

  <div id="timesPaginationTop"><?php echo advanced_pagination($times_pagination, get_url('time', 'index', array('page' => '#PAGE#'))) ?></div>

<table class="timeLogs blank">
  <tr>
    <th><?php echo lang('date') ?></th>
    <th><?php echo lang('name') ?></th>
    <th><?php echo lang('details') ?></th>
    <th><?php echo lang('task') ?></th>
    <th><?php echo lang('hours') ?></th>
    <th><?php echo lang('bill') ?></th>
    <th><?php echo lang('actions') ?></th>
  </tr>

<?php
  foreach($times as $time) {
    $this->assign('time', $time);
?>

<?php if($time->isToday()) { ?>
  <tr class="timeToday">
<?php } elseif($time->isYesterday()) { ?>
  <tr class="timeYesterday">
<?php } else { ?>
  <tr class="timeOlder">
<?php } // if ?>

    <td class="timeDate">
<?php if(is_null($time->getDoneDate())) { ?>
  <?php echo '-'; ?>
<?php } else { ?>
<?php if($time->getDoneDate()->getYear() > DateTimeValueLib::now()->getYear()) { ?>
  <?php echo format_date($time->getDoneDate(), null, 0) ?>
<?php } else { ?>
  <?php echo format_descriptive_date($time->getDoneDate(), 0) ?>
<?php } // if ?>
<?php } // if ?>
		</td>
		<td class="timeUser">
      <?php if($time->getAssignedTo() instanceof ApplicationDataObject) { ?>
        <?php echo clean($time->getAssignedTo()->getObjectName()) ?>
      <?php } // if ?>
		</td>
    <td class="timeDetails">
			<a href="<?php echo $time->getViewUrl() ?>"><?php echo clean($time->getName()) ?></a>
    </td>
    <td class="timeTaskDetails">
<?php
      $task = ProjectTasks::findById($time->getTaskId());
      if ($task instanceof ProjectTask) {
?>
			<a href="<?php echo $task->getViewUrl() ?>"><?php echo clean($task->getObjectName()) ?></a>
      <?php } else { // if ?>
            &nbsp;
      <?php } // if ?>
    </td>
    <td class="timeHours"><?php echo $time->getHours() ?></td>
    <td class="timeFiles">
      <?php echo render_object_files_brief($time, $time->canEdit(logged_user())) ?>
    </td>
    <td class="timeEdit">
<?php
  $options = array();
  if($time->canEdit(logged_user())) $options[] = '<a href="' . $time->getEditUrl() . '">' . lang('edit') . '</a>';
  if($time->canDelete(logged_user())) $options[] = '<a href="' . $time->getDeleteUrl() . '" onclick="return confirm(\'' . lang('confirm delete time') . '\')">' . lang('delete') . '</a>';
?>
<?php if(count($options)) { ?>
     <?php echo implode(' | ', $options) ?>
<?php } ?>
		</td>
  </tr>
<?php
	}
?>
</table>
<div id="timesPaginationBottom"><?php echo advanced_pagination($times_pagination, get_url('time', 'index', array('page' => '#PAGE#'))) ?></div>

</div>
<?php } else { ?>
<p><?php echo clean(lang('no time records in project')) ?></p>
<?php } // if ?>