<?php

  set_page_title(lang('report by task'));
  project_tabbed_navigation();
  project_crumbs(lang('time'));
  if(ProjectTime::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add time'), get_url('time', 'add'));
    add_page_action(lang('report by task'), get_url('time', 'bytask'));
  } // if

  add_stylesheet_to_page('project/time.css');
?>
<?php if($times) { ?>
<div id="time">

<?php if(isset($task_lists) && is_array($task_lists) && count($task_lists)) { 

  foreach($task_lists as $task_list) {

    $this->assign('task_list', $task_list);

    $tl_time = 0;
    $tl = ProjectTimes::getTimeByTaskList ($task_list);
    
    $headers_outputted = false;
    
    if (is_array($tl) ) {

    	foreach($tl as $tl_entry) {
		$tl_time += $tl_entry->getHours();
    	}

	if ($tl_time > 0) {

		echo '<div class="timeTaskList">';
		echo '<h2>' . $task_list->getName() . ' [' . $tl_time . ' ' . lang('hour(s)') . ']' . '</h2>';
		echo '<h4>' . 'Common (not assigned to task)' . '</h4>';
		$tt = 0;
		
		foreach($tl as $tl_entry) {

			if (!$tl_entry->getTaskId()) {

				$tt += $tl_entry->getHours();

				if (!$headers_outputted) {
					echo '<table class="timeLogs blank"><tr><th>Date</th><th>Name</th><th>Details</th><th>Hours</th></tr>';
					$headers_outputted = true;
				}

				echo '<tr>';
				echo '<td class="timeDate">' . format_descriptive_date($tl_entry->getDoneDate(), 0) . '</td>';

				if($tl_entry->getAssignedTo() instanceof ApplicationDataObject) { 
					echo '<td class="timeUser">' . clean($tl_entry->getAssignedTo()->getObjectName()) . '</td>';
				} else {
					echo '<td class="timeUser">' . '' . '</td>';
				}
				echo '<td class="timeDetails">' . clean($tl_entry->getName()) . '</td>';
				echo '<td class="timeHours">' . $tl_entry->getHours() . '</td>';
				echo '</tr>';

			}

		}

		if ($headers_outputted) {
			echo '<tr><td>' . '<strong>Total</strong>' . '</td><td></td><td></td><td><strong>' . $tt . '</strong></td></tr>';
			echo '</table>';
		}
		
	}

    }

    if(is_array($task_list->getTasks()) && $tl_time > 0) {

    	foreach($task_list->getTasks() as $task) {

		echo '<h4>' . $task->getText() . '</h4>';

		$ts = ProjectTimes::getTimeByTask ($task);
		
		if(is_array($ts))
		{
			$tt = 0;
			echo '<table class="timeLogs blank"><tr><th>Date</th><th>Name</th><th>Details</th><th>Hours</th></tr>';
			foreach($ts as $t) {
				echo '<tr>';
				echo '<td class="timeDate">' . format_descriptive_date($t->getDoneDate(), 0) . '</td>';

      				if($t->getAssignedTo() instanceof ApplicationDataObject) { 
					echo '<td class="timeUser">' . clean($t->getAssignedTo()->getObjectName()) . '</td>';
				} else {
					echo '<td class="timeUser">' . '' . '</td>';
				}
				echo '<td class="timeDetails">' . clean($t->getName()) . '</td>';
				echo '<td class="timeHours">' . $t->getHours() . '</td>';
				echo '</tr>';
				$tt += $t->getHours();
			}
			echo '<tr><td>' . '<strong>Total</strong>' . '</td><td></td><td></td><td><strong>' . $tt . '</strong></td></tr>';
			echo '</table>';
		}
		
    	}

    }
    echo '</div>';

  } // foreach

}
?>

</div>
<?php } else { ?>
<p><?php echo clean(lang('no time records in project')) ?></p>
<?php } // if ?>