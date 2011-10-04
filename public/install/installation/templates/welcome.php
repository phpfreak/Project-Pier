<h1 class="pageTitle"><span>Step <?php echo $current_step->getStepNumber() ?>:</span> Welcome</h1>
<p>ProjectPier is an open source collaboration and project management system.  Please make sure
you meet the minimum system requirements and have the database login information below before
proceeding.</p>
<h2>System Requirements:</h2>
<ul>
  <li>At least PHP 5.2 (MySQL required, GD and SimpleXML optional)</li>
  <li>At least MySQL 4.1 (InnoDB support preferred)</li>
  <li>At least Apache 2.0 or IIS 5.0</li>
</ul>

<h2>Information you need to supply:</h2>
<ul>
  <li>Database Host</li>
  <li>Database User</li>
  <li>Database Password</li>
  <li>Database Name</li>
  <li>Table Prefix</li>
</ul>

<h2>Installation steps:</h2>
<ol>
<?php foreach ($installer->getSteps() as $this_step) { ?>
  <li><?php echo clean($this_step->getName()) ?></li>
<?php } // foreach ?>
</ol>