<?php

/**
 * Mn
 * 
 * @package ProjectPier Gantt
 * @author ALBATROS INFORMATIQUE SARL - CARQUEFOU FRANCE - Damien HENRY
 * @copyright 2011
 * @version $Id$
 * @access public
 */
class Gantt  {
	
  public function __construct(){
  }
  /**
   *Make Gantt
   *@return string
   */        
  function MakeGantt(){
      /*
      * includes jpgraph dans l'autoloader
      */      
      //include_once ("/application/plugins/library/jpgraph/src/jpgraph.php");
      //include_once ("/application/plugins/library/jpgraph/src/jpgraph_gantt.php");

      /*
      * security access
      */ 
      // is logged ?     
      if (!logged_user()->isProjectUser(active_project())) {
        die; 
      } // if
      // is user can view this project ??
      if (!ProjectFile::canView(logged_user(), active_project())) {
        die;
      } //if

      /*
      * Init gantt graph
      */
      $width = 800;      
      $graph = new GanttGraph($width);
      //graph header
      $graph->ShowHeaders(GANTT_HYEAR | GANTT_HMONTH | GANTT_HWEEK);
      
      
      /*
      * data jpgraph construction gantt type for project
      */    
      $project = active_project();
      //Project title
      $project_name = $project->getName();
      $graph->title->Set(lang('project') . ' : ' . substr(utf8_decode($project_name),0,40) );
      /*
      * There is no start date in project i take the created date project
      * fields "created_on"      
      */      
      //start date project
      $start_date =  Localization::instance()->formatDate($project->getCreatedOn(),0,"Y-m-d");

      $task_lists = $project->getTaskLists();
      /*
      * We took only task because we can just compute execution % on task_list, there is no notion in task
      */
      //line number jpgraph      
      $rows = 0;
      if (is_array($task_lists)) {
        //Tasks lists
        foreach ($task_lists as $task_list) {
          /*
          * security access
          */      
          //security access User can view this task_list ?
          if (!ProjectTaskList::canView(logged_user(), $task_list->getId())) continue;
          
          // task list name
          $task_list_name=$task_list->getName();
          //due to migration to 0.8.6 it s possible task_list due_date isnull
          $mydate = $task_list->getDueDate();
          if ($mydate == ''){
            $mydate = date('Y-m-d');
          }else{
            $mydate = Localization::instance()->formatDate($mydate,0,'Y-m-d');
          }
          $activity = new GanttBar($rows++,substr(utf8_decode($task_list_name),0,25),$start_date,$mydate);
          $graph->Add($activity);
        } // foreach
      } // if
      /*
      * Milestone
      */      
      $milestones = $project->getMilestones();
      $mymilestone = array();
      foreach($milestones as $milestone){
        $mymilestone[] = array($rows++, ACTYPE_MILESTONE, utf8_decode($milestone->getName()), Localization::instance()->formatDate($milestone->getDueDate(),0,'Y-m-d'), '');
      }
      // Ajouter les différents points ou périodes
      if (count($mymilestone)>0) $graph->CreateSimple($mymilestone);

      //send data
      //$type = "image/png";

    //header("Pragma: public"); // required 
      //header("Content-Type: $type");
      //header("Content-Length: " . (string) $size);
      $graph->Stroke();
  	  die; //end process do not send other informations
  }  //MakeGantt
  
  /*
  * Necessary call by line : if (!ProjectTaskList::canView(logged_user(), $task_list->getId())) continue;
  */
    
  public function isPrivate(){
    return false;
  } //isPrivate
  
  /*
  * Necessary : call by line : if (!ProjectTask::canView(logged_user(), $task->getId())) continue;
  */  
  public function getProject(){
    return active_project(); 
  } //getProject
}




