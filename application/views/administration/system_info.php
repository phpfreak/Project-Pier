<?php
  set_page_title($tool->getDisplayName());
  administration_tabbed_navigation(ADMINISTRATION_TAB_TOOLS);
  administration_crumbs(array(
    array(lang('administration tools'), get_url('administration', 'tools')),
    array($tool->getDisplayName())
  ));
?>
<?php phpinfo(); ?>