<?php
  set_page_title(lang('edit logo'));
  administration_tabbed_navigation('i18n');
  administration_crumbs(lang('i18n'), get_url('i18n'));

  add_page_action(lang('add locale'), get_url('i18n', 'add_locale', array('status' => '0')));
  add_stylesheet_to_page('i18n.css');
  add_stylesheet_to_page('imgareaselect/imgareaselect-animated.css');
?>
<script type='text/javascript'> 
$(function () {
  $('#snapshot').imgAreaSelect({ 
    aspectRatio: '1:1', 
    handles: true,
    fadeSpeed: 200,
    resizeable:false,
    maxHeight:300,
    maxWidth:300,			
    minHeight:20,
    minWidth:20,
    show: true,
    x1: 0,			
    y1: 0,			
    x2: 50,			
    y2: 50,			
    onSelectChange: preview,
    onSelectEnd: selectend
  });
});
function preview(img, selection) {
  if (!selection.width || !selection.height)
    return;
		
  //50 is the #preview dimension, change this to your liking
  var scaleX = 50 / selection.width; 
  var scaleY = 50 / selection.height;

  $('#preview img').css({
    width: Math.round( scaleX * $('#snapshot').attr('width') ),
    height: Math.round(scaleY * $('#snapshot').attr('height')),
    marginLeft: -Math.round(scaleX * selection.x1),
    marginTop: -Math.round(scaleY * selection.y1)
  });
  //alert(selection.x);
}
function selectend (img, selection) {
  $('input[name=x1]').val(selection.x1);
  $('input[name=y1]').val(selection.y1);
  $('input[name=x2]').val(selection.x2);
  $('input[name=y2]').val(selection.y2);            
}
</script>

<form action="<?php echo $locale->getEditLogoUrl() ?>" method="post" enctype="multipart/form-data">
  <input type="hidden" name="x1" value="" />
  <input type="hidden" name="y1" value="" />
  <input type="hidden" name="x2" value="" />
  <input type="hidden" name="y2" value="" />
<?php tpl_display(get_template_path('form_errors')) ?>
  
  <fieldset>
    <legend><?php echo lang('current logo') ?></legend>
<?php if ($locale->hasLogo()) { ?>
    <img src="<?php echo $locale->getLogoUrl() ?>" alt="<?php echo clean($locale->getName()) ?> logo" />
    <p><a href="<?php echo $locale->getDeleteLogoUrl() ?>" onclick="return confirm('<?php echo lang('confirm delete logo') ?>')"><?php echo lang('delete logo') ?></a></p>
<?php } else { ?>
    <?php echo lang('no current logo') ?>
<?php } // if ?>
  </fieldset>
  <fieldset>
    <legend><?php echo lang('new logo'); ?></legend>
<?php if ($locale->hasLogo()) { ?>
    <p class="desc"><?php echo lang('new logo notice') ?></p>
<?php } // if ?>
    <?php echo label_tag(lang('file'), 'localeFormLogo', false) ?>
    <?php echo file_field('new_logo', null, array('id' => 'localeFormLogo')) ?>
  </fieldset>
  <?php echo submit_button(lang('upload')) ?> <a href="<?php echo get_url('i18n'); ?>"><?php echo lang('cancel') ?></a>
</form>