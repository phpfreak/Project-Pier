<?php

  /**
  * Project controller
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class ProjectController extends ApplicationController {
    
    /**
    * Prepare this controller
    *
    * @param void
    * @return ProjectController
    */
    function __construct() {
      parent::__construct();
      prepare_company_website_controller($this, 'project_website');
    } // __construct
    
    /**
    * Call overview action
    *
    * @param void
    * @return null
    */
    function index() {
      $this->forward('overview');
    } // index
    
    /**
    * Show project overview
    *
    * @param void
    * @return null
    */
    function overview() {
      if (active_project() == null || !logged_user()->isProjectUser(active_project())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard', 'index');
      } // if
      
      $this->addHelper('textile');
      
      $project = active_project();
      
      $this->setLayout('project_website');
      tpl_assign('project_log_entries', $project->getProjectLog(
        config_option('project_logs_per_page', 20)
      ));
      tpl_assign('late_milestones', $project->getLateMilestones());
      tpl_assign('today_milestones', $project->getTodayMilestones());
      tpl_assign('upcoming_milestones', $project->getUpcomingMilestones());
      
      // Sidebar
      tpl_assign('visible_forms', $project->getVisibleForms(true));
      tpl_assign('project_companies', $project->getCompanies());
      tpl_assign('important_messages', active_project()->getImportantMessages());
      tpl_assign('important_files', active_project()->getImportantFiles());
      
      $this->setSidebar(get_template_path('overview_sidebar', 'project'));
    } // overview
    
    /**
    * Execute search
    *
    * @param void
    * @return null
    */
    function search() {
      if (!logged_user()->isProjectUser(active_project())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard');
      } // if

      $search_for = array_var($_GET, 'search_for');
      $page = (integer) array_var($_GET, 'page', 1);
      if ($page < 1) {
        $page = 1;
      }
      
      if (trim($search_for) == '') {
        $search_results = null;
        $pagination = null;
      } else {
        list($search_results, $pagination) = SearchableObjects::searchPaginated($search_for, active_project(), logged_user()->isMemberOfOwnerCompany(), 10, $page);
      } // if
      
      tpl_assign('search_string', $search_for);
      tpl_assign('current_page', $page);
      tpl_assign('search_results', $search_results);
      tpl_assign('pagination', $pagination);

      $tag_names = plugin_active('tags') ? active_project()->getTagNames() : '';
      tpl_assign('tag_names', $tag_names);
      $this->setSidebar(get_template_path('search_sidebar', 'project'));
    } // search
    
    /**
    * Show tags page
    *
    * @param void
    * @return null
    */
    function tags() {
      if (!logged_user()->isProjectUser(active_project())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard', 'index');
      } // if
      
      tpl_assign('tag_names', active_project()->getTagNames());
    } // tags
    
    /**
    * List all companies and users involved in this project
    *
    * @param void
    * @return null
    */
    function people() {
      if (!logged_user()->isProjectUser(active_project())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard', 'index');
      } // if
      
      tpl_assign('project_companies', active_project()->getCompanies());
    } // people
    
    /**
    * Show permission update form
    *
    * @param void
    * @return null
    */
    function permissions() {
      $project = active_project();
      if (!$project->canChangePermissions(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToUrl($project->getOverviewUrl());
      } // if
      
      tpl_assign('project_users', $project->getUsers(false));
      tpl_assign('project_companies', $project->getCompanies());
      tpl_assign('user_projects', logged_user()->getProjects());
      
      $permissions = PermissionManager::getPermissionsText();
      tpl_assign('permissions', $permissions);
      
      $companies = array(owner_company());
      $clients = owner_company()->getClientCompanies();
      if (is_array($clients)) {
        $companies = array_merge($companies, $clients);
      } // if
      tpl_assign('companies', $companies);
      
      if (array_var($_POST, 'process') == 'process') {
        try {
          DB::beginWork();
          
          $project->clearCompanies();
          $project->clearUsers();
          
          $companies = array(owner_company());
          $client_companies = owner_company()->getClientCompanies();
          if (is_array($client_companies)) {
            $companies = array_merge($companies, $client_companies);
          } // if
          
          foreach ($companies as $company) {
            trace(__FILE__,"permissions(): processing company {$company->getId()}");
            // Company is selected!
            if (array_var($_POST, 'project_company_' . $company->getId()) == 'checked') {
              
              $is_owner_company = $company->isOwner();
  
              // Owner company is automatically included so it does not need to be in project_companies table
              if (!$is_owner_company) {
                $project_company = new ProjectCompany();
                $project_company->setProjectId(active_project()->getId());
                $project_company->setCompanyId($company->getId());
                $project_company->save();
              } // if
              
              $users = $company->getUsers();
              if (is_array($users)) {
                $counter = 0;
                foreach ($users as $user) {
                  trace(__FILE__,"permissions(): processing user {$user->getId()} in company {$company->getId()}");
                  $user_id = $user->getId();
                  $counter++;
                  if (array_var($_POST, "project_user_$user_id") == 'checked') {
                    
                    $project_user = new ProjectUser();
                    $project_user->setProjectId($project->getId());
                    $project_user->setUserId($user_id);
                    $project_user->save();
                    
                    foreach ($permissions as $permission_name => $permission_text) {
                      
                      // Owner company members have all permissions
                      $permission_value = $is_owner_company ? true : array_var($_POST, 'project_user_' . $user_id . '_' . $permission_name) == 'checked';

                      //$user = Users::findById($project_user->getUserId());
                      trace(__FILE__,"permissions(): processing permission $permission_name=$permission_value for user {$user->getId()} in company {$company->getId()}");
                      $user->setProjectPermission($project,$permission_name,$permission_value);
                    } // if
                   
                  } // if
                  
                } // foreach
              } // if
            } // if
          } // foreach
          
          DB::commit();
          
          flash_success(lang('success update project permissions'));
          $this->redirectTo('project', 'overview');
        } catch(Exception $e) {
          DB::rollback();
          flash_error(lang('error update project permissions', $e->__toString() ));
          $this->redirectTo('project', 'permissions');
        } // try
      } // if
    } // permissions
  
    /**
    * Add project
    *
    * @param void
    * @return null
    */
    function add() {
      $this->setTemplate('add_project');
      $this->setLayout('administration');
      
      if (!logged_user()->canManageProjects()) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('dashboard'));
      } // if
      
      $project = new Project();
      
      $project_data = array_var($_POST, 'project');
      tpl_assign('project', $project);
      tpl_assign('project_data', $project_data);
      
      // Submitted...
      if (is_array($project_data)) {
        $project->setFromAttributes($project_data);
        
        $default_folders = array();
        if (plugin_active('files')) {
          $default_folders_config = str_replace(array("\r\n", "\r"), array("\n", "\n"), config_option('default_project_folders', ''));
          if (trim($default_folders_config) == '') {
            $default_folders = array();
          } else {
            $default_folders = explode("\n", $default_folders_config);
          } // if
        } // if

        $default_ticket_categories = array();
        if (plugin_active('tickets')) {
          $default_ticket_categories_config = str_replace(array("\r\n", "\r"), array("\n", "\n"), config_option('tickets_default_categories', ''));
          if (trim($default_ticket_categories_config) == '') {
            $default_ticket_categories = array();
          } else {
            $default_ticket_categories = explode("\n", $default_ticket_categories_config);
          } // if
        } // if
        
        try {
          DB::beginWork();
          $project->save();
          
          $permissions = array_keys(PermissionManager::getPermissionsText());
          $auto_assign_users = owner_company()->getAutoAssignUsers();
          
          // We are getting the list of auto assign users. If current user is not in the list
          // add it. He's creating the project after all...
          if (is_array($auto_assign_users)) {
            $auto_assign_logged_user = false;
            foreach ($auto_assign_users as $user) {
              if ($user->getId() == logged_user()->getId()) {
                $auto_assign_logged_user = true;
              }
            } // if
            if (!$auto_assign_logged_user) {
              $auto_assign_users[] = logged_user();
            }
          } else {
            $auto_assign_users[] = logged_user();
          } // if
          
          foreach ($auto_assign_users as $auto_assign_user) {
            $project_user = new ProjectUser();
            $project_user->setProjectId($project->getId());
            $project_user->setUserId($auto_assign_user->getId());
            $project_user->save();
            if (is_array($permissions)) {
              foreach ($permissions as $permission) {
                $auto_assign_user->setProjectPermission($project,$permission,true);
              }
            } // if
          } // foreach
          
          if (count($default_folders)) {
            $added_folders = array();
            foreach ($default_folders as $default_folder) {
              $folder_name = trim($default_folder);
              if ($folder_name == '') {
                continue;
              } // if
              
              if (in_array($folder_name, $added_folders)) {
                continue;
              } // if
              
              $folder = new ProjectFolder();
              $folder->setProjectId($project->getId());
              $folder->setName($folder_name);
              $folder->save();
              
              $added_folders[] = $folder_name;
            } // foreach
          } // if
          
          if (count($default_ticket_categories)) {
            $added_categories = array();
            foreach ($default_ticket_categories as $default_ticket_category) {
              $category_name = trim($default_ticket_category);
              if ($category_name == '') {
                continue;
              } // if
              
              if (in_array($category_name, $added_categories)) {
                continue;
              } // if
              
              $folder = new ProjectCategory();
              $folder->setProjectId($project->getId());
              $folder->setName($category_name);
              $folder->save();
              
              $added_categories[] = $category_name;
            } // foreach
          } // if

          ApplicationLogs::createLog($project, null, ApplicationLogs::ACTION_ADD, false, true);
          DB::commit();
          
          flash_success(lang('success add project', $project->getName()));
          $this->redirectToUrl($project->getPermissionsUrl());
          
        } catch(Exception $e) {
          tpl_assign('error', $e);
          DB::rollback();
        } // try
        
      } // if
      
    } // add
    
    /**
    * Copy project
    *
    * @param void
    * @return null
    */
    function copy() {
      trace(__FILE__,"copy():begin");   
      if (!Project::canAdd(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('dashboard'));
      } // if
      
      $this->setTemplate('copy_project');
      $this->setLayout('administration');
      
      $project_data = array_var($_POST, 'project');
      tpl_assign('project_data', $project_data);
      
      // Submitted...
      if (is_array($project_data)) {
        $source = Projects::findById($project_data['source']);
        if (!($source instanceof Project)) {
          flash_error(lang('project dnx'));
          $this->redirectTo('administration', 'projects');
        } // if
        try {
          $shift_dates = (isset($project_data['shift_dates'])) ? ($project_data['shift_dates']=='checked') : false;
          $copy_details = (isset($project_data['copy_details'])) ? ($project_data['copy_details']=='checked') : false;
          $copy_tasks = (isset($project_data['copy_tasks'])) ? ($project_data['copy_tasks']=='checked') : false;
          $copy_milestones = (isset($project_data['copy_milestones'])) ? ($project_data['copy_milestones']=='checked') : false;
          $copy_messages = (isset($project_data['copy_messages'])) ? ($project_data['copy_messages']=='checked') : false;
          $copy_links = (isset($project_data['copy_links'])) ? ($project_data['copy_links']=='checked') : false;
          $copy_files = (isset($project_data['copy_files'])) ? ($project_data['copy_files']=='checked') : false;
          $copy_users = (isset($project_data['copy_users'])) ? ($project_data['copy_users']=='checked') : false;
          $copy_pages = (isset($project_data['copy_pages'])) ? ($project_data['copy_pages']=='checked') : false;

          DB::beginWork();

          $project = new Project();
          $new_name = lang( 'projects copy new name', $source->getName() );
          $new_name .= date(' z H:i:s');
          $project->setName($new_name);
          if ($copy_details) {
             $project->setDescription( $source->getDescription() );
             $project->setPriority( $source->getPriority() );
             $project->setShowDescriptionInOverview( $source->getShowDescriptionInOverview() );
          }
          $project->save();
          $project_id = $project->getId();

          $add_seconds = 0;
          if (isset($project_data['add_days'])) { 
             $add_days = 0 + trim( $project_data['add_days'] );
             $add_seconds = $add_days * 24 * 60 * 60;
          }

          $source_created_on = $source->getCreatedOn();
          //var_dump($source_created_on);
          $milestone_map = array( 0 => 0 );

          // project milestones
          if ($copy_milestones) {
            $source_milestones = $source->getAllMilestones();
            if (is_array($source_milestones)) {
              foreach ($source_milestones as $source_milestone) {
                $milestone = new ProjectMilestone();
                //$milestone->copy($source_milestone);
                $milestone->setName($source_milestone->getName());
                $milestone->setDescription($source_milestone->getDescription());
                if ($shift_dates) {
                  trace(__FILE__,"copy():shift dates");   
                  $milestone->setDueDate(DateTimeValueLib::now());
                  $seconds = $source_milestone->getDueDate()->difference($source_created_on);
                  $milestone->getDueDate()->advance($seconds);
                } else {
                  $milestone->setDueDate($source_milestone->getDueDate());
                }
                $milestone->getDueDate()->advance($add_seconds);
                $milestone->setIsPrivate($source_milestone->getIsPrivate());
                $milestone->setAssignedToUserId($source_milestone->getAssignedToUserId());
                $milestone->setAssignedToCompanyId($source_milestone->getAssignedToCompanyId());
                $milestone->setProjectId($project_id);
                $milestone->save();
                $milestone_map[$source_milestone->getId()]=$milestone->getId();
              } // foreach
            } // if
          } // if

          // project tasks
          if ($copy_tasks) {
            $source_task_lists = $source->getAllTaskLists();
            if (is_array($source_task_lists)) {
              foreach ($source_task_lists as $source_task_list) {
                $task_list = new ProjectTaskList();
                //$task_list->copy($source_milestone);
                $task_list->setName($source_task_list->getName());
                $task_list->setPriority($source_task_list->getPriority());
                $task_list->setDescription($source_task_list->getDescription());
                if ($copy_milestones) {
                  $task_list->setMilestoneId($milestone_map[$source_task_list->getMilestoneId()]);
                }
                $task_list->setDueDate($source_task_list->getDueDate());
                if ($task_list->getDueDate() instanceof DateTimeValue) {
                  if ($shift_dates) {
                    trace(__FILE__,"copy():task list shift dates");   
                    $task_list->setDueDate(DateTimeValueLib::now());
                    $seconds = $source_task_list->getDueDate()->difference($source_created_on);
                    $task_list->getDueDate()->advance($seconds);
                  }
                  $task_list->getDueDate()->advance($add_seconds);
                }
                $task_list->setIsPrivate($source_task_list->getIsPrivate());
                $task_list->setOrder($source_task_list->getOrder());
                $task_list->setProjectId($project_id);
                $task_list->save();
                $source_tasks = $source_task_list->getTasks();
                if (is_array($source_tasks)) {
                  foreach($source_tasks as $source_task) {
                    $task = new ProjectTask();
                    $task->setOrder($source_task->getOrder());
                    $task->setDueDate($source_task->getDueDate());
                    if ($task->getDueDate() instanceof DateTimeValue) {
                      if ($shift_dates) {
                        trace(__FILE__,"copy():task shift dates");   
                        $task->setDueDate(DateTimeValueLib::now());
                        $seconds = $source_task->getDueDate()->difference($source_created_on);
                        $task->getDueDate()->advance($seconds);
                      }
                      $task->getDueDate()->advance($add_seconds);
                    }
                    $task->setText($source_task->getText());
                    $task->getAssignedToUserId($source_task->getAssignedToUserId());
                    $task->getAssignedToCompanyId($source_task->getAssignedToCompanyId());
                    $task_list->attachTask($task);
                  }
                }
              } // foreach
            } // if
          } // if

          // project messages
          if ($copy_messages) {
            $source_messages= $source->getAllMessages();
            if (is_array($source_messages)) {
              foreach ($source_messages as $source_message) {
                $message = new ProjectMessage();
                //$message->copy($source_message);
                $message->setTitle($source_message->getTitle());
                $message->setText($source_message->getText());
                $message->setAdditionalText($source_message->getAdditionalText());
                if ($copy_milestones) {
                  $message->setMilestoneId($milestone_map[$source_message->getMilestoneId()]);
                }
                $message->setIsImportant($source_message->getIsImportant());
                $message->setIsPrivate($source_message->getIsPrivate());
                $message->setCommentsEnabled($source_message->getCommentsEnabled());
                $message->setAnonymousCommentsEnabled($source_message->getAnonymousCommentsEnabled());
                $message->setProjectId($project_id);
                $message->save();
              } // foreach
            } // if
          } // if

          // project links
          if ($copy_links) {
            $source_links = ProjectLinks::getAllProjectLinks($source);
            if (is_array($source_links)) {
              foreach ($source_links as $source_link) {
                $link = new ProjectLink();
                //$folder->copy($source_link);
                $link->setTitle($source_link->getTitle());
                $link->setUrl($source_link->getUrl());
                $link->setProjectId($project_id);
                $link->save();
              } // foreach
            } // if
          } // if

          // project folders & files  
          if ($copy_files) {
            $folder_map = array( 0 => 0 );
            $source_folders = $source->getFolders();
            if (is_array($source_folders)) {
              foreach ($source_folders as $source_folder) {
                $folder = new ProjectFolder();
                //$folder->copy($source_folder);
                $folder->setName($source_folder->getName());
                $folder->setProjectId($project_id);
                $folder->save();
                $folder_map[$source_folder->getId()]=$folder->getId();
              } // foreach
            } // if
            $source_files = ProjectFiles::getAllFilesByProject($source);
            if (is_array($source_files)) {
              foreach ($source_files as $source_file) {
                $file = new ProjectFile();
                $file->setProjectId($project_id);
                $file->setFolderId($folder_map[$source_file->getFolderId()]);
                $file->setFileName($source_file->getFileName());
                $file->setDescription($source_file->getDescription());
                $file->setIsPrivate($source_file->getIsPrivate());
                $file->setIsImportant($source_file->getIsImportant());
                $file->setIsLocked($source_file->getIsLocked());
                $file->setIsVisible($source_file->getIsVisible());
                $file->setExpirationTime($source_file->getExpirationTime());
                $file->setCommentsEnabled($source_file->getCommentsEnabled());
                $file->setAnonymousCommentsEnabled($source_file->getAnonymousCommentsEnabled());
                $file->save();
                $source_revision = $source_file->getLastRevision();
                if ($source_revision instanceof ProjectFileRevision) {
                  $revision = new ProjectFileRevision();
                  $revision->setFileId($file->getId());
                  $revision->setRevisionNumber($source_revision->getRevisionNumber());
                  $revision->setRepositoryId($source_revision->getRepositoryId());
                  $revision->setFilesize($source_revision->getFilesize());
                  $revision->setFilename($source_revision->getFileName());
                  $revision->setTypeString($source_revision->getTypeString());
                  $revision->setThumbFilename($source_revision->getThumbFilename());
                  $revision->setFileTypeId($source_revision->getFileTypeId());
                  $revision->setComment($source_revision->getComment());
                  $revision->save();
                }
              } // foreach
            } // if
          } // if
          if ($copy_pages) {
            $source_pages = Wiki::getAllProjectPages($source);
            if (is_array($source_pages)) {
              foreach ($source_pages as $source_page) {
                $page = new WikiPage();
		$page->setProjectId($project_id);
		$page->setProjectIndex($source_page->getProjectIndex());
		$page->setProjectSidebar($source_page->getProjectSidebar());
                if (plugin_active('tags')) {
                  //$page->setTags($source_page->getTagNames());
		}
	
		//Make a new revision of this page
		$revision = $page->makeRevision();

                $source_revision = $source_page->getLatestRevision();
			
		//Set attributes
                $revision->setName($source_revision->getName());
                $revision->setContent($source_revision->getContent());
                $revision->setLogMessage($source_revision->getLogMessage());
		//Save the page
                $page->save();
              } // foreach
            } // if
          } // if
          
          if ($copy_users) {

            $source_companies = ProjectCompanies ::instance()->getCompaniesByProject($source);
            if (is_array($source_companies)) {
              foreach ($source_companies as $source_company) {
                $project_company = new ProjectCompany();
                $project_company->setCompanyId($source_company->getId());
                $project_company->setProjectId($project_id);
                $project_company->save();
              } // foreach
            }

            $source_users = ProjectUsers::instance()->getUsersByProject($source);
            if (is_array($source_users)) {
              foreach ($source_users as $source_user) {
                $project_user = new ProjectUser();
                $project_user->setUserId($source_user->getId());
                $project_user->setProjectId($project_id);
                $project_user->save();
              } // foreach
            }

          }
/*
          $permissions = array_keys(PermissionManager::getPermissionsText());
          $auto_assign_users = owner_company()->getAutoAssignUsers();
          
          // We are getting the list of auto assign users. If current user is not in the list
          // add it. He's creating the project after all...
          if (is_array($auto_assign_users)) {
            $auto_assign_logged_user = false;
            foreach ($auto_assign_users as $user) {
              if ($user->getId() == logged_user()->getId()) {
                $auto_assign_logged_user = true;
              }
            } // if
            if (!$auto_assign_logged_user) {
              $auto_assign_users[] = logged_user();
            }
          } else {
            $auto_assign_users[] = logged_user();
          } // if
          
          foreach ($auto_assign_users as $user) {
            $project_user = new ProjectUser();
            $project_user->setProjectId($project->getId());
            $project_user->setUserId($user->getId());
            if (is_array($permissions)) {
              foreach ($permissions as $permission) {
                $user = Users::findById($project_user->getUserId());
                $user->setProjectPermission($project,$permission,true);
              }
            } // if
            $project_user->save();
          } // foreach
*/
          ApplicationLogs::createLog($project, null, ApplicationLogs::ACTION_ADD, false, true);
          DB::commit();
          
          flash_success(lang('success copy project', $source->getName(), $project->getName()));
          $this->redirectToUrl($project->getPermissionsUrl());
          
        } catch(Exception $e) {
          echo $e->getMessage();
          tpl_assign('error', $e);
          DB::rollback();
        } // try
      
      } // if (submitted)
      
    } // copy 

    /**
    * Download project task lists
    *
    * @param void
    * @return null
    */
    function download_task_lists() {
      if (!logged_user()->isProjectUser(active_project())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard', 'index');
      } // if
      $project = active_project();
      $task_lists = $project->getTaskLists();
      $project_name = $project->getName();
      if (is_array($task_lists)) {
        $name = $project_name.'_tasks.txt';
        $content = '';
        $header = true;
        $count = 0;
        foreach ($task_lists as $task_list) {
          $content .= $task_list->getDownloadText($count, "\t", $header);
          $header = false;
        }
        flash_success(lang('%s items downloaded', $count));
        download_contents($content, 'text/csv', $name, strlen($content));
      } else {
        flash_error(lang('nothing to download', $project_name));
      }
      $this->redirectTo('project', 'index');
    }

    /**
    * Edit project
    *
    * @param void
    * @return null
    */
    function edit() {
      $project = Projects::findById(get_id());
      if (!($project instanceof Project)) {
        flash_error(lang('project dnx'));
        $this->redirectTo('dashboard', 'index');
      } // if
      
      if (!$project->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('dashboard', 'index'));
      } // if

      $this->setTemplate('add_project');
      $this->setLayout('administration');
      
      $project_data = array_var($_POST, 'project');
      if (!is_array($project_data)) {
        $project_data = array(
          'name' => $project->getName(),
          'priority' => $project->getPriority(),
          'description' => $project->getDescription(),
          'show_description_in_overview' => $project->getShowDescriptionInOverview()
        ); // array
      } // if
      
      tpl_assign('project', $project);
      tpl_assign('project_data', $project_data);
      
      if (is_array(array_var($_POST, 'project'))) {
        $project->setFromAttributes($project_data);
        
        try {
          DB::beginWork();
          $project->save();
          ApplicationLogs::createLog($project, null, ApplicationLogs::ACTION_EDIT, false, true);
          DB::commit();
          
          flash_success(lang('success edit project', $project->getName()));
          $this->redirectToUrl($project->getOverviewUrl());
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      } // if
    } // edit

    /**
    * Show and process edit project logo form
    *
    * @param void
    * @return null
    */
    function edit_logo() {
      $project = Projects::findById(get_id());
      if (!($project instanceof Project)) {
        flash_error(lang('project dnx'));
        $this->redirectToReferer(get_url('dashboard'));
      } // if

      if (!$project->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('dashboard'));
      } // if

      $this->setTemplate('edit_logo');
      $this->setLayout('administration');
      
      tpl_assign('project', $project);
      
      $logo = array_var($_FILES, 'new_logo');
      if (is_array($logo)) {
        try {
          if (!isset($logo['name']) || !isset($logo['type']) || !isset($logo['size']) || !isset($logo['tmp_name']) || !is_readable($logo['tmp_name'])) {
            throw new InvalidUploadError($logo, lang('error upload file'));
          } // if
          
          $valid_types = array('image/jpg', 'image/jpeg', 'image/pjpeg', 'image/gif', 'image/png');
          $max_width   = config_option('max_logo_width', 50);
          $max_height  = config_option('max_logo_height', 50);
          
          if (!in_array($logo['type'], $valid_types) || !($image = getimagesize($logo['tmp_name']))) {
            throw new InvalidUploadError($logo, lang('invalid upload type', 'JPG, GIF, PNG'));
          } // if
          
          $old_file = $project->getLogoPath();
          
          DB::beginWork();
          
          if (!$project->setLogo($logo['tmp_name'], $max_width, $max_height, true)) {
            DB::rollback();
            flash_error(lang('error edit project logo'));
            $this->redirectToUrl($project->getEditLogoUrl());
          } // if
          
          ApplicationLogs::createLog($project, null, ApplicationLogs::ACTION_EDIT);
          
          flash_success(lang('success edit project logo'));
          DB::commit();
          
          if (is_file($old_file)) {
            @unlink($old_file);
          } // uf
          
        } catch(Exception $e) {
          flash_error(lang('error edit project logo'));
          DB::rollback();
        } // try
        
        $this->redirectToUrl($project->getEditLogoUrl());
      } // if
    } // edit_logo
    
    /**
    * Delete company logo
    *
    * @param void
    * @return null
    */
    function delete_logo() {
      if (!logged_user()->isAdministrator(owner_company())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard');
      } // if
      
      $project = Projects::findById(get_id());
      if (!($project instanceof Project)) {
        flash_error(lang('project dnx'));
        $this->redirectToReferer(get_url('dashboard', 'projects'));
      } // if
      
      try {
        DB::beginWork();
        $project->deleteLogo();
        $project->save();
        ApplicationLogs::createLog($project, null, ApplicationLogs::ACTION_EDIT);
        DB::commit();
        
        flash_success(lang('success delete project logo'));
      } catch(Exception $e) {
        DB::rollback();
        flash_error(lang('error delete project logo'));
      } // try
      
      $this->redirectToUrl($project->getEditLogoUrl());
    } // delete_logo
    
    /**
    * Delete project
    *
    * @param void
    * @return null
    */
    function delete() {
      $this->setTemplate('del_project');
      $this->setLayout('administration');

      $project = Projects::findById(get_id());
      if (!($project instanceof Project)) {
        flash_error(lang('project dnx'));
        $this->redirectTo('administration', 'projects');
      } // if
      
      if (!$project->canDelete(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('administration', 'projects'));
      } // if

      $delete_data = array_var($_POST, 'deleteProject');
      tpl_assign('project', $project);
      tpl_assign('delete_data', $delete_data);

      if (!is_array($delete_data)) {
        $delete_data = array(
          'really' => 0,
          'password' => '',
          ); // array
        tpl_assign('delete_data', $delete_data);
      } else if ($delete_data['really'] == 1) {
        $password = $delete_data['password'];
        if (trim($password) == '') {
          tpl_assign('error', new Error(lang('password value missing')));
          $this->render();
        }
        if (!logged_user()->isValidPassword($password)) {
          tpl_assign('error', new Error(lang('invalid login data')));
          $this->render();
        } // if
        try {

          DB::beginWork();
          $project->delete();
          CompanyWebsite::instance()->setProject(null);
          ApplicationLogs::createLog($project, null, ApplicationLogs::ACTION_DELETE);
          DB::commit();

          flash_success(lang('success delete project', $project->getName()));

        } catch(Exception $e) {
          DB::rollback();
          flash_error(lang('error delete project'));
        } // try

        $this->redirectTo('administration', 'projects');
      } else {
        flash_error(lang('error delete project'));
        $this->redirectTo('administration', 'projects');
      }
    } // delete
    
    /**
    * Complete this project
    *
    * @param void
    * @return null
    */
    function complete() {
      
      $project = Projects::findById(get_id());
      if (!($project instanceof Project)) {
        flash_error(lang('project dnx'));
        $this->redirectTo('administration', 'projects');
      } // if
      
      if (!$project->canChangeStatus(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('administration', 'projects'));
      } // if
      
      try {
        
        $project->setCompletedOn(DateTimeValueLib::now());
        $project->setCompletedById(logged_user()->getId());
        
        DB::beginWork();
        $project->save();
        ApplicationLogs::createLog($project, null, ApplicationLogs::ACTION_CLOSE);
        DB::commit();
        
        flash_success(lang('success complete project', $project->getName()));
        
      } catch(Exception $e) {
        DB::rollback();
        flash_error(lang('error complete project'));
      } // try
      
      $this->redirectToReferer(get_url('administration', 'projects'));
    } // complete
    
    /**
    * Reopen project
    *
    * @param void
    * @return null
    */
    function open() {
      $project = Projects::findById(get_id());
      if (!($project instanceof Project)) {
        flash_error(lang('project dnx'));
        $this->redirectTo('administration', 'projects');
      } // if
      
      if (!$project->canChangeStatus(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('administration', 'projects'));
      } // if
      
      try {
        
        $project->setCompletedOn(null);
        $project->setCompletedById(0);
        
        DB::beginWork();
        $project->save();
        ApplicationLogs::createLog($project, null, ApplicationLogs::ACTION_OPEN);
        DB::commit();
        
        flash_success(lang('success open project', $project->getName()));
        
      } catch(Exception $e) {
        DB::rollback();
        flash_error(lang('error open project'));
      } // try
      
      $this->redirectToReferer(get_url('administration', 'projects'));
    } // open
    
    /**
    * Remove user from project
    *
    * @param void
    * @return null
    */
    function remove_user() {
      if (!active_project()->canChangePermissions(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(active_project()->getOverviewUrl());
      } // if
      
      $user = Users::findById(get_id('user_id'));
      if (!($user instanceof User)) {
        flash_error(lang('user dnx'));
        $this->redirectTo('project', 'people');
      } // if
      
      if ($user->isAccountOwner()) {
        flash_error(lang('user cant be removed from project'));
        $this->redirectTo('project', 'people');
      } // if
      
      $project = Projects::findById(get_id('project_id'));
      if (!($project instanceof Project)) {
        flash_error(lang('project dnx'));
        $this->redirectTo('project', 'people');
      } // if
      
      $project_user = ProjectUsers::findById(array('project_id' => $project->getId(), 'user_id' => $user->getId()));
      if (!($project_user instanceof ProjectUser)) {
        flash_error(lang('user not on project'));
        $this->redirectTo('project', 'people');
      } // if
      
      try {
        $project_user->delete();
        flash_success(lang('success remove user from project'));
      } catch(Exception $e) {
        flash_error(lang('error remove user from project'));
      } // try
      
      $this->redirectTo('project', 'people');
    } // remove_user
    
    /**
    * Remove company from project
    *
    * @param void
    * @return null
    */
    function remove_company() {
      if (!active_project()->canChangePermissions(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(active_project()->getOverviewUrl());
      } // if
      
      $project = Projects::findById(get_id('project_id'));
      if (!($project instanceof Project)) {
        flash_error(lang('project dnx'));
        $this->redirectTo('project', 'people');
      } // if
      
      $company = Companies::findById(get_id('company_id'));
      if (!($company instanceof Company)) {
        flash_error(lang('company dnx'));
        $this->redirectTo('project', 'people');
      } // if
      
      $project_company = ProjectCompanies::findById(array('project_id' => $project->getId(), 'company_id' => $company->getId()));
      if (!($project_company instanceof ProjectCompany)) {
        flash_error(lang('company not on project'));
        $this->redirectTo('project', 'people');
      } // if
      
      try {
        
        DB::beginWork();
        $project_company->delete();
        $users = ProjectUsers::getCompanyUsersByProject($company, $project);
        if (is_array($users)) {
          foreach ($users as $user) {
            $project_user = ProjectUsers::findById(array('project_id' => $project->getId(), 'user_id' => $user->getId()));
            if ($project_user instanceof ProjectUser) {
              $project_user->delete();
            }
          } // foreach
        } // if
        DB::commit();
        
        flash_success(lang('success remove company from project'));
        
      } catch(Exception $e) {
        DB::rollback();
        flash_error(lang('error remove company from project'));
      } // try
      
      $this->redirectTo('project', 'people');
    } // remove_company
  
    /**
    * Show project time
    *
    * @access public
    * @param void
    * @return null
    */
    function time() {
      if (!logged_user()->isAdministrator(owner_company())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard');
      } // if

      $this->setLayout('dashboard');
      tpl_assign('projects', owner_company()->getProjects());
    } // time

  } // ProjectController

?>
