<?php

/**
 * @author Alex Mayhew
 * @copyright 2008
 */

/**
 * Wiki link helper
 * Replaces wiki links in format [wiki:{PAGE_ID}] with a textile link to the page
 * 
 * @param mixed $content
 * @return
 */
if (!function_exists('wiki_links')) {
  function wiki_links($content)
  {
    return preg_replace_callback('/\[(wiki|user):([0-9]*)\]/', 'wiki_replace_link_callback', $content);	
    //return $content;	
  }
}


function wiki_replace_link_callback($matches)
{
  if(count($matches) < 2){
    return null;
  }
	
  if ($matches[1]=='wiki') {
        $rev = Revisions::instance()->getTableName(true);
        $page = Wiki::instance()->getTableName(true);
        $where1 = 'WHERE page_id = ' . $matches[2] . ' AND project_id = ' . active_project()->getId();
        $where2 = 'WHERE id = ' . $matches[2] . ' AND project_id = ' . active_project()->getId();

	$sql = "SELECT page_id, name FROM $rev $where1 ";
        $sql .= "AND revision = ( select revision from $page $where2 )";
	//echo $sql;
	$row = DB::executeOne($sql);
	if(!count($row)){
		return null;
	}
	$url = get_url($matches[1], 'view', array('id' => $matches[2]));
        $url = str_replace( '&amp;', '&', $url );
	return '"' . $row['name']  . '(' . $row['page_id'] . ')":' . $url;
  }
        $user = Users::instance()->getTableName(true);
        $where1 = 'WHERE id = ' . $matches[2];
	$sql = "SELECT id, display_name FROM $user $where1 ";
	echo $sql;
	$row = DB::executeOne($sql);
	if(!count($row)){
		return null;
	}
	$url = get_url($matches[1], 'card', array('id' => $matches[2]));
        $url = str_replace( '&amp;', '&', $url );
	return '"' . $row['display_name']  . '(' . $row['id'] . ')":' . $url;
}

?>