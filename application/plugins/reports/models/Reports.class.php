<?php
/**
 * @author ALBATROS INFORMATIQUE SARL - CARQUEFOU FRANCE - Damien HENRY
 * @licence Honest Public License
 * @package ProjectPier Gantt
 * @version $Id$
 * @access public
 */
class Reports  {
	
  public function __construct(){
  }
  /**
   *Make Gantt
   *@return image png & die
   */        
  function MakeGanttChart(){
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
      $width = 850;      
      $graph = new GanttGraph($width);
      /*
      * here header must be set at end and during process catch all date to determine the difference max between start and end 
      * to present HDAY or not depend on information volume
      */
      //graph header
      $graph->ShowHeaders(GANTT_HYEAR | GANTT_HMONTH | GANTT_HWEEK | GANTT_HDAY);
      // Instead of week number show the date for the first day in the week
      // on the week scale
      $graph->scale->week->SetStyle(WEEKSTYLE_FIRSTDAY);
      $graph->SetMarginColor('blue:1.7');
      $graph->SetColor('white');
      $graph->SetBackgroundGradient('#60A2BA','white',GRAD_HOR,BGRAD_MARGIN);
      //$graph->SetBackgroundGradient('#A01010','white',GRAD_HOR,BGRAD_MARGIN);
      $graph->title->SetColor('white');
      $graph->title->SetFont(FF_FONT2,FS_BOLD,18);
      //$graph->scale->actinfo->SetColTitles(array('Act','Duration','Start','Finish','Resp'));
      $graph->scale->actinfo->SetStyle(ACTINFO_3D);
      $graph->scale->actinfo->SetFont(FF_ARIAL,FS_NORMAL,10);
      $graph->scale->actinfo->vgrid->SetColor('gray');
      $graph->scale->actinfo->SetColor('darkgray');
      $locale_char_set = 'utf-8';
      //For french support
      //Localization::instance()->getLocale();
      //if (preg_match('/' . Localization::instance()->getLocale() . '/i', 'fr_fr')) $graph->scale->SetDateLocale("fr_FR.utf8");

      /*
      * data jpgraph construction gantt type for project
      */    
      $project = active_project();
      //Project title
      $project_name = $project->getName();
      $graph->title->Set(lang('project') . ': ' . substr(utf8_decode($project_name),0,40) );

      $rows = $this->displayProjectGantt($project, $graph, 0);
      $subprojects = $project->getSubprojects();
      if (is_array($subprojects)) {
        foreach($subprojects as $subproject) {
          $rows = $this->displayProjectGantt($subproject, $graph, $rows++);
        }
      }

      //send data
      $type = "image/png";
      $name = "projectpiergantt.png";
      header("Content-Type: $type");
      header("pragma: no-cache");
      header("Content-Disposition: attachment; filename=\"$name\"");
      $graph->Stroke();
      die(); //end process do not send other informations
  }  //MakeGantt


