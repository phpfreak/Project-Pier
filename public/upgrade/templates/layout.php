<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title><?php echo clean($upgrader->getName()) ?></title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
  <link rel="Shortcut Icon" href="favicon.ico" type="image/x-icon" />
  <link rel="stylesheet" href="assets/style.css" media="all" />
</head>
<body>
  <div id="wrapper">
    <div id="header">
      <h1><?php echo clean($upgrader->getName()) ?></h1>
      <div id="installationDesc"><?php echo clean($upgrader->getDescription()) ?></div>
    </div>
    <form action="index.php" id="upgraderForm" method="post">
      <div id="upgraderControls">
        <table class="formBlock">
          <tr>
            <th colspan="2">Upgrade</th>
          </tr>
          <tr>
            <td class="optionLabel"><label for="upgradeFormScript">Script</label></td>
            <td>
              <select name="form_data[script_class]" id="upgradeFormScript">
<?php foreach ($upgrader->getScripts() as $script) { ?>
                <option value="<?php echo clean(get_class($script)) ?>"><?php echo clean($script->getScriptName()) ?></option>
<?php } // foreach ?>
              </select>
            </td>
          </tr>
        </table>
        <button type="submit" accesskey="s">Upgrade (Alt+S)</button>
      </div>
      <div id="content">
<?php if (isset($status_messages) && count($status_messages)) { ?>
        <ul>
<?php foreach ($status_messages as $status_message) { ?>
          <li><?php echo $status_message ?></li>
<?php } // foreach ?>
        </ul>
<?php } // if ?>
      </div>
      <input type="hidden" name="submitted" value="submitted" />
    </form>
    <div id="footer">&copy; <?php echo date('Y') ?> <a href="http://www.projectpier.org/">ProjectPier</a>. All rights reserved.</div>
  </div>

</body>
</html>