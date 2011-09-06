<?php $this->includeTemplate(get_template_path('tickets_sidebar', 'tickets')) ?>
<div class="sidebarBlock" id="tickets_legend">
  <h2><?php echo lang('legend'); ?></h2>
  <ul>
    <li class='legend critical'><?php echo lang('critical'); ?></li>
    <li class='legend major'><?php echo lang('major'); ?></li>
    <li class='legend minor'><?php echo lang('minor'); ?></li>
    <li class='legend trivial'><?php echo lang('trivial'); ?></li>
  </ul>
</div>
