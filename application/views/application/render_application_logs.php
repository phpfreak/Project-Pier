<?php
  add_stylesheet_to_page('application_logs.css')
?>
<?php if (isset($application_logs_entries) && is_array($application_logs_entries) && count($application_logs_entries)) { ?>
<table class="applicationLogs blank">
  <tr>
    <th></th>
    <th><?php echo lang('application log details column name') ?></th>
<?php if ($application_logs_show_project_column) { ?>
    <th class="right"><?php echo lang('application log project column name') ?></th>
<?php } else { ?>
    <th class="right"><?php echo lang('application log taken on column name') ?></th>
<?php } // if ?>
  </tr>
<?php foreach ($application_logs_entries as $application_log_entry) { ?>
<?php if ($application_log_entry->isToday()) { ?>
  <tr class="logToday">
<?php } elseif ($application_log_entry->isYesterday()) { ?>
  <tr class="logYesterday">
<?php } else { ?>
  <tr class="logOlder">
<?php } // if ?>

    <td class="logTypeIcon"><img src="<?php echo image_url('logtypes/' . strtolower($application_log_entry->getRelObjectManager()) . '.gif') ?>" alt="<?php echo $application_log_entry->getObjectTypeName() ?>" title="<?php echo $application_log_entry->getObjectTypeName() ?>" /></td>
    <td class="logDetails">
<?php if ($application_log_entry_url = $application_log_entry->getObjectUrl()) { ?>
      <a href="<?php echo $application_log_entry_url ?>"><?php echo clean($application_log_entry->getText()) ?></a>
<?php } else { ?>
      <?php echo clean($application_log_entry->getText()) ?>
<?php } // if ?>

<?php if ($application_logs_show_project_column) { ?>
      <br /><?php echo render_action_taken_on_by($application_log_entry); ?>
<?php } // if ?>
    </td>
<?php if ($application_logs_show_project_column) { ?>
    <td class="logProject">
<?php if (($application_log_entry_project = $application_log_entry->getProject()) instanceof Project) { ?>
      <a href="<?php echo $application_log_entry_project->getOverviewUrl() ?>"><?php echo clean($application_log_entry_project->getName()) ?></a>
<?php } // if ?>
    </td>
<?php } else { ?>
    <td class="logTakenOnBy"><?php echo render_action_taken_on_by($application_log_entry); ?></td>
<?php } // if ?>
  </tr>
<?php } // foreach ?>
</table>
<?php } // if ?>
