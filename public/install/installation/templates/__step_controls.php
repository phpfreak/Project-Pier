<div id="installerControls">
<?php if ($current_step->hasNextStep()) { ?>
  <?php if ($current_step->hasPreviousStep()) { ?>
    <button type="button" onclick="location.href = '<?php echo $current_step->getPreviousStepUrl() ?>'; return true;">Back</button>&nbsp;
  <?php } // if ?>

  <?php if ($current_step->getNextDisabled()) { ?>
    <button type="button" onclick="location.href = '<?php echo $current_step->getStepUrl() ?>'; return true;">Try Again</button>
  <?php } else { // if ?>
    <button type="submit">Next</button>
  <?php	} // if ?>
  
<?php } else { ?>
  <?php $url = '/'; ?>
  <?php if (isset($relative_url)) { $url = $relative_url; } ?>
  <?php if (isset($absolute_url)) { $url = $absolute_url; } ?>
    <button type="button" onclick="location.href = '<?php echo $url ?>'">Finish</button>
<?php } // if ?>
</div>