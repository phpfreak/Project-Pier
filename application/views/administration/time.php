<?php
  set_page_title(lang('time manager'));
  administration_tabbed_navigation('time');
  administration_crumbs(lang('time manager'));

  add_page_action(lang('unbilled time'), get_url('administration', 'time', array('status' => '0')));
  add_page_action(lang('billed time'), get_url('administration', 'time', array('status' => '1')));
  add_page_action(lang('view by user'), get_url('user', 'time'));
  add_page_action(lang('view by project'), get_url('project', 'time'));

  $status = (array_var($_GET, 'status')) ? array_var($_GET, 'status') : 0;
  $button = ($status) ? lang('unbilled') : lang('billed');
  $title = ($status) ? lang('billed time') : lang('unbilled time');

  add_stylesheet_to_page('project/time.css');
?>
<div id="time">

<h2><?php echo $title; ?></h2>

<form action="<?php echo get_url('time', 'setstatus', array('status' => $status, 'redirect_to' => $redirect_to)) ?>" method="post">

<table class="timeLogs blank">
  <tr>
    <th class="short"></th>
    <th><?php echo lang('done date'); ?></th>
    <th><?php echo lang('name'); ?></th>
    <th><?php echo lang('details'); ?></th>
    <th><?php echo lang('hours'); ?></th>
    <th><?php echo lang('bill'); ?></th>
    <th><?php echo lang('actions'); ?></th>
  </tr>

<?php
    $total_hours = 0;
    if ($times) {
      foreach($times as $time) {
        $this->assign('time', $time);
?>

<?php if($time->isToday()) { ?>
  <tr class="timeToday">
<?php } elseif($time->isYesterday()) { ?>
  <tr class="timeYesterday">
<?php } else { ?>
  <tr class="timeOlder">
<?php } // if ?>
    <td class="timeCheck">
      <input type="checkbox" name="item[<?php echo $time->getId(); ?>]" />
    </td>
    <td class="timeDate">
<?php if($time->getDoneDate()->getYear() > DateTimeValueLib::now()->getYear()) { ?>
  <?php echo format_date($time->getDoneDate(), null, 0) ?>
<?php } else { ?>
  <?php echo format_descriptive_date($time->getDoneDate(), 0) ?>
<?php } // if ?>
    </td>
    <td class="timeUser">
      <?php if($time->getAssignedTo() instanceof ApplicationDataObject) { ?>
        <?php echo clean($time->getAssignedTo()->getObjectName()) ?>
      <?php } // if ?>
    </td>
    <td class="timeDetailsSmall">
      <a href="<?php echo $time->getViewUrl() ?>"><?php echo clean($time->getName()) ?></a>
    </td>
    <td class="timeHours"><?php echo $time->getHours() ?></td>
    <td class="timeFiles">
      <?php echo render_object_files_brief($time, $time->canEdit(logged_user())) ?>
    </td>
    <td class="timeEdit">
<?php
  $options = array();
  if($time->canEdit(logged_user())) $options[] = '<a href="' . $time->getEditUrl() . '">' . lang('edit') . '</a>';
  if($time->canDelete(logged_user())) $options[] = '<a href="' . $time->getDeleteUrl() . '" onclick="return confirm(\'' . lang('confirm delete time') . '\')">' . lang('delete') . '</a>';
?>
<?php if(count($options)) { ?>
     <?php echo implode(' | ', $options) ?>
<?php } else { // if(count ?>
     <?php echo '&nbsp;' ?>
<?php } // if ?>
    </td>
  </tr>

<?php
      $total_hours += $time->getHours();
      } // foreach
    } // if
?>

  <tr class="timeOlder total">
    <td class="timeCheck"></td>
    <td class="timeDate"></td>
    <td class="timeUser"></td>
    <td class="timeDetailsSmall" style="text-align:right;"><strong><?php echo lang('total'); ?>:&nbsp;</strong></td>
    <td class="timeHours"><strong><?php echo $total_hours; ?></strong></td>
    <td class="timeBills"></td>
    <td class="timeEdit"></td>
  </tr>

</table>

<div class="submitTime">
  <?php echo submit_button(lang('mark as'). ' ' . $button) ?>
</div>

</form>

</div>