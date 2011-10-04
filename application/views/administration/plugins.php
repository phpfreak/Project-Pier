<?php

  set_page_title(lang('plugins'));
  administration_tabbed_navigation(ADMINISTRATION_TAB_PLUGINS);
  administration_crumbs(lang('plugins'), 'index');
  add_stylesheet_to_page('project/messages.css');
?>
<?php if (isset($plugins) && is_array($plugins) && count($plugins)) { ?>
<script language="JavaScript">
  function toggleVisibility(me) {
    if (me.style.visibility=="hidden") {
      me.style.visibility="visible";
    } else {
      me.style.visibility="hidden";
    }
  }
  function toggleDisplay(me) {
    if (me.style.display=="none") {
      me.style.display="block";
    } else {
      me.style.display="none";
    }
  }
</script>
<div id="plugins">
  <form action="<?php echo get_url('administration', 'update_plugins') ?>" method="post">
  <fieldset>
    <legend><?php echo lang('list of plugins') ?></legend>
  
  <?php tpl_display(get_template_path('form_errors')) ?>
  
<?php 
  $count = 0;
  foreach($plugins as $name=>$id) {
    $count++;
    $oddeven = ($count%2) ? 'odd' : 'even';
?>
    <div class="objectOption <?php echo $oddeven ?>">
      <div class="optionLabel"><label><?php echo ucwords(str_replace('_',' ',$name)) ?>:</label></div>
      <div class="optionControl">
	<?php if ('-'==$id) { ?>
	  	<input id="<?php echo $name; ?>Yes" class="yes_no" value="1" type="radio" name="plugins[<?php echo $name; ?>]" /> <label class="yes_no" for="<?php echo $name; ?>Yes"><?php echo lang('activated'); ?> </label> 
	  	<input id="<?php echo $name; ?>No" class="yes_no" value="0" type="radio" checked="checked" name="plugins[<?php echo $name; ?>]" /> <label class="yes_no" for="<?php echo $name; ?>No"><?php echo lang('deactivated'); ?></label>
	<?php } else { ?>
	    <input id="<?php echo $name; ?>Yes" onclick="javascript:toggleDisplay(document.getElementById('keep_data_<?php echo $name; ?>'))" checked="checked" class="yes_no" value="1" type="radio" name="plugins[<?php echo $name; ?>]" /> <label class="yes_no" for="<?php echo $name; ?>Yes"><?php echo lang('activated'); ?> </label> 
	    <input id="<?php echo $name; ?>No" onclick="javascript:toggleDisplay(document.getElementById('keep_data_<?php echo $name; ?>'))" class="yes_no" value="0" type="radio" name="plugins[<?php echo $name; ?>]" /> <label class="yes_no" for="<?php echo $name; ?>No"><?php echo lang('deactivated'); ?> </label>
	<?php } ?>
      </div>
      <div id="keep_data_<?php echo $name; ?>" style="display:none" class="optionControl">
     	<?php echo lang('what to do with data') ?><br /> 
     	<?php echo yes_no_widget('plugins['.$name.'_data]', $name.'_data', true, lang('keep data'), lang('delete data')) ?> 
      </div>
    </div>
<?php } ?>
    <p><?php echo submit_button(lang('update plugins')) ?></p>
  </fieldset>
  </form>
</div>

<?php } else { ?>
<p><?php echo lang('no plugins found') ?></p>
<?php } // if ?>