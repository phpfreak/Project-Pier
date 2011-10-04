<?php if ($installer->hasErrors()) { ?>
<?php $installer_errors = $installer->getErrors() ?>
<div id="errors">
<?php if (count($installer_errors) > 1) { ?>
<p>Errors:</p>
<ul>
<?php foreach ($installer_errors as $error) { ?>
  <li><?php echo clean($error) ?></li>
<?php } // foreach ?>
</ul>
<?php } else { ?>
<p><?php echo clean($installer_errors[0]) ?></p>
<?php } // if ?>
</div>
<?php } // if ?>