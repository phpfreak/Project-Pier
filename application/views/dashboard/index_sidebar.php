<?php if (isset($online_users) && is_array($online_users) && count($online_users)) { ?>
<div class="sidebarBlock">
  <h2><?php echo lang('online users') ?></h2>
  <div class="blockContent">
    <p><?php echo lang('online users desc') ?></p>
    <ul>
<?php foreach ($online_users as $user) { ?>
<?php if (logged_user()->canSeeUser($user)) { ?>
      <li><a href="<?php echo $user->getCardUrl() ?>"><?php echo clean($user->getDisplayName()) ?></a> <span class="desc">(<?php echo clean($user->getCompanyDisplayName()) ?>)</span></li>
<?php } // if ?>
<?php } // foreach ?>
    </ul>
  </div>
</div>
<?php } // if ?>

<?php if (isset($my_projects) && is_array($my_projects) && count($my_projects)) { ?>
<div class="sidebarBlock">
  <h2><?php echo lang('my projects') ?></h2>
  <div class="blockContent">
    <ul>
<?php foreach ($my_projects as $my_project) { ?>
      <li><a href="<?php echo $my_project->getOverviewUrl() ?>"><?php echo clean($my_project->getName()) ?></a></li>
<?php } // foreach ?>
    </ul>
  </div>
</div>
<?php } // if ?>


<?php if (isset($my_files) && is_array($my_files) && count($my_files)) { ?>
<div class="sidebarBlock">
  <h2><?php echo lang('my files') ?></h2>
  <div class="blockContent">
    <ul>
<?php foreach ($my_files as $my_file) { ?>
      <li><a href="<?php echo $my_file->getViewUrl() ?>"><?php echo clean($my_file->getFileName()) ?></a></li>
<?php } // foreach ?>
    </ul>
  </div>
</div>
<?php } // if ?>

<div class="sidebarBlock">
  <h2><?php echo lang('rss feeds') ?></h2>
  <div class="blockContent">
    <ul id="listOfRssFeeds">
      <li><a href="<?php echo logged_user()->getRecentActivitiesFeedUrl() ?>"><?php echo lang('recent activities feed') ?></a></li>
    </ul>
  </div>
</div>