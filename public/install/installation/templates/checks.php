<h1 class="pageTitle"><span>Step <?php echo $current_step->getStepNumber() ?>:</span> Server check</h1>
<?php $checklist = $installer->getCheckList() ?>
<?php if (is_array($checklist) && count($checklist)) { ?>
<ul>
<?php foreach ($checklist as $checklist_item) { ?>
<?php if ($checklist_item->getChecked()) { ?>
  <li class="success">OK: <?php echo clean($checklist_item->getMessage()) ?></li>
<?php } else { ?>
  <li class="error">Error: <?php echo clean($checklist_item->getMessage()) ?></li>
<?php } // if ?>
<?php } // foreach ?>
</ul>
<?php } // if ?>