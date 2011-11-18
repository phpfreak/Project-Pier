<?php

  /**
  * Notifier class has purpose of sending various notification to users. Primary
  * notification method is email
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class Notifier {
    
    /** Supported transports **/
    const MAIL_TRANSPORT_MAIL = 'mail()';
    const MAIL_TRANSPORT_SMTP = 'smtp';
    
    /** Secure connection values **/
    const SMTP_SECURE_CONNECTION_NO  = 'no';
    const SMTP_SECURE_CONNECTION_SSL = 'ssl';
    const SMTP_SECURE_CONNECTION_TLS = 'tls';
    
    /**
    * Cached value of exchange compatible config option
    *
    * @var boolean
    */
    static public $exchange_compatible = null;
    
    /**
    * Reset password and send forgot password email to the user
    *
    * @param User $user
    * @return boolean
    * @throws NotifierConnectionError
    */
    static function forgotPassword(User $user) {
      $administrator = owner_company()->getCreatedBy();
      
      $new_password = $user->resetPassword(true);
      tpl_assign('user', $user);
      tpl_assign('new_password', $new_password);

      $from = $administrator->getDisplayName() . ' ' . config_option('site_name', '');
      
      return self::sendEmail(
        self::prepareEmailAddress($user->getEmail(), $user->getDisplayName()),
        self::prepareEmailAddress($administrator->getEmail(), $from),
        lang('your password'),
        tpl_fetch(get_template_path('forgot_password', 'notifier'))
      ); // send
    } // forgotPassword
    
    /**
    * Send new account notification email to the user whose accout has been created 
    * (welcome message)
    *
    * @param User $user
    * @param string $raw_password
    * @return boolean
    * @throws NotifierConnectionError
    */
    static function newUserAccount(User $user, $raw_password) {
      tpl_assign('new_account', $user);
      tpl_assign('raw_password', $raw_password);

      $from = $user->getCreatedByDisplayName() . ' ' . config_option('site_name', '');
      
      return self::sendEmail(
        self::prepareEmailAddress($user->getEmail(), $user->getDisplayName()),
        self::prepareEmailAddress($user->getCreatedBy()->getEmail(), $from),
        lang('your account created'),
        tpl_fetch(get_template_path('new_account', 'notifier'))
      ); // send
    } // newUserAccount

    /**
    * Send account update notification email to the user whose account has been updated
    *
    * @param User $user
    * @param string $raw_password
    * @return boolean
    * @throws NotifierConnectionError
    */
    static function updatedUserAccount(User $user, $raw_password) {
      tpl_assign('updated_account', $user);
      tpl_assign('raw_password', $raw_password);
      
      return self::sendEmail(
        self::prepareEmailAddress($user->getEmail(), $user->getDisplayName()),
        self::prepareEmailAddress($user->getUpdatedBy()->getEmail(), $user->getUpdatedByDisplayName()),
        lang('your account updated'),
        tpl_fetch(get_template_path('updated_account', 'notifier'))
      ); // send
    } // updatedUserAccount
  
    /**
    * Send new task notification to the list of users ($people)
    *
    * @param ProjectMessage $message New message
    * @param array $people
    * @return boolean
    * @throws NotifierConnectionError
    */
    static function newTask(ProjectTask $task, $people) {
      if(!is_array($people) || !count($people)) {
        return; // nothing here...
      } // if
      
      tpl_assign('new_task', $task);

      $recipients = array();
      foreach($people as $user) {
        $recipients[] = self::prepareEmailAddress($user->getEmail(), $user->getDisplayName());
      } // foreach
      return self::sendEmail(
        $recipients,
        self::prepareEmailAddress($task->getCreatedBy()->getEmail(), $task->getCreatedByDisplayName()),
        $task->getProject()->getName() . ' - ' . lang('new task') . ' - ' . $task->getObjectName(),
        tpl_fetch(get_template_path('new_task', 'notifier'))
      ); // send
    } // newTask
  
    /**
    * Send new message notification to the list of users ($people)
    *
    * @param ProjectMessage $message New message
    * @param array $people
    * @return boolean
    * @throws NotifierConnectionError
    */
    static function newMessage(ProjectMessage $message, $people) {
      if (!is_array($people) || !count($people)) {
        return; // nothing here...
      } // if
      
      tpl_assign('new_message', $message);
      
      $recipients = array();
      foreach ($people as $user) {
        $recipients[] = self::prepareEmailAddress($user->getEmail(), $user->getDisplayName());
      } // foreach
      
      return self::sendEmail(
        $recipients,
        self::prepareEmailAddress($message->getCreatedBy()->getEmail(), $message->getCreatedByDisplayName()),
        $message->getProject()->getName() . ' - ' . $message->getTitle(),
        tpl_fetch(get_template_path('new_message', 'notifier'))
      ); // send
    } // newMessage

    /**
    * Send new message notification to the list of users ($people)
    *
    * @param ProjectFile $file New file
    * @param array $people
    * @return boolean
    * @throws NotifierConnectionError
    */
    static function newFile(ProjectFile $file, $people) {
      if (!is_array($people) || !count($people)) {
        return; // nothing here...
      } // if
      
      tpl_assign('new_file', $file);
      
      $recipients = array();
      foreach ($people as $user) {
        $recipients[] = self::prepareEmailAddress($user->getEmail(), $user->getDisplayName());
      } // foreach
      
      return self::sendEmail(
        $recipients,
        self::prepareEmailAddress($file->getCreatedBy()->getEmail(), $file->getCreatedByDisplayName()),
        $file->getProject()->getName() . ' - ' . $file->getFilename(),
        tpl_fetch(get_template_path('new_file', 'notifier'))
      ); // send
    } // newFile

    /**
    * Send ticket notification to the list of users ($people)
    *
    * @param ProjectTicket $ticket New ticket
    * @param array $people
    * @param string $template template to send notification
    * @param User $user user who send the notification
    * @return boolean
    * @throws NotifierConnectionError
    */
    static function ticket(ProjectTicket $ticket, $people, $template, $user) {
      if(!is_array($people) || !count($people)) {
        return; // nothing here...
      } // if

      $recipients = array();
      foreach($people as $subscriber) {
        if($subscriber->getId() == $user->getId()) {
          continue; // skip comment author
        } // if

        $recipients[] = self::prepareEmailAddress($subscriber->getEmail(), $subscriber->getDisplayName());
      } // foreach

      if(!count($recipients)) {
        return true; // no recipients
      } // if

      tpl_assign('ticket', $ticket);

      return self::sendEmail(
        $recipients,
        self::prepareEmailAddress($user->getEmail(), $user->getDisplayName()),
        $ticket->getProject()->getName() . ' - ' . $ticket->getSummary(),
        tpl_fetch(get_template_path($template, 'notifier'))
      ); // send
    } // ticket

    /**
    * Send some files attached to ticket notification to ticket subscribers
    *
    * @param ProjectTicket $ticket
    * @param array $attached_files Files attached to ticket
    * @return boolean
    * @throws NotifierConnectionError
    */
    static function attachFilesToTicket(ProjectTicket $ticket, $attached_files) {
      $all_subscribers = $ticket->getSubscribers();
      if(!is_array($all_subscribers)) {
        return true; // no subscribers
      } // if
      
      $recipients = array();
      foreach($all_subscribers as $subscriber) {
        if($subscriber->getId() == $ticket->getUpdatedById()) {
          continue; // skip comment author
        } // if
        
        $recipients[] = self::prepareEmailAddress($subscriber->getEmail(), $subscriber->getDisplayName());
      } // foreach
      
      if(!count($recipients)) {
        return true; // no recipients
      } // if
      
      tpl_assign('ticket', $ticket);
      tpl_assign('attached_files', $attached_files);
      
      return self::sendEmail(
        $recipients,
        self::prepareEmailAddress($ticket->getUpdatedBy()->getEmail(), $ticket->getUpdatedBy()->getDisplayName()),
        $ticket->getProject()->getName() . ' - ' . $ticket->getSummary(),
        tpl_fetch(get_template_path('attach_files_ticket', 'notifier'))
      ); // send
    } // attachFilesToTicket

    /**
    * Send some files detached from ticket notification to ticket subscribers
    *
    * @param ProjectTicket $ticket
    * @param array $detached_files Files detached from ticket
    * @return boolean
    * @throws NotifierConnectionError
    */
    static function detachFilesFromTicket(ProjectTicket $ticket, $detached_files) {
      $all_subscribers = $ticket->getSubscribers();
      if (!is_array($all_subscribers)) {
        return true; // no subscribers
      } // if
      
      $recipients = array();
      foreach ($all_subscribers as $subscriber) {
        if ($subscriber->getId() == $ticket->getUpdatedById()) {
          continue; // skip comment author
        } // if
        
        $recipients[] = self::prepareEmailAddress($subscriber->getEmail(), $subscriber->getDisplayName());
      } // foreach
      
      if (!count($recipients)) {
        return true; // no recipients
      } // if
      
      tpl_assign('ticket', $ticket);
      tpl_assign('detached_files', $detached_files);
      
      return self::sendEmail(
        $recipients,
        self::prepareEmailAddress($ticket->getUpdatedBy()->getEmail(), $ticket->getUpdatedBy()->getDisplayName()),
        $ticket->getProject()->getName() . ' - ' . $ticket->getSummary(),
        tpl_fetch(get_template_path('detach_files_ticket', 'notifier'))
      ); // send
    } // detachFilesFromTicket

    /**
    * Send new comment notification to ticket subscriber
    *
    * @param TicketComment $comment
    * @return boolean
    * @throws NotifierConnectionError
    */
    static function newTicketComment(Comment $comment) {
      $ticket = $comment->getObject();
      if(!($ticket instanceof ProjectTicket)) {
        throw new Error('Invalid comment object');
      } // if

      return self::newComment($comment, $ticket->getSubscribers());
    } // newTicketComment
    
    /**
    * Send new comment notification to message subscriber
    *
    * @param MessageComment $comment
    * @return boolean
    * @throws NotifierConnectionError
    */
    static function newMessageComment(Comment $comment) {
      $message = $comment->getObject();
      if (!($message instanceof ProjectMessage)) {
        throw new Error('Invalid comment object');
      } // if
      
      $all_subscribers = $message->getSubscribers();
      return self::newComment($comment, $message->getSubscribers());
    } // newMessageComment


    /**
    * Send new comment notification to subscribers
    *
    * @access private
    * @param Comment $comment
    * @param string $title title of object for subject
    * @param array $all_subscribers subscribers
    * @return boolean
    * @throws NotifierConnectionError
    */
    static function newComment(Comment $comment, $all_subscribers) {
      if (!is_array($all_subscribers)) {
        return true; // no subscribers
      } // if
      
      $recipients = array();
      foreach ($all_subscribers as $subscriber) {
        //if ($subscriber->getId() == $comment->getCreatedById()) {
        //  continue; // skip comment author
        //} // if
        
        if ($comment->isPrivate() || $comment->getObject()->isPrivate()) {
          if ($subscriber->isMemberOfOwnerCompany()) {
            $recipients[] = self::prepareEmailAddress($subscriber->getEmail(), $subscriber->getDisplayName());
          } // if
        } else {
          $recipients[] = self::prepareEmailAddress($subscriber->getEmail(), $subscriber->getDisplayName());
        } // of
      } // foreach
      
      if (!count($recipients)) {
        return true; // no recipients
      } // if
      
      tpl_assign('new_comment', $comment);
      
      return self::sendEmail(
        $recipients,
        self::prepareEmailAddress($comment->getCreatedBy()->getEmail(), $comment->getCreatedByDisplayName()),
        $comment->getProject()->getName() . ' - ' . $comment->getObject()->getTitle(),
        tpl_fetch(get_template_path('new_comment', 'notifier'))
      ); // send
    } // newComment



    /**
    * Tests to see if $new_user is not the same as $old_user
    * if users are different return true so a notification can be sent
    * otherwise return false so the notification can be avoided 
    *
    * @param $new_user (optional) Newly assigned user (if applicable)
    * @param $old_user (optional) Previously assigned user (if applicable)
    * @return boolean
    */
    static function notifyNeeded($new_user, $old_user) {
      if ($old_user instanceof User) {
        // We have a new owner and it is different than old owner
        if ($new_user instanceof User && $new_user->getId() <> $old_user->getId()) {
          return true;
        }
      } else {
          // We have new owner
          if ($new_user instanceof User) {
            return true;
          }
      } // if
      return false;
    }
    
    // ---------------------------------------------------
    //  Milestone
    // ---------------------------------------------------
    
    /**
    * Milestone has been assigned to the user
    *
    * @param ProjectMilestone $milestone
    * @return boolean
    * @throws NotifierConnectionError
    */
    function milestoneAssigned(ProjectMilestone $milestone) {
      if ($milestone->isCompleted()) {
        return true; // milestone has been already completed...
      } // if
      if (!($milestone->getAssignedTo() instanceof User)) {
        return true; // not assigned to user
      } // if
      
      tpl_assign('milestone_assigned', $milestone);
      
      return self::sendEmail(
        self::prepareEmailAddress($milestone->getAssignedTo()->getEmail(), $milestone->getAssignedTo()->getDisplayName()),
        self::prepareEmailAddress($milestone->getCreatedBy()->getEmail(), $milestone->getCreatedByDisplayName()),
        $milestone->getProject()->getName() . ' - ' . lang('milestone assigned to you') . ' - ' . $milestone->getName(),
        tpl_fetch(get_template_path('milestone_assigned', 'notifier'))
      ); // send
    } // milestoneAssigned

    /**
    * Task has been assigned to the user
    *
    * @param ProjectTask $task
    * @return boolean
    * @throws NotifierConnectionError
    */
    function taskAssigned(ProjectTask $task) {
      if ($task->isCompleted()) {
        return true; // task has been already completed...
      } // if
      if (!($task->getAssignedTo() instanceof User)) {
        return true; // not assigned to user
      } // if
      if ($task->getCreatedBy() instanceof User) {
        $from = self::prepareEmailAddress($task->getCreatedBy()->getEmail(), $task->getCreatedByDisplayName()); 
      } else {
        $from = self::prepareEmailAddress(logged_user()->getEmail(), logged_user()->getDisplayName()); 
      } // if

      tpl_assign('task_assigned', $task);
      
      return self::sendEmail(
        self::prepareEmailAddress($task->getAssignedTo()->getEmail(), $task->getAssignedTo()->getDisplayName()),
        $from,
        $task->getProject()->getName() . ' - ' . lang('task assigned to you') . ' - ' . $task->getObjectName(),
        tpl_fetch(get_template_path('task_assigned', 'notifier'), 'html', '')
      ); // send
    }

    /**
    * Send new comment notification to selected users, if not message (because message is already treated and can subscribre/unsubscribe)
    *
    * @param comment $comment
    * @return boolean
    * @throws NotifierConnectionError
    */
    static function newOtherComment(Comment $comment, $people) {
      if (!is_array($people) || !count($people)) {
        return; // nothing here...
      } // if
    
      // normally, if comment on message, shouldn't be using this function by the normal subscription
      if (($comment->getObject() instanceof ProjectMessage)) {
        throw new Error('Invalid comment object');
      } // if
              
      if (!is_array($people)) {
        return true; // no subscribers
      } // if
      
      $recipients = array();
      foreach ($people as $subscriber) {
        //if ($subscriber->getId() == $comment->getCreatedById()) {
        //  continue; // skip comment author
        //} // if
        
        if ($comment->isPrivate() || $comment->getObject()->isPrivate()) {
          if ($subscriber->isMemberOfOwnerCompany()) {
            $recipients[] = self::prepareEmailAddress($subscriber->getEmail(), $subscriber->getDisplayName());
          } // if
        } else {
          $recipients[] = self::prepareEmailAddress($subscriber->getEmail(), $subscriber->getDisplayName());
        } // of
      } // foreach
      
      if (!count($recipients)) {
        return true; // no recipients
      } // if
      
      tpl_assign('new_comment', $comment);
      
      return self::sendEmail(
        $recipients,
        self::prepareEmailAddress($comment->getCreatedBy()->getEmail(), $comment->getCreatedByDisplayName()),
        $comment->getProject()->getName(),
        tpl_fetch(get_template_path('new_comment', 'notifier'))
      ); // send
    } // newOtherComment

    // ---------------------------------------------------
    //  Util functions
    // ---------------------------------------------------
    
    /**
    * This function will prepare email address. It will return $name <$email> if both 
    * params are presend and we are not in exchange compatibility mode. In other case 
    * it will just return email
    *
    * @param string $email
    * @param string $name
    * @return string
    */
    static function prepareEmailAddress($email, $name = null) {
      if (trim($name) && !self::getExchangeCompatible()) {
        return trim($name) . ' <' . trim($email) . '>';
      } else {
        return trim($email);
      } // if
    } // prepareEmailAddress
    
    /**
    * Returns true if exchange compatible config option is set to true
    *
    * @param void
    * @return boolean
    */
    static function getExchangeCompatible() {
      if (is_null(self::$exchange_compatible)) {
        self::$exchange_compatible = config_option('exchange_compatible', false);
      } // if
      return self::$exchange_compatible;
    } // getExchangeCompatible
    
    /**
    * Send an email using Swift (send commands)
    * 
    * @param string to_address
    * @param string from_address
    * @param string subject
    * @param string body, optional
    * @param string content-type,optional
    * @param string content-transfer-encoding,optional
    * @return bool successful
    */
    static function sendEmail($to, $from, $subject, $body = false, $type = 'text/plain', $encoding = '8bit') {
    //static function sendEmail($to, $from, $subject, $body = false, $type = 'text/html', $encoding = '') {
   
      Env::useLibrary('swift');
      
      $mailer = self::getMailer();
      if (!($mailer instanceof Swift)) {
        throw new NotifierConnectionError();
      } // if

     
      /** 
      * Set name address in ReplyTo, some MTA think we're usurpators
      * (which is quite true actually...)
      */
      if (config_option('mail_use_reply_to', 0)==1) {
        $i = strpos($from, ' <');
        $name = '?';
        if ($i!==false) {
          $name = substr($from, 0, $i);
        }
        $mailer->setReplyTo($from);
        $mail_from = trim(config_option('mail_from'));
        if ($mail_from=='') {
          $mail_from = 'projectpier@'.$_SERVER['SERVER_NAME'];
        }
        $from = "$name <$mail_from>";
      }

      // from must be address known on server when authentication is selected
      $smtp_authenticate = config_option('smtp_authenticate', false);
      if ($smtp_authenticate) $from = config_option('smtp_username');

      trace("mailer->send($to, $from, $subject, $body, $type, $encoding)");

      $result = $mailer->send($to, $from, $subject, $body, $type, $encoding);
      $mailer->close();
      
      return $result;
    } // sendEmail
    
    /**
    * This function will return SMTP connection. It will try to load options from 
    * config and if it fails it will use settings from php.ini
    *
    * @param void
    * @return Swift
    */
    static function getMailer() {
      $mail_transport_config = config_option('mail_transport', self::MAIL_TRANSPORT_MAIL);
      
      // Emulate mail() - use NativeMail
      if ($mail_transport_config == self::MAIL_TRANSPORT_MAIL) {
        $mailer = new Swift(new Swift_Connection_NativeMail());
        return $mailer->isConnected() ? $mailer : null;
        
      // Use SMTP server
      } elseif ($mail_transport_config == self::MAIL_TRANSPORT_SMTP) {
        
        // Load SMTP config
        $smtp_server = config_option('smtp_server');
        $smtp_port = config_option('smtp_port', 25);
        $smtp_secure_connection = config_option('smtp_secure_connection', self::SMTP_SECURE_CONNECTION_NO);
        $smtp_authenticate = config_option('smtp_authenticate', false);
        if ($smtp_authenticate) {
          $smtp_username = config_option('smtp_username');
          $smtp_password = config_option('smtp_password');
        } // if
        
        switch ($smtp_secure_connection) {
          case self::SMTP_SECURE_CONNECTION_SSL:
            $transport = SWIFT_SSL;
            break;
          case self::SMTP_SECURE_CONNECTION_TLS:
            $transport = SWIFT_TLS;
            break;
          default:
            $transport = SWIFT_OPEN;
        } // switch
        
        $mailer = new Swift(new Swift_Connection_SMTP($smtp_server, $smtp_port, $transport));
        if (!$mailer->isConnected()) {
          return null;
        } // if
        
        $mailer->setCharset('UTF-8');
        
        if ($smtp_authenticate) {
          if ($mailer->authenticate($smtp_username, $smtp_password)) {
            return $mailer;
          } else {
            return null;
          } // if
        } else {
          return $mailer;
        } // if
        
      // Somethings wrong here...
      } else {
        return null;
      } // if
    } // getMailer
  
  } // Notifier  
?>