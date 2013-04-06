<?php
  trace(__FILE__, 'start');
  add_stylesheet_to_page('application_logs.css')
?>
<?php if (isset($application_logs_entries) && is_array($application_logs_entries) && count($application_logs_entries)) { ?>
<div class="block">
<div class="header"><?php echo lang('application log events my projects'); ?></div>
<div class="content"><table class="applicationLogs blank">
  <tr>
    <th><?php echo lang('application log date column name') ?></th>
    <th><?php echo lang('application log by column name') ?></th>
    <th><?php echo lang('application log type column name') ?></th>
    <th><?php echo lang('application log details column name') ?></th>
<?php if ($application_logs_show_project_column) { ?>
    <th class="right"><?php echo lang('application log project column name') ?></th>
<?php } // if ?>
  </tr>
<?php $row_count=0; ?>
<?php $prev = new ApplicationLog(); ?>
<?php foreach ($application_logs_entries as $application_log_entry) { ?>
<?php   $row_count++; ?>
<?php 
      // skip log lines about the same object and same action
      // note: lines are ordered on creation date. any other order messes this up
      $cur = $application_log_entry;
      if ($cur->getTakenById() == $prev->getTakenById()) {
        if ($cur->getProjectId() == $prev->getProjectId()) {
          if ($cur->getRelObjectId() == $prev->getRelObjectId()) {
            if ($cur->getRelObjectManager() == $prev->getRelObjectManager()) {
              if ($cur->getAction() == $prev->getAction()) {
                continue;  // skip this log entry cause it is about the same object and same action
              }
            }
          }
        }
      }
      $prev = $cur;

      if ($application_log_entry->isToday()) {
        $trclass='logToday';
      } elseif ($application_log_entry->isYesterday()) {
        $trclass='logYesterday';
      } else { 
        $trclass='logOlder';
      } // if 
      if (($row_count % 2)==0) { 
        $trclass = "$trclass even";
      } else { 
        $trclass = "$trclass odd"; 
      }  
      $objtype = strtolower($application_log_entry->getObjectTypeName());
      $objtype = strtr($objtype, ' ', '_');
      $trclass = "$trclass $objtype"; 
?>
  <tr class="<?php echo $trclass ?>">
    <td class="logTakenOnBy"><?php echo render_action_taken_on_by($application_log_entry); ?></td>
<?php if (config_option('logs_show_icons')) { ?>
    <td class="logTypeIcon"><img src="<?php echo image_url('logtypes/' . strtolower($application_log_entry->getRelObjectManager()) . '.gif') ?>" alt="<?php echo $application_log_entry->getObjectTypeName() ?>" title="<?php echo $application_log_entry->getObjectTypeName() ?>" /></td>
<?php } else { ?>
    <td class="logTypeIcon"><?php echo $application_log_entry->getObjectTypeName(); ?></td>
<?php } // if ?>
<?php if ($application_log_entry_url = $application_log_entry->getObjectUrl()) { ?>
      <td class="logDetails"><a href="<?php echo $application_log_entry_url ?>"><?php echo clean($application_log_entry->getText()) ?></a></td>
<?php } else { ?>
      <td class="logDetails"><?php echo clean($application_log_entry->getText()) ?></td>
<?php } // if ?>
<?php if ($application_logs_show_project_column) { ?>
    <td class="logProject">
<?php if (($application_log_entry_project = $application_log_entry->getProject()) instanceof Project) { ?>
      <a href="<?php echo $application_log_entry_project->getOverviewUrl() ?>"><?php echo clean($application_log_entry_project->getName()) ?></a>
<?php } // if ?>
    </td>
<?php } // if ?>
  </tr>
<?php } // foreach ?>
</table></div></div>
<?php } // if ?>