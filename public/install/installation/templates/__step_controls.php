<div id="installerControls">
<?php if ($current_step->hasNextStep()) { ?>
<?php if ($current_step->hasPreviousStep()) { ?>
  <button type="button" onclick="location.href = '<?php echo $current_step->getPreviousStepUrl() ?>'; return true;">&laquo; Back</button>&nbsp;
<?php } // if ?>

  <?php if ($current_step->getNextDisabled()) { ?>
    <button type="button" onclick="location.href = '<?php echo $current_step->getStepUrl() ?>'; return true;">Try Again &raquo;</button>
  <?php } else { // if ?>
    <button type="submit">Next &raquo;</button>
  <?php	} // if ?>
  
<?php } else { ?>
<?php if (isset($absolute_url)) { ?>
  <button type="button" onclick="location.href = '<?php echo $absolute_url ?>'">Finish</button>
<?php } else {?>
  <button type="button" onclick="location.href = '../../index.php'">Finish</button>
<?php } // if ?>
<?php } // if ?>
</div>
