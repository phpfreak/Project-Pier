<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title><?php echo get_page_title() ?></title>
<?php echo stylesheet_tag('dialog.css') ?> 
<?php echo meta_tag('content-type', 'text/html; charset=utf-8', true) ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<?php echo meta_tag('robots', 'noindex, nofollow', false) ?> 
<?php echo link_tag(ROOT_URL.'favicon.ico', 'rel', 'Shortcut Icon', array("type"=>"image/x-icon")) ?>
<?php echo render_page_head() ?>
  </head>
  <body>
<?php echo $content_for_layout ?>
  </body>
</html>