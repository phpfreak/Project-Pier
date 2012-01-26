<?php
  class RemindersController extends ApplicationController {
    
    /**
    * Construct the RemindersController
    *
    * @access public
    * @param void
    * @return RemindersController
    */
    function __construct() {
      parent::__construct();
      $this->setLayout('dialog');
    }
    /**
    * List all project forms
    *
    * @param void
    * @return null
    */
    function index() {
      tpl_assign('user', logged_user());
    } // index     } // index
     
    function preferences() {
      prepare_company_website_controller($this, 'account');
      $this->setTemplate('edit_preferences');

      $user = logged_user();

      if (!($user instanceof User)) {
        flash_error(lang('user dnx'));
        $this->redirectTo('dashboard');
      } // if
      
      $company = $user->getCompany();
      if (!($company instanceof Company)) {
        flash_error(lang('company dnx'));
        $this->redirectToReferer(get_url('administration'));
      } // if
      
      if (!$user->canUpdateProfile(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard');
      } // if
      
      $redirect_to = array_var($_GET, 'redirect_to');
      if ((trim($redirect_to)) == '' || !is_valid_url($redirect_to)) {
        $redirect_to = $user->getCardUrl();
      } // if

      $reminder_prefs = Reminders::findById(logged_user()->getId());
      if (!$reminder_prefs instanceof Reminder) {
        $reminder_prefs = new Reminder();
      }

      $weekArray = array(
        'Sunday', 
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
      );
    
      tpl_assign('reminder_prefs', $reminder_prefs);
      
      $dayOfWeek = ConfigOptions::getByName('calendar_first_day_of_week');

      tpl_assign('dayOfWeek', $dayOfWeek->getValue());
      tpl_assign('weekArray', $weekArray);
      tpl_assign('redirect_to', $redirect_to);
      tpl_assign('user', $user);
      tpl_assign('company', $company);

     } //reminder_preferences
     
    function update_prefs() {
      prepare_company_website_controller($this, 'account');
 
      $user = logged_user();
      if (!($user instanceof User)) {
        flash_error(lang('user dnx'));
        $this->redirectTo('dashboard');
      } // if
        
      $company = $user->getCompany();
      if (!($company instanceof Company)) {
        flash_error(lang('company dnx'));
        $this->redirectToReferer(get_url('administration'));
      } // if
        
      if (!$user->canUpdateProfile(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard');
      } // if
        
      $redirect_to = array_var($_GET, 'redirect_to');
      if ((trim($redirect_to)) == '' || !is_valid_url($redirect_to)) {
         $redirect_to = $user->getCardUrl();
      } // if
  

      $this->setTemplate('edit_preferences');
       
      $reminder_prefs = Reminders::findById(logged_user()->getId());
  
      if (!$reminder_prefs instanceof Reminder) {
        $reminder_prefs = new Reminder();
      }
       
      $prefs_form = array_var($_POST, 'prefs_form');
       
      $reminder_prefs->setUserId(logged_user()->getId());
      $reminder_prefs->setRemindersEnabled($prefs_form['reminders_enabled']);
      $reminder_prefs->setSummarizedBy($prefs_form['summarized_by']);
      $reminder_prefs->setRemindersFuture($prefs_form['future']);
      $reminder_prefs->setIncludeEveryone($prefs_form['ivsteam']);
  
      $weekArray = array(
        'Sunday', 
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
      );
      $days = '';
      for ($i = 0; $i < 7; $i++) {
          if (isset($prefs_form[$weekArray[$i]])) {
            $days .= "".$weekArray[$i].",";
          }
      }
      $reminder_prefs->setReminderDaysToSend($days);
      $reminder_prefs->setReportsEnabled($prefs_form['reports_enabled']);
      $reminder_prefs->setReportsSummarizedBy($prefs_form['reports_summarized']);
      $reminder_prefs->setReportsIncludeEveryone($prefs_form['ivsteam2']);
      $reminder_prefs->setReportDay($prefs_form['reportDay']);
      $reminder_prefs->setReportsIncludeActivity($prefs_form['report_activity']);

      try {
        DB::beginWork();
        $reminder_prefs->save();
        DB::commit();
        flash_success(lang('prefs updated'));
      } catch(Exception $e) {
        DB::rollback();
        flash_error('Error: '. $e );
      }     	
      $dayOfWeek = ConfigOptions::getByName('calendar_first_day_of_week');

      tpl_assign('dayOfWeek', $dayOfWeek->getValue());    	
      tpl_assign('redirect_to', $redirect_to);
      tpl_assign('user', $user);
      tpl_assign('company', $company);
      tpl_assign('reminder_prefs', $reminder_prefs);
    }
     
    function send_emails() {
       $this->send_reminders();
       $this->send_reports();
       die();
    }
     
    function send_reminders() {
      $company = Companies::findById(1);
      $lTime = time() + (60 * 60 * $company->getTimezone());
      $dayOfWeek = date("l", $lTime);

      $people = Reminders::findAll(array('conditions' => 'reminders_enabled = 1 and FIND_IN_SET("'.$dayOfWeek.'", reminder_days)'));
      if (is_array($people) && count($people)) { 
      foreach ($people as $person) {
        $emailBody = "";
        tpl_assign('settings', $person);
        $user = Users::findById($person->getUserId());
        //echo $user->getDisplayName();
        tpl_assign('user', $user);
        $activeProjects = $user->getActiveProjects();
        $recipient = Notifier::prepareEmailAddress($user->getEmail(), $user->getDisplayName());
        foreach ($activeProjects as $project) {
          $openTaskLists = array();
          tpl_assign('project', $project);
          $taskLists = $project->getAllOpenTaskLists();
          if (!is_array($taskLists)) $taskLists = array();
          foreach ($taskLists as $list) {
            tpl_assign('taskList', $list);
            $condition = 'task_list_id = '.$list->getId();
            if (!$person->getIncludeEveryone()) {
              $condition .= " and assigned_to_user_id = ".$user->getId();
            }
            $condition .= " and completed_on is null";
            $condition .= " and due_date < Interval ".$person->getRemindersFuture()." day + now()";
            $tasks = ProjectTasks::findAll(array('conditions' => $condition));

            if (is_array($tasks)) {
              $openTaskLists[] = $list;
            }
            if (!is_array($tasks)) $tasks = array();

            if ($person->getSummarizedBy() == 'task list' && is_array($tasks)) {
              tpl_assign('tasks', $tasks);
              try { 
                Notifier::sendEmail(
                  $recipient,
                  $recipient,
                  "[ProjectPier] - Task List Reminder - ".$list->getObjectName(),
                  tpl_fetch(get_template_path('per_tasklist', 'reminders')),
                  'text/html'
                ); // send
              } catch (Exception $e) { echo $e; }
            } else if ($person->getSummarizedBy() == 'task') {
              foreach ($tasks as $task) {
                tpl_assign('task', $task);
                try { 
                  Notifier::sendEmail(
                    $recipient,
                    $recipient,
                    "[ProjectPier] - Task Reminder - ".$task->getObjectName(),
                    tpl_fetch(get_template_path('per_task', 'reminders')),
                    'text/html'
                  ); // send
                } catch (Exception $e) { echo $e; }
                print $task->getText();
              }
            }
          }
          if ($person->getSummarizedBy() == 'all' && (!empty($openTaskLists))) {
            tpl_assign('taskLists', $openTaskLists);
            $emailBody .= tpl_fetch(get_template_path('reminders_all', 'reminders'));
          }
          if ($person->getSummarizedBy() == 'project' && (!empty($openTaskLists))) {
            tpl_assign('taskLists', $openTaskLists);
            try { 
              Notifier::sendEmail(
                $recipient,
                $recipient,
                "[ProjectPier] - Project Reminder - ".$project->getObjectName(),
                tpl_fetch(get_template_path('per_project', 'reminders')),
                'text/html'
              ); // send
            } catch (Exception $e) { echo $e; }
          }
        }
        if ($person->getSummarizedBy() == 'all' && strlen($emailBody)) {
          try { 
            Notifier::sendEmail(
              $recipient,
              $recipient,
              "[ProjectPier] - Reminders",
              $emailBody."<hr><a href='".externalUrl(ROOT_URL)."'>".externalUrl(ROOT_URL)."</a>\n",
              'text/html'
            ); // send
          } catch (Exception $e) { echo $e; }
        }
      }
      }
    }
     
    function send_reports() {
      $company = Companies::findById(1);
      $lTime = time() + (60 * 60 * $company->getTimezone());
      $dayOfWeek = date("l", $lTime);
      $footer = '<a href="'.externalUrl(ROOT_URL).'">'.externalUrl(ROOT_URL)."</a>";
      $people = Reminders::findAll(array('conditions' => 'reports_enabled = 1 and report_day = "'.$dayOfWeek.'"'));
      if (is_array($people) && count($people)) {
      foreach ($people as $person) {
        tpl_assign('settings', $person); 
        $user = Users::findById($person->getUserId());
        tpl_assign('user', $user);
        $offset = 60 * 60 * $user->getTimezone();
        tpl_assign('offset', $offset);
        $allProjects = $user->getProjects();
        $emailBody  = '';
        $recipient = Notifier::prepareEmailAddress($user->getEmail(), $user->getDisplayName());			
        foreach ($allProjects as $project) {
          if (($project->isActive()) || ($project->getCompletedOn()->getLeftInDays() > -7)) {
            tpl_assign('project', $project);
            $condition = 'project_id = '.$project->getId();
            $condition .= " and is_private = 0 and is_silent = 0";
            if (!$person->getReportsIncludeEveryone()) {
              $condition .= ' and taken_by_id = '.$user->getId();
            }
            $logs = array();
            if ($person->getReportsIncludeActivity()) {
              $condition .= " and created_on > Interval -7 day + now()";
              $logs = ApplicationLogs::findAll(array('conditions' => $condition));
            }
            tpl_assign('logs', $logs);
            $taskLists = $project->getAllTaskLists();
            $emailTaskLists = array();
            if (is_array($taskLists) && count($taskLists)) {
              foreach ($taskLists as $taskList) {
                $condition = 'task_list_id = '.$taskList->getId();
                if (!$person->getReportsIncludeEveryone()) {
                    $condition .= " and assigned_to_user_id = ".$user->getId();
                }
                $condition .= " and completed_on > Interval -7 day + now()";
                $tasks = ProjectTasks::findAll(array('conditions' => $condition));
                if (is_array($tasks) && count($tasks)) {
                  $emailTaskLists[] = $taskList;
                }
              }
            }
            if (count($emailTaskLists) || count($logs)) {
              tpl_assign('taskLists', $emailTaskLists);
              $emailBody .= tpl_fetch(get_template_path('report_per_project', 'reminders'));

              if ($person->getReportsSummarizedBy()) {
                try { 
                  Notifier::sendEmail(
                    $recipient,
                    $recipient,
                    "[ProjectPier] - Project Report - ".$project->getObjectName(),
                    $emailBody.$footer,
                    'text/html'
                  ); // send
                  $emailBody = '';
                } catch (Exception $e) { echo $e; }
              }
            } 					
          }
        }
        if (strlen($emailBody) && !$person->getReportsSummarizedBy()) {
          $time = time() + (60 * 60 * $user->getTimezone());
          try { 
            Notifier::sendEmail(
              $recipient,
              $recipient,
              "[ProjectPier] - Activity Report - ".gmdate('Y/m/d', $time),
              $emailBody.$footer,
              'text/html'
            ); // send
            $emailBody = '';
          } catch (Exception $e) { echo $e; }
        }
      }
      }
    }
  }
?>