  function displayProjectGantt(&$project, &$graph, $start_row) {
      /*
      * There is no start date in project i take the created date project
      * fields "created_on"      
      */      
      //start date project
      $start_date =  Localization::instance()->formatDate($project->getCreatedOn(),0,"Y-m-d");

      //line number jpgraph      
      $rows = $start_row;

      $project_name = $project->getName();
      $label = lang('project') . ': ' . substr(utf8_decode($project_name),0,40);
      $mydate = date('Y-m-d');
      $data = array(
        array($rows++,ACTYPE_GROUP,$label,$start_date,$mydate,'')
      );
      $graph->SetSimpleFont(FF_FONT1,FS_BOLD,18);
      $graph->CreateSimple($data);

      /*
      * Milestone
      */      
      $milestonehidden = array();         
      $milestones = $project->getMilestones();
      $mymilestone = array();
      if (is_array($milestones)) {
       foreach($milestones as $milestone){
        if (!in_array($milestone->getId(),$milestonehidden)){
          $ms_date = $milestone->getDueDate();
          if (is_null($ms_date)) {
            $ms_date =  Localization::instance()->formatDate($project->getCreatedOn(),0,"Y-m-d");
          } else {
            $ms_date = Localization::instance()->formatDate($ms_date,0,'Y-m-d');
          }
          $mymilestone[] = array($rows++, ACTYPE_MILESTONE, "  " . utf8_decode($milestone->getName()), $ms_date, $ms_date);
        }  //if
       } //foreach
      } //if

      // add many diamond on graph
      if (count($mymilestone)>0) $graph->CreateSimple($mymilestone);
      $task_lists = $project->getTaskLists();
      /*
      * We took only task because we can just compute execution % on task_list, there is no notion in task
      */
      //milestone which dont appear => link to task_list
      $milestonehidden = array();         
      if (is_array($task_lists)) {
        // Tasks lists
        foreach ($task_lists as $task_list) {
          //security access User can view this task_list ?
          if (!ProjectTaskList::canView(logged_user(), $task_list->getId())) continue;
          
          // task list name
          $task_list_name=$task_list->getName();
          //due to migration to 0.8.6 it s possible task_list due_date isnull
          $start_date = $task_list->getStartDate();
          if (is_null($start_date)) {
            $start_date =  Localization::instance()->formatDate($project->getCreatedOn(),0,"Y-m-d");
            //$start_date = date('Y-m-d');
          } else {
            $start_date = Localization::instance()->formatDate($start_date,0,'Y-m-d');
          }
          $mydate = $task_list->getDueDate();
          if ($mydate == ''){
            $mydate = date('Y-m-d');
          }else{
            $mydate = Localization::instance()->formatDate($mydate,0,'Y-m-d');
          }
          $progress = $this->progress($task_list);
          $progressgantt = array(
            array($rows,$progress[0]/100)
          );
          /*
          * detect if task_list is linked to milestone ?
          */
          $istasklistlinktomilestone = $task_list->getMilestone();
          //This task list have a milestone it due_date is milestone now
          $typebar = ACTYPE_GROUP;
          $milestonename = '';
          if ($istasklistlinktomilestone != '' && $istasklistlinktomilestone != null){
              $mydatemilestone = $istasklistlinktomilestone->getDueDate();
              if ($mydatemilestone != ''){
                $mydate = Localization::instance()->formatDate($mydatemilestone,0,'Y-m-d');
              }
              $milestonehidden[] = $istasklistlinktomilestone->getId();
              $typebar = ACTYPE_MILESTONE;
              $milestonename =  "\n  " . lang('milestone') . ": " . substr(utf8_decode($istasklistlinktomilestone->getName()),0,20);
          }//if
          
          $datasgantt = array(
           array($rows++,$typebar,"  " . substr(utf8_decode($task_list_name),0,35) . " [" . $progress[1] . '/' . $progress[2] . "]" . $this->epure($milestonename),$start_date,$mydate,'[' . $progress[0] ."%]",'','')
          );
          
          //task for this task_list
          $tasks = $task_list->getTasks();
          if (is_array($tasks)) {
            foreach($tasks as $task) {
              /*
              * security access
              */      
              //security access User can view this task ?
              if (!ProjectTask::canView(logged_user(), $task->getId())) continue;

              // icon freeming ok | cancel              
              if ($task->isCompleted()) {          
                //complete
                $progressgantt[] = array($rows,1); 
              } else {                             
                $progressgantt[] = array($rows,0);
              }//if
              //task name
              $task_text = '[' . $task->getId() . '] ' . $task->getText();
	      $this->epure($task_text);
	      $task_text = "    $task_text";
	      if (strlen($task_text) > 35) $task_text = substr($task_text,0,35) . "...";
              $start_date = $task->getStartDate();
              if (is_null($start_date)) {
                $start_date =  Localization::instance()->formatDate($project->getCreatedOn(),0,"Y-m-d");
                //$start_date = date('Y-m-d');
              } else {
                $start_date = Localization::instance()->formatDate($start_date,0,'Y-m-d');
              }
              $mydate = $task->getDueDate();
              if ($mydate == ''){
                $mydate = date('Y-m-d');
              } else {
                $mydate = Localization::instance()->formatDate($mydate,0,'Y-m-d');
              }
	      $datasgantt[] = array($rows++,ACTYPE_NORMAL,utf8_decode($task_text),$start_date,$mydate,$mydate,'','');
            }
          }
          if (count($datasgantt)> 0) $graph->CreateSimple($datasgantt,null,$progressgantt);
        } // foreach
      } // if

      return $rows;
  } // displayProjectGantt
  
