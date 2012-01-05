<?php

  return array(
  
    // source: actions.php

    // Bug Trac
    'open tickets' => 'Open tickets',  
    'closed tickets' => 'Closed tickets',
    'add ticket' => 'Add ticket',  
    'edit ticket' => 'Edit ticket',  
    'view ticket' => 'View ticket',  
    'open ticket' => 'Open ticket', 
    'close ticket' => 'Close ticket',  
    'delete ticket' => 'Delete ticket',  
    'add ticket category' => 'Add category',
    'add default ticket categories' => 'Add default categories',
    'edit ticket category' => 'Edit category',
    'ticket categories' => 'Ticket categories',
    'update ticket options' => 'Update options',

    // source: administration.php

    'config category name tickets' => 'Tickets',  
    'config category desc tickets' => 'Use this set of settings to set ticket options. Currently only default categories.',
    'config option name tickets_types' => 'Allowed ticket types',
    'config option name tickets_default_categories' => 'Default ticket categories for a project',

    // source: emails.php

    'new ticket' => 'New ticket',
    'new ticket posted' => 'New ticket "%s" has been posted in "%s" project',
    'ticket edited' => 'Ticket "%s" has been edited in "%s" project',
    'ticket closed' => 'Ticket "%s" has been closed in "%s" project',
    'ticket opened' => 'Ticket "%s" has been opened in "%s" project',
    'attached files to ticket' => 'Some files have been attached to ticket "%s" in "%s" project',
    'detached files from ticket' => 'Some files have been detached from ticket "%s" in "%s" project',
    'view new ticket' => 'View that ticket',


    // source: errors.php

    // Add category
    'category name required' => 'Category name value is required',
    
    // Add ticket
    'ticket summary required' => 'Summary value is required',
    'ticket description required' => 'Description value is required',

    // source: messages.php
    // Empty, dnx etc
    'no ticket subscribers' => 'There are no users subscribed to this ticket',

    'ticket dnx' => 'Requested ticket does not exist',
    'no tickets in project' => 'There are no tickets in this project',
    'no my tickets' => 'There are no tickets assigned to you',
    'no changes in ticket' => 'There are no changes in this ticket',
    'category dnx' => 'Requested category does not exist',
    'no categories in project' => 'There are no categories in this project',

    // Success
    'success add ticket' => 'Ticket \'%s\' has been added successfully',
    'success edit ticket' => 'Ticket \'%s\' has been updated successfully',
    'success deleted ticket' => 'Ticket \'%s\' and all of its comments has been deleted successfully',
    'success close ticket' => 'Selected ticket has been closed',
    'success open ticket' => 'Selected ticket has been reopened',
    'success add category' => 'Category \'%s\' has been added successfully',
    'success edit category' => 'Category \'%s\' has been updated successfully',
    'success deleted category' => 'Category \'%s\' and all of its comments has been deleted successfully',
    
    'success subscribe to ticket' => 'You have been successfully subscribed to this ticket',
    'success unsubscribe to ticket' => 'You have been successfully unsubscribed from this ticket',

    // Failures
    'error update ticket options' => 'Failed to update ticket options',
    'error close ticket' => 'Failed to close selected ticket',
    'error open ticket' => 'Failed to reopen selected ticket',
    'error subscribe to ticket' => 'Failed to subscribe to selected ticket',
    'error unsubscribe to ticket' => 'Failed to unsubscribe from selected ticket',
    'error delete ticket' => 'Failed to delete selected ticket',

    // Confirmation
    'confirm delete ticket' => 'Are you sure that you want to delete this ticket?',
    'confirm unsubscribe' => 'Are you sure that you want to unsubscribe?',
    'confirm subscribe ticket' => 'Are you sure that you want to subscribe to this ticket? You will receive an email everytime someone (except you) makes a change or posts a comment on this ticket',

    // Log
    'log add projectcategories' => '\'%s\' added',
    'log edit projectcategories' => '\'%s\' updated',
    'log delete projectcategories' => '\'%s\' deleted',
    'log add projecttickets' => '\'%s\' added',
    'log edit projecttickets' => '\'%s\' updated',
    'log delete projecttickets' => '\'%s\' deleted',
    'log close projecttickets' => '\'%s\' closed',
    'log open projecttickets' => '\'%s\' opened',
  
    // source: general.php


    // source: objects.php

    'ticket' => 'Ticket',
    'tickets' => 'Tickets',
    'private ticket' => 'Private ticket',

    // source: project_interface.php

    'email notification ticket desc' => 'Notify selected people about this ticket via email',
    'subscribers ticket desc' => 'Subscribers will receive an email notification whenever someone (except themselves) makes a change or posts a comment on this ticket',
    
    // Tickets
    'summary' => 'Summary',
    'category' => 'Category',
    'assigned to' => 'Assigned to',
    'reported by' => 'Reported by',
    'closed' => 'Closed',
    'open' => 'Open',
    'critical' => 'Critical',
    'major' => 'Major',
    'minor' => 'Minor',
    'trivial' => 'Trivial',
    'opened' => 'New',
    'confirmed' => 'Confirmed',
    'not reproducable' => 'Not reproducable',
    'test and confirm' => 'Test and confirm',
    'fixed' => 'Fixed',
    'defect' => 'Defect',
    'enhancement' => 'Enhancement',
    'feature request' => 'Feature',
    'legend' => 'Legend',
    'ticket #' => 'Ticket #%s',
    'updated on by' => '%s | <a href="%s">%s</a> | %s',
    'history' => 'Change history',
    'field' => 'Field',
    'old value' => 'Old value',
    'new value' => 'New value',
    'change date' => 'Change date',

    'private ticket desc' => 'Private tickets are visible only to owner company members. Members of client companies will not be able to see them.',

    // source: site_interface.php
    
    // Tickets
    'my tickets' => 'My tickets',

    'filters' => 'Filters',  
    'new' => 'New',  
    'pending' => 'Pending',  
    'updated on' => 'Updated on',  
    'most recent' => 'Newest',

  ); // array

?>