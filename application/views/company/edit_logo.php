<?php
  
  set_page_title(lang('edit company logo'));
  if ($company->isOwner()) {
    administration_tabbed_navigation(ADMINISTRATION_TAB_COMPANY);
    administration_crumbs(array(
      array(lang('company'), get_url('administration', 'company')),
      array(lang('edit company logo'))
    ));
  } else {
    administration_tabbed_navigation(ADMINISTRATION_TAB_CLIENTS);
    administration_crumbs(array(
      array(lang('clients'), get_url('administration', 'clients')),
      array($company->getName(), $company->getViewUrl()),
      array(lang('edit company logo'))
    ));
  } // if

?>
<form action="<?php echo $company->getEditLogoUrl() ?>" method="post" enctype="multipart/form-data">

<?php tpl_display(get_template_path('form_errors')) ?>
  
  <fieldset>
    <legend><?php echo lang('current logo') ?></legend>
<?php if ($company->hasLogo()) { ?>
    <img src="<?php echo $company->getLogoUrl() ?>" alt="<?php echo clean($company->getName()) ?> logo" />
    <p><a href="<?php echo $company->getDeleteLogoUrl() ?>" onclick="return confirm('<?php echo lang('confirm delete company logo') ?>')"><?php echo lang('delete company logo') ?></a></p>
<?php } else { ?>
    <?php echo lang('no current logo') ?>
<?php } // if ?>
  </fieldset>
  
  <div>
    <?php echo label_tag(lang('new logo'), 'avatarFormAvatar', true) ?>
    <?php echo file_field('new_logo', null, array('id' => 'avatarFormAvatar')) ?>
<?php if ($company->hasLogo()) { ?>
    <p class="desc"><?php echo lang('new logo notice') ?></p>
<?php } // if ?>
  </div>
  
  <?php echo submit_button(lang('edit company logo')) ?>
  
</form>