<?php

  set_page_title($project_form->isNew() ? lang('add form') : lang('edit form'));
  project_tabbed_navigation(PROJECT_TAB_FORMS);
  project_crumbs(array(
    array(lang('forms'), get_url('form')),
    array($project_form->isNew() ? lang('add form') : lang('edit form'))
  ));
  add_stylesheet_to_page('project/forms.css');

?>
<?php if ($project_form->isNew()) { ?>
<form action="<?php echo get_url('form', 'add') ?>" method="post">
<?php } else { ?>
<form action="<?php echo $project_form->getEditUrl() ?>" method="post">
<?php } // if?>

<?php tpl_display(get_template_path('form_errors')) ?>

  <div>
    <?php echo label_tag(lang('name'), 'projectFormName', true) ?>
    <?php echo text_field('project_form[name]', array_var($project_form_data, 'name'), array('id' => 'projectFormName', 'class' => 'long')) ?>
  </div>
  
  <div>
    <?php echo label_tag(lang('description'), 'projectFormDescription') ?>
    <?php echo textarea_field('project_form[description]', array_var($project_form_data, 'description'), array('id' => 'projectFormDescription', 'class' => 'short')) ?>
  </div>
  
  <div>
    <?php echo label_tag(lang('success message'), 'projectFormSuccessMessage',true) ?>
    <?php echo textarea_field('project_form[success_message]', array_var($project_form_data, 'success_message'), array('id' => 'projectFormSuccessMessage', 'class' => 'short')) ?>
  </div>
  
  <div class="formBlock" id="projectFormAction">
    <fieldset>
      <legend><?php echo lang('project form action') ?></legend>
      
      <table class="blank">
        <tr>
          <td><?php echo radio_field('project_form[action]', array_var($project_form_data, 'action') == ProjectForm::ADD_COMMENT_ACTION, array('value' => ProjectForm::ADD_COMMENT_ACTION, 'id' => 'projectFormActionAddComment')) ?> <?php echo label_tag(lang('project form action add comment'), 'projectFormActionAddComment', false, array('class' => 'checkbox'), '') ?></td>
          <td><?php echo lang('add comment to message short') ?>: <?php echo select_message('project_form[message_id]', active_project(), array_var($project_form_data, 'message_id'), array('id' => 'projectFormActionSelectMessage')) ?></td>
        </tr>
        <tr>
          <td><?php echo radio_field('project_form[action]', array_var($project_form_data, 'action') == ProjectForm::ADD_TASK_ACTION, array('value' => ProjectForm::ADD_TASK_ACTION , 'id' => 'projectFormActionAddTask')) ?> <?php echo label_tag(lang('project form action add task'), 'projectFormActionAddTask', false, array('class' => 'checkbox'), '') ?></td>
          <td><?php echo lang('add task to list short') ?>: <?php echo select_task_list('project_form[task_list_id]', active_project(), array_var($project_form_data, 'task_list_id'), false, array('id' => 'projectFormActionSelectTaskList')) ?></td>
        </tr>
      </table>
    </fieldset>
  </div>
  
  <div class="formBlock" id="projectFormOptions">
    <fieldset>
      <legend><?php echo lang('options') ?></legend>
      <table class="blank">
        <tr>
          <td><?php echo label_tag(lang('project form enabled')) ?></td>
          <td><?php echo yes_no_widget('project_form[is_enabled]', 'projectFormIsEnabled', array_var($project_form_data, 'is_enabled'), lang('yes'), lang('no')) ?></td>
        </tr>
        <tr>
          <td><?php echo label_tag(lang('project form visible')) ?></td>
          <td><?php echo yes_no_widget('project_form[is_visible]', 'projectFormIsVisible', array_var($project_form_data, 'is_visible'), lang('yes'), lang('no')) ?></td>
        </tr>
      </table>
    </fieldset>
  </div>
  
  <?php echo submit_button($project_form->isNew() ? lang('add form') : lang('edit form')) ?>
</form>