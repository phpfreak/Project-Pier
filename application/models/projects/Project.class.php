<?php

  /**
  * Project class
  *
  * @http://www.projectpier.org/
  */
  class Project extends BaseProject {

    // ---------------------------------------------------
    // Page Attachments
    // ---------------------------------------------------
    
    /** Cache of all page attachments
    *
    * @var array
    */
    private $all_page_attachments;

    /**
    * This object is taggable
    *
    * @var boolean
    */
    protected $is_taggable = true;
    
    // ---------------------------------------------------
    //  Projects
    // ---------------------------------------------------
    
    /**
    * Cache of all subprojects
    *
    * @var array
    */
    private $all_subprojects;
    
    /**
    * Cached array of subprojects that user can access. If user is member of owner company
    * $all_subprojects will be used (members of owner company can browse all subprojects)
    *
    * @var array
    */
    private $subprojects;
    
    // ---------------------------------------------------
    //  Messages
    // ---------------------------------------------------
    
    /**
    * Cache of all messages
    *
    * @var array
    */
    private $all_messages;
    
    /**
    * Cached array of messages that user can access. If user is member of owner company
    * $all_messages will be used (members of owner company can browse all messages)
    *
    * @var array
    */
    private $messages;
    
    /**
    * Array of all important messages (including private ones)
    *
    * @var array
    */
    private $all_important_messages;
    
    /**
    * Array of important messages. If user is not member of owner company private 
    * messages will be skipped
    *
    * @var array
    */
    private $important_messages;
    
    // ---------------------------------------------------
    //  Milestones
    // ---------------------------------------------------
    
    /**
    * Cached array of milestones. This is array of all project milestones. They are not 
    * filtered by is_private stamp
    *
    * @var array
    */
    private $all_milestones;
    
    /**
    * Cached array of project milestones
    *
    * @var array
    */
    private $milestones;
    
    /**
    * Array of all open milestones in this projects
    *
    * @var array
    */
    private $all_open_milestones;
    
    /**
    * Array of open milestones in this projects that user can access. If user is not member of owner
    * company private milestones will be hidden
    *
    * @var array
    */
    private $open_milestones;
    
    /**
    * Cached array of late milestones. This variable is populated by splitOpenMilestones() private 
    * function on request
    *
    * @var array
    */
    private $late_milestones = false;
    
    /**
    * Cached array of today milestones. This variable is populated by splitOpenMilestones() private 
    * function on request
    *
    * @var array
    */
    private $today_milestones = false;
    
    /**
    * Cached array of upcoming milestones. This variable is populated by splitOpenMilestones() private 
    * function on request
    *
    * @var array
    */
    private $upcoming_milestones = false;
    
    /**
    * Cached all completed milestones
    *
    * @var array
    */
    private $all_completed_milestones;
    
    /**
    * Cached array of completed milestones - is_private check is made before retrieving meaning that if
    * user is no member of owner company all private data will be hidden
    *
    * @var array
    */
    private $completed_milestones;
    
    // ---------------------------------------------------
    //  Task lists
    // ---------------------------------------------------
    
    /**
    * All task lists in this project
    *
    * @var array
    */
    private $all_task_lists;
    
    /**
    * Array of all task lists. If user is not member of owner company private task 
    * lists will be excluded from the list
    *
    * @var array
    */
    private $task_lists;
    
    /**
    * All open task lists in this project
    *
    * @var array
    */
    private $all_open_task_lists;
    
    /**
    * Array of open task lists. If user is not member of owner company private task 
    * lists will be excluded from the list
    *
    * @var array
    */
    private $open_task_lists;
    
    /**
    * Array of all completed task lists in this project
    *
    * @var array
    */
    private $all_completed_task_lists;
    
    /**
    * Array of completed task lists. If user is not member of owner company private task 
    * lists will be excluded from the list
    *
    * @var array
    */
    private $completed_task_lists;
    
    // ---------------------------------------------------
    //  Tickets
    // ---------------------------------------------------

    /**
    * All categories in this project
    *
    * @var array
    */
    private $categories;

    /**
    * All tickets in this project
    *
    * @var array
    */
    private $all_tickets;

    /**
    * Array of all tickets. If user is not member of owner company private tickets
    * will be excluded from the list
    *
    * @var array
    */
    private $tickets;

    /**
    * All open tickets in this project
    *
    * @var array
    */
    private $all_open_tickets;

    /**
    * Array of open tickets. If user is not member of owner company private tickets
    * will be excluded from the list
    *
    * @var array
    */
    private $open_tickets;

    /**
    * All closed tickets in this project
    *
    * @var array
    */
    private $all_closed_tickets;

    /**
    * Array of closed tickets. If user is not member of owner company private tickets
    * will be excluded from the list
    *
    * @var array
    */
    private $closed_tickets;

    // ---------------------------------------------------
    //  Tags
    // ---------------------------------------------------
    
    /**
    * Cached object tag names
    *
    * @var array
    */
    private $tag_names;
    
    // ---------------------------------------------------
    //  Log
    // ---------------------------------------------------
    
    /**
    * Cache of all project logs
    *
    * @var array
    */
    private $all_project_logs;
    
    /**
    * Cache of all project logs that current user can access
    *
    * @var array
    */
    private $project_logs;
    
    // ---------------------------------------------------
    //  Forms
    // ---------------------------------------------------
    
    /**
    * Cache of all project forms
    *
    * @var array
    */
    private $all_forms;
    
    // ---------------------------------------------------
    //  Files
    // ---------------------------------------------------
    
    /**
    * Cached array of project folders
    *
    * @var array
    */
    private $folders;
    
    /**
    * Cached array of all important files
    *
    * @var array
    */
    private $all_important_files;
    
    /**
    * Important files filtered by the users access permissions
    *
    * @var array
    */
    private $important_files;
    
    /**
    * All orphaned files, user permissions are not checked
    *
    * @var array
    */
    private $all_orphaned_files;
    
    /**
    * Orphaned file
    *
    * @var array
    */
    private $orphaned_files;

    /**
    * All times
    *
    * @var array
    */
    private $all_times;

    // ---------------------------------------------------
    //  Milestones
    // ---------------------------------------------------
    
    /**
    * Return parent project
    *
    * @access public
    * @param void
    * @return Project or NULL
    */
    function getParent() {
      return Projects::findById($this->getParentId());
    } // getTaskList

    /**
    * Return all milestones, don't filter them by is_private stamp based on users permissions
    *
    * @param void
    * @return array
    */
    function getAllSubprojects() {
      if (is_null($this->all_subprojects)) {
        $this->all_subprojects = Projects::findAll(array(
          'conditions' => array('`parent_id` = ?', $this->getId()),
          'order' => 'name'
        )); // findAll
      } // if
      return $this->all_subprojects;
    } // getAllSubprojects
    
    /**
    * Return subprojects
    *
    * @access public
    * @param void
    * @return array
    */
    function getSubprojects() {
      if (logged_user()->isMemberOfOwnerCompany()) {
        return $this->getAllSubprojects();
      }
      if (is_null($this->subprojects)) {
        $this->subprojects = Projects::findAll(array(
          // 'conditions' => array('`parent_id` = ? AND `is_private` = ?', $this->getId(), 0),
          'conditions' => array('`parent_id` = ?', $this->getId()),
          'order' => 'name'
        )); // findAll
      } // if
      return $this->subprojects;
    } // getSubprojects

    // ---------------------------------------------------
    // Page Attachments
    // ---------------------------------------------------
    
    /**
    * This function will return all page attachments in project
    *
    * @param void
    * @return array
    */
    function getAllPageAttachments() {
      if (is_null($this->all_page_attachments)) {
        $this->all_page_attachments = PageAttachments::getAllByProject($this);
      }
      return $this->all_page_attachments;
    } // getAllPageAttachments
    
    // ---------------------------------------------------
    //  Messages
    // ---------------------------------------------------
    
    /**
    * This function will return all messages in project and it will not exclude private 
    * messages if logged user is not member of owner company
    *
    * @param void
    * @return array
    */
    function getAllMessages() {
      if (is_null($this->all_messages)) {
        $this->all_messages = ProjectMessages::getProjectMessages($this, true);
      } // if
      return $this->all_messages;
    } // getAllMessages
    
    /**
    * Return only the messages that current user can see (if not member of owner company private 
    * messages will be excluded)
    *
    * @param null
    * @return null
    */
    function getMessages() {
      if (logged_user()->isMemberOfOwnerCompany()) {
        return $this->getAllMessages(); // members of owner company can view all messages
      } // if
      
      if (is_null($this->messages)) {
        $this->messages = ProjectMessages::getProjectMessages($this, false);
      } // if
      return $this->messages;
    } // getMessages
    
    /**
    * Return all important messages
    *
    * @param void
    * @return array
    */
    function getAllImportantMessages() {
      if (is_null($this->all_important_messages)) {
        $this->all_important_messages = ProjectMessages::getImportantProjectMessages($this, true);
      } // if
      return $this->all_important_messages;
    } // getAllImportantMessages
    
    /**
    * Return array of important messages
    *
    * @param void
    * @return array
    */
    function getImportantMessages() {
      if (logged_user()->isMemberOfOwnerCompany()) {
        return $this->getAllImportantMessages();
      } // if
      
      if (is_null($this->important_messages)) {
        $this->important_messages = ProjectMessages::getImportantProjectMessages($this, false);
      } // if
      return $this->important_messages;
    } // getImportantMessages
    
    // ---------------------------------------------------
    //  Milestones
    // ---------------------------------------------------
    
    /**
    * Return all milestones, don't filter them by is_private stamp based on users permissions
    *
    * @param void
    * @return array
    */
    function getAllMilestones() {
      if (is_null($this->all_milestones)) {
        $this->all_milestones = ProjectMilestones::findAll(array(
          'conditions' => array('`project_id` = ?', $this->getId()),
          'order' => 'due_date'
        )); // findAll
      } // if
      return $this->all_milestones;
    } // getAllMilestones
    
    /**
    * Return all project milestones
    *
    * @access public
    * @param void
    * @return array
    */
    function getMilestones() {
      if (logged_user()->isMemberOfOwnerCompany()) {
        return $this->getAllMilestones(); // member of owner company
      }
      if (is_null($this->milestones)) {
        $this->milestones = ProjectMilestones::findAll(array(
          'conditions' => array('`project_id` = ? AND `is_private` = ?', $this->getId(), 0),
          'order' => 'due_date'
        )); // findAll
      } // if
      return $this->milestones;
    } // getMilestones
    
    /**
    * Return all open milestones without is_private check
    *
    * @param void
    * @return array
    */
    function getAllOpenMilestones() {
      if (is_null($this->all_open_milestones)) {
        $this->all_open_milestones = ProjectMilestones::findAll(array(
          'conditions' => array('`project_id` = ? AND `completed_on` = ?', $this->getId(), EMPTY_DATETIME),
          'order' => 'due_date'
        )); // findAll
      } // if
      return $this->all_open_milestones;
    } // getAllOpenMilestones
    
    /**
    * Return open milestones
    *
    * @access public
    * @param void
    * @return array
    */
    function getOpenMilestones() {
      if (logged_user()->isMemberOfOwnerCompany()) {
        return $this->getAllOpenMilestones();
      }
      if (is_null($this->open_milestones)) {
        $this->open_milestones = ProjectMilestones::findAll(array(
          'conditions' => array('`project_id` = ? AND `completed_on` = ? AND `is_private` = ?', $this->getId(), EMPTY_DATETIME, 0),
          'order' => 'due_date'
        )); // findAll
      } // if
      return $this->open_milestones;
    } // getOpenMilestones
    
    /**
    * This function will return all completed milestones
    *
    * @param void
    * @return array
    */
    function getAllCompletedMilestones() {
      if (is_null($this->all_completed_milestones)) {
        $this->all_completed_milestones = ProjectMilestones::findAll(array(
          'conditions' => array('`project_id` = ? AND `completed_on` > ?', $this->getId(), EMPTY_DATETIME),
          'order' => 'due_date'
        )); // findAll
      } // if
      return $this->all_completed_milestones;
    } // getAllCompletedMilestones
    
    /**
    * Return completed milestones
    *
    * @access public
    * @param void
    * @return array
    */
    function getCompletedMilestones() {
      if (logged_user()->isMemberOfOwnerCompany()) {
        return $this->getAllCompletedMilestones();
      }
      if (is_null($this->completed_milestones)) {
        $this->completed_milestones = ProjectMilestones::findAll(array(
          'conditions' => array('`project_id` = ? AND `completed_on` > ? AND `is_private` = ?', $this->getId(), EMPTY_DATETIME, 0),
          'order' => 'due_date'
        )); // findAll
      } // if
      return $this->completed_milestones;
    } // getCompletedMilestones
    
    /**
    * Return array of late open milestones
    *
    * @param void
    * @return array
    */
    function getLateMilestones() {
      if ($this->late_milestones === false) {
        $this->splitOpenMilestones();
      }
      return $this->late_milestones;
    } // getLateMilestones
    
    /**
    * Return array of today open milestones
    *
    * @param void
    * @return array
    */
    function getTodayMilestones() {
      if ($this->today_milestones === false) {
        $this->splitOpenMilestones();
      }
      return $this->today_milestones;
    } // getTodayMilestones
    
    /**
    * Return array of upcoming open milestones
    *
    * @param void
    * @return array
    */
    function getUpcomingMilestones() {
      if ($this->upcoming_milestones === false) {
        $this->splitOpenMilestones();
      }
      return $this->upcoming_milestones;
    } // getUpcomingMilestones
    
    /**
    * This function will walk through open milestones array and splid them into late, today and upcomming
    *
    * @param void
    * @return array
    */
    private function splitOpenMilestones() {
      $open_milestones = $this->getOpenMilestones();
      
      // Reset from false
      $this->late_milestones = null;
      $this->today_milestones = null;
      $this->upcoming_milestones = null;
      
      if (is_array($open_milestones)) {
        foreach ($open_milestones as $open_milestone) {
          if ($open_milestone->isLate()) {
            if (!is_array($this->late_milestones)) {
              $this->late_milestones = array();
            }
            $this->late_milestones[] = $open_milestone;
          } elseif ($open_milestone->isToday()) {
            if (!is_array($this->today_milestones)) {
              $this->today_milestones = array();
            }
            $this->today_milestones[] = $open_milestone;
          } else {
            if (!is_array($this->upcoming_milestones)) {
              $this->upcoming_milestones = array();
            }
            $this->upcoming_milestones[] = $open_milestone;
          } // if
        } // foreach
      } // if
    } // splitOpenMilestones
    
    /**
    * Return array of milestones for the month specified that the user has
    * access to.
    *
    * @access public
    * @param int $year
    * @param int $month
    * @return array
    */
    function getMilestonesByMonth($year, $month) {
      $from_date = DateTimeValueLib::make(0, 0, 0, $month, 1, $year);
      $to_date = new DateTimeValue(strtotime('+1 month -1 day', $from_date->getTimestamp()));

      if (logged_user()->isMemberOfOwnerCompany()) {
        $conditions = array('`project_id` = ? AND (`due_date` >= ? AND `due_date` < ?)', $this->getId(), $from_date, $to_date);
      } else {
        $conditions = array('`project_id` = ? AND (`due_date` >= ? AND `due_date` < ?) AND `is_private` = ?', $this->getId(), $from_date, $to_date, 0);
      }
      return ProjectMilestones::findAll(array(
        'conditions' => $conditions,
        'order' => 'due_date'
      )); // findAll
    } // getMilestonesByMonth

    // ---------------------------------------------------
    //  Time
    // ---------------------------------------------------
  
    /**
    * Return all times, don't filter them by is_private stamp based on users permissions
    *
    * @param void
    * @return array
    */
    function getAllTimes() {
      if (!plugin_active('times')) return null;
      if(is_null($this->all_times)) {
        $this->all_times = ProjectTimes::findAll(array(
          'conditions' => array('`project_id` = ?', $this->getId()),
          'order' => 'done_date desc'
        )); // findAll
      } // if
      return $this->all_times;
    } // getAllTimes

    /**
    * Return all project time
    *
    * @access public
    * @param void
    * @return array
    */
    function getTimes() {
      if (!plugin_active('times')) return null;
      if(logged_user()->isMemberOfOwnerCompany()) return $this->getAllTimes(); // member of owner company
      if(is_null($this->times)) {
        $this->times = ProjectTimes::findAll(array(
          'conditions' => array('`project_id` = ? AND `is_private` = ?', $this->getId(), 0),
          'order' => 'done_date desc'
        )); // findAll
      } // if
      return $this->times;
    } // getTimes

    // ---------------------------------------------------
    //  Task lists
    // ---------------------------------------------------
    
    /**
    * Return all task lists
    *
    * @param void
    * @return array
    */
    function getAllTaskLists() {
      if (is_null($this->all_task_lists)) {
        $this->all_task_lists = ProjectTaskLists::findAll(array(
          'conditions' => array('`project_id` = ?', $this->getId()),
          'order' => '`order`'
        )); // findAll
      } // if
      return $this->all_task_lists;
    } // getAllTaskLists
    
    /**
    * Return all task lists
    *
    * @access public
    * @param void
    * @return array
    */
    function getTaskLists() {
      if (logged_user()->isMemberOfOwnerCompany()) {
        return $this->getAllTaskLists();
      }
      if (is_null($this->task_lists)) {
        $this->task_lists = ProjectTaskLists::findAll(array(
          'conditions' => array('`project_id` = ? AND `is_private` = ?', $this->getId(), 0),
          'order' => '`order`'
        )); // findAll
      } // if
      return $this->task_lists;
    } // getTaskLists
    
    /**
    * Return all open task lists from this project
    *
    * @param void
    * @return array
    */
    function getAllOpenTaskLists() {
      if (is_null($this->all_open_task_lists)) {
        $this->all_open_task_lists = ProjectTaskLists::findAll(array(
          'conditions' => array('`project_id` = ? AND `completed_on` = ?', $this->getId(), EMPTY_DATETIME),
          'order' => '`order`'
        )); // findAll
      } // if
      return $this->all_open_task_lists;
    } // getAllOpenTaskLists
    
    /**
    * Return open task lists
    *
    * @access public
    * @param void
    * @return array
    */
    function getOpenTaskLists() {
      if (logged_user()->isMemberOfOwnerCompany()) {
        return $this->getAllOpenTaskLists();
      }
      if (is_null($this->open_task_lists)) {
        $this->open_task_lists = ProjectTaskLists::findAll(array(
          'conditions' => array('`project_id` = ? AND `completed_on` = ? AND `is_private` = ?', $this->getId(), EMPTY_DATETIME, 0),
          'order' => '`order`'
        )); // findAll
      } // if
      return $this->open_task_lists;
    } // getOpenTaskLists
    
    /**
    * Return all completed task lists
    *
    * @param void
    * @return array
    */
    function getAllCompletedTaskLists() {
      if (is_null($this->all_completed_task_lists)) {
        $this->all_completed_task_lists = ProjectTaskLists::findAll(array(
          'conditions' => array('`project_id` = ? AND `completed_on` > ?', $this->getId(), EMPTY_DATETIME),
          'order' => '`order`'
        )); // findAll
      } // if
      return $this->all_completed_task_lists;
    } // getAllCompletedTaskLists
    
    /**
    * Return completed task lists
    *
    * @access public
    * @param void
    * @return array
    */
    function getCompletedTaskLists() {
      if (logged_user()->isMemberOfOwnerCompany()) {
        return $this->getAllCompletedTaskLists();
      }
      if (is_null($this->completed_task_lists)) {
        $this->completed_task_lists = ProjectTaskLists::findAll(array(
          'conditions' => array('`project_id` = ? AND `completed_on` > ? AND `is_private` = ?', $this->getId(), EMPTY_DATETIME, 0),
          'order' => '`order`'
        )); // findAll
      } // if
      return $this->completed_task_lists;
    } // getCompletedTaskLists

    /**
    * Return array of milestones for the month specified that the user has
    * access to.
    *
    * @access public
    * @param int $year
    * @param int $month
    * @return array
    */
    function getTaskListsByMonth($year, $month) {
      $from_date = DateTimeValueLib::make(0, 0, 0, $month, 1, $year);
      $to_date = new DateTimeValue(strtotime('+1 month -1 day', $from_date->getTimestamp()));

      if (logged_user()->isMemberOfOwnerCompany()) {
        $conditions = array('`project_id` = ? AND (`due_date` >= ? AND `due_date` < ?)', $this->getId(), $from_date, $to_date);
      } else {
        $conditions = array('`project_id` = ? AND (`due_date` >= ? AND `due_date` < ?) AND `is_private` = ?', $this->getId(), $from_date, $to_date, 0);
      }
      return ProjectTaskLists::findAll(array(
        'conditions' => $conditions,
        'order' => 'due_date'
      )); // findAll
    } // getMilestonesByMonth

   
    // ---------------------------------------------------
    //  Tickets
    // ---------------------------------------------------

    /**
    * Return all categories
    *
    * @param void
    * @return array
    */
    function getCategories() {
      if(is_null($this->categories)) {
        $this->categories = ProjectCategories::getProjectCategories($this);
      } // if
      return $this->categories;
    } // getCategories

    /**
    * This function will return all tickets in project and it will not exclude private
    * tickets if logged user is not member of owner company
    *
    * @param void
    * @return array
    */
    function getAllTickets() {
      if (!plugin_active('tickets')) return null;
      if(is_null($this->all_tickets)) {
        $this->all_tickets = ProjectTickets::getProjectTickets($this, true);
      } // if
      return $this->all_tickets;
    } // getAllTickets

    /**
    * Return only the tickets that current user can see (if not member of owner company private
    * tickets will be excluded)
    *
    * @param void
    * @return array
    */
    function getTickets() {
      if (!plugin_active('tickets')) return null;
      if(logged_user()->isMemberOfOwnerCompany()) {
        return $this->getAllTickets(); // members of owner company can view all tickets
      } // if

      if(is_null($this->tickets)) {
        $this->tickets = ProjectTickets::getProjectTickets($this, false);
      } // if
      return $this->tickets;
    } // getTickets

    /**
    * This function will return all open tickets in project and it will not exclude private
    * tickets if logged user is not member of owner company
    *
    * @param void
    * @return array
    */
    function getAllOpenTickets() {
      if (!plugin_active('tickets')) return null;
      if(is_null($this->all_open_tickets)) {
        $this->all_open_tickets = ProjectTickets::getOpenProjectTickets($this, true);
      } // if
      return $this->all_open_tickets;
    } // getAllOpenTickets

    /**
    * Return only the open tickets that current user can see (if not member of owner company private
    * tickets will be excluded)
    *
    * @param void
    * @return array
    */
    function getOpenTickets() {
      if (!plugin_active('tickets')) return null;
      if(logged_user()->isMemberOfOwnerCompany()) {
        return $this->getAllOpenTickets(); // members of owner company can view all tickets
      } // if

      if(is_null($this->open_tickets)) {
        $this->open_tickets = ProjectTickets::getOpenProjectTickets($this, false);
      } // if
      return $this->open_tickets;
    } // getOpenTickets

    /**
    * This function will return all closed tickets in project and it will not exclude private
    * tickets if logged user is not member of owner company
    *
    * @param void
    * @return array
    */
    function getAllClosedTickets() {
      if (!plugin_active('tickets')) return null;
      if(is_null($this->all_closed_tickets)) {
        $this->all_closed_tickets = ProjectTickets::getClosedProjectTickets($this, true);
      } // if
      return $this->all_closed_tickets;
    } // getAllClosedTickets
    
    /**
    * Return only the closed tickets that current user can see (if not member of owner company private 
    * tickets will be excluded)
    *
    * @param void
    * @return array
    */
    function getClosedTickets() {
      if (!plugin_active('tickets')) return null;
      if(logged_user()->isMemberOfOwnerCompany()) {
        return $this->getAllClosedTickets(); // members of owner company can view all tickets
      } // if
      
      if(is_null($this->closed_tickets)) {
        $this->closed_tickets = ProjectTickets::getClosedProjectTickets($this, false);
      } // if
      return $this->closed_tickets;
    } // getClosedTickets
    
    // ---------------------------------------------------
    //  Tags
    // ---------------------------------------------------
    
    /**
    * This function will return unique tags used on objects of this project. Result is cached!
    *
    * @access public
    * @param void
    * @return array
    */
    function getTagNames() {
      $exclude_private = !logged_user()->isMemberOfOwnerCompany();
      if (is_null($this->tag_names)) {
        $this->tag_names = Tags::getProjectTagNames($this, $exclude_private);
      } // if
      return $this->tag_names;
    } // getTagNames
    
    /**
    * This function return associative array of project objects tagged with specific tag. Array has following elements:
    * 
    *  - messages
    *  - milestones
    *  - task lists
    *  - files
    *
    * @access public
    * @param string $tag
    * @return array
    */
    function getObjectsByTag($tag) {
      $exclude_private = !logged_user()->isMemberOfOwnerCompany();
      return array(
        'messages'   => Tags::getProjectObjects($this, $tag, 'ProjectMessages', $exclude_private),
        'milestones' => Tags::getProjectObjects($this, $tag, 'ProjectMilestones', $exclude_private),
        'task_lists' => Tags::getProjectObjects($this, $tag, 'ProjectTaskLists', $exclude_private),
        'tickets'    => Tags::getProjectObjects($this, $tag, 'ProjectTickets', $exclude_private),
        'files'      => Tags::getProjectObjects($this, $tag, 'ProjectFiles', $exclude_private),
        'wiki'       => Tags::getProjectObjects($this, $tag, 'Wiki', $exclude_private),
        'links'      => Tags::getProjectObjects($this, $tag, 'ProjectLinks', $exclude_private),
      ); // array
    } // getObjectsByTag
    
    /**
    * Return number of project objects tagged with $tag
    *
    * @param string $tag
    * @return integer
    */
    function countObjectsByTag($tag) {
      $exclude_private = !logged_user()->isMemberOfOwnerCompany();
      return Tags::countProjectObjectsByTag($tag, $this, $exclude_private);
    } // countObjectsByTag
    
    // ---------------------------------------------------
    //  Project log
    // ---------------------------------------------------
    
    /**
    * Return full project log
    *
    * @param integer $limit
    * @param integer $offset
    * @return array
    */
    function getFullProjectLog($limit = null, $offset = null) {
      return ApplicationLogs::getProjectLogs($this, true, true, $limit, $offset);
    } // getFullProjectLog
    
    /**
    * Return all project log entries that this user can see
    *
    * @param integer $limit Number of logs that will be returned
    * @param integer $offset Return from this record
    * @return array
    */
    function getProjectLog($limit = null, $offset = null) {
      $include_private = logged_user()->isMemberOfOwnerCompany();
      $include_silent = logged_user()->isAdministrator();
      
      return ApplicationLogs::getProjectLogs($this, $include_private, $include_silent, $limit, $offset);
    } // getProjectLog
    
    /**
    * Return number of logs for this project
    *
    * @access public
    * @param void
    * @return null
    */
    function countProjectLogs() {
      return ApplicationLogs::count(array('`project_id` = ?', $this->getId()));
    } // countProjectLogs
    
    // ---------------------------------------------------
    //  Project forms
    // ---------------------------------------------------
    
    /**
    * Return all project forms
    *
    * @param void
    * @return array
    */
    function getAllForms() {
      if(!plugin_active('form')) { return null; }
      if (is_null($this->all_forms)) {
        $this->all_forms = ProjectForms::findAll(array(
          'conditions' => array('`project_id` = ?', $this->getId()),
          'order' => '`order`'
        )); // findAll
      } // if
      return $this->all_forms;
    } // getAllForms
    
    /**
    * Return only visible project forms
    *
    * @param void
    * @return null
    */
    function getVisibleForms($only_enabled = false) {
      if(!plugin_active('form')) { return null; }
      $conditions = '`project_id` = ' . DB::escape($this->getId());
      if ($only_enabled) {
        $conditions .= ' AND `is_enabled` = ' . DB::escape(true);
      } // if
      
      return ProjectForms::findAll(array(
        'conditions' => $conditions,
        'order' => '`order`'
      )); // findAll
    } // getVisibleForms
    
    /**
    * Return owner company object
    *
    * @access public
    * @param void
    * @return Company
    */
    function getCompany() {
      return owner_company();
    } // getCompany
    
    /**
    * Get all companies involved in this project
    *
    * @access public
    * @param boolean $include_owner_company Include owner in result
    * @return array
    */
    function getCompanies($include_owner_company = true) {
      $result = array();
      if ($include_owner_company) {
        $result[] = $this->getCompany();
      }
      
      $companies = ProjectCompanies::getCompaniesByProject($this);
      if (is_array($companies)) {
        $result = array_merge($result, $companies);
      } // if
      
      return $result;
    } // getCompanies
    
    /**
    * Get all companies involved in this project visible to the given user
    *
    * @access public
    * @param User $user The user to filter with
    * @param boolean $include_owner_company Include owner in result
    * @return array
    */
    function getVisibleCompanies($user, $include_owner_company = false) {
      $visible = array();
      $companies = $this->getCompanies($include_owner_company);
      foreach($companies as $company) {
        if (logged_user()->canSeeCompany($company)) {
          $visible[] = $company;
        }
      }
      return $visible;
    } // getVisibleCompanies

    /**
    * Remove all companies from project
    *
    * @access public
    * @param void
    * @return boolean
    */
    function clearCompanies() {
      return ProjectCompanies::clearByProject($this);
    } // clearCompanies
    
    /**
    * Return all users involved in this project
    *
    * @access public
    * @param void
    * @return array
    */
    function getUsers($group_by_company = true) {
      $users = ProjectUsers::getUsersByProject($this);
      if (!is_array($users) || !count($users)) {
        return null;
      } // if
      
      if ($group_by_company) {
        
        $grouped = array();
        foreach ($users as $user) {
          if (!isset($grouped[$user->getCompanyId()]) || !is_array($grouped[$user->getCompanyId()])) {
            $grouped[$user->getCompanyId()] = array();
          } // if
          $grouped[$user->getCompanyId()][] = $user;
        } // foreach
        return $grouped;
        
      } else {
        return $users;
      } // if
    } // getUsers
    
    
    /**
    * Get all users involved in this project visible to the given user
    *
    * @access public
    * @param User $user The user to filter with
    * @param boolean $include_owner_company Include owner in result
    * @return array
    */
    function getVisibleUsers($user) {
      $visible = array();
      $users = $this->getUsers(false);
      foreach($users as $user) {
        if (logged_user()->canSeeUser($user)) {
          $visible[] = $user;
        }
      }
      return $visible;
    } // getVisibleUsers

    /**
    * Remove all users from project
    *
    * @access public
    * @param void
    * @return boolean
    */
    function clearUsers() {
      return ProjectUsers::clearByProject($this);
    } // clearUsers
    
    /**
    * Return user who created this milestone
    *
    * @access public
    * @param void
    * @return User
    */
    function getCreatedBy() {
      return Users::findById($this->getCreatedById());
    } // getCreatedBy
    
    /**
    * Return user who completed this project
    *
    * @access public
    * @param void
    * @return User
    */
    function getCompletedBy() {
      return Users::findById($this->getCompletedById());
    } // getCompletedBy
    
    /**
    * Return display name of user who completed this project
    *
    * @access public
    * @param void
    * @return string
    */
    function getCompletedByDisplayName() {
      $completed_by = $this->getCompletedBy();
      return $completed_by instanceof User ? $completed_by->getDisplayName() : lang('n/a');
    } // getCompletedByDisplayName
    
    // ---------------------------------------------------
    //  User tasks
    // ---------------------------------------------------
    
    /**
    * Return array of milestones that are assigned to specific user or his company
    *
    * @param User $user
    * @return array
    */
    function getUsersMilestones(User $user) {
      $conditions = DB::prepareString('`project_id` = ? AND ((`assigned_to_user_id` = ? AND `assigned_to_company_id` = ?) OR (`assigned_to_user_id` = ? AND `assigned_to_company_id` = ?) OR (`assigned_to_user_id` = ? AND `assigned_to_company_id` = ?)) AND `completed_on` = ?', array($this->getId(), $user->getId(), $user->getCompanyId(), 0, $user->getCompanyId(), 0, 0, EMPTY_DATETIME));
      if (!$user->isMemberOfOwnerCompany()) {
        $conditions .= DB::prepareString(' AND `is_private` = ?', array(0));
      } // if
      return ProjectMilestones::findAll(array(
        'conditions' => $conditions,
        'order' => '`due_date`'
      ));
    } // getUsersMilestones
    
    /**
    * Return array of task that are assigned to specific user or his company
    *
    * @param User $user
    * @return array
    */
    function getUsersTasks(User $user) {
      $task_lists = $this->getTaskLists();
      if (!is_array($task_lists)) {
        return false;
      } // if
      
      $task_list_ids = array();
      foreach ($task_lists as $task_list) {
        if (!$user->isMemberOfOwnerCompany() && $task_list->isPrivate()) {
          continue;
        } // if
        $task_list_ids[] = $task_list->getId();
      } // if
      
      return ProjectTasks::findAll(array(
        'conditions' => array('`task_list_id` IN (?) AND ((`assigned_to_user_id` = ? AND `assigned_to_company_id` = ?) OR (`assigned_to_user_id` = ? AND `assigned_to_company_id` = ?) OR (`assigned_to_user_id` = ? AND `assigned_to_company_id` = ?)) AND `completed_on` = ?', $task_list_ids, $user->getId(), $user->getCompanyId(), 0, $user->getCompanyId(), 0, 0, EMPTY_DATETIME),
        //'conditions' => array('((`assigned_to_user_id` = ? AND `assigned_to_company_id` = ?) OR (`assigned_to_user_id` = ? AND `assigned_to_company_id` = ?) OR (`assigned_to_user_id` = ? AND `assigned_to_company_id` = ?)) AND `completed_on` = ?', $task_list_ids, $user->getId(), $user->getCompanyId(), 0, $user->getCompanyId(), 0, 0, EMPTY_DATETIME),
        'order' => '`task_list_id`, `due_date`'
      )); // findAll
    } // getUsersTasks
    
    // ---------------------------------------------------
    //  User tickets
    // ---------------------------------------------------
    
    /**
    * Return array of task that are assigned to specific user or his company
    *
    * @param User $user
    * @param array $options
    * @param boolean $include_company
    * @return array
    */
    function getUsersTickets(User $user, $options = null, $include_company = false) {
      if (!plugin_active('tickets')) return null;
      if ($include_company) {      
        $conditions = DB::prepareString('`project_id` = ? AND ((`assigned_to_user_id` = ? AND `assigned_to_company_id` = ?) OR (`assigned_to_user_id` = ? AND `assigned_to_company_id` = ?) OR (`assigned_to_user_id` = ? AND `assigned_to_company_id` = ?) OR `created_by_id`= ?) AND `closed_on` = ?', array($this->getId(), $user->getId(), $user->getCompanyId(), 0, $user->getCompanyId(), 0, 0, $user->getId(), EMPTY_DATETIME));
      } else {
        $conditions = DB::prepareString('`project_id` = ? AND `assigned_to_user_id` = ? AND `closed_on` = ?', array($this->getId(), $user->getId(), EMPTY_DATETIME));
      } // if
      if(!$user->isMemberOfOwnerCompany()) {
        $conditions .= DB::prepareString(' AND `is_private` = ?', array(0));
      } // if
      $options['conditions'] = $conditions;
      if (!isset($options['order'])) {
        $options['order'] = '`created_on`';
      }
      return ProjectTickets::findAll($options); // findAll
    } // getUsersTickets
    
    // ---------------------------------------------------
    //  Files
    // ---------------------------------------------------

    function getFolders() {
      if(!plugin_active('files')) { return null; }
      if (is_null($this->folders)) {
        $this->folders = ProjectFolders::getProjectFolders($this);
      } // if
      return $this->folders;
    } // getFolders
        
    /**
    * Return all important files
    *
    * @param void
    * @return array
    */
    function getAllImportantFiles() {
      trace(__FILE__,'getAllImportantFiles()');
      if(!plugin_active('files')) { return null; }
      if (is_null($this->all_important_files)) {
        $this->all_important_files = ProjectFiles::getImportantProjectFiles($this, true);
      } // if
      return $this->all_important_files;
    } // getAllImportantFiles
    
    /**
    * Return important files
    *
    * @param void
    * @return array
    */
    function getImportantFiles() {
      trace(__FILE__,'getImportantFiles()');
      if(!plugin_active('files')) { return null; }
      if (logged_user()->isMemberOfOwnerCompany()) {
        return $this->getAllImportantFiles();
      } // if
      
      if (is_null($this->important_files)) {
        $this->important_files = ProjectFiles::getImportantProjectFiles($this, false);
      } // if
      return $this->important_files;
    } // getImportantFiles
    
    /**
    * Return all orphaned files
    *
    * @param void
    * @return array
    */
    function getAllOrphanedFiles() {
      if(!plugin_active('files')) { return null; }
      if (is_null($this->all_orphaned_files)) {
        $this->all_orphaned_files = ProjectFiles::getOrphanedFilesByProject($this, true);
      } //
      return $this->all_orphaned_files;
    } // getAllOrphanedFiles
    
    /**
    * Return orphaned files
    *
    * @param void
    * @return array
    */
    function getOrphanedFiles() {
      if(!plugin_active('files')) { return null; }
      if (is_null($this->orphaned_files)) {
        $this->orphaned_files = ProjectFiles::getOrphanedFilesByProject($this, logged_user()->isMemberOfOwnerCompany());
      } // if
      return $this->orphaned_files;
    } // getOrphanedFiles
    
    // ---------------------------------------------------
    //  Status
    // ---------------------------------------------------
    
    /**
    * Check if this project is active
    *
    * @access public
    * @param void
    * @return boolean
    */
    function isActive() {
      return !$this->isCompleted();
    } // isActive
    
    /**
    * Check if this project is completed
    *
    * @access public
    * @param void
    * @return boolean
    */
    function isCompleted() {
      return (boolean) $this->getCompletedOn();
    } // isCompleted
    
    // ---------------------------------------------------
    //  Permissions
    // ---------------------------------------------------
    
    /**
    * Check if user can add project
    *
    * @access public
    * @param void
    * @return null
    */
    function canAdd(User $user) {
      return $user->isAccountOwner() || $user->isAdministrator(owner_company()) || $user->canManageProjects();
    } // canAdd
    
    /**
    * Returns true if user can update specific project
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canEdit(User $user) {
      return ($this->getCreatedById() == $user->getId()) || $user->isAccountOwner() || $user->isAdministrator(owner_company());
    } // canEdit
    
    /**
    * Returns true if user can delete specific project
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canDelete(User $user) {
      return ($this->getCreatedById() == $user->getId()) || $user->isAccountOwner() || $user->isAdministrator(owner_company());
    } // canDelete
    
    /**
    * Returns true if user can change status of this project
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canChangeStatus(User $user) {
      return $this->canEdit($user);
    } // canChangeStatus
    
    /**
    * Returns true if user can access permissions page and can update permissions
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canChangePermissions(User $user) {
      return ($this->getCreatedById() == $user->getId()) || $user->isAccountOwner() || $user->isAdministrator(owner_company());
    } // canChangePermissions
    
    /**
    * Check if specific user can remove company from project
    *
    * @access public
    * @param User $user
    * @param Company $remove_company Remove this company
    * @return boolean
    */
    function canRemoveCompanyFromProject(User $user, Company $remove_company) {
      if ($remove_company->isOwner()) {
        return false;
      }
      return ($this->getCreatedById() == $user->getId()) || $user->isAccountOwner() || $user->isAdministrator();
    } // canRemoveCompanyFromProject
    
    /**
    * Check if this user can remove other user from project
    *
    * @access public
    * @param User $user
    * @param User $remove_user User that need to be removed
    * @return boolean
    */
    function canRemoveUserFromProject(User $user, User $remove_user) {
      if ($remove_user->isAccountOwner()) {
        return false;
      }
      return ($this->getCreatedById() == $user->getId()) || $user->isAccountOwner() || $user->isAdministrator();
    } // canRemoveUserFromProject
    
    // ---------------------------------------------------
    //  URLS
    // ---------------------------------------------------
    
    /**
    * Link to project overview page
    *
    * @access public
    * @param void
    * @return stirng
    */
    function getOverviewUrl() {
      return get_url('project', 'overview', array('active_project' => $this->getId()));
    } // getOverviewUrl
    
    /**
    * Return project messages index page URL
    *
    * @param void
    * @return string
    */
    function getMessagesUrl() {
      return get_url('message', 'index', array('active_project' => $this->getId()));
    } // getMessagesUrl
    
    /**
    * Return project tasks index page URL
    *
    * @param void
    * @return string
    */
    function getTasksUrl() {
      return get_url('task', 'index', array('active_project' => $this->getId()));
    } // getTasksUrl
    
    /**
    * Return project milestones index page URL
    *
    * @param void
    * @return string
    */
    function getMilestonesUrl() {
      return get_url('milestone', 'index', array('active_project' => $this->getId()));
    } // getMilestonesUrl
    
    /**
    * Return project tickets index page URL
    *
    * @param void
    * @return string
    */
    function getTicketsUrl() {
      return get_url('tickets', 'index', array('active_project' => $this->getId()));
    } // getTicketsUrl

    /**
    * Return project forms index page URL
    *
    * @param void
    * @return string
    */
    function getFormsUrl() {
      return get_url('form', 'index', array('active_project' => $this->getId()));
    } // getFormsUrl
    
    /**
    * Return project people index page URL
    *
    * @param void
    * @return string
    */
    function getPeopleUrl() {
      return get_url('project', 'people', array('active_project' => $this->getId()));
    } // getPeopleUrl
    
    /**
    * Return project settings page URL
    *
    * @param void
    * @return string
    */
    function getSettingsUrl() {
      return get_url('project_settings', 'index', array('active_project' => $this->getId()));
    } // getSettingsUrl
    
    /**
    * Return project permissions page URL
    *
    * @param void
    * @return string
    */
    function getPermissionsUrl() {
      return get_url('project', 'permissions', array('active_project' => $this->getId()));
    } // getPermissionsUrl
    
    /**
    * Return search URL
    *
    * @param string $search_for
    * @param string placeholder for search page
    * @return string
    */
    function getSearchUrl($search_for = null, $page = '#PAGE#') {
      if (trim($search_for) <> '') {
        $params = array(
          'active_project' => $this->getId(),
          'search_for' => $search_for,
          'page' =>  $page,
        ); // array
        return get_url('project', 'search', $params);
      } else {
        return ROOT_URL . 'index.php';
      } // if
    } // getSearchUrl
    
    /**
    * Return edit project URL
    *
    * @access public
    * @param string $redirect_to URL where we need to redirect user when edit is done
    * @return string
    */
    function getEditUrl($redirect_to = null) {
      $attributes = array('id' => $this->getId(),
        'active_project' => $this->getId());
      if (trim($redirect_to) <> '') {
        $attributes['redirect_to'] = urlencode(trim($redirect_to));
      } // if
      
      return get_url('project', 'edit', $attributes);
    } // getEditUrl
    
    /**
    * Return delete project URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getDeleteUrl() {
      return get_url('project', 'delete', array(
        'id' => $this->getId(),
        'active_project' => $this->getId(),
      ));
    } // getDeleteUrl
    
    /**
    * Return complete project url
    *
    * @access public
    * @param void
    * @return string
    */
    function getCompleteUrl() {
      return get_url('project', 'complete', $this->getId());
    } // getCompleteUrl
    
    /**
    * Return open project URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getOpenUrl() {
      return get_url('project', 'open', $this->getId());
    } // getOpenUrl
    
    /**
    * Return add contact to project URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getAddContactUrl($params = null) {
      $params['active_project'] = $this->getId();
      return get_url('project', 'add_contact', $params);
    } // getAddContactUrl
    
    /**
    * Return remove contact to project URL
    *
    * @access public
    * @param integer $contact_id
    * @return string
    */
    function getRemoveContactUrl($contact_id) {
      return get_url('project', 'remove_contact', array('rel_object_manager' => 'Contacts', 'rel_object_id' => $contact_id, 'project_id' => $this->getId()));
    } // getRemoveContactUrl
    
    /**
    * Return edit contact to project URL
    *
    * @access public
    * @param integer $contact_id
    * @return string
    */
    function getEditContactUrl($contact_id) {
      return get_url('project', 'edit_contact', array('rel_object_manager' => 'Contacts', 'rel_object_id' => $contact_id, 'project_id' => $this->getId()));
    } // getEditContactUrl
    
    /**
    * Return remove user from project URL
    *
    * @access public
    * @param User $user
    * @return string
    */
    function getRemoveUserUrl(User $user) {
      return get_url('project', 'remove_user', array('user_id' => $user->getId(), 'project_id' => $this->getId()));
    } // getRemoveUserUrl
    
    /**
    * Return remove company from project URL
    *
    * @access public
    * @param Company $company
    * @return string
    */
    function getRemoveCompanyUrl(Company $company) {
      return get_url('project', 'remove_company', array('company_id' => $company->getId(), 'project_id' => $this->getId()));
    } // getRemoveCompanyUrl
    
    /**
    * Return tag URL
    *
    * @access public
    * @param string $tag_name
    * @return string
    */
    function getTagUrl($tag_name) {
      return get_url('tags', 'project_tag', array('tag' => $tag_name, 'active_project' => $this->getId()));
    } // getTagUrl

    /**
    * Return time report URL
    *
    * @access public
    * @param string $tag_name
    * @return string
    */
    function getTimeReportUrl() {
      return get_url('time', 'bytask', array('active_project' => $this->getId()));
    } // getTimeReportUrl

    /**
    * Return update logo URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getEditLogoUrl() {
      return get_url('project', 'edit_logo', $this->getId());
    } // getEditLogoUrl
    
    /**
    * Return delete logo URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getDeleteLogoUrl() {
      return get_url('project', 'delete_logo', $this->getId());
    } // getDeleteLogoUrl

    // ---------------------------------------------------
    //  Logo
    // ---------------------------------------------------
    
    /**
    * Set logo value
    *
    * @param string $source Source file
    * @param integer $max_width
    * @param integer $max_height
    * @param boolean $save Save object when done
    * @return null
    */
    function setLogo($source, $max_width = 50, $max_height = 50, $save = true) {
      if (!is_readable($source)) {
        return false;
      }
      
      do {
        $temp_file = ROOT . '/cache/' . sha1(uniqid(rand(), true));
      } while (is_file($temp_file));
      
      try {
        Env::useLibrary('simplegd');
        
        $image = new SimpleGdImage($source);
        $thumb = $image->scale($max_width, $max_height, SimpleGdImage::BOUNDARY_DECREASE_ONLY, false);
        $thumb->saveAs($temp_file, IMAGETYPE_PNG);
        
        $public_filename = PublicFiles::addFile($temp_file, 'png');
        if ($public_filename) {
          $this->setLogoFile($public_filename);
          if ($save) {
            $this->save();
          } // if
        } // if
        
        $result = true;
      } catch(Exception $e) {
        $result = false;
      } // try
      
      // Cleanup
      if (!$result && $public_filename) {
        PublicFiles::deleteFile($public_filename);
      } // if
      @unlink($temp_file);
      
      return $result;
    } // setLogo
    
    /**
    * Delete logo
    *
    * @param void
    * @return null
    */
    function deleteLogo() {
      if ($this->hasLogo()) {
        PublicFiles::deleteFile($this->getLogoFile());
        $this->setLogoFile('');
      } // if
    } // deleteLogo
    
    /**
    * Returns path of company logo. This function will not check if file really exists
    *
    * @access public
    * @param void
    * @return string
    */
    function getLogoPath() {
      return PublicFiles::getFilePath($this->getLogoFile());
    } // getLogoPath
    
    /**
    * description
    *
    * @access public
    * @param void
    * @return string
    */
    function getLogoUrl() {
      return $this->hasLogo() ? PublicFiles::getFileUrl($this->getLogoFile()) : get_image_url('logo.gif');
    } // getLogoUrl
    
    /**
    * Returns true if this company have logo file value and logo file exists
    *
    * @access public
    * @param void
    * @return boolean
    */
    function hasLogo() {
      return trim($this->getLogoFile()) && is_file($this->getLogoPath());
    } // hasLogo
    
    // ---------------------------------------------------
    //  System functions
    // ---------------------------------------------------
  
    /**
    * Validate object before save
    *
    * @access public
    * @param array $errors
    * @return null
    */
    function validate(&$errors) {
      if (!$this->validatePresenceOf('name')) {
        $errors[] = lang('project name required');
      } // if
      if (!$this->validateUniquenessOf('name')) {
        $errors[] = lang('project name unique');
      } // if
    } // validate
    
    /**
    * Delete project
    *
    * @param void
    * @return boolean
    */
    function delete() {
      $this->clearPageAttachments();
      $this->clearMessages();
      $this->clearTaskLists();
      $this->clearTickets();
      $this->clearMilestones();
      $this->clearFiles();
      $this->clearFolders();
      $this->clearForms();
      $this->clearPermissions();
      $this->clearLogs();
      return parent::delete();
    } // delete
    
    /**
    * Clear all project page attachments
    *
    * @param void
    * @return null
    */
    private function clearPageAttachments() {
      $page_attachments = $this->getAllPageAttachments();
      if (is_array($page_attachments)) {
        foreach ($page_attachments as $page_attachment) {
          $page_attachment->delete();
        } // foreach
      } // if
    } // clearPageAttachments
 
    /**
    * Clear all project messages
    *
    * @param void
    * @return null
    */
    private function clearMessages() {
      trace(__FILE__,'clearMessages');
      $messages = $this->getAllMessages();
      if (is_array($messages)) {
        foreach ($messages as $message) {
          $message->delete();
        } // foreach
      } // if
    } // clearMessages
    
    /**
    * Clear all task lists
    *
    * @param void
    * @return null
    */
    private function clearTaskLists() {
      trace(__FILE__,'clearTaskLists');
      $task_lists = $this->getAllTaskLists();
      if (is_array($task_lists)) {
        foreach ($task_lists as $task_list) {
          $task_list->delete();
        } // foreach
      } // if
    } // clearTaskLists

    /**
    * Clear all tickets
    *
    * @param void
    * @return null
    */
    private function clearTickets() {
      $tickets = $this->getAllTickets();
      if (is_array($tickets)) {
        foreach ($tickets as $ticket) {
          $ticket->delete();
        } // foreach
      } // if
    } // clearTickets
        
    /**
    * Clear all milestones
    *
    * @param void
    * @return null
    */
    private function clearMilestones() {
      trace(__FILE__,'clearMilestones');
      $milestones = $this->getAllMilestones();
      if (is_array($milestones)) {
        foreach ($milestones as $milestone) {
          $milestone->delete();
        } // foreach
      } // if
    } // clearMilestones
    
    /**
    * Clear forms
    *
    * @param void
    * @return null
    */
    private function clearForms() {
      trace(__FILE__,'clearForms');
      if(!plugin_active('form')) { return null; }
      $forms = $this->getAllForms();
      if (is_array($forms)) {
        foreach ($forms as $form) {
          $form->delete();
        } // foreach
      } // if
    } // clearForms
    
    /**
    * Clear all files and folders
    *
    * @param void
    * @return null
    */
    private function clearFiles() {
      if(!plugin_active('files')) { return null; }
      $files = ProjectFiles::getAllFilesByProject($this);
      if (is_array($files)) {
        foreach ($files as $file) {
          $file->delete();
        } // foreach
      } // if
    } // clearFiles
    
    /**
    * Clear all folders
    *
    * @param void
    * @return null
    */
    private function clearFolders() {
      if(!plugin_active('files')) { return null; }
      $folders = $this->getFolders();
      if (is_array($folders)) {
        foreach ($folders as $folder) {
          $folder->delete();
        } // foreach
      } // if
    } // clearFolders
    
    /**
    * Clear project level permissions
    *
    * @param void
    * @return null
    */
    function clearPermissions() {
      ProjectCompanies::clearByProject($this);
      ProjectUsers::clearByProject($this);
    } // clearPermissions
    
    /**
    * Clear application logs for this project
    *
    * @param void
    * @return null
    */
    function clearLogs() {
      ApplicationLogs::clearByProject($this);
    } // clearLogs
    
    // ---------------------------------------------------
    //  ApplicationDataObject implementation
    // ---------------------------------------------------
    
    /**
    * Return object type name
    *
    * @param void
    * @return string
    */
    function getObjectTypeName() {
      return lang('project');
    } // getObjectTypeName
    
    /**
    * Return object URl
    *
    * @access public
    * @param void
    * @return string
    */
    function getObjectUrl() {
      return $this->getOverviewUrl();
    } // getObjectUrl
    
  } // Project 

?>