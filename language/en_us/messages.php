<?php

  /**
  * Array of messages file (error, success message, status...)
  *
  * @http://www.projectpier.org/
  */

  return array(
  
    // Empty, dnx etc
    'project dnx' => 'Requested project does not exist in database',
    'message dnx' => 'Requested message does not exist',
    'no comments in message' => 'There are no comments on this message',
    'no comments associated with object' => 'There are no comments posted for this object',
    'no status updates associated with object' => 'There are no status updates posted for this object',
    'no messages in project' => 'There are no messages in this project',
    'no subscribers' => 'There are no users subscribed to this message',
    'no contacts in company' => 'There are no contacts in this company',

    'no activities in project' => 'There are no activities logged for this project',
    'comment dnx' => 'Requested comment does not exist',
    'milestone dnx' => 'Requested milestone does not exist',
    'time dnx' => 'Requested time record does not exist',
    'task list dnx' => 'Requested task list does not exist',
    'task dnx' => 'Requested task does not exist',
    'no milestones in project' => 'There are no milestones in this project',
    'no active milestones in project' => 'There are no active milestones in this project',
    'empty milestone' => 'This milestone is empty. You can add a <a href="%s">message</a> or a <a href="%s">task list</a> to it at any time',
    'no logs for project' => 'There are no log entries related to this project',
    'no recent activities' => 'There are no recent activities logged in the database',
    'no open task lists in project' => 'There are no open task lists in this project',
    'no completed task lists in project' => 'There are no completed task lists in this project',
    'no open task in task list' => 'There are no tasks in this list',
    'no projects in db' => 'There are no defined projects',
    'no projects owned by company' => 'There are no projects owned by this company',
    'no projects started' => 'There are no started projects',
    'no active projects in db' => 'There are no active projects',
    'no new objects in project since last visit' => 'There are no new objects in this project since your last visit',
    'no clients in company' => 'Your company does not have any registered clients',
    'no contacts in company' => 'There are no contacts in this company',
    'no users in company' => 'There are no users in this company',
    'client dnx' => 'Selected client company does not exist',
    'company dnx' => 'Selected company does not exist',
    'contact dnx' => 'Selected contact does not exist',
    'user dnx' => 'Requested user does not exist in database',
    'avatar dnx' => 'Avatar does not exist',
    'no current avatar' => 'No avatar uploaded',
    'no current logo' => 'No logo uploaded',
    'user not on project' => 'Selected user is not involved in selected project',
    'company not on project' => 'Selected company is not involved in selected project',
    'user cant be removed from project' => 'Selected user can\'t be removed from project',
    'tag dnx' => 'Requested tag does not exist',
    'no tags used on projects' => 'There are no tags used in this project',
    'no forms in project' => 'There are no forms in this project',
    'project form dnx' => 'Requested project form does not exist in database',
    'related project form object dnx' => 'Related form object does not exist in database',
    'no my tasks' => 'There are no tasks assigned to you',
    'no search result for' => 'There are no objects that match "<strong>%s</strong>"',
    'config category dnx' => 'Configuration category you requested does not exists',
    'config category is empty' => 'Selected configuration category is empty',
    'email address not in use' => '%s is not in use',
    'no administration tools' => 'There are no registered administration tools in the database',
    'administration tool dnx' => 'Administration tool "%s" does not exists',
    'about to delete' => 'You are about to delete',
    'about to move' => 'You are about to move',
    'no image functions' => 'No image functions (install GD library)',
    'no ldap functions' => 'No LDAP functions (install ldap extension)',

    
    // Success
    'success add project' => 'Project %s has been added successfully',
    'success copy project' => 'Project %s has been copied to %s',
    'success edit project' => 'Project %s has been updated',
    'success delete project' => 'Project %s has been deleted',
    'success complete project' => 'Project %s has been completed',
    'success open project' => 'Project %s has been reopened',
    'success edit project logo' => 'Project logo has been updated',
    'success delete project logo' => 'Project logo has been deleted',
    'success edit logo' => 'Logo has been updated',
    'success delete logo' => 'Logo has been deleted',
    
    'success add milestone' => 'Milestone \'%s\' has been created successfully',
    'success edit milestone' => 'Milestone \'%s\' has been updated successfully',
    'success deleted milestone' => 'Milestone \'%s\' has been deleted successfully',

    'success add time' => 'Time \'%s\' has been created successfully',
    'success edit time' => 'Time \'%s\' has been updated successfully',
    'success deleted time' => 'Time \'%s\' has been deleted successfully',
    
    'success add message' => 'Message %s has been added successfully',
    'success edit message' => 'Message %s has been updated successfully',
    'success move message' => 'Message \'%s\' has been moved from project \'%s\' to project \'%s\'',
    'success deleted message' => 'Message \'%s\' and all of its comments have been deleted successfully',
    
    'success add comment' => 'Comment has been posted successfully',
    'success edit comment' => 'Comment has been updated successfully',
    'success delete comment' => 'Comment has been delete successfully',
    
    'success add task list' => 'Task list \'%s\' has been added',
    'success edit task list' => 'Task list \'%s\' has been updated',
    'success copy task list' => 'Task list \'%s\' has been copied to \'%s\' with %s tasks',
    'success move task list' => 'Task list \'%s\' has been moved from project \'%s\' to project \'%s\'',
    'success delete task list' => 'Task list \'%s\' has been deleted',
    
    'success add task' => 'Selected task has been added',
    'success edit task' => 'Selected task has been updated',
    'success delete task' => 'Selected task has been deleted',
    'success complete task' => 'Selected task has been completed',
    'success open task' => 'Selected task has been reopened',
    'success n tasks updated' => '%s tasks updated',
     
    'success add client' => 'Client company %s has been added',
    'success edit client' => 'Client company %s has been updated',
    'success delete client' => 'Client company %s has been deleted',
    
    'success edit company' => 'Company data has been updated',
    'success edit company logo' => 'Company logo has been updated',
    'success delete company logo' => 'Company logo has been deleted',
    
    'success add user' => 'User %s has been added successfully',
    'success edit user' => 'User %s has been updated successfully',
    'success delete user' => 'User %s has been deleted successfully',
    
    'success add contact' => 'Contact %s has been added successfully',
    'success edit contact' => 'Contact %s has been updated successfully',
    'success delete contact' => 'Contact %s has been deleted successfully',
    
    'success update project permissions' => 'Project permissions have been updated successfully',
    'success remove user from project' => 'User has been successfully removed from the project',
    'success remove company from project' => 'Company has been successfully removed from the project',
    
    'success update profile' => 'Profile has been updated',
    'success edit avatar' => 'Avatar has been updated successfully',
    'success delete avatar' => 'Avatar has been deleted successfully',
    
    'success hide welcome info' => 'Welcome info box has been successfully hidden',
    
    'success complete milestone' => 'Milestone \'%s\' has been completed',
    'success open milestone' => 'Milestone \'%s\' has been reopened',
    
    'success subscribe to message' => 'You have been successfully subscribed to this message',
    'success unsubscribe to message' => 'You have been successfully unsubscribed from this message',
   
    'success add project form' => 'Form \'%s\' has been added',
    'success edit project form' => 'Form \'%s\' has been updated',
    'success delete project form' => 'Form \'%s\' has been deleted',
    
    'success update config category' => '%s configuration values have been updated',
    'success forgot password' => 'Your password has been emailed to you',
    
    'success test mail settings' => 'Test mail has been successfully sent',
    'success massmail' => 'Email has been sent',
    
    'success update company permissions' => 'Company permissions updated successfully. %s records updated',
    'success user permissions updated' => 'User permissions have been updated',
    
    // Failures
    'error form validation' => 'Failed to save object because some of its properties are not valid',
    'error delete owner company' => 'Owner company can\'t be deleted',
    'error delete message' => 'Failed to delete selected message',
    'error update message options' => 'Failed to update message options',
    'error delete comment' => 'Failed to delete selected comment',
    'error delete milestone' => 'Failed to delete selected milestone',
    'error delete time' => 'Failed to delete selected time',
    'error complete task' => 'Failed to complete selected task',
    'error open task' => 'Failed to reopen selected task',
    'error delete project' => 'Failed to delete selected project',
    'error complete project' => 'Failed to complete selected project',
    'error open project' => 'Failed to reopen selected project',
    'error edit project logo' => 'Failed to update project logo',
    'error delete project logo' => 'Failed to delete project logo',
    'error edit logo' => 'Failed to update logo %s',
    'error delete logo' => 'Failed to delete logo %s',
    'error delete client' => 'Failed to delete selected client company',
    'error delete user' => 'Failed to delete selected user',
    'error delete contact' => 'Failed to delete selected contact',
    'error update project permissions' => 'Failed to update project permissions',
    'error remove user from project' => 'Failed to remove user from project',
    'error remove company from project' => 'Failed to remove company from project',
    'error edit avatar' => 'Failed to edit avatar',
    'error delete avatar' => 'Failed to delete avatar',
    'error hide welcome info' => 'Failed to hide welcome info',
    'error complete milestone' => 'Failed to complete selected milestone',
    'error open milestone' => 'Failed to reopen selected milestone',
    'error edit company logo' => 'Failed to update company logo',
    'error delete company logo' => 'Failed to delete company logo',
    'error subscribe to message' => 'Failed to subscribe to selected message',
    'error unsubscribe to message' => 'Failed to unsubscribe from selected message',

    'error move message' => 'Failed to move selected message %s',
    'error move task list' => 'Failed to move selected task list',
    'error delete task list' => 'Failed to delete selected task list',
    'error delete task' => 'Failed to delete selected task',
    'error delete category' => 'Failed to delete selected category',
    'error check for upgrade' => 'Failed to check for a new version',
    'error test mail settings' => 'Failed to send test message',
    'error massmail' => 'Failed to send email',
    'error owner company has all permissions' => 'Owner company has all permissions',
    
    // Access or data errors
    'no access permissions' => 'You don\'t have permission to access the requested page',
    'invalid request' => 'Invalid request!',
    
    // Confirmation
    'confirm delete message' => 'Are you sure that you want to delete this message?',
    'confirm delete milestone' => 'Are you sure that you want to delete this milestone?',
    'confirm delete task list' => 'Are you sure that you want to delete this task list and all of its tasks?',
    'confirm delete task' => 'Are you sure that you want to delete this task?',
    'confirm delete comment' => 'Are you sure that you want to delete this comment?',
    'confirm delete category' => 'Are you sure that you want to delete this category?',
    'confirm delete project' => 'Are you sure that you want to delete this project and all related data (messages, tasks, milestones, files...)?',
    'confirm delete project logo' => 'Are you sure that you want to delete this logo?',
    'confirm delete logo' => 'Are you sure that you want to delete this logo?',
    'confirm complete project' => 'Are you sure that you want to mark this project as finished? All project actions will be locked',
    'confirm open project' => 'Are you sure that you want to mark this project as open? This will unlock all project actions',
    'confirm delete client' => 'Are you sure that you want to delete the selected client company and all of its users?',
    'confirm delete user' => 'Are you sure that you want to delete this user account?',
    'confirm delete contact' => 'Are you sure that you want to delete this contact?',
    'confirm reset people form' => 'Are you sure that you want to reset this form? All modifications you made will be lost!',
    'confirm remove user from project' => 'Are you sure that you want to remove this user from the project?',
    'confirm remove company from project' => 'Are you sure that you want to remove this company from the project?',
    'confirm logout' => 'Are you sure that you want to log out?',
    'confirm delete current avatar' => 'Are you sure that you want to delete this avatar?',
    'confirm delete company logo' => 'Are you sure that you want to delete this logo?',
    'confirm subscribe' => 'Are you sure that you want to subscribe to this message? You will receive an email every time someone (except you) posts a comment on this message.',
    'confirm reset form' => 'Are you sure that you want to reset this form?',
    
    // Errors...
    'system error message' => 'We are sorry, but a fatal error prevented ProjectPier from executing your request. An Error Report has been sent to the administrator.',
    'execute action error message' => 'We are sorry, but ProjectPier is not currently able to execute your request. An Error Report has been sent to the administrator.',
    
    // Log
    'log add projectmessages' => 'Message \'%s\' added',
    'log edit projectmessages' => 'Message \'%s\' updated',
    'log delete projectmessages' => 'Message \'%s\' deleted',
    
    'log add comments' => 'Comment \'%s\' added',
    'log edit comments' => 'Comment \'%s\' updated',
    'log delete comments' => 'Comment \'%s\' deleted',
    
    'log add projectmilestones' => 'Milestone \'%s\' added',
    'log edit projectmilestones' => 'Milestone \'%s\' updated',
    'log delete projectmilestones' => 'Milestone \'%s\' deleted',
    'log close projectmilestones' => 'Milestone \'%s\' finished',
    'log open projectmilestones' => 'Milestone \'%s\' reopened',

    'log add projecttimes' => '\'%s\' added', 
    'log edit projecttimes' => '\'%s\' updated',
    'log delete projecttimes' => '\'%s\' deleted',
    
    'log add projecttasklists' => 'Tasklist \'%s\' added',
    'log edit projecttasklists' => 'Tasklist \'%s\' updated',
    'log delete projecttasklists' => 'Tasklist \'%s\' deleted',
    'log close projecttasklists' => 'Tasklist \'%s\' closed',
    'log open projecttasklists' => 'Tasklist \'%s\' opened',
    
    'log add projecttasks' => 'Task \'%s\' added',
    'log edit projecttasks' => 'Task \'%s\' updated',
    'log delete projecttasks' => 'Task \'%s\' deleted',
    'log close projecttasks' => 'Task \'%s\' closed',
    'log open projecttasks' => 'Task \'%s\' opened',
  
    'log add projectforms' => 'Form \'%s\' added',
    'log edit projectforms' => 'Form \'%s\' updated',
    'log delete projectforms' => 'Form \'%s\' deleted',
  
    'log add projects' => 'Project \'%s\' added',
    'log edit projects' => 'Project \'%s\' added',
    'log open projects' => 'Project \'%s\' opened',
    'log close projects' => 'Project \'%s\' opened',
    'log delete projects' => 'Project \'%s\' deleted',

    'log add users' => 'User \'%s\' added',
    'log edit users' => 'User \'%s\' updated',
    'log delete users' => 'User \'%s\' deleted',

    'log add companies' => 'Company \'%s\' added',
    'log edit companies' => 'Company \'%s\' updated',
    'log delete companies' => 'Company \'%s\' deleted',

    'log add contacts' => 'Contact \'%s\' added',
    'log edit contacts' => 'Contact \'%s\' updated',
    'log delete contacts' => 'Contact \'%s\' deleted',

    'log add i18nlocales' => 'Locale \'%s\' added',
    'log edit i18nlocales' => 'Locale \'%s\' updated',
    'log delete i18nlocales' => 'Locale \'%s\' deleted',

    'log add i18localevalues' => 'Locale value \'%s\' added',
    'log edit i18nlocalevalues' => 'Locale value \'%s\' updated',
    'log delete i18nlocalevalues' => 'Locale value \'%s\' deleted',
  ); // array

?>