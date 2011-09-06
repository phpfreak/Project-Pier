<?php
  trace(__FILE__, 'start');
  add_stylesheet_to_page('application_logs.css');
?>
<?php if(isset($application_logs_entries) && is_array($application_logs_entries) && count($application_logs_entries)) { ?>
<div class="block"><div class="header"><?php echo lang('project').':' ?>
<?php if ($project_url = $application_logs_project->getObjectUrl()) { ?>
      <a href="<?php echo $project_url ?>"><?php echo $application_logs_project->getName(); ?></a>
<?php } else { ?>
      <?php echo $application_logs_project->getName() ?>
<?php } // if ?>
 </div>
<div class="content" style="display:none"><table class="applicationLogs blank">
<?php if (config_option('application_log_column_header', false)==true) { ?>
  <tr>
    <th><?php echo lang('application log date column name') ?></th>
    <th><?php echo lang('application log by column name') ?></th>
    <th><?php echo lang('application log type column name') ?></th>
    <th><?php echo lang('application log details column name') ?></th>
  </tr>
<?php } // if ?>
<?php $row_count=0; ?>
<?php foreach($application_logs_entries as $application_log_entry) { ?>
<?php   $row_count++; ?>
<?php
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
    <td class="logBy"><?php echo render_action_taken_on_by($application_log_entry); ?></td>
<?php if (config_option('logs_show_icons')=='1') { ?>
    <td class="logTypeIcon"><img src="<?php echo image_url('logtypes/' . strtolower($application_log_entry->getRelObjectManager()) . '.gif') ?>" alt="<?php echo $application_log_entry->getObjectTypeName() ?>" title="<?php echo $application_log_entry->getObjectTypeName() ?>" /></td>
<?php } else { ?>
    <td class="logTypeIcon"><?php echo $application_log_entry->getObjectTypeName(); ?></td>
<?php } // if ?>
    
<?php if($application_log_entry_url = $application_log_entry->getObjectUrl()) { ?>
<td class="logDetails"><a href="<?php echo $application_log_entry_url ?>"><?php echo $application_log_entry->getText() ?></a></td>
<?php } else { ?>
<td class="logDetails"><?php echo $application_log_entry->getText() ?></td>
<?php } // if ?>
  </tr>
<?php } // foreach ?>
 </table></div></div>
<?php } // if ?>