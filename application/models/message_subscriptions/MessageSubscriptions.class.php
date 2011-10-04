<?php

  /**
  * MessageSubscriptions, generated on Mon, 29 May 2006 03:51:15 +0200 by 
  * DataObject generation tool
  *
  * @http://www.projectpier.org/
  */
  class MessageSubscriptions extends BaseMessageSubscriptions {
  
    /**
    * Return array of users that are subscribed to this specific message
    *
    * @param ProjectMessage $message
    * @return array
    */
    static function getUsersByMessage(ProjectMessage $message) {
      $users = array();
      $subscriptions = MessageSubscriptions::findAll(array(
        'conditions' => '`message_id` = ' . DB::escape($message->getId())
      )); // findAll
      if (is_array($subscriptions)) {
        foreach ($subscriptions as $subscription) {
          $user = $subscription->getUser();
          if ($user instanceof User) {
            $users[] = $user;
          } // if
        } // foreach
      } // if
      return count($users) ? $users : null;
    } // getUsersByMessage
    
    /**
    * Return array of messages that $user is subscribed to
    *
    * @param User $user
    * @return array
    */
    static function getMessagesByUser(User $user) {
      $messages = array();
      $subscriptions = MessageSubscriptions::findAll(array(
        'conditions' => '`user_id` = ' . DB::escape($user->getId())
      )); // findAll
      if (is_array($subscriptions)) {
        foreach ($subscriptions as $subscription) {
          $message = $subscription->getMessage();
          if ($message instanceof ProjectMessage) {
            $messages[] = $message;
          }
        } // foreach
      } // if
      return count($messages) ? $messages : null;
    } // getMessagesByUser
    
    /**
    * Clear subscriptions by message
    *
    * @param ProjectMessage $message
    * @return boolean
    */
    static function clearByMessage(ProjectMessage $message) {
      return MessageSubscriptions::delete('`message_id` = ' . DB::escape($message->getId()));
    } // clearByMessage
    
    /**
    * Clear subscriptions by user
    *
    * @param User $user
    * @return boolean
    */
    static function clearByUser(User $user) {
      return MessageSubscriptions::delete('`user_id` = ' . DB::escape($user->getId()));
    } // clearByUser
    
  } // MessageSubscriptions 

?>