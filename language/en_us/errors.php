<?php

  /** 
  * Error messages
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */

  // Return langs
  return array(
  
    // General
    'invalid email address' => 'Email address format is not valid',
    'id missing' => 'Required ID value is missing',
   
    // Company validation errors
    'company name required' => 'Company / organization name is required',
    'company homepage invalid' => 'Homepage value is not a valid URL (http://www.example.com)',

    // Contact validation errors
    'name value required' => 'Name is required',
    'existing contact required' => 'You need to select an existing contact',
    
    // Add user to contact form
    'contact already has user' => 'This contact already has a user account attached to it.',    
    // User validation errors
    'username value required' => 'Username value is required',
    'username must be unique' => 'Sorry, but selected username is already taken',
    'email value is required' => 'Email address value is required',
    'email address must be unique' => 'Sorry, selected email address is already taken',
    'company value required' => 'User must be part of company / organization',
    'password value required' => 'Password value is required',
    'passwords dont match' => 'Passwords don\'t match',
    'old password required' => 'Old password value is required',
    'invalid old password' => 'Old password is not valid',
    'user homepage invalid' => 'Homepage value is not a valid URL (http://www.example.com)',
    
    // Avatar
    'invalid upload type' => 'Invalid file type. Allowed types are %s',
    'invalid upload dimensions' => 'Invalid image dimensions. Max size is %sx%s pixels',
    'invalid upload size' => 'Invalid image size. Max size is %s',
    'invalid upload failed to move' => 'Failed to move uploaded file',
    
    // Registration form
    'terms of services not accepted' => 'In order to create an account you need to read and accept our terms of services',
    
    // Init company website
    'failed to load company website' => 'Failed to load website. Owner company not found',
    'failed to load project' => 'Failed to load active project',
    
    // Login form
    'username value missing' => 'Please enter your username',
    'password value missing' => 'Please enter your password',
    'invalid login data' => 'Failed to log you in. Please check your login data and try again',
    'invalid password' => 'Incorrect password. Please check your password and try again',
    
    // Add project form
    'project name required' => 'Project name value is required',
    'project name unique' => 'Project name must be unique',
    
    // Add message form
    'message title required' => 'Title value is required',
    'message title unique' => 'Title value must be unique in this project',
    'message text required' => 'Text value is required',
    
    // Add comment form
    'comment text required' => 'Text of the comment is required',
    
    // Add milestone form
    'milestone name required' => 'Milestone name value is required',
    'milestone due date required' => 'Milestone due date value is required',

    // Add task list
    'task list name required' => 'Task list name value is required',
    'task list name unique' => 'Task list name must be unique in project',
    
    // Add task
    'task text required' => 'Task text is required',

    // Test mail settings
    'test mail recipient required' => 'Recipient address is required',
    'test mail recipient invalid format' => 'Invalid recipient address format',
    'test mail message required' => 'Mail message is required',
    
    // Mass mailer
    'massmailer subject required' => 'Message subject is required',
    'massmailer message required' => 'Message body is required',
    'massmailer select recipients' => 'Please select users that will receive this email',
    
  ); // array

?>