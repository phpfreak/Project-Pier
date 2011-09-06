<div class="sidebarBlock">
  <h2><?php echo lang('view'); ?></h2>
  <div class="blockContent">
    <ul>
      <li><a href="<?php echo ProjectTickets::getIndexUrl() ?>" <?php if (isset($closed) && !$closed) echo 'class="selected"'; ?>><?php echo lang('open tickets') ?></a></li>
      <li><a href="<?php echo ProjectTickets::getIndexUrl(true) ?>" <?php if (isset($closed) && $closed) echo 'class="selected"'; ?>><?php echo lang('closed tickets') ?></a></li>
      <li><a href="<?php echo get_url('tickets', 'categories') ?>" <?php if (!isset($closed)) echo 'class="selected"'; ?>><?php echo lang('ticket categories') ?></a></li>
    </ul>
  </div>
</div>
