<?php
  set_page_title(lang('edit logo'));
  project_tabbed_navigation();
  project_crumbs(array(
    array(lang('links'), get_url('links')),
    array(lang('edit logo'))
  ));
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

<form action="<?php echo $link->getEditLogoUrl() ?>" method="post" enctype="multipart/form-data">
  <input type="hidden" name="x1" value="" />
  <input type="hidden" name="y1" value="" />
  <input type="hidden" name="x2" value="" />
  <input type="hidden" name="y2" value="" />
<?php tpl_display(get_template_path('form_errors')) ?>
  
  <fieldset>
    <legend><?php echo lang('current logo') ?></legend>
<?php if ($link->hasLogo()) { ?>
    <img src="<?php echo $link->getLogoUrl() ?>" alt="<?php echo clean($link->getName()) ?> logo" />
    <p><a href="<?php echo $link->getDeleteLogoUrl() ?>" onclick="return confirm('<?php echo lang('confirm delete logo') ?>')"><?php echo lang('delete logo') ?></a></p>
<?php } else { ?>
    <?php echo lang('no current logo') ?>
<?php } // if ?>
  </fieldset>
  <fieldset>
    <legend><?php echo lang('new logo'); ?></legend>
<?php if ($link->hasLogo()) { ?>
    <p class="desc"><?php echo lang('new logo notice') ?></p>
<?php } // if ?>
    <?php echo label_tag(lang('file'), 'linkFormLogo', false) ?>
    <?php echo file_field('new_logo', null, array('id' => 'linkFormLogo')) ?>
    <?php echo label_tag(lang('snapshot'), 'linkFormSnapshot', false) ?>
    <span id="linkFormSnapshot" style="float: left;"><img id="snapshot" src="http://wimg.ca/<?php echo $link->asUrl(); ?>" width="256" height="192"></span>
    <span id="preview" style="margin-left: 20px; float: left; display: block; overflow:hidden; width:50px; height:50px;"><img src="http://wimg.ca/<?php echo $link->asUrl(); ?>"></span>    
  </fieldset>
  <?php echo submit_button(lang('upload')) ?> <a href="<?php echo get_url('links'); ?>"><?php echo lang('cancel') ?></a>
</form>