<?php

  set_page_title(lang('delete contact'));
  if ($contact->isMemberOfOwnerCompany()) {
    administration_tabbed_navigation(ADMINISTRATION_TAB_COMPANY);
  } else {
    administration_tabbed_navigation(ADMINISTRATION_TAB_CLIENTS);
  }
  administration_crumbs(lang('contacts'));

?>
<form action="<?php echo $contact->getDeleteUrl() ?>" method="post">
  <?php tpl_display(get_template_path('form_errors')) ?>

<?php if ($contact->hasAvatar()) { ?>
  <div class="contactAvatar"><img src="<?php echo $contact->getAvatarUrl() ?>" alt="<?php echo clean($contact->getDisplayName()) ?> <?php echo lang('avatar') ?>" /></div>
<?php } ?>
  <div><?php echo lang('about to delete') ?> <b><?php echo clean($contact->getDisplayName()) ?></b></div>

  <div>
    <label><?php echo lang('confirm delete contact') ?></label>
    <?php echo yes_no_widget('deleteContact[really]', 'deleteContactReallyDelete', false, lang('yes'), lang('no')) ?>
  </div>

  <div>
    <?php echo label_tag(lang('password')) ?>
    <?php echo password_field('deleteContact[password]', null, array('id' => 'loginPassword', 'class' => 'medium')) ?>
  </div>

  <?php echo submit_button(lang('delete contact')) ?> <a href="<?php echo $contact->getCompany()->getViewUrl() ?>"><?php echo lang('cancel') ?></a>
</form>