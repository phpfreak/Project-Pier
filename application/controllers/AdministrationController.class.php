<?php

  /**
  * Administration controller
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class AdministrationController extends ApplicationController {
  
    /**
    * Construct the AdministrationController 
    *
    * @access public
    * @param void
    * @return AdministrationController 
    */
    function __construct() {
      parent::__construct();
      prepare_company_website_controller($this, 'administration');
      
      // Access permissions
      if (!logged_user()->isAdministrator(owner_company())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard');
      } // if
    } // __construct
    
    /**
    * Show administration index
    *
    * @access public
    * @param void
    * @return null
    */
    function index() {
      
    } // index
    
    /**
    * Show company page
    *
    * @access public
    * @param void
    * @return null
    */
    function company() {
      $this->addHelper('textile');
      tpl_assign('company', owner_company());
      $this->render(get_template_path('view_company', 'company'));
    } // company
    
    /**
    * Show owner company members
    *
    * @access public
    * @param void
    * @return null
    */
    function members() {
      tpl_assign('company', owner_company());
      tpl_assign('users', owner_company()->getContacts());
    } // members
    
    /**
    * List all company projects
    *
    * @access public
    * @param void
    * @return null
    */
    function projects() {
      tpl_assign('projects', logged_user()->getProjects());
    } // projects

    /**
    * Display time management tool
    *
    * @access public
    * @param void
    * @return null
    */
    function time() {
      if (plugin_active('time')) {
        tpl_assign('projects', logged_user()->getProjects());
        tpl_assign('users', owner_company()->getUsers());

        $status = (array_var($_GET, 'status')) ? array_var($_GET, 'status') : 0;
        $times = ProjectTimes::getTimeByStatus($status);

        $redirect_to = array_var($_GET, 'redirect_to');
        if ($redirect_to == '') {
          $redirect_to = get_url('administration', 'time', array('status' => $status));
          $redirect_to = str_replace('&amp;', '&', trim($redirect_to));
        } // if

        tpl_assign('times', $times);
        tpl_assign('redirect_to', $redirect_to);
      } else {
        $this->redirectTo('administration');
      }
    } // time
    
    /**
    * List clients
    *
    * @access public
    * @param void
    * @return null
    */
    function clients() {
      tpl_assign('clients', owner_company()->getClientCompanies());
    } // clients
    
    /**
    * Show configuration index page
    *
    * @param void
    * @return null
    */
    function configuration() {
      $this->addHelper('textile');
      tpl_assign('config_categories', ConfigCategories::getAll());
    } // configuration
    
    /**
    * List all available administration tools
    *
    * @param void
    * @return null
    */
    function tools() {
      tpl_assign('tools', AdministrationTools::getAll());
    } // tools
    
    /**
    * Show upgrade page
    *
    * @param void
    * @return null
    */
    function upgrade() {
      $this->addHelper('textile');
      
      $version_feed = VersionChecker::check(true);
      if (!($version_feed instanceof VersionsFeed)) {
        flash_error(lang('error check for upgrade'));
        $this->redirectTo('administration', 'upgrade');
      } // if
      
      tpl_assign('versions_feed', $version_feed);
    } // upgrade
    
    // ---------------------------------------------------
    //  Tool implementations
    // ---------------------------------------------------
    
    /**
    * Render and execute test mailer form
    *
    * @param void
    * @return null
    */
    function tool_test_email() {
      $tool = AdministrationTools::getByName('test_mail_settings');
      if (!($tool instanceof AdministrationTool)) {
        flash_error(lang('administration tool dnx', 'test_mail_settings'));
        $this->redirectTo('administration', 'tools');
      } // if
      
      $test_mail_data = array_var($_POST, 'test_mail');
      
      tpl_assign('tool', $tool);
      tpl_assign('test_mail_data', $test_mail_data);
      
      if (is_array($test_mail_data)) {
        try {
          $recipient = trim(array_var($test_mail_data, 'recipient'));
          $message = trim(array_var($test_mail_data, 'message'));
          
          $errors = array();
          
          if ($recipient == '') {
            $errors[] = lang('test mail recipient required');
          } else {
            if (!is_valid_email($recipient)) {
              $errors[] = lang('test mail recipient invalid format');
            } // if
          } // if
          
          if ($message == '') {
            $errors[] = lang('test mail message required');
          } // if
          
          if (count($errors)) {
            throw new FormSubmissionErrors($errors);
          } // if
          
          $success = Notifier::sendEmail($recipient, logged_user()->getEmail(), lang('test mail message subject'), $message);
          if ($success) {
            flash_success(lang('success test mail settings'));
          } else {
            flash_error(lang('error test mail settings'));
          } // if
          
          $this->redirectToUrl($tool->getToolUrl());
        } catch(Exception $e) {
          tpl_assign('error', $e);
        } // try
      } // if
    } // tool_test_email
    
    /**
    * Send multiple emails using this simple tool
    *
    * @param void
    * @return null
    */
    function tool_mass_mailer() {
      $tool = AdministrationTools::getByName('mass_mailer');
      if (!($tool instanceof AdministrationTool)) {
        flash_error(lang('administration tool dnx', 'test_mail_settings'));
        $this->redirectTo('administration', 'tools');
      } // if
      
      $massmailer_data = array_var($_POST, 'massmailer');
      
      tpl_assign('tool', $tool);
      tpl_assign('grouped_users', Users::getGroupedByCompany());
      tpl_assign('massmailer_data', $massmailer_data);
      
      if (is_array($massmailer_data)) {
        try {
          $subject = trim(array_var($massmailer_data, 'subject'));
          $message = trim(array_var($massmailer_data, 'message'));
          
          $errors = array();
          
          if ($subject == '') {
            $errors[] = lang('massmailer subject required');
          } // if
          
          if ($message == '') {
            $errors[] = lang('massmailer message required');
          } // if
          
          $users = Users::getAll();
          $recipients = array();
          if (is_array($users)) {
            foreach ($users as $user) {
              if (array_var($massmailer_data, 'user_' . $user->getId()) == 'checked') {
                $recipients[] = Notifier::prepareEmailAddress($user->getEmail(), $user->getDisplayName());
              } // if
            } // foreach
          } // if
          
          if (!count($recipients)) {
            $errors[] = lang('massmailer select recipients');
          } // if
          
          if (count($errors)) {
            throw new FormSubmissionErrors($errors);
          } // if
          
          if (Notifier::sendEmail($recipients, Notifier::prepareEmailAddress(logged_user()->getEmail(), logged_user()->getDisplayName()), $subject, $message)) {
            flash_success(lang('success massmail'));
          } else {
            flash_error(lang('error massmail'));
          } // if
          
          $this->redirectToUrl($tool->getToolUrl());
        } catch(Exception $e) {
          tpl_assign('error', $e);
        } // try
      } // if
    } // tool_mass_mailer

    function system_info() {
      trace(__FILE__,'system_info()');
      $tool = AdministrationTools::getByName('system_info');
      if (!($tool instanceof AdministrationTool)) {
        flash_error(lang('administration tool dnx', 'system_info'));
        $this->redirectTo('administration', 'tools');
      } // if
            
      tpl_assign('tool', $tool);
    } // phpinfo


    function browse_log() {
      trace(__FILE__,'browse_log()');
      $tool = AdministrationTools::getByName('browse_log');
      if (!($tool instanceof AdministrationTool)) {
        flash_error(lang('administration tool dnx', 'browse_log'));
        $this->redirectTo('administration', 'tools');
      } // if
            
      tpl_assign('tool', $tool);

      $pos = isset($_GET['pos']) ? 0 + $_GET['pos'] : -1;
      $dir = isset($_GET['dir']) ? $_GET['dir'] : 'up';

      $lines = array();
      $handle = fopen("cache/log.php", "r");
      //$handle = fopen("AdministrationController.class.php", "r");
      if ($handle) {
        if ($pos<0) {
          fseek($handle,0,SEEK_END); // Seek to the end
          $pos = ftell($handle);
        }
        $pos = ($dir=='up') ? $pos - 4096 : $pos;  
        fseek($handle,$pos,SEEK_SET); // Seek to the position
        $lines = explode( "\n", fread($handle, 4096) ); 
        $pos=ftell($handle);
        fclose($handle);
      }
      //$lines = array( "aaaaa", "bbbbbb" );
      tpl_assign('pos', $pos);
      tpl_assign('lines', $lines);

    } // browse_log

    // ---------------------------------------------------
    //  Plugins
    // ---------------------------------------------------

    /**
    * Displays all local plugins (enabled or not)
    *
    * @param void
    * @return null
    */
    function plugins() {
      trace(__FILE__,'plugins()');
      $plugins = Plugins::getAllPlugins();
      tpl_assign('plugins',$plugins);
      tpl_assign('plugins_keep_data',array());
    } // index
    
    function update_plugins() {
      trace(__FILE__,'update_plugins()');
      $plugins = array_var($_POST,'plugins');
      //$plugins = array('invoices' => '1');
      if (is_null($plugins)) {
        $this->redirectTo('administration','plugins');
      }

      $reference = Plugins::getAllPlugins();
      trace(__FILE__,'update_plugins() - getAllPlugins done');
      $errors = array();
      foreach($plugins as $name => $yes_no) {
        //If it is not a plugin continue
        $plugin_file_path = APPLICATION_PATH.'/plugins/'.$name.'/init.php';
        trace(__FILE__,"update_plugins() - plugin_file_path=[$plugin_file_path]");
        if (!file_exists($plugin_file_path)) continue;
        trace(__FILE__,"update_plugins() - plugin_file_path=[$plugin_file_path] exists");
        // get existing id
        $id = $reference[$name];
        $nicename = ucwords(str_replace('_',' ',$name));
        trace(__FILE__,"update_plugins() - id=$id name=$name nicename=$nicename");
        if ($yes_no && '-' == $id) {
          trace(__FILE__,"update_plugins() - activating [$name]");
          try {
            // Check if plugin exists in database
            $plugin = Plugins::findOne(array('conditions' => array('`name` = ?', $name)));
            trace(__FILE__,"update_plugins() - findOne");
            if ($plugin == NULL) $plugin = new Plugin();
            trace(__FILE__,"update_plugins() - setName");
            $plugin->setName($name);
            trace(__FILE__,"update_plugins() - setInstalled");
            $plugin->setInstalled(true);
            
            DB::beginWork();
            trace(__FILE__,"update_plugins() - including [$plugin_file_path]");
            // get the file loaded here
            include $plugin_file_path;
            
            // get activation routine ready
            trace(__FILE__,"update_plugins() - activate: $name");
            $activate = $name.'_activate';
            if ( function_exists($activate) ) {
              trace(__FILE__,"update_plugins() - calling: $activate");
              $activate();
            }
            
            // save to db now
            $plugin->save();
            DB::commit();
          } catch (Exception $e) {
            trace(__FILE__,'update_plugins() - '.$e->getMessage());
            DB::rollback();
            $errors[] = $nicename.' ('.$e->getMessage().')';
          }
        }
        elseif (!$yes_no && '-' != $id) {
          try
          {
            trace(__FILE__,"update_plugins() - deactivating [$name]");
            $plugin = Plugins::findById($id);
            DB::beginWork();
            $deactivate = $name.'_deactivate';
            if( function_exists($deactivate) ) {
              trace(__FILE__,"update_plugins() - calling $deactivate");
              //Check if user choose to purge data
              if ($plugins[$name."_data"]=="0") {
                trace(__FILE__,"update_plugins() - calling $deactivate(true)");
                $deactivate(true);
              } else {
                $deactivate();
              }
            }
            $plugin->setInstalled(false);
            $plugin->save();
            DB::commit();
          } catch(Exception $e) {
            DB::rollback();
            $errors[] = $nicename.' ('.$e->getMessage().')';
          }
        }
      }
      if ( count($errors) ) {
        flash_error(lang('plugin activation failed', implode(", ",$errors)));
      } else {
        flash_success(lang('plugins updated'));
      }
      $this->redirectTo('administration','plugins');
      
    } // update
 
 } // AdministrationController 
?>