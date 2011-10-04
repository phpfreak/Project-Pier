<div>
    <?php echo label_tag(lang('start date'), 'viewReportStartDate', false) ?>
    <?php echo pick_date_widget('report_start_date', array_var($report_data, 'start_date')) ?>
    <input class="submit" type="button" onclick="refresh();" value="<?php echo lang('refresh');?>"></input>  </div>
  <div>
    <?php echo label_tag(lang('end date'), 'viewReportEndDate', false) ?>
    <?php echo pick_date_widget('report_end_date', array_var($report_data, 'end_date')) ?>
    <input class="submit" type="button" onclick="downloadganttfile();" value="<?php echo lang('download');?>"></input>
  </div>
  <br />
  <div id="GANTT" style="height:auto;width:auto;display:block">&nbsp;</div>
  <img id="GRAPH" src="<?php echo $urlGantt . '&' . time(); ?>" />