<?php

  /**
  * MessageSubscription class
  * Generated on Mon, 29 May 2006 03:51:15 +0200 by DataObject generation tool
  *
  * @http://www.projectpier.org/
  */
  class MessageSubscription extends BaseMessageSubscription {
  
    /**
    * User who is subscribed to this message
    *
    * @var User
    */
    private $user;
    
    /**
    * Message
    *
    * @var ProjectMessage
    */
    private $message;
    
    /**
    * Return user object
    *
    * @param void
    * @return User
    */
    function getUser() {
      if (is_null($this->user)) {
        $this->user = Users::findById($this->getUserId());
      }
      return $this->user;
    } // getUser
    
    /**
    * Return message object
    *
    * @param void
    * @return ProjectMessage
    */
    function getMessage() {
      if (is_null($this->message)) {
        $this->message = ProjectMessages::findById($this->getMessageId());
      }
      return $this->message;
    } // getMessage
    
  } // MessageSubscription 

?>