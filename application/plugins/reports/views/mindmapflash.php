<div id="MM" style="display:none">
<div style="float:left"><input class="submit" type="button" onclick="downloadmindmapfile();" title="<?php echo lang('freemind version');?>" value="<?php echo lang('download');?>"></input></div>
<script type="text/javascript" src="<?php echo externalUrl(ROOT_URL.'/application/plugins/reports/flashobject.js'); ?>"></script>
<style type="text/css">
  /* hide from ie on mac \*/
  html {
	height: 100%;
	overflow: auto;
  }
		
  #flashcontent {
    height: 100%;
  }
  /* end hide */

  #MM{
    width: 525px;
  }
</style>
<script language="javascript">
function giveFocus() { 
  //if (document.visorFreeMind) document.visorFreeMind.focus(); 
}

</script>
	
<div id="flashcontent" onmouseover="giveFocus();">
	  Flash plugin or Javascript are turned off.
	  Activate both and reload to view the mind map
</div>
	
<script type="text/javascript">
	// <![CDATA[
	// for allowing using http://.....?mindmap.mm mode
	function getMap(map){
	  var result=map;
	  var loc=document.location+'';
	  if(loc.indexOf(".mm")>0 && loc.indexOf("?")>0){
		result=loc.substring(loc.indexOf("?")+1);
	  }
	  return result;
	}
	var fo = new FlashObject("<?php echo externalUrl(ROOT_URL.'application/plugins/reports/visorFreemind.swf');?>", "visorFreeMind", "100%", "100%", 6, "#9999ff");
	fo.addParam("quality", "high");
	fo.addParam("bgcolor", "#a0a0f0");
	fo.addVariable("openUrl", "_blank");
	fo.addVariable("startCollapsedToLevel","3");
	fo.addVariable("maxNodeWidth","200");
	//
	fo.addVariable("mainNodeShape","elipse");
	fo.addVariable("justMap","false");
	fo.addVariable("initLoadFile",getMap("<?php echo $urlMindMap?>"));
	fo.addVariable("defaultToolTipWordWrap",200);
	fo.addVariable("offsetX","left");
	fo.addVariable("offsetY","5");
	fo.addVariable("buttonsPos","top");
	fo.addVariable("min_alpha_buttons",80);
	fo.addVariable("max_alpha_buttons",100);
	fo.addVariable("scaleTooltips","false");
	fo.write("flashcontent");
	// ]]>
	giveFocus();
</script>
</div>