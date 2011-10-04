<?php
  set_page_title(lang('time manager'));
  administration_tabbed_navigation();
  administration_crumbs(lang('time manager'));

  add_page_action(lang('unbilled time'), get_url('administration', 'time', array('status' => '0')));
  add_page_action(lang('billed time'), get_url('administration', 'time', array('status' => '1')));
  add_page_action(lang('view by user'), get_url('user', 'time'));
  add_page_action(lang('view by project'), get_url('project', 'time'));

  add_stylesheet_to_page('project/time.css');
?>
<div id="time">

<h2><?php echo $user->getDisplayName(); ?>'s <?php echo lang('unbilled time'); ?></h2>

<form action="<?php echo get_url('time', 'setstatus', array('status' => '0', 'redirect_to' => $redirect_to)) ?>" method="post">

<table class="timeLogs blank">
  <tr>
    <th></th>
    <th><?php echo lang('date'); ?></th>
    <th><?php echo lang('project'); ?></th>
    <th><?php echo lang('details'); ?></th>
    <th><?php echo lang('hours'); ?></th>
    <th></th>
  </tr>

<?php
    $total_hours = 0;
    
    if ($unbilled) {

      foreach($unbilled as $time) {

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
    <td class="timeDateSmall">
<?php if($time->getDoneDate()->getYear() > DateTimeValueLib::now()->getYear()) { ?>
  <?php echo format_date($time->getDoneDate(), 'D j M', 0) ?>
<?php } else { ?>
  <?php echo format_descriptive_date($time->getDoneDate(), 0, 'D j M') ?>
<?php } // if ?>
    </td>
    <td class="timeProject">
      <?php if($time->getProject() instanceof ApplicationDataObject) { ?>
        <?php echo clean($time->getProject()->getObjectName()) ?>
      <?php } // if ?>
    </td>
    <td class="timeDetailsLarge">
      <a href="<?php echo $time->getViewUrl() ?>"><?php echo clean($time->getName()) ?></a>
    </td>
    <td class="timeHours"><?php echo $time->getHours() ?></td>
    <td class="timeEdit">
<?php
  $options = array();
  if($time->canEdit(logged_user())) $options[] = '<a href="' . $time->getEditUrl() . '">' . lang('edit') . '</a>';
  if($time->canDelete(logged_user())) $options[] = '<a href="' . $time->getDeleteUrl() . '" onclick="return confirm(\'' . lang('confirm delete time') . '\')">' . lang('delete') . '</a>';
?>
<?php if(count($options)) { ?>
     <?php echo implode(' | ', $options) ?>
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
    <td class="timeDateSmall"></td>
    <td class="timeUser"></td>
    <td class="timeDetailsLarge" style="text-align:right;"><strong><?php echo lang('total'); ?>:&nbsp;</strong></td>
    <td class="timeHours"><strong><?php echo $total_hours; ?></strong></td>
    <td class="timeEdit"></td>
  </tr>

</table>

<div class="submitTime">
  <?php echo submit_button(lang('mark as billed')) ?>
  <div style="clear:both !important;"></div>
</div>

</form>


<!-- Billed Time Starts Here -->

<h2><?php echo $user->getDisplayName(); ?>'s <?php echo lang('billed time'); ?></h2>

<form action="<?php echo get_url('time', 'setstatus', array('status' => '1', 'redirect_to' => $redirect_to)) ?>" method="post">

<table class="timeLogs blank">
  <tr>
    <th></th>
    <th><?php echo lang('date'); ?></th>
    <th><?php echo lang('project'); ?></th>
    <th><?php echo lang('details'); ?></th>
    <th><?php echo lang('hours'); ?></th>
    <th></th>
  </tr>

<?php
    $total_hours = 0;
    
    if ($billed) {

      foreach($billed as $time) {

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
    <td class="timeDateSmall">
<?php if($time->getDoneDate()->getYear() > DateTimeValueLib::now()->getYear()) { ?>
  <?php echo format_date($time->getDoneDate(), 'D j M', 0) ?>
<?php } else { ?>
  <?php echo format_descriptive_date($time->getDoneDate(), 0, 'D j M') ?>
<?php } // if ?>
    </td>
    <td class="timeProject">
      <?php if($time->getProject() instanceof ApplicationDataObject) { ?>
        <?php echo clean($time->getProject()->getObjectName()) ?>
      <?php } // if ?>
    </td>
    <td class="timeDetailsLarge">
      <a href="<?php echo $time->getViewUrl() ?>"><?php echo clean($time->getName()) ?></a>
    </td>
    <td class="timeHours"><?php echo $time->getHours() ?></td>
    <td class="timeEdit">
<?php
  $options = array();
  if($time->canEdit(logged_user())) $options[] = '<a href="' . $time->getEditUrl() . '">' . lang('edit') . '</a>';
  if($time->canDelete(logged_user())) $options[] = '<a href="' . $time->getDeleteUrl() . '" onclick="return confirm(\'' . lang('confirm delete time') . '\')">' . lang('delete') . '</a>';
?>
<?php if(count($options)) { ?>
     <?php echo implode(' | ', $options) ?>
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
    <td class="timeDateSmall"></td>
    <td class="timeUser"></td>
    <td class="timeDetailsLarge" style="text-align:right;"><strong><?php echo lang('total'); ?>:&nbsp;</strong></td>
    <td class="timeHours"><strong><?php echo $total_hours; ?></strong></td>
    <td class="timeEdit"></td>
  </tr>

</table>

<div class="submitTime">
  <?php echo submit_button(lang('mark as unbilled')) ?>
</div>

</form>



</div>