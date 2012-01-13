<?php $owner_company_name = clean(owner_company()->getName()) ?>
<?php $site_name = config_option('site_name', $owner_company_name) ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title><?php echo get_page_title() ?> | <?php echo $site_name ?></title>
<?php echo stylesheet_tag('company_website.css') ?> 
<?php echo stylesheet_tag('colorbox/colorbox.css') ?> 
<?php echo meta_tag('content-type', 'text/html; charset=utf-8', true) ?> 
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<?php echo link_tag(ROOT_URL.'favicon.ico', 'rel', 'Shortcut Icon', array("type"=>"image/x-icon")) ?>
<?php echo link_tag(logged_user()->getRecentActivitiesFeedUrl(), 'rel', 'alternate', array("type"=>"application/rss+xml", "title"=>lang('recent activities feed'))) ?>
<?php add_javascript_to_page('pp.js') ?>
<?php add_javascript_to_page('jquery.min.js') ?>
<?php add_javascript_to_page('jquery-ui.min.js') ?>
<?php add_javascript_to_page('jquery.colorbox-min.js') ?>
<?php add_javascript_to_page('jquery.imgareaselect.dev.js') ?>
<?php add_javascript_to_page('jquery.jeditable.mini.js') ?>
<?php echo render_page_head() ?>
</head>
  <body id="body">
<?php include('inlinejs.php') ?>
<?php echo render_system_notices(logged_user()) ?>
    <div id="wrapper">
    
      <!-- header -->
      <div id="headerWrapper">
        <div id="header">
          <h1><a href="<?php echo get_url('dashboard', 'index') ?>"><?php echo $site_name ?></a></h1>
          <div id="userboxWrapper"><?php echo render_user_box(logged_user()) ?></div>
        </div>
      </div>
      <!-- /header -->
      <div id="tabsWrapper">
        <div id="tabs">
<?php if (is_array(tabbed_navigation_items())) { ?>
          <ul>
<?php foreach (tabbed_navigation_items() as $tabbed_navigation_item) { ?>
            <li id="tabbed_navigation_item_<?php echo $tabbed_navigation_item->getID() ?>" <?php if ($tabbed_navigation_item->getSelected()) { ?> class="active" <?php } ?>><a href="<?php echo $tabbed_navigation_item->getUrl() ?>"><?php echo clean($tabbed_navigation_item->getTitle()) ?></a></li>
<?php } // foreach ?>
          </ul>
<?php } // if ?>
        </div>
      </div>
      
      <div id="crumbsWrapper">
        <div id="crumbsBlock">
          <div id="crumbs">
<?php if (is_array(bread_crumbs())) { ?>
            <ul class="lavaLampNoImage">
<?php foreach (bread_crumbs() as $bread_crumb) { ?>
<?php if ($bread_crumb->getUrl()) { ?>
              <li><a href="<?php echo $bread_crumb->getUrl() ?>"><?php echo clean($bread_crumb->getTitle()) ?></a></li>
<?php } else {?>
              <li><a href="#"><span><?php echo clean($bread_crumb->getTitle()) ?></span></a></li>
<?php } // if {?>
<?php } // foreach ?>
            </ul>
<?php } // if ?>
          </div>
        </div>
      </div>

      <!-- content wrapper -->
      <div id="outerContentWrapper">
        <div id="innerContentWrapper">
<?php if (!is_null(flash_get('success'))) { ?>
          <div id="success"><?php echo clean(flash_get('success')) ?></div>
<?php } ?>
<?php if (!is_null(flash_get('error'))) { ?>
          <div id="error"><?php echo clean(flash_get('error')) ?></div>
<?php } ?>
 <div style="clear:both"></div>
          <div id="pageHeader"><span id="pageTitle"><?php echo get_page_title() ?></span><?php include('pageoptions.php'); ?></div>
          <div id="pageContent">
            <div id="content">
              <!-- Content -->
              <?php echo $content_for_layout ?>
              <!-- /Content -->
            </div>
<?php if (isset($content_for_sidebar)) { ?>
            <div id="sidebar"><?php echo $content_for_sidebar ?></div>
<?php } // if ?>
            <div class="clear"></div>
          </div>
        </div>
        
        <!--footer -->
        <div id="footer">
          <div id="copy">
<?php if (is_valid_url($owner_company_homepage = owner_company()->getHomepage())) { ?>
            <?php echo lang('footer copy with homepage', date('Y'), $owner_company_homepage, clean(owner_company()->getName())) ?>
<?php } else { ?>
            <?php echo lang('footer copy without homepage', date('Y'), clean(owner_company()->getName())) ?>
<?php } // if ?>
          </div>
          <div id="productSignature"><?php echo product_signature() ?><span id="request_duration"><?php printf(' in %.3f seconds', (microtime(true) - $GLOBALS['request_start_time']) ); ?></span> <span id="current_datetime"><?php echo date('c/I[W]'); ?></span></div>
        </div>
        <!--footer -->
      </div>
      <!-- /content wrapper -->
    </div>
  </body>
</html>