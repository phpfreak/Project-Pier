<?php

  set_page_title(lang('delete project'));
  project_crumbs(lang('projects'));
  $this->includeTemplate(get_template_path('project/pageactions'));
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

  <?php echo submit_button(lang('delete project')) ?> <a href="<?php echo $project->getOverviewUrl() ?>"><?php echo lang('cancel') ?></a>
</form>