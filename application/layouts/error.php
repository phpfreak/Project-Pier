<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title><?php echo get_page_title() ?></title>
<?php echo meta_tag('content-type', 'text/html; charset=utf-8', true) ?> 
<?php echo link_tag(ROOT_URL.'favicon.ico', 'rel', 'Shortcut Icon', array("type"=>"image/x-icon")) ?>
<?php echo render_page_head() ?>
    <style>
      * {
        margin: 0;
        padding: 0;
      }
      
      body {
        font: 12px verdana, arial, helvetica, sans-serif;
        color: black;
        background: white;
        text-align: center;
        line-height: 150%;
      }
      
      a {
        color: #263356;
        font-weight: bolder;
        text-decoration: none;
        border-bottom: 1px dotted #ccc;
      }
      
      a:hover {
        border: 0;
        color: white;
        background: #263356;
      }
      
      h1 {
        margin: 0 0 5px 0;
        padding: 0 0 5px 0;
        color: #263356;
        font-size: 20px;
        border-bottom: 3px double #ccc;
      }
      
      h2 {
        margin: 10px 0;
        color: #263356;
        font-size: 16px;
      }
      
      p, ul, pre {
        margin: 8px 0;
      }
      
      ul {
        padding-left: 20px;
        list-style: square;
      }
      
      code {
        padding: 0 2px;
        font-size: 1.2em;
        background: #e8e8e8;
      }
      
      pre {
        border: 1px solid #263356;
        padding: 0 8px;
        font-size: 1.2em;
        background: #e8e8e8;
      }
      
      acronym {
        border-bottom: 1px dotted #ccc;
        cursor: help;
      }
      
      /** Construction **/
      
      #dialog {
        margin: 100px auto 0 auto;
        border: 3px solid #ccc;
        padding: 10px;
        width: 332px;
        text-align: left;
      }
    </style>
  </head>
  <body>
    <div id="dialog">
      <h1><?php echo get_page_title() ?></h1>
      <?php echo $content_for_layout ?>
    </div>
  </body>
</html>