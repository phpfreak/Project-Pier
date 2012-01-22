<?php

/**
 * @author Alex Mayhew
 * @copyright 2008
 */

Class WikiController extends ApplicationController {

  function __construct()
  {
    trace(__FILE__,'__construct()');
    parent::__construct();
    trace(__FILE__,'__construct() - prepare_company_website_controller');
    prepare_company_website_controller($this, 'project_website');
    trace(__FILE__,'__construct() - add textile');
    $this->addHelper('textile');
  } // __controller
  
  /**
  * Wiki index
   * 
   * @return void
   */
  function index()
  {
    trace(__FILE__,'index()');
    //Here we show them the default wiki page
    $page = Wiki::getProjectIndex(active_project());
    trace(__FILE__,'index() - got project index page');
    
    if(!instance_of($page, 'WikiPage')){
      //There isn't a wiki page at the moment
      //to prevent nasty errors, make a temp page
      $page = new WikiPage;
      //Make a revision for the page
      $revision = $page->makeRevision();
      //Fill in the default content
      $revision->setContent(lang('wiki default page content'));
      //Set the name of the page
      $revision->setName(lang('wiki default page name'));
    } else {
      //Fetch the latest revision of the page
      $revision = $page->getLatestRevision();
      
      if(!instance_of($revision, 'Revision')){
        //If for some screwy reason there isn't a revision
        flash_error(lang('wiki revision dnx'));
        //Go to the dashboard
        $this->redirectTo();
      }
    }
    trace(__FILE__,'index() - tpl_assign');
    tpl_assign('page', $page);
    tpl_assign('revision', $revision);
    $this->_load_sidebar();
  }// index
  
  /**
   * Delete a wiki page
   * 
   * @todo Add password confirmation
   * @return void
   */
  function delete()
  {
    
    $page = Wiki::getPageById(get_id(), active_project());
    
    if(!instance_of($page, 'WikiPage')){
      //If the page doesn't exist
      flash_error(lang('wiki page dnx'));
      //redirect to wiki index
      $this->redirectTo('wiki');
    }// if
    
    if(!$page->canDelete(logged_user())){
      //We will only let authorised users delete pages
      flash_error(lang('no access permissions'));
      $this->redirectToReferer(get_url('wiki'));
    }// if
    
    //We fetch the latest revision so that we can show the user page title & use it in app logs
    $revision = $page->getLatestRevision();
    
    if(array_var($_POST, 'deleteWikiPage')){
      try {
        //Start the transaction
        DB::beginWork();
        
        //Delete the page and all of its revisions
        $page->delete();
        
        //Make a log of the deletion
        ApplicationLogs::createLog($page, $page->getProject(), ApplicationLogs::ACTION_DELETE);
        
        //Commit changes
        DB::commit();
        
        //Tell the user they did a good job
        flash_success(lang('success delete wiki page'));
        
      } catch (Exception $e){
        //Something went wrong, so delete any changes made to the DB
        DB::rollback();
        //Show the user the error
        flash_error(lang('failure delete wiki page', '(' . $e->getMessage() . ')'));
      }// try
      
      //Redirect to the wiki index either way
      $this->redirectTo('wiki');
    }// if
 
    tpl_assign('page', $page);
    tpl_assign('revision', $revision);
    
  }// delete
  
  function _load_sidebar()
  {
    trace(__FILE__,'_load_sidebar()');

    //Quick error / XSS preventor
    if(request_action() == '_load_sidebar'){
      flash_error('no access permissions');
      $this->redirectTo();
    }
    
    //Get Sidebar stuff
    $sidebar_page = Wiki::getProjectSidebar(active_project());
    if(instance_of($sidebar_page, 'WikiPage')){
      $sidebar_revision = $sidebar_page->getLatestRevision();		
    } else {
      //Make some default content which should help the user set stuff up
      $sidebar_page = new WikiPage;
      $sidebar_revision = new Revision;
      $sidebar_revision->setName(lang('wiki default sidebar name'));
      $sidebar_revision->setContent(lang('wiki default sidebar content'));
    }// if
    $all_pages = Wiki::getAllProjectPages(active_project());
    tpl_assign('sidebar_links', $all_pages);
    
    tpl_assign('sidebar_page', $sidebar_page);
    tpl_assign('sidebar_revision', $sidebar_revision);

    $this->setSidebar(get_template_path('view_sidebar', 'wiki'));	
  }// _load_sidebar
  
  /**
   * View a wiki page
   * 
   * @return void
   */
  function view()
  {
    //Get the page that they want
    $page = Wiki::getPageById(get_id(), active_project());
    
    if(!instance_of($page, 'WikiPage')){
      //If page isn't an instance of WikiPage then the page does not exist
      flash_error(lang('wiki page dnx'));
      //Redirect to wiki controller
      $this->redirectTo('wiki');
    }
    
    if(!$page->canView(logged_user())){
      //If User can't view page
      flash_error(lang('no access permissions'));
      $this->redirectTo(get_url('wiki'));
    } // if
    
    //Get the revision the user wants. defaults to latest 
    $revision = $page->getRevision(array_var($_GET, 'revision'));
    
    if(!instance_of($revision, 'Revision')){
      //If for some screwy reason there isn't a revision
      flash_error(lang('wiki revision dnx'));
      //Go to the dashboard
      $this->redirectTo('wiki');
    }// if
    
    tpl_assign('iscurrev', (!(bool) array_var($_GET, 'revision', false)));
    tpl_assign('page', $page);
    tpl_assign('revision', $revision);
    $this->setTemplate('view');
    
    //Get Sidebar stuff
    $this->_load_sidebar();
  }
  
  /**
   * Add a wiki page
   *
   * @return void
   */
  function add()
  {
    if(!WikiPage::canAdd(logged_user(), active_project())){
      flash_error(lang('no access permissions'));
      $this->redirectTo('wiki');
    } //if
    
    //Here we will edit a wiki page
    $preview = false;
    $data = array_var($_POST, 'wiki', false);
    if (false !== $data) {
      $preview = array_key_exists('preview', $data); 
    }

    if(!$preview && $data){
      //Make a new wiki page
      $page = new WikiPage;
      //Set the Id for this project
      $page->setProjectId(active_project()->getId());
      $page->setProjectIndex((logged_user()->isMemberOfOwnerCompany() ? $data['project_index'] : 0));
      $page->setPublish((logged_user()->isMemberOfOwnerCompany() ? $data['publish'] : 0));
      $page->setParentId($data['parent_id']);
      
      $page->setProjectSidebar((logged_user()->isMemberOfOwnerCompany() ? $data['project_sidebar'] : 0));
      //Make a new revision of this page
      $revision = $page->makeRevision();
      
      // Check to see if we want to lock this page
      if (isset($data['locked'])) {
        if ($data['locked'] == 1 && $page->canLock(logged_user())) {
          // If we want to lock this page and the user has permissions to lock it, and the page is not already locked
          $page->setLocked(true);
          $page->setLockedById(logged_user()->getId());
          $page->setLockedOn(DateTimeValueLib::now());
        } // if
      } // if
      //Set attributes from form
      $revision->setFromAttributes($data);
      
      //Set user ID and project ID
      $revision->setCreatedbyId(logged_user()->getId());
      
      try {
        //Start the db transaction
        DB::beginWork();				
        
        //Save the page
        $page->save();
        
        //Make a log entry
        ApplicationLogs::createLog($page, active_project(), ApplicationLogs::ACTION_ADD);
        
        if (plugin_active('tags')) {
            //Add page tags
          $page->setTagsFromCSV($data['tags']);
        }
        
        //Commit changed
        DB::commit();
        
        //Tell the user they made a page
        flash_success(lang('success add wiki page'));
        
        //Redirect
        $this->redirectToUrl($page->getViewUrl());
        
      } catch (Exception $e){
        DB::rollback();
        tpl_assign('error', $e);
      }//try
    }// if
    
    if(!isset($page) || !instance_of($page, 'WikiPage')){
      $page = new WikiPage;
      $page->setProjectId(active_project()->getId());	
    }// if
    $revision = new Revision;

    if (!$data) {  // there was no input POSTed
      $data['content'] = $revision->getContent();
    }
    $data['preview_content'] = do_textile($data['content']);
    
    //Assign revision object
    tpl_assign('data', $data);
    tpl_assign('page', $page);
    tpl_assign('revision', $revision);
    $this->setTemplate('edit');
    $this->setSidebar(get_template_path('textile_help_sidebar'));
    
  } // add
  
  /**
   * Edit a wiki page
   * 
   * @return void
   */
  function edit()
  {
    if(!WikiPage::canEdit(logged_user())){
      flash_error(lang('no wiki page edit permissions'));
      $this->redirectToReferer(get_url('wiki'));
    }

    //Get the page from the url params
    $page = Wiki::getPageById(get_id(), active_project());
    
    if(!instance_of($page, 'WikiPage')){
      //If the page doesn't exist, redirect to wiki index
      flash_error(lang('wiki page dnx'));
      $this->redirectToReferer(get_url('wiki'));
    }// if
    
    //Check that the user can edit this entry
    if(!$page->canEdit(logged_user())){
      flash_error(lang('no access permissions'));
      $this->redirectTo(get_url('wiki'));
    }// if
    
    // Check that the page isn't locked
    if ($page->isLocked() && !$page->canUnlock(logged_user())) {
      flash_error(lang('wiki page locked by', $page->getLockedByUser()->getUsername()));
      $this->redirectToUrl($page->getViewUrl());
    } // if

    //Here we will edit a wiki page
    $preview = false;
    $data = array_var($_POST, 'wiki', false);
    if (false !== $data) {
      $preview = array_key_exists('preview', $data); 
    }

    if(!$preview && $data){
    //if(null !== ($data = array_var($_POST, 'wiki'))){
      //If we have received data
      
      //Make a new revision
      $revision = $page->makeRevision();
      $revision->setFromAttributes($data);
      
      $page->setProjectIndex($data['project_index']);
      $page->setProjectSidebar($data['project_sidebar']);
      $page->setPublish($data['publish']);
      $page->setParentId($data['parent_id']);

      // Check to see if we want to lock this page
      if (isset($data['locked'])) {
        if ($data['locked'] == 1 && $page->canLock(logged_user()) && !$page->isLocked()) {
          // If we want to lock this page and the user has permissions to lock it, and the page is not already locked
          $page->setLocked(true);
          $page->setLockedById(logged_user()->getId());
          $page->setLockedOn(DateTimeValueLib::now());
        } elseif ($data['locked'] == 0 & $page->canUnlock(logged_user()) && $page->isLocked()) {
          // Else if we want to unlock the page, and the user is allowed to, and the page is locked
          $page->setLocked(false);
        } // if
      } // if
      
      //Set the users ID
      $revision->setCreatedById(logged_user()->getId());
      
      try{
        
        //Start the transaction
        DB::beginWork();
        
        //Save the page and create revision
        //The page will make sure that the revision's project and page Id are correct 
        $page->save();
        
        ApplicationLogs::createLog($page, active_project(), ApplicationLogs::ACTION_EDIT);
        
        if (plugin_active('tags')) {
          //Set the tags
          $page->setTagsFromCSV($data['tags']);	
        }
        
        //Commit changes
        DB::commit();
        
        flash_success(lang('success edit wiki page'));
        
        //Redirect to the page we just created
        $this->redirectToUrl($page->getViewUrl());
          
      } catch (Exception $e){
        //Get rid of any Db changes we've made
        DB::rollback();
        //Assign the problem to the template so we can tell the user
        tpl_assign('error', $e);
      }//try	
    } else if(array_var($_GET, 'revision')){
      //If we want to make a new revision based off a revision
      $revision = $page->getRevision($_GET['revision']);
    } else {
      $revision = $page->getLatestRevision();
    } //if

    if (!$data) {  // there was no input POSTed
      $data['content'] = $revision->getContent();
    }
    $data['preview_content'] = do_textile($data['content']);
    
    //Assign revision object
    tpl_assign('revision', $revision);
    tpl_assign('data', $data);
    //Assign the page object
    tpl_assign('page', $page);
    $tag_names = plugin_active('tags') ? $page->getTagNames() : '';
    $tags = is_array($tag_names) ? implode(', ', $tag_names) : '';
    tpl_assign('tags', $tags);
    //Set the template
    $this->setTemplate('edit');		
    $this->setSidebar(get_template_path('textile_help_sidebar'));
  }// edit
  
  /**
   * View the revision history of a page
   * 
   * @return void
   */
  function history()
  {
    //Here we will view the history of a wiki page
    $page = Wiki::getPageById(get_id(), active_project());
    
    if(!instance_of($page, 'WikiPage')){
      //If page DNX (Does not exist)
      flash_error('wiki page dnx');
      $this->redirectTo('wiki');
    }// if
    
    if(!$page->canView(logged_user())){
      //If the user can't view a page, then they have no business looking at it's revisions :p
      flash_error('no access permissions');
      //Redirect to dashboard
      $this->redirectTo();
    }// if
    
    //Work out the page we are on
    $pnum = (integer) array_var($_GET, 'page', 1);
    if ($pnum < 0) {
      $pnum = 1;
    }// if
    
    //Get the revisions for this page
    list($revisions, $pagination) = $page->paginateRevisions(array(), 30, $pnum);
    
    //Assign template variables
    tpl_assign('page', $page);
    tpl_assign('cur_revision', $page->getLatestRevision());
    tpl_assign('revisions', $revisions);
    tpl_assign('pagination', $pagination);
    
    //Load the wiki sidebar
    $this->_load_sidebar();
    
  }// history
  
  function revert()
  {
    //Here we will rollback to a wiki page
    $page = Wiki::getPageById(get_id(), active_project());
  
    if(!instance_of($page, 'WikiPage')){
      flash_error(lang('wiki page dnx'));
      $this->redirectTo('wiki');
    }// if
    
    if(!$page->canEdit(logged_user())){
      flash_error(lang('no access permissions'));
      $this->redirectTo('wiki');
    }// if
    
    $old_revision = $page->getRevision(array_var($_GET, 'revision', -1));
  
    if(!instance_of($old_revision, 'Revision')){
      flash_error(lang('wiki page revision dnx'));
      $this->redirectTo('wiki');
    }// if
    
    $new_revision = $page->makeRevision();
    
    $new_revision->setContent($old_revision->getContent());
    $new_revision->setName($old_revision->getName());
    $new_revision->setLogMessage(lang('wiki page revision restored from', $old_revision->getRevision()));
    
    try{
      DB::beginWork();
      $page->save();
      DB::commit();
      flash_success(lang('success restore wiki page revision'));
      $this->redirectToUrl($page->getViewUrl());
      
    } catch (Exception $e){
      DB::rollback();
      flash_error(lang('failure restore wiki page revision', $e->getMessage()));
      $this->redirectTo('wiki');
    }// try

  }// revert
  
  function diff()
  {
    $page = Wiki::getPageById(get_id(), active_project());
    if(!instance_of($page, 'WikiPage')){
      flash_error('wiki page dnx');
      $this->redirectTo('wiki');
    }// if
    
    if(!$page->canView(logged_user())){
      flash_error('no access permissions');
      $this->redirectTo('wiki');
    }// if
    
    $rev1 = $page->getRevision(array_var($_GET, 'rev1', -1));
    
    $rev2 = $page->getRevision(array_var($_GET, 'rev2', -1));
    
    if(!instance_of($rev1, 'Revision') || !instance_of($rev2, 'Revision')){
      flash_error(lang('wiki page revision dnx'));
      $this->redirectTo('wiki');
    }// if
    
    $this->addHelper('textile');

    //Load text diff library
    Env::useLibrary('diff', 'wiki');
    
    $diff = new diff($rev1->getContent(), $rev2->getContent());
    
    $output = new diff_renderer_inline;
    
    tpl_assign('diff', $output->render($diff));
    tpl_assign('page', $page);
    tpl_assign('revision', $page->getLatestRevision());
    tpl_assign('rev1', $rev1);
    tpl_assign('rev2', $rev2);
    
  }// diff
  /**
    * View all wiki pages
    * 
    * @return void
    */
  function all_pages() {
    // There isn't a wiki page for all pages
    // So prepare a dummy page
    $page = new WikiPage;
    // Make a revision for the page
    $revision = $page->makeRevision();
    $revision->setName(lang('wiki all pages'));

    $all_pages = Wiki::getAllProjectPages(active_project());
    tpl_assign('all_pages', $all_pages);
    tpl_assign('page', $page);
    tpl_assign('revision', $revision);
    $this->_load_sidebar();
  } // all_pages
}

?>