<?php

  set_page_title(lang('time manager'));
  administration_tabbed_navigation('time');
  administration_crumbs(lang('time manager'));

  add_page_action(lang('unbilled time'), get_url('administration', 'time', array('status' => '0')));
  add_page_action(lang('billed time'), get_url('administration', 'time', array('status' => '1')));
  add_page_action(lang('view by user'), get_url('user', 'time'));
  add_page_action(lang('view by project'), get_url('project', 'time'));

?>

<h2><?php echo lang('view time by project'); ?></h2>

<?php if (isset($projects) && is_array($projects) && count($projects)) { ?>
<table id="projects">
  <tr>
    <th class="short"></th>
    <th><?php echo lang('name'); ?></th>
    <th><?php echo lang('unbilled'); ?></th>
    <th><?php echo lang('billed'); ?></th>
  </tr>

<?php $counter = 0; ?>
<?php foreach ($projects as $project) { ?>
  <tr>
    <td class="middle">
      &nbsp;<?php echo ++$counter; ?>.&nbsp;
    </td>
    <td class="long middle">
      &nbsp;<a href="<?php echo get_url('time', 'byproject', array('id' => $project->getId())); ?>"><?php echo clean($project->getName()) ?></a>
    </td>
    <td class="middle">
      &nbsp;<?php echo ProjectTimes::getTimeByProjectStatus($project, 0, 'hours');?>&nbsp;<?php echo lang('hrs'); ?>
    </td>
    <td class="middle">
      &nbsp;<?php echo ProjectTimes::getTimeByProjectStatus($project, 1, 'hours');?>&nbsp;<?php echo lang('hrs'); ?>
    </td>
  </tr> 
<?php } // foreach ?>
</table>
<?php } else { ?>
<?php echo lang('no projects owned by company'); ?>
<?php } // if ?>