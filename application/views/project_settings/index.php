<?php
  set_page_title(lang('settings'));
  project_tabbed_navigation('settings');
  project_crumbs(lang('settings'));

?>
<div id="configuration">
<?php if (logged_user()->isAdministrator() || active_project()->canEdit(logged_user())) { ?>
  <h2><a href="<?php echo $project->getEditUrl(); ?>"><?php echo lang('edit project'); ?></a></h2>
<?php } // if ?>
<?php if (logged_user()->isAdministrator() || active_project()->canChangePermissions(logged_user())) { ?>
  <h2><a href="<?php echo get_url('project_settings', 'users'); ?>"><?php echo lang('users'); ?></a></h2>
<?php } // if ?>
</div>