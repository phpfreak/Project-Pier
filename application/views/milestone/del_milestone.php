<?php

  set_page_title(lang('delete milestone'));
  project_tabbed_navigation('milestones');
  project_crumbs(lang('delete milestone'));

?>
<form action="<?php echo $milestone->getDeleteUrl() ?>" method="post">
  <?php tpl_display(get_template_path('form_errors')) ?>

  <div><?php echo lang('about to delete') ?> <?php echo lc(lang('milestone')) ?> <b><?php echo clean($milestone->getName()) ?></b></div>
    
  <div>
    <label><?php echo lang('confirm delete milestone') ?></label>
    <?php echo yes_no_widget('deleteMilestone[really]', 'deleteMilestoneReallyDelete', false, lang('yes'), lang('no')) ?>
  </div>
    
  <div>
    <?php echo label_tag(lang('password')) ?>
    <?php echo password_field('deleteMilestone[password]', null, array('id' => 'loginPassword', 'class' => 'medium')) ?>
  </div>
    
  <?php echo submit_button(lang('delete milestone')) ?> <a href="<?php echo get_url('milestone') ?>"><?php echo lang('cancel') ?></a>
</form>