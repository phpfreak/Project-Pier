<?php

  set_page_title($project_form->getName());
  project_tabbed_navigation(PROJECT_TAB_OVERVIEW);
  project_crumbs($project_form->getName());

?>
<form action="<?php echo $project_form->getSubmitUrl() ?>" method="post">
  <?php tpl_display(get_template_path('form_errors')) ?>
  
<?php if ($project_form->getDescription()) { ?>
  <div class="formDescription"><?php echo do_textile($project_form->getDescription()) ?></div>
<?php } // if ?>
  <div>
    <?php echo textarea_field('project_form_data[content]', array_var($project_form_data, 'content'), array('class' => 'editor')) ?>
  </div>
  <?php echo submit_button(lang('submit project form')) ?>
</form>