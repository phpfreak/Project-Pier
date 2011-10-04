<div class="sidebarBlock">
  <h2><?php echo lang('icalendar') ?></h2>
  <div class="blockContent">
    <a href="<?php echo logged_user()->getICalendarUrl() ?>" class="iCalSubscribe"><?php echo lang('icalendar subscribe') ?></a>
    <p><?php echo lang('icalendar subscribe desc') ?></p>
    <p><?php echo lang('icalendar password change notice') ?></p>
  </div>
</div>

<div class="sidebarBlock">
  <h2><?php echo lang('rss feeds') ?></h2>
  <div class="blockContent">
    <ul id="listOfRssFeeds">
      <li><a href="<?php echo logged_user()->getRecentActivitiesFeedUrl() ?>"><?php echo lang('recent activities feed') ?></a></li>
    </ul>
  </div>
</div>