<?php $owner_company_name = clean(owner_company()->getName()); ?>
<?php $site_name = config_option('site_name', $owner_company_name); ?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo get_page_title(); ?> | <?php echo $site_name; ?></title>

  <?php echo meta_tag('content-type', 'text/html; charset=utf-8', true); ?>
  <?php echo render_page_meta(); ?> 
  
  <?php echo link_tag(ROOT_URL.'favicon.ico', 'rel', 'shortcut icon', array("type"=>"image/x-icon")); ?> 
  <?php echo link_tag(ROOT_URL.'favicon.ico', 'rel', 'icon', array("type"=>"image/x-icon")); ?>
  <?php echo render_page_links(); ?> 

  <?php echo stylesheet_tag('project_website.css'); ?> 
  <?php echo stylesheet_tag('colorbox/colorbox.css'); ?> 
  <?php echo render_page_inline_css(); ?> 

  <?php echo javascript_tag('jquery-1.9.1.js'); ?> 
  <?php echo javascript_tag('bootstrapp.js'); ?> 
  <?php include('inlinejs.php'); ?> 
  <?php echo render_page_javascript(); ?>
  <?php echo render_page_inline_js(); ?> 
</head>
<body>
    <script src="../javascript/jquery-1.9.1.js"></script>
    <script src="../javascript/bootstrap.min.js"></script>
<?php echo render_system_notices(logged_user()); ?>
    <div id="wrapper">
    
      <!-- header -->
      <div id="headerWrapper">
        <div id="header">
          <h1><a href="<?php echo get_url('dashboard') ?>"><?php echo $site_name ?></a></h1>
          <h2><a href="<?php echo get_url('administration') ?>"><?php echo lang('administration') ?></a></h2>
        </div>
      </div>
      <!-- /header -->
<div class="row-fluid">      
<div class="span2"><div id="userboxWrapper"><?php echo render_user_box(logged_user()) ?></div></div>
      <!-- content wrapper -->
      <div class="span10">
      <div id="outerContentWrapper">
<div class="navbar"> <div class="navbar-inner"> <!-- tabs wrapper -->
<?php if (is_array(tabbed_navigation_items())) { ?>
          <ul class="nav">
<?php foreach (tabbed_navigation_items() as $tabbed_navigation_item) { ?>
            <li id="tabbed_navigation_item_<?php echo $tabbed_navigation_item->getID() ?>" <?php if ($tabbed_navigation_item->getSelected()) { ?> class="active" <?php } ?>><a href="<?php echo $tabbed_navigation_item->getUrl() ?>"><?php echo clean($tabbed_navigation_item->getTitle()) ?></a></li>
<?php } // foreach ?>
          </ul>
<?php } // if ?>
        </div>
      </div> <!-- /tabs wrapper -->
      
      <div id="crumbsWrapper" class="row"> <!-- crumbs wrapper -->
        <div id="crumbsBlock">
          <div id="crumbs">
<?php if (is_array(bread_crumbs())) { ?>
            <ul class="">
<?php foreach (bread_crumbs() as $bread_crumb) { ?>
<?php if ($bread_crumb->getUrl()) { ?>
              <li><a href="<?php echo $bread_crumb->getUrl() ?>"><?php echo clean($bread_crumb->getTitle()) ?></a> &raquo;</li>
<?php } else {?>
              <li><span><?php echo clean($bread_crumb->getTitle()) ?></span></li>
<?php } // if {?>
<?php } // foreach ?>
            </ul>
<?php } // if ?>
          </div>
        </div>
      </div> <!-- /crumbs wrapper -->

        <div id="innerContentWrapper">
<?php if (!is_null(flash_get('success'))) { ?>
          <div id="success" onclick="this.style.display = 'none'"><?php echo clean(flash_get('success')) ?></div>
<?php } ?>
<?php if (!is_null(flash_get('error'))) { ?>
          <div id="error" onclick="this.style.display = 'none'"><?php echo clean(flash_get('error')) ?></div>
<?php } ?>
          <div id="pageHeader" class="row"><span id="pageTitle"><?php echo get_page_title() ?> - dashboard</span>
                <?php if (is_array(page_actions())) { ?>
                <div id="actionwrap" class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-chevron-down"></i></a>
                  <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                      <?php foreach (page_actions() as $page_action) { ?>
                      <li><a href="<?php echo $page_action->getURL() ?>"><?php echo clean($page_action->getTitle()) ?> - dashboard</a></li>
                      <?php } // foreach ?>
                  </ul>
                </div>
                <?php } else { // if ?>
                <?php } // if ?>
          </div>
          <div id="pageContent">
<div class="row-fluid">
  <div class="span10">
            <div id="content">
              <!-- Content -->
              <?php echo $content_for_layout ?>
              <!-- /Content -->
            </div>
  </div>
  <div class="span2">
<?php if (isset($content_for_sidebar)) { ?>
            <div id="sidebar"><?php echo $content_for_sidebar ?></div>
<?php } // if ?>
  </div>
</div>
            <div class="clear"></div>
        </div>
      </div>
        </div>
        
        <!--Footer -->
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
      </div><!-- /content wrapper -->
      </div><!-- /span10 -->
   </div> <!-- /row_fluid -->  
    </div>
  </body>
</html>
