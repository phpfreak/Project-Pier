<?php
/**
 * @author ALBATROS INFORMATIQUE SARL - CARQUEFOU FRANCE - Damien HENRY
 * @licence Honest Public License
 * @package ProjectPier Gantt
 * @version $Id$
 * @access public
 */
  set_page_title(lang('reports'));
  project_tabbed_navigation(PROJECT_TAB_REPORTS);
  project_crumbs(array(
    array(lang('reports')) 
    ));

  //object height
  $ObjHeight = '500px';
  $urlMindMap = externalUrl(html_entity_decode(get_url('reports','mindmap')));
  $urlGantt = externalUrl(html_entity_decode(get_url('reports','Gantt_Chart')));

//$urlMindMap = html_entity_decode('http://freemind.sourceforge.net/wiki/images/a/a5/FreemindFlash.mm&startCollapsedToLevel=5&mm_title=FreemindFlash.mm');

  add_page_action(lang('gantt'), 'javascript:show_gantt();' );
  add_page_action(lang('mindmap'), 'javascript:show_mindmap();' );
    
?>
<script>
show_gantt = function() {
  document.getElementById('MM').style.display = 'none';
  document.getElementById('GANTT').style.display = 'block';
  document.getElementById('GRAPH').style.display = 'block';
  var now = new Date();
  document.getElementById('GRAPH').src = '<?php echo $urlGantt ?>&'+ now.valueOf();
}
show_mindmap = function() {
  document.getElementById('GRAPH').style.display = 'none';
  document.getElementById('GANTT').style.display = 'none';
  document.getElementById('MM').style.display = 'block';
}
downloadmindmapfile = function(){
	link = '<?php echo $urlMindMap?>';
	window.open(link);
	return true;
}
downloadganttfile = function(){
	link = document.getElementById('GRAPH').src; //'<?php echo $urlGantt?>';
	window.open(link);
	return true;
}
refresh = function(){
}
</script>
<?php 
  /*
  * include views
  */  
  //Gantt
  $locale_char_set = 'en_us';
  include dirname(__FILE__) . "/gantt.php"; 

  //mindmapping
  define('MINDMAPPINGMETHOD','flash');
  /* here to watch flash or java applet
   * Necessary for freemind evolution
   * because flash is an alternate solution not official
  */  	
  if (defined('MINDMAPPINGMETHOD') && MINDMAPPINGMETHOD == 'java'){
    include dirname(__FILE__) . "/mindmapjava.php";
  }else{
    include dirname(__FILE__) . "/mindmapflash.php";
  } 
?>