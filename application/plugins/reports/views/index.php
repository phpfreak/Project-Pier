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

  add_page_action(lang('Click here to see gantt chart'), get_url('reports', 'Gantt_Chart'));
  add_page_action(lang('Click here to see mindmapping'), get_url('reports', 'mindmap'));
    
  //object height
  $ObjHeight = '600px';
  $urlMindMapFile = externalUrl(html_entity_decode(get_url('reports','mindmap')));
  $urlGanttFile = externalUrl(html_entity_decode(get_url('reports','Gantt_Chart')));
?>
<script>
displayReports = function(obj,icon){
  myobj = document.getElementById(obj);
  myicon = document.getElementById(icon);
  if (obj == 'gantt-page-content'){
    myotherobj = document.getElementById('mn-page-content');
    myothericon = document.getElementById('iconReportfolderMINDMAP');
  }else{
    myotherobj = document.getElementById('gantt-page-content');
    myothericon = document.getElementById('iconReportfolderGANTT');
  }
  if (myobj.style.display == 'none'){
    myobj.style.display = 'block';
    myotherobj.style.display = 'none';
    myicon.src = '<?php echo get_image_url("icons/0110_ico-arrow.gif");?>';
    myothericon.src = '<?php echo get_image_url("icons/0105_ico-arrow.gif");?>';
    //refresh image gantt  
    if (obj == 'gantt-page-content'){
        myimg = document.getElementById('ganttchart');
        var now = new Date();
		    myimg.src = '<?php echo $urlGanttFile;?>' + '&' + now.getTime();
    }else{
      document.getElementById('innerContentWrapper').style.height = "720px";
    } 
  }else{
    myobj.style.display = 'none';
    myicon.src = '<?php echo get_image_url("icons/0105_ico-arrow.gif");?>';
  }
}
downloadmindmapfile = function(){
	link = '<?php echo $urlMindMapFile?>';
	window.open(link);
	return true;
}
downloadganttfile = function(){
	link = '<?php echo $urlGanttFile?>';
	window.open(link);
	return true;
}
</script>

<table>
<tr>
<td>
<!-- Gantt -->
<div class="Reportfolder" title="<?php echo lang('Click here to see gantt chart');?>" onclick="displayReports('gantt-page-content','iconReportfolderGANTT');">
<img id="iconReportfolderGANTT" src="<?php echo get_image_url("icons/0105_ico-arrow.gif");?>"/>
<font class="folder">GANTT</font>
</div>
</td>
<td>
<!-- Mind Mapping -->
<div class="Reportfolder" title="<?php echo lang('Click here to see mindmapping');?>" onclick="displayReports('mn-page-content','iconReportfolderMINDMAP');">
<img id="iconReportfolderMINDMAP" src="<?php echo get_image_url("icons/0105_ico-arrow.gif");?>"/>
<font class="folder">MINDMAPPING</font>
</div>
</td>
</tr>
</table>
<?php 
  /*
  * include views
  */  
  //Gannt
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
