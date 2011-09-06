<html><head><title>####</title>
<link href="wwww.css" rel="Stylesheet" type="text/css" /> 
<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
</head><body>
<?php
require '../../config/config.php';
require '../../library/textile/Textile.class.php';
require '../../environment/functions/general.php';

function do_textile($text) {
  $textile = new Textile();
  $text = $textile->TextileRestricted($text, false, false); 
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
}



mysql_connect(DB_HOST,DB_USER,DB_PASS)
    or die("Couldn't connect!");
mysql_select_db(DB_NAME);
$project_id = 0;
$page_id = 0;
$pages = pp_pages();
echo "<table id=\"index\" style=\"float:left\">";
echo "<tr><th>Project</th><th>Page</th></tr>";
foreach($pages as $row) {
  echo navitem($row);
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
echo "</table>";
echo "<div id=content>";
echo pp_content($project_id, pp_page($project_id, $page_id));
echo "<div>";
?>
</body></html>