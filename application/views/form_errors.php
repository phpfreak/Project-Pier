<?php if (isset($error) && ($error instanceof Error)) { ?>
<!-- Form errors -->
<div id="formErrors">
<?php if (($error instanceof DAOValidationError) || ($error instanceof FormSubmissionErrors)) { ?>
  <p><?php echo lang('error form validation') ?></p>
  <ul>
<?php foreach ($error->getErrors() as $err) { ?>
    <li><?php echo clean($err) ?></li>
<?php } // foreach ?>
  </ul>
<?php } else { ?>
  <p><?php echo clean($error->getMessage()) ?></p>
<?php } // if ?>
</div>
<?php } // if ?>