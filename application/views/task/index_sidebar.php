<?php if (isset($open_task_lists) && is_array($open_task_lists) && count($open_task_lists)) { ?>
<div class="sidebarBlock">
  <h2><?php echo lang('open task lists') ?></h2>
  <div class="blockContent">
    <ul class="listWithDetails">
<?php foreach ($open_task_lists as $current_task_list) { ?>
      <li><a href="<?php echo $current_task_list->getViewUrl() ?>"><?php echo clean($current_task_list->getName()) ?></a><br /><span class="desc">(<?php echo lang('task open of total tasks', $current_task_list->countOpenTasks(), $current_task_list->countAllTasks()) ?>)</span></li>
<?php } // foreach ?>
    </ul>
  </div>
</div>
<?php } // if ?>

<?php if (isset($completed_task_lists) && is_array($completed_task_lists) && count($completed_task_lists)) { ?>
<div class="sidebarBlock">
  <h2><?php echo lang('completed task lists') ?></h2>
  <div class="blockContent">
    <ul class="listWithDetails">
<?php foreach ($completed_task_lists as $current_task_list) { ?>
      <li><a href="<?php echo $current_task_list->getViewUrl() ?>"><?php echo clean($current_task_list->getName()) ?></a><br /><span class="desc">(<?php
        if ($current_task_list->getCompletedBy()) {
          echo lang('completed on by', format_date($current_task_list->getCompletedOn()), $current_task_list->getCompletedBy()->getCardUrl(), clean($current_task_list->getCompletedBy()->getDisplayName()));
        } else {
          echo lang('completed on', format_date($current_task_list->getCompletedOn()));
        } // if ?>)</span></li>
<?php } // foreach ?>
    </ul>
  </div>
</div>
<?php } // if ?>