/*
$row = 0;

if (!is_array($projects) || sizeof($projects) == 0) {
 $d = new CDate();
 $bar = new GanttBar($row++, array(' '.$AppUI->_('No projects found'),  ' ', ' ', ' '), $d->getDate(), $d->getDate(), ' ', 0.6);
 $bar->title->SetCOlor('red');
 $graph->Add($bar);
}

if (is_array($projects)) {
foreach($projects as $p) {


        if ($showLabels){
                $caption .= $AppUI->_($projectStatus[$p['project_status']]).", ";
                $caption .= $p['project_status'] <> 7 ? $AppUI->_('active') : $AppUI->_('archived');
        }
	$enddate = new CDate($end);
	$startdate = new CDate($start);
	$actual_end = $p["project_actual_end_date"] ? $p["project_actual_end_date"] : $end;

	$actual_enddate = new CDate($actual_end);
	$actual_enddate = $actual_enddate->after($startdate) ? $actual_enddate : $enddate;
        $bar = new GanttBar($row++, array($name, $startdate->format($df), (string)round($p['project_percent_complete'],0), $actual_enddate->format($df)), $start, $actual_end, $cap, 0.6);
        $bar->progress->Set(min(($progress/100), 1));

        $bar->title->SetFont(FF_FONT1,FS_NORMAL,10);
        $bar->SetFillColor("#".$p['project_color_identifier']);
        $bar->SetPattern(BAND_SOLID,"#".$p['project_color_identifier']);

	//adding captions
	$bar->caption = new TextProperty($caption);
	$bar->caption->Align("left","center");

        // gray out templates, completes, on ice, on hold
        if ($p['project_status'] != '3' || $p['project_status'] == '7') {
                $bar->caption->SetColor('darkgray');
                $bar->title->SetColor('darkgray');
                $bar->SetColor('darkgray');
                $bar->SetFillColor('gray');
                //$bar->SetPattern(BAND_SOLID,'gray');
                $bar->progress->SetFillColor('darkgray');
                $bar->progress->SetPattern(BAND_SOLID,'darkgray',98);
        }

 		foreach($tasks as $t)
 		{
 			if ($t["task_end_date"] == null)
 				$t["task_end_date"] = $t["task_start_date"];

			$tStart = ($t["task_start_date"] > "0000-00-00 00:00:00") ? $t["task_start_date"] : date("Y-m-d H:i:s");
			$tEnd = ($t["task_end_date"] > "0000-00-00 00:00:00") ? $t["task_end_date"] : date("Y-m-d H:i:s");
			$tStartObj = new CDate($tStart);
			$tEndObj = new CDate($tEnd);
 				
 			if ($t["task_milestone"] != 1)
 			{
				$bar2 = new GanttBar($row++, array(substr(" --".$t["task_name"], 0, 20)."...", $tStartObj->format($df),  $tEndObj->format($df), ' '), $tStart, $tEnd, ' ', $t['task_dynamic'] == 1 ? 0.1 : 0.6);
				
				$bar2->title->SetColor( bestColor( '#ffffff', '#'.$p['project_color_identifier'], '#000000' ) );
 				$bar2->SetFillColor("#".$p['project_color_identifier']);		
 				$graph->Add($bar2);
 			}
 			else
 			{
 				$bar2  = new MileStone ($row++, "-- " . $t["task_name"], $t["task_start_date"], $tStartObj->format($df));
 				$bar2->title->SetColor("#CC0000");
 				$graph->Add($bar2);
 			}				
 				
 				// Insert workers for each task into Gantt Chart 
 				$q  = new DBQuery;
				$q->addTable('user_tasks', 't');
				$q->addQuery('DISTINCT user_username, t.task_id');
				$q->addJoin('users', 'u', 'u.user_id = t.user_id');
				$q->addWhere("t.task_id = ".$t["task_id"]);
				$q->addOrder('user_username ASC');
 				$workers = $q->loadList();
				$q->clear();
 				$workersName = "";
 				foreach($workers as $w)
 				{	
 					$workersName .= " ".$w["user_username"];
 				
 					$bar3 = new GanttBar($row++, array("   * ".$w["user_username"], " ", " "," "), "0", "0;", 0.6);							
 					$bar3->title->SetColor(bestColor( '#ffffff', '#'.$p['project_color_identifier'], '#000000' ));
 					$bar3->SetFillColor("#".$p['project_color_identifier']);		
 					$graph->Add($bar3);
 				}
 				// End of insert workers for each task into Gantt Chart  				
 		}
 		// End of insert tasks into Gantt Chart 
 	}			
 	// End of if showAllGant checkbox is checked
}
} // End of check for valid projects array.

*/
?>