  /**
   *Make Mn
   *@return string
   */        
  function MakeMindMap(){
      // header xml data freemind
      $content = "<map version=\"0.9.0\">\n";
      $content .= "<!-- To view this file, download free mind mapping software FreeMind from http://freemind.sourceforge.net -->\n";
      $mytime = time();

      // is logged ?     
      if (!logged_user()->isProjectUser(active_project())) {
        echo $content;
        echo "<node CREATED=\"$mytime\" ID=\"Freemind_Link_558888646\" MODIFIED=\"$mytime\" STYLE=\"bubble\" TEXT=\"Disconnected\">\n";
        echo "</node>\n";
        echo "</map>\n";
        die; 
      } // if
      // is user can view this project ??
      if (!ProjectFile::canView(logged_user(), active_project())) {
        echo $content;
        echo "<node CREATED=\"$mytime\" ID=\"Freemind_Link_558888646\" MODIFIED=\"$mytime\" STYLE=\"bubble\" TEXT=\"Not Allowed\">\n";
        echo "</node>\n";
        echo "</map>\n";
        die;
      } //if
      
      /*
      * xml data construction freemind for project
      */    
      $project = active_project();
      $project_name = $project->getName();
      $this->epure($project_name);
      //Project title
      $url = externalUrl(get_url('task','index'));
      $content .= "<node CREATED=\"$mytime\" LINK=\"$url\" MODIFIED=\"$mytime\" STYLE=\"bubble\" TEXT=\"$project_name\">\n";

      //milestones
      $milestones = $project->getMilestones();
      $mymilestone = array();
      if (is_array($milestones)) {
        foreach($milestones as $milestone){
	  $url = externalUrl(get_url('milestone','view',array('id' => $milestone->getId())));
	  $content .= "<node CREATED=\"$mytime\" LINK=\"$url\" POSITION=\"right\" MODIFIED=\"$mytime\" TEXT=\"  [" . $milestone->getName() . ' ' . Localization::instance()->formatDate($milestone->getDueDate()) . "]\">\n";
	  $content .= "<font NAME=\"SansSerif\" BOLD=\"true\" SIZE=\"12\"/>";
          $content .= "<icon BUILTIN=\"messagebox_warning\"/>\n";
          $content .= "<icon BUILTIN=\"messagebox_warning\"/>\n";
          $content .= "</node>\n";
        }
      }

      $task_lists = $project->getTaskLists();
      if (is_array($task_lists)) {
        //Tasks lists
        $positions = array('right','left');
        $actualpos = 0;
        foreach ($task_lists as $task_list) {
          /*
          * security access
          */      
          //security access User can view this task_list ?
          if (!ProjectTaskList::canView(logged_user(), $task_list->getId())) continue;
          
          // task list name
          $task_list_name=$task_list->getName();
	  //Complete or not complete
	  $progress = $this->progress($task_list);
	  $icon = null;
	  $tasklistComplete = false;
	  if ($progress[0] == '100'){
	    $icon .= "<icon BUILTIN=\"button_ok\"/>\n";
	    $tasklistComplete = true;
	  }
	  $this->epure('tl:'.$task_list_name);
          if (strlen($task_list_name) > 40) $task_list_name = substr($task_list_name,0,40) . "...";
          $position = $positions[$actualpos];
          $url = externalUrl(get_url('task','view_list',array('id' => $task_list->getId())));
          $content .= "<node CREATED=\"$mytime\" LINK=\"$url\" MODIFIED=\"$mytime\" POSITION=\"$position\" TEXT=\"$task_list_name\">\n";
	  $content .= "$icon";
          if ($actualpos == 0){
            $actualpos =1;            
          }else{
            $actualpos =0;            
          } //if
          //tasks
          $tasks = $task_list->getTasks();
          if (is_array($tasks)) {
            foreach($tasks as $task) {
              /*
              * security access
              */      
              //security access User can view this task ?
              if (!ProjectTask::canView(logged_user(), $task->getId())) continue;

              // icon freeming ok | cancel              
              $icon = null;
	      if (!$tasklistComplete){
		if ($task->isCompleted()) {          
		  //complete : icon ok
		  $icon .= "<icon BUILTIN=\"button_ok\"/>\n";
		  $dateclose = " []";
		}else{
		  //incomplete : icon cancel
		  $icon .= "<icon BUILTIN=\"button_cancel\"/>\n";
		  $dateclose = " []";
		} //if
	      } //if
              //task name
              $task_text = $task->getText();
	      $this->epure($task_text);
	      if (strlen($task_text) > 40) $task_text = substr($task_text,0,40) . "...";
              $url = externalUrl(get_url('task','view_task',array('id' => $task->getId())));
              $content .= "<node CREATED=\"$mytime\" LINK=\"$url\" MODIFIED=\"$mytime\" TEXT=\"" . $task_text . "\">\n";
              $content .= $icon;
              $content .= "</node>\n";
            }
          }
          $content .= "</node>\n";
        } // if
      } // if

    //footer xml data freemind  
    $content .= "</node>\n";
    $content .= "</map>";

    //send data
    $type = "x-freemind/mm";
    $name = "projectpier.mm";
    $size = strlen($content);
    header("Content-Type: $type");
    header("Content-Disposition: attachment; filename=\"$name\"");
    header("Content-Length: " . (string) $size);
    echo $content;
    die; //end process do not send other informations
  }  //MakeMm
  
  
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

  private function progress($task_list){
    /*
    * return string[] 
    */    
    $totalTasks = $task_list->countAllTasks();
    $openTasks = $task_list->countOpenTasks();
    $completedTasks = $task_list->countCompletedTasks();
    $percentTasks = 0;
    if ($totalTasks>0) {
      $percentTasks = round($completedTasks / $totalTasks * 100);
    }
    return array($percentTasks,$completedTasks,$totalTasks);
  }

  private function epure(&$value){
      /*
      * for epure char include <> not compatible with xml datas
      */      
      $value = preg_replace('/\>|\</','',$value);
      $value = preg_replace('/\"/','\'',$value);
      $value = preg_replace('/\n|\r/','',$value);
  }
  
}

?>