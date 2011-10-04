<h1 class="pageTitle"><span>Step <?php echo $current_step->getStepNumber() ?>:</span> Database configuration</h1>
<table class="formBlock">
  <tr>
    <th colspan="2"></th>
  </tr>
  
  <tr>
    <td class="optionLabel"><label for="configFormDatabaseType">Database type:</label></td>
    <td>
      <select name="config_form[database_type]" id="configFormDatabaseType">
        <option value="mysql">MySQL</option>
      </select>
    </td>
  </tr>
</table>

<table class="formBlock">
  <tr>
    <th colspan="2">Connection</th>
  </tr>
  
  <tr>
    <td class="optionLabel"><label for="configFormDatabaseHost">Database host:</label></td>
    <td><input type="text" name="config_form[database_host]" id="configFormDatabaseHost" value="<?php echo array_var($config_form_data, 'database_host') ?>" /></td>
  </tr>

  <tr>
    <td class="optionLabel"><label for="configFormDatabaseUser">Database user:</label></td>
    <td><input type="text" name="config_form[database_user]" id="configFormDatabaseUser" value="<?php echo array_var($config_form_data, 'database_user') ?>" /></td>
  </tr>
  
  <tr>
    <td class="optionLabel"><label for="configFormDatabasePass">Database password:</label></td>
    <td><input type="password" name="config_form[database_pass]" id="configFormDatabasePass" value="<?php echo array_var($config_form_data, 'database_pass') ?>" /></td>
  </tr>
  
</table>

<table class="formBlock">
  <tr>
    <th colspan="2">Database</th>
  </tr>
  
  <tr>
    <td class="optionLabel"><label for="configFormDatabaseName">Database name:</label></td>
    <td><input type="text" name="config_form[database_name]" id="configFormDatabaseName" value="<?php echo array_var($config_form_data, 'database_name') ?>" /></td>
  </tr>

  <tr>
    <td class="optionLabel"><label for="configFormDatabaseCreate">Create database:</label></td>
    <td>
      <select name="config_form[database_create]" id="configFormDatabaseCreate">
        <option value="no">No</option>
        <option value="yes">Yes</option>
      </select>
    </td>
  </tr>

  <tr>
    <td class="optionLabel"><label for="configFormDatabaseCharSet">Character set:</label></td>
    <td><input type="text" name="config_form[database_charset]" id="configFormDatabaseCharSet" readonly value="<?php echo array_var($config_form_data, 'database_charset') ?>" /></td>
  </tr>
  
  <tr>
    <td class="optionLabel"><label for="configFormDatabasePrefix">Table prefix:</label></td>
    <td><input type="text" name="config_form[database_prefix]" id="configFormDatabasePrefix" value="<?php echo array_var($config_form_data, 'database_prefix') ?>" /></td>
  </tr>
</table>