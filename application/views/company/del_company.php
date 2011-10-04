<?php

  set_page_title(lang('delete client'));
  administration_tabbed_navigation(ADMINISTRATION_TAB_PROJECTS);
  administration_crumbs(lang('clients'));

?>
<form action="<?php echo $company->getDeleteClientUrl() ?>" method="post">
  <?php tpl_display(get_template_path('form_errors')) ?>

  <div><?php echo lang('about to delete') ?> <b><?php echo clean($company->getName()) ?></b></div>
    
  <div>
    <label><?php echo lang('confirm delete client') ?></label>
    <?php echo yes_no_widget('deleteCompany[really]', 'deleteCompanyReallyDelete', false, lang('yes'), lang('no')) ?>
  </div>
    
  <div>
    <?php echo label_tag(lang('password')) ?>
    <?php echo password_field('deleteCompany[password]', null, array('id' => 'loginPassword', 'class' => 'medium')) ?>
  </div>
    
  <?php echo submit_button(lang('delete client')) ?> <a href="<?php echo get_url('administration','clients') ?>"><?php echo lang('cancel') ?></a>
</form>