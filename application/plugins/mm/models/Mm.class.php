<?php

/**
 * Mn
 * 
 * @package ProjectPier Freemind
 * @author ALBATROS INFORMATIQUE SARL - CARQUEFOU FRANCE - Damien HENRY
 * @copyright 2011
 * @version $Id$
 * @access public
 */
class Mm  {
	
  public function __construct(){
  }
  /**
   *Make Mn
   *@return string
   */        
  function MakeMm(){
      // header xml data freemind
      $content = "<map version=\"0.9.0\">";
      $content .= "<!-- To view this file, download free mind mapping software FreeMind from http://freemind.sourceforge.net -->";
      $mytime = time();

      /*
      * security access
      */ 
      // is logged ?     
      if (!logged_user()->isProjectUser(active_project())) {
        echo $content;
        echo "<node CREATED=\"$mytime\" ID=\"Freemind_Link_558888646\" MODIFIED=\"$mytime\" STYLE=\"bubble\" TEXT=\"Disconnected\">";
        echo "</node>";
        echo "</map>";
        die; 
      } // if
      // is user can view this project ??
      if (!ProjectFile::canView(logged_user(), active_project())) {
        echo $content;
        echo "<node CREATED=\"$mytime\" ID=\"Freemind_Link_558888646\" MODIFIED=\"$mytime\" STYLE=\"bubble\" TEXT=\"Not Allowed\">";
        echo "</node>";
        echo "</map>";
        die;
      } //if
      
      /*
      * xml data construction freemind for project
      */    
      $project = active_project();
      $project_name = $project->getName();
      $this->epure($project_name);
      //Project title
      $url = externalUrl(html_entity_decode(get_url('task','index')));
      $content .= "<node CREATED=\"$mytime\" LINK=\"$url\" MODIFIED=\"$mytime\" STYLE=\"bubble\" TEXT=\"$project_name\">";
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
	  $this->epure($task_list_name);
          if (strlen($task_list_name) > 40) $task_list_name = substr($task_list_name,0,40) . "...";
          $position = $positions[$actualpos];
          $url = externalUrl(html_entity_decode(get_url('task','view_list',array('id' => $task_list->getId()))));
          $content .= "<node CREATED=\"$mytime\" LINK=\"$url\" MODIFIED=\"$mytime\" POSITION=\"$position\" TEXT=\"$task_list_name\">";
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
              if ($task->isCompleted()) {          
                //complete : icon ok
                $icon .= "<icon BUILTIN=\"button_ok\"/>";
                $dateclose = " []";
              }else{
                //incomplete : icon cancel
                $icon .= "<icon BUILTIN=\"button_cancel\"/>";
                $dateclose = " []";
              } //if
              //task name
              $task_text = $task->getText();
	      $this->epure($task_text);
	      if (strlen($task_text) > 40) $task_text = substr($task_text,0,40) . "...";
              $url = externalUrl(html_entity_decode(get_url('task','view_task',array('id' => $task->getId()))));
              $content .= "<node CREATED=\"$mytime\" LINK=\"$url\" MODIFIED=\"$mytime\" TEXT=\"" . $task_text . "\">";
              $content .= $icon;
              $content .= "</node>";
            }
          }
          $content .= "</node>";
        } // if
      } // if
    //footer xml data freemind  
    $content .= "</node>";
    $content .= "</map>";

    //send data
    $type = "text/html";
    $name = "mn.mm";
    $size = strlen($content);
    header("Content-Type: $type");
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

  private function epure(&$value){
      $value = preg_replace('/\>|\</','',$value);
  }
}

?>