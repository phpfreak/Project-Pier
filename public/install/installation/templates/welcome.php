<h1 class="pageTitle"><span>Step <?php echo $current_step->getStepNumber() ?>:</span> Welcome</h1>
<p>ProjectPier is an open source collaboration and project management system.  Please make sure
you meet the minimum system requirements and have the database login information below before
proceeding.</p>
<h2>System Requirements:</h2>
<ul>
  <li>PHP 5.0.2 or greater (MySQL, GD and SimpleXML extensions are required.)</li>
  <li>MySQL 4.1 or greater with InnoDB support</li>
  <li>Apache 2.0 or greater or IIS 5.0 or greater</li>
</ul>

<h2>Information you will need for installation:</h2>
<ul>
  <li>MySQL Host Name (usually 'localhost')</li>
  <li>MySQL Username</li>
  <li>MySQL Password</li>
  <li>MySQL Database Name</li>
  <li>The absolute URL to your installation root (ex. http://www.your-projectpier-site.com/projectpier/)</li>
</ul>

<h2>Installation steps:</h2>
<ol>
<?php foreach ($installer->getSteps() as $this_step) { ?>
  <li><?php echo clean($this_step->getName()) ?></li>
<?php } // foreach ?>
</ol>
