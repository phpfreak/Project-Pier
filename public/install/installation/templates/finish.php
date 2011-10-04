<h1 class="pageTitle"><span>Step <?php echo $current_step->getStepNumber() ?>:</span> Finish</h1>
<p>Installation process:</p>
<?php if (isset($status_messages)) { ?>
<ul>
<?php foreach ($status_messages as $status_message) { ?>
  <li><?php echo $status_message ?></li>
<?php } // foreach ?>
</ul>
<?php } // if ?>

<?php if (isset($all_ok) && $all_ok) { ?>
<h1>Success!</h1>
<p>You have installed ProjectPier <strong>successfully</strong>. Press Finish and start managing your projects. ProjectPier will ask you to create an administrator and provide some details about your company first.</p>
<p><strong>Visit <a href="http://www.projectpier.org/">www.ProjectPier.org</a> for news and updates.</strong>. 
<?php } // if ?>