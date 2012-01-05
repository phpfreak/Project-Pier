<?php 

  // Set page title and set crumbs to index
  set_page_title(lang('add ticket'));
  project_tabbed_navigation(PROJECT_TAB_TICKETS);
  project_crumbs(array(
    array(lang('tickets'), get_url('tickets')),
    array(lang('add ticket'))
  ));
  
  add_stylesheet_to_page('project/tickets.css');
?>
<h2><?php echo lang('ticket #', $ticket->getId()); ?></h2>

<form action="<?php echo get_url('tickets', 'add_ticket') ?>" method="post" enctype="multipart/form-data">

<?php tpl_display(get_template_path('form_errors')) ?>


  <div>
    <?php echo label_tag(lang('summary'), 'ticketFormSummary', true) ?>
    <?php echo text_field('ticket[summary]', array_var($ticket_data, 'summary'), array('id' => 'ticketFormSummary', 'class' => 'title')) ?>
  </div>
  
  <div>
    <?php echo label_tag(lang('type'), 'ticketFormType') ?>
    <?php echo select_ticket_type("ticket[type]", array_var($ticket_data, 'type'), array('id' => 'ticketFormType')) ?>
  </div>
  
  <div>
    <?php echo label_tag(lang('category'), 'ticketFormCategory') ?>
    <?php echo select_ticket_category("ticket[category_id]", $ticket->getProject(), array_var($ticket_data, 'category_id'), array('id' => 'ticketFormCategory')) ?>
  </div>
  
  <div>
    <?php echo label_tag(lang('priority'), 'ticketFormPriority') ?>
    <?php echo select_ticket_priority("ticket[priority]", array_var($ticket_data, 'priority'), array('id' => 'ticketFormPriority')) ?>
  </div>

  <div>
    <?php echo label_tag(lang('status'), 'ticketFormState') ?>
    <?php echo select_ticket_state("ticket[state]", array_var($ticket_data, 'state'), array('id' => 'ticketFormState')) ?>
  </div>
  
  <div>
    <?php echo label_tag(lang('assigned to'), 'ticketFormAssignedTo') ?>
    <?php echo assign_to_select_box("ticket[assigned_to]", active_project(), array_var($ticket_data, 'assigned_to'), array('id' => 'ticketFormAssignedTo')) ?>
  </div>

  <div>
      <?php echo label_tag(lang('milestone'), 'ticketFormMilestone') ?>
      <?php echo select_milestone("ticket[milestone_id]", active_project(), array_var($ticket_data, 'milestone_id'), array('id' => 'ticketFormMilestone')) ?>
  </div>

  <br />
  <div class="description">
    <?php echo label_tag(lang('description'), 'messageFormDescription', true) ?>
    <?php echo editor_widget('ticket[description]', null, array('id' => 'messageFormDescription')) ?>
  </div>
  
<?php if(logged_user()->isMemberOfOwnerCompany()) { ?>
  <fieldset>
    <legend><?php echo lang('options') ?></legend>
    
    <div class="objectOption">
      <div class="optionLabel"><label><?php echo lang('private ticket') ?>:</label></div>
      <div class="optionControl"><?php echo yes_no_widget('ticket[is_private]', 'ticketFormIsPrivate', array_var($ticket_data, 'is_private'), lang('yes'), lang('no')) ?></div>
      <div class="optionDesc"><?php echo lang('private ticket desc') ?></div>
    </div>
  </fieldset>
<?php } // if ?>
  
  <fieldset id="emailNotification">
    <legend><?php echo lang('email notification') ?></legend>
    <p><?php echo lang('email notification ticket desc') ?></p>
<?php foreach(active_project()->getCompanies() as $company) { ?>
<?php if(is_array($users = $company->getUsersOnProject(active_project())) && count($users)) { ?>
    <div class="companyDetails">
      <div class="companyName"><?php echo checkbox_field('ticket[notify_company_' . $company->getId() . ']', array_var($ticket_data, 'notify_company_' . $company->getId()), array('id' => 'notifyCompany' . $company->getId())) ?> <label for="notifyCompany<?php echo $company->getId() ?>" class="checkbox"><?php echo clean($company->getName()) ?></label></div>
      <div class="companyMembers">
        <ul>
<?php foreach($users as $user) { ?>
          <li><?php echo checkbox_field('ticket[notify_user_' . $user->getId() . ']', array_var($message_data, 'notify_user_' . $user->getId()), array('id' => 'notifyUser' . $user->getId())) ?> <label for="notifyUser<?php echo $user->getId() ?>" class="checkbox"><?php echo clean($user->getDisplayName()) ?></label></li>
<?php } // foreach ?>
        </ul>
      </div>
    </div>
<?php } // if ?>
<?php } // foreach ?>
  </fieldset>

<?php if($ticket->canAttachFile(logged_user(), active_project())) { ?>
  <?php echo render_attach_files() ?>
<?php } // if ?>

  <?php echo submit_button($ticket->isNew() ? lang('add ticket') : lang('edit ticket')) ?>
</form>