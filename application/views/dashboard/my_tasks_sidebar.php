<div class="sidebarBlock">
  <h2><?php echo lang('icalendar') ?></h2>
  <div class="blockContent">
    <a href="<?php echo logged_user()->getICalendarUrl() ?>" class="iCalSubscribe"><?php echo lang('icalendar subscribe') ?></a>
    <p><?php echo lang('icalendar subscribe desc') ?></p>
    <p><?php echo lang('icalendar password change notice') ?></p>
  </div>
</div>
