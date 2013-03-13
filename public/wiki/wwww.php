<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html><head><title>Public wiki</title>
<link href="wwww.css" rel="Stylesheet" type="text/css" /> 
<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
</head><body id="body">
<?php
require '../../config/config.php';
require '../../library/textile/Textile.class.php';
require '../../environment/functions/general.php';
//require '../../environment/environment.php';
//require '../../application/plugins/wiki/helpers/wiki.php';


function do_textile($text) {
  $textile = new Textile();
  //$text = $textile->TextileRestricted($text, false, false); 
  $text = $textile->TextileThis($text, false, false); 
  //return $text;
  return add_links($text);
} // do_textile


function pp_pages() {
  $pages = array(); 
  $prefix = str_replace('_', '_', DB_PREFIX);
  $sql = "SELECT a.`project_index`, c.`id` as project_id, a.`id` as page_id, c.`name` as project_name, b.`name` as page_name FROM `{$prefix}wiki_pages` a, `{$prefix}wiki_revisions` b, `{$prefix}projects` c WHERE a.`id` = b.`page_id` and a.`revision` = b.`revision` and a.`project_id` = c.`id` and a.`publish` = 1 order by b.`name`";
  $result = mysql_query($sql);
  if($result) {
    while ($data = mysql_fetch_array($result)) {
      $pages[] = $data;
    }
    return $pages;
  } else {
    return $pages;
  }
}
function pp_page($project_id, $page_id) {
  $content = array(); 
  $prefix = str_replace('_', '_', DB_PREFIX);
  $sql = "SELECT b.*, c.`name` as project_name, b.`name` as page_name FROM `{$prefix}wiki_pages` a, `{$prefix}wiki_revisions` b, `{$prefix}projects` c WHERE a.`id` = b.`page_id` and a.`revision` = b.`revision` and a.`project_id` = $project_id and a.`id` = $page_id and a.`project_id` = c.`id` and a.`publish` = 1 LIMIT 1";
  $result = mysql_query($sql); 
  if ($result) { 
    while($row = mysql_fetch_array($result)) {
      $content[] = $row;
    }
  }
  return $content;
}
function navitem($row) {
  return "<tr><td>{$row['project_name']}</td><td><a href=\"?project={$row['project_id']}&page={$row['page_id']}\">{$row['page_name']}</a></td></tr>";
}
function pp_content($project_id, $content) {
  $html = '';
  foreach($content as $page) {
    $html .= "<h1>{$page['project_name']}</h1>";
    $html .= "<h2>{$page['page_name']}</h2>";
    $c = do_textile(pp_wiki_links($project_id, $page[page_name], $page['content']));
    $c = $page['content'];
    $html .= "<div class=content>{$c}</div>";
    $html .= "<h3>{$page['created_on']} {$page['log_message']}</h3>";
  }
  return $html;
}

function pp_wiki_links($project_id, $page_name, $content)
{
  // TODO page name is the wrong name, should get name of page identified by $1 of match!!!!
  $url = '"'.$page_name.'($1)":http://www.2share.com/pp086/public/wiki/?project='.$project_id.'&page=$1';
  return preg_replace('/\[wiki:([0-9]*)\]/', $url, $content);	
  //return wiki_links($content);
}
/*
  //trace(__FILE__,'connect to database');
  // Connect to database...
  try {
    DB::connect(DB_ADAPTER, array(
      'host'    => DB_HOST,
      'user'    => DB_USER,
      'pass'    => DB_PASS,
      'name'    => DB_NAME,
      'persist' => DB_PERSIST
    )); // connect
    if (defined('DB_CHARSET') && trim(DB_CHARSET)) {
      DB::execute("SET NAMES ?", DB_CHARSET);
    } // if
    DB::execute('ROLLBACK');
    DB::execute('UNLOCK TABLES');
    DB::execute('SET AUTOCOMMIT=1');
    DB::execute("SET SQL_MODE=''");
    DB::execute("SET STORAGE_ENGINE=INNODB");  // try to set to INNODB, don't care if it fails
  } catch(Exception $e) {
    if (Env::isDebugging()) {
      Env::dumpError($e);
    } else {
      Logger::log($e, Logger::FATAL);
      Env::executeAction('error', 'db_connect');
    } // if
  } // try
*/

mysql_connect(DB_HOST,DB_USER,DB_PASS)
    or die("Couldn't connect!");
mysql_select_db(DB_NAME);
mysql_query("SET NAMES 'utf8'");
$project_id = 0;
$page_id = 0;
$pages = pp_pages();
$nav = '';
foreach($pages as $row) {
  $nav .= navitem($row);
  if ($row['project_index']) {
    $project_id = $row['project_id'];
    $page_id = $row['page_id'];
  }
}
if (isset($_REQUEST['project'])) {
  $project_id = 0 + $_REQUEST['project'];
}
if (isset($_REQUEST['page'])) {
  $page_id = 0 + $_REQUEST['page'];
}
?>
<div id="wrapper">
 <!-- header -->
      <div id="headerWrapper">
        <div id="header">
          <h1><a href="<?php echo get_url('dashboard', 'index') ?>"><?php echo $site_name ?></a></h1>
        </div>
      </div>
      <!-- /header -->
 <div id="tabsWrapper">
  <div id="tabs">
  </div>
 </div>
 <div id="outerContentWrapper">
  <div id="innerContentWrapper">
   <h1 id="pageTitle">Wiki</h1>
   <div id="pageContent">
    <div id="content">
     <!-- Content -->
<?php echo pp_content($project_id, pp_page($project_id, $page_id)); ?>
    </div>
    <div id="sidebar">
     <div class="sidebarBlock">
      <h2>Projects & Pages</h2>
      <div class="blockContent">
       <table id="index">
        <tr><th>Project</th><th>Page</th></tr>
<?php echo $nav; ?>
       </table>
      </div>
     </div>
    </div>
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
</div>
</div>
</body></html><?php ?>