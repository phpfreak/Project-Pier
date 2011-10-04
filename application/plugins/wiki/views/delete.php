<?php

  set_page_title(lang('delete message'));
  project_tabbed_navigation();
  project_crumbs(array(
	array(lang('wiki'), get_url('wiki')),
	array($revision->getName(), $page->getViewUrl()),
	array(lang('delete wiki page'))
  ));

?>
<form action="<?php echo $page->getDeleteUrl() ?>" method="post">
  <?php tpl_display(get_template_path('form_errors')) ?>

  <div><?php echo lang('about to delete') ?> <?php echo strtolower(lang('wiki page')) ?> <b><?php echo clean($revision->getName()) ?></b></div>

  <div>
    <label><?php echo lang('confirm delete wiki page') ?></label>
    <?php echo yes_no_widget('deleteWikiPage', 'deleteWikiPageReallyDelete', false, lang('yes'), lang('no')) ?>
  </div>

  <?php echo submit_button(lang('delete wiki page')) ?> <a href="<?php echo get_url('wiki') ?>"><?php echo lang('cancel') ?></a>
</form>