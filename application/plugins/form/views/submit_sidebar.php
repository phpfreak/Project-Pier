<?php if (isset($visible_forms) && is_array($visible_forms) && (count($visible_forms) > 0)) { ?>
<div class="sidebarBlock">
  <h2><?php echo lang('forms') ?></h2>
  <div class="blockContent">
    <ul>
<?php foreach ($visible_forms as $visible_form) { ?>
<?php if ($visible_form->getId() == $project_form->getId()) { ?>
      <li><?php echo clean($visible_form->getName()) ?></li>
<?php } else { ?>
      <li><a href="<?php echo $visible_form->getSubmitUrl() ?>"><?php echo clean($visible_form->getName()) ?></a></li>
<?php } // if ?>
<?php } // foreach ?>
    </ul>
  </div>
</div>
<?php } // if ?>