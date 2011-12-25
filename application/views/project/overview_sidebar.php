<?php trace(__FILE__,'begin') ?>
<?php if (plugin_active('forms')) { ?>
<?php if (isset($visible_forms) && is_array($visible_forms) && (count($visible_forms) > 0)) { ?>
<div class="sidebarBlock">
  <h2><?php echo lang('forms') ?></h2>
  <div class="blockContent">
    <ul>
<?php foreach ($visible_forms as $visible_form) { ?>
      <li class="<?php echo odd_even_class($form_ln); ?>"><a href="<?php echo $visible_form->getSubmitUrl() ?>"><?php echo clean($visible_form->getName()) ?></a></li>
<?php } // foreach ?>
    </ul>
  </div>
</div>
<?php } // if ?>
<?php } // if ?>

<?php if (isset($important_messages) && is_array($important_messages) && count($important_messages)) { ?>
<div class="sidebarBlock">
  <h2><?php echo lang('important messages') ?></h2>
  <div class="blockContent">
    <ul class="listWithDetails">
<?php foreach ($important_messages as $important_message) { ?>
      <li class="<?php echo odd_even_class($message_ln); ?>"><a href="<?php echo $important_message->getViewUrl() ?>"><?php echo clean($important_message->getTitle()) ?></a><br />
      <span class="desc"><?php echo lang('comments on message', $important_message->countComments()) ?></span></li>
<?php } // foreach ?>
    </ul>
  </div>
</div>
<?php } // if ?>

<?php if (plugin_active('files')) { ?>
<?php if (isset($important_files) && is_array($important_files) && count($important_files)) { ?>
<div class="sidebarBlock">
  <h2><?php echo lang('important files') ?></h2>
  <div class="blockContent">
    <ul>
<?php foreach ($important_files as $important_file) { ?>
      <li class="<?php echo odd_even_class($files_ln); ?>"><a href="<?php echo $important_file->getDetailsUrl() ?>"><?php echo clean($important_file->getFilename()) ?></a><br /><span class="desc"><?php echo lang('revisions on file', $important_file->countRevisions()) ?></span></li>
<?php } // foreach ?>
    </ul>
  </div>
</div>
<?php } // if ?>
<?php } // if ?>

<?php if (active_project()->canEdit(logged_user()) || active_project()->canChangeStatus(logged_user())) { ?>
<div class="sidebarBlock">
<?php if (active_project()->isActive()) { ?>
  <h2><?php echo lang('project status') ?>: <?php echo lang('active') ?></h2>
<?php } else { ?>
  <h2><?php echo lang('project status') ?>: <?php echo lang('completed') ?></h2>
<?php } // if ?>
  <div class="blockContent">
    <ul>

<?php if (active_project()->canEdit(logged_user()) && (config_option('enable_efqm')=='yes')) { 
      $score_card_url = get_url('project', 'score_card', array(
        'id' => active_project()->getId(),
        'active_project' => active_project()->getId(),
      ));
?>
      <li><a href="<?php echo $score_card_url; ?>"><?php echo lang('view score card') ?></a></li>
<?php } // if ?>
<?php if (active_project()->canEdit(logged_user())) { ?>
      <li><a href="<?php echo active_project()->getEditUrl() ?>"><?php echo lang('edit project') ?></a></li>
      <li><a href="<?php echo active_project()->getEditLogoUrl() ?>"><?php echo lang('edit logo') ?></a></li>
<?php } // if ?>
<?php if (active_project()->canChangePermissions(logged_user())) { ?>
      <li><a href="<?php echo active_project()->getPermissionsUrl(); ?>"><?php echo lang('edit permissions') ?></a></li>
<?php } // if ?>    
<?php if (active_project()->canChangeStatus(logged_user())) { ?>
<?php if (active_project()->isActive()) { ?>
      <li><a href="<?php echo active_project()->getCompleteUrl() ?>" onclick="return confirm('<?php echo lang('confirm complete project') ?>')"><?php echo lang('mark project as finished') ?></a></li>
<?php } else { ?>
      <li><a href="<?php echo active_project()->getOpenUrl() ?>" onclick="return confirm('<?php echo lang('confirm open project') ?>')"><?php echo lang('mark project as active') ?></a></li>
<?php } // if ?>
<?php } // if ?>
<?php if (active_project()->canDelete(logged_user())) { ?>
      <li><a href="<?php echo active_project()->getDeleteUrl(); ?>"><?php echo lang('delete project') ?></a></li>
<?php } // if ?>    
<?php if (logged_user()->isAdministrator() || active_project()->canChangePermissions(logged_user())) { ?>
      <li><a href="<?php echo get_url('project_settings', 'users'); ?>"><?php echo lang('users'); ?></a></li>
<?php } // if ?>

    </ul>
  </div>
</div>
<?php } // if ?>

<?php if (isset($project_companies) && is_array($project_companies) && count($project_companies)) { ?>
<div class="sidebarBlock">
  <h2><?php echo lang('companies involved in project') ?></h2>
  <div class="blockContent">
    <ul>
<?php foreach ($project_companies as $project_company) { ?>
      <li class="<?php echo odd_even_class($companies_ln); ?>"><a href="<?php echo $project_company->getCardUrl() ?>"><?php echo clean($project_company->getName()) ?></a></li>
<?php } // foreach ?>
    </ul>
  </div>
</div>
<?php } // if ?>


<?php if (isset($project_users) && is_array($project_users) && count($project_users)) { ?>
<?php count($project_users); ?>
<div class="sidebarBlock">
  <h2><?php echo lang('users involved in project') ?></h2>
  <div class="blockContent">
    <ul>
<?php foreach ($project_users as $project_user) { ?>
      <li class="<?php echo odd_even_class($users_ln); ?>"><a href="<?php echo $project_user->getCardUrl() ?>"><?php echo clean($project_user->getDisplayName()) ?></a></li>
<?php } // foreach ?>
    </ul>
  </div>
</div>
<?php } // if ?>

<div class="sidebarBlock">
  <h2><?php echo lang('rss feeds') ?></h2>
  <div class="blockContent">
    <ul id="listOfRssFeeds">
      <li><a href="<?php echo logged_user()->getRecentActivitiesFeedUrl(active_project()) ?>"><?php echo lang('recent activities feed') ?></a></li>
    </ul>
  </div>
</div>
<?php trace(__FILE__,'end') ?>