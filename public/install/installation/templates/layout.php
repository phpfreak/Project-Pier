<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title><?php echo $installation_name ?></title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
  <link rel="Shortcut Icon" href="<?php echo ROOT_URL ?>/favicon.ico" type="image/x-icon" />
  <link rel="stylesheet" href="assets/style.css" media="all" />
</head>
<body>
  <div id="wrapper">
    <div id="header">
      <h1><?php echo $installation_name ?></h1>
      <div id="installationDesc"><?php echo clean($installation_description) ?></div>
    </div>
    <form action="<?php echo $current_step->getStepUrl() ?>" id="installerForm" method="post">
      <?php $this->includeTemplate(get_template_path('__step_errors.php')) ?>
      <div id="content"><?php echo $content_for_layout ?></div>
      <!-- <h2 style="color: #ff0000; font-weight:bold;">WARNING - THIS IS A BETA VERSION, USE FOR TESTING PURPOSES ONLY!</h2> --->
      <?php $this->includeTemplate(get_template_path('__step_controls.php')) ?>
      <input type="hidden" name="submitted" value="submitted" />
    </form>
    <div id="footer">
    <ul>
      <li><a href="http://www.projectpier.org/" target="_blank">ProjectPier</a> is provided free of charge under the <a href="http://www.projectpier.org/AGPL" target="_blank">Gnu Affero General Public License (AGPL).</a></li>
      <li>If you have problems, check the <a href="http://www.projectpier.org/forum/" target="_blank">support forum</a></ul>
    </ul>  
    </div>
  </div>

</body>
</html>