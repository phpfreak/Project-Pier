<h2>Upgrade process log</h2>
<ul>
<?php foreach ($upgrader->getChecklistItems() as $group_name => $checklist_items) { ?>
<?php if (is_array($checklist_items)) { ?>
<?php foreach ($checklist_items as $checklist_item) { ?>
  <li class="<?php echo $checklist_item->getChecked() ? 'success' : 'error' ?>"><strong><?php echo clean($group_name) ?>:</strong> <?php echo clean($checklist_item->getText()) ?></li>
<?php } // if ?>
<?php } // if ?>
<?php } // foreach ?>
</ul>