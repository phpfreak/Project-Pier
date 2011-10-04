<?php $this->includeTemplate(get_template_path('tickets_sidebar', 'tickets')) ?>
<div class="sidebarBlock">
  <h2><?php echo lang('most recent'); ?></h2>
  <div class="blockContent">
  <ul>
  <?php
        $project = active_project();
        if ($project) {
        }
    ?>
  </ul>
  </div>
</div>