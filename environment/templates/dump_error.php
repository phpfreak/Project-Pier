<?php if (!isset($error) || !instance_of($error, 'Error')) return; ?>
<?php if (!$css_rendered) { ?>
<style type="text/css">
  div.error_dump table, div.error_dump th, div.error_dump tr, div.error_dump td {
    font-family: verdana, helvetica, sans-serif; 
    font-size: 12px; 
    background: whote; 
    color: black; 
    border-collapse: collapse; 
    border: 3px solid black;
  }
  
  div.error_dump th {
    background: red;
    color: white;
  }
  
  div.error_dump tr, div.error_dump th, div.error_dump td {
    padding: 5px;
    border: 1px solid #ccc;
  }
  
  div.error_dump .bold {
    font-weight: bolder;
  }
  
  div.error_dump .monospace {
    font-family: "Courier new", monospace;
  }
  
  td ul {
    margin: 0;
    padding: 0 0 0 20px;
    list-style: square;
  }
  
</style>
<?php $css_rendered = true; ?>
<?php } // if ?>
<div class="error_dump">
<table>
  <tr>
    <th colspan="2">Error (<?php echo get_class($error) ?>)</th>
  </tr>
  <tr>
    <td colspan="2" style="padding: 15px 7px"><?php echo clean($error->getMessage()) ?></td>
  </tr>
<?php if (is_array($error->getParams())) { ?>
  <tr>
    <td class="bold" colspan="2">Error params:</td>
  </tr>
<?php foreach ($error->getParams() as $param_name => $param_value) { ?>
  <tr>
    <td><?php echo clean(ucfirst($param_name)) ?>:</td>
    <td class="monospace">
<?php if (is_scalar($param_value)) { ?>
      <?php echo clean($param_value) ?>
<?php } elseif (is_null($param_value)) { ?>
      NULL
<?php } else { ?>
      <?php echo pre_var_dump($param_value) ?>
<?php } // if ?>
    </td>
  </tr>
<?php } // foreachs ?>
<?php } ?>

  <tr>
    <td class="bold" colspan="2">Backtrace:</td>
  </tr>
  <tr>
    <td colspan="2" class="monospace"><?php echo nl2br($error->getTraceAsString()) ?></td>
  </tr>

  <tr>
    <td class="bold" colspan="2">Autoglobal varibles:</td>
  </tr>
  <tr>
    <td style="vertical-align: top">$_GET:</td>
    <td class="monospace">
<?php if (isset($_GET) && is_array($_GET) && count($_GET)) { ?>
<?php echo nl2br(clean_var_info($_GET)) ?>
<?php } // if ?>
    </td>
  </tr>
  <tr>
    <td style="vertical-align: top">$_POST:</td>
    <td class="monospace">
<?php if (isset($_POST) && is_array($_POST) && count($_POST)) { ?>
<?php echo nl2br(clean_var_info($_POST)) ?>
<?php } // if ?>
    </td>
  </tr>
  <tr>
    <td style="vertical-align: top">$_COOKIE:</td>
    <td class="monospace">
<?php if (isset($_COOKIE) && is_array($_COOKIE) && count($_COOKIE)) { ?>
<?php echo nl2br(clean_var_info($_COOKIE)) ?>
<?php } // if ?>
    </td>
  </tr>
  <tr>
    <td style="vertical-align: top">$_SESSION:</td>
    <td class="monospace">
<?php if (isset($_SESSION) && is_array($_SESSION) && count($_SESSION)) { ?>
<?php echo nl2br(clean_var_info($_SESSION)) ?>
<?php } // if ?>
    </td>
  </tr>
  
<?php if (function_exists('benchmark_timer_total_execution_time')) { ?>
  <tr>
    <td colspan="2" class="bold">Execution time:</th>
  </tr>
  <tr>
    <td colspan="2">Total execution time: <?php echo benchmark_timer_total_execution_time() ?> seconds</td>
  </tr>
<?php } // if ?>
  
</table>
</div>