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
function wiki_links($content)
{
	return preg_replace_callback('/\[wiki:([0-9]*)\]/', 'replace_wiki_link_callback', $content);	
}

function replace_wiki_link_callback($matches)
{
	if(count($matches) < 2){
		return null;
	}
	
        $rev = Revisions::instance()->getTableName(true);
        $page = Wiki::instance()->getTableName(true);
        $where1 = 'WHERE page_id = ' . $matches[1] . ' AND project_id = ' . active_project()->getId();
        $where2 = 'WHERE id = ' . $matches[1] . ' AND project_id = ' . active_project()->getId();

	$sql = "SELECT page_id, name FROM $rev $where1 ";
        $sql .= "AND revision = ( select revision from $page $where2 )";
	//echo $sql;
	$row = DB::executeOne($sql);
	if(!count($row)){
		return null;
	}
	$url = get_url('wiki', 'view', array('id' => $matches[1]));
        $url = str_replace( '&amp;', '&', $url );
	return '"' . $row['name']  . '(' . $row['page_id'] . ')":' . $url;
}

?>