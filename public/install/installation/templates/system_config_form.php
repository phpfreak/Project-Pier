<h1 class="pageTitle"><span>Step <?php echo $current_step->getStepNumber() ?>:</span> System settings</h1>
<table class="formBlock">
  <tr>
    <th colspan="2">Database connection</th>
  </tr>
  
  <tr>
    <td class="optionLabel"><label for="configFormDatabaseType">Database type:</label></td>
    <td>
      <select name="config_form[database_type]" id="configFormDatabaseType">
        <option value="mysql">MySQL</option>
      </select>
    </td>
  </tr>
  
  <tr>
    <td class="optionLabel"><label for="configFormDatabaseHost">Host name:</label></td>
    <td><input type="text" name="config_form[database_host]" id="configFormDatabaseHost" value="<?php echo array_var($config_form_data, 'database_host', 'localhost') ?>" /></td>
  </tr>
  
  <tr>
    <td class="optionLabel"><label for="configFormDatabaseUser">Username:</label></td>
    <td><input type="text" name="config_form[database_user]" id="configFormDatabaseUser" value="<?php echo array_var($config_form_data, 'database_user') ?>" /></td>
  </tr>
  
  <tr>
    <td class="optionLabel"><label for="configFormDatabasePass">Password:</label></td>
    <td><input type="password" name="config_form[database_pass]" id="configFormDatabasePass" value="<?php echo array_var($config_form_data, 'database_pass') ?>" /></td>
  </tr>
  
  <tr>
    <td class="optionLabel"><label for="configFormDatabaseName">Database name:</label></td>
    <td><input type="text" name="config_form[database_name]" id="configFormDatabaseName" value="<?php echo array_var($config_form_data, 'database_name') ?>" /></td>
  </tr>
  
  <tr>
    <td class="optionLabel"><label for="configFormDatabasePrefix">Table prefix:</label></td>
    <td><input type="text" name="config_form[database_prefix]" id="configFormDatabasePrefix" value="<?php echo array_var($config_form_data, 'database_prefix', 'pp_') ?>" /></td>
  </tr>
</table>

<table class="formBlock">
  <tr>
    <th colspan="2">Other settings</th>
  </tr>
  
  <tr>
    <td class="optionLabel"><label for="configFormAbsoluteUrl">Absolute script URL:</label></td>
    <td><input type="text" name="config_form[absolute_url]" id="configFormAbsoluteUrl" value="<?php echo array_var($config_form_data, 'absolute_url', $installation_url) ?>" /></td>
  </tr>
</table>
