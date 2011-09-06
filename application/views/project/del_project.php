<?php

  set_page_title(lang('delete project'));
  administration_tabbed_navigation(ADMINISTRATION_TAB_PROJECTS);
  administration_crumbs(lang('projects'));

?>
<form action="<?php echo $project->getDeleteUrl() ?>" method="post">
  <?php tpl_display(get_template_path('form_errors')) ?>

  <div><?php echo lang('about to delete') ?> <b><?php echo clean($project->getName()) ?></b></div>

  <div>
    <label><?php echo label_tag(lang('confirm delete project')) ?></label>
    <?php echo yes_no_widget('deleteProject[really]', 'deleteProjectReallyDelete', false, lang('yes'), lang('no')) ?>
  </div>

  <div>
    <?php echo label_tag(lang('password')) ?>
    <?php echo password_field('deleteProject[password]', null, array('id' => 'loginPassword', 'class' => 'medium')) ?>
  </div>

  <?php echo submit_button(lang('delete project')) ?> <a href="<?php echo get_url('administration','projects') ?>"><?php echo lang('cancel') ?></a>
</form>
