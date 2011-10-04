<div class="sidebarBlock">
  <h2><?php echo lang('icalendar') ?></h2>
  <div class="blockContent">
    <a href="<?php echo logged_user()->getICalendarUrl(active_project()) ?>" class="iCalSubscribe"><?php echo lang('icalendar subscribe') ?></a>
    <p><?php echo lang('icalendar subscribe desc') ?></p>
    <p><?php echo lang('icalendar password change notice') ?></p>
  </div>
</div>

<?php if (isset($completed_milestones) && is_array($completed_milestones) && count($completed_milestones)) { ?>
<div class="sidebarBlock">
  <h2><?php echo lang('completed milestones') ?></h2>
  <div class="blockContent">
    <ul class="listWithDetails">
<?php foreach ($completed_milestones as $milestone) { ?>
      <li><a href="<?php echo $milestone->getViewUrl() ?>"><?php echo clean($milestone->getName()) ?></a><?php if ($milestone->getCompletedBy() instanceof User) { ?>
<?php if ($milestone->getCompletedBy() instanceof User) { ?>
        <br /><span class="desc"><?php echo lang('completed on by', format_datetime($milestone->getCompletedOn()), $milestone->getCompletedBy()->getCardUrl(), clean($milestone->getCompletedBy()->getDisplayName())) ?></span><?php } // if ?></li>
<?php } // if ?>
<?php } // foreach ?>
    </ul>
  </div>
</div>
<?php } // if ?>