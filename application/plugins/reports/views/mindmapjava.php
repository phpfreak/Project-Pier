<!--  
	testing with java applet - dont works
	The problem is the param browsemode_initial_map which only accep stricly file and not php generation !!!

 -->
<div id="mn-page-content" style="height:<?php echo $ObjHeight;?>;display:none">
  <applet code="freemind.main.FreeMindApplet.class" archive="<?php echo externalUrl('/application/plugins/reports/freemindbrowser.jar');?>" width="100%" height="100%">
    <param name="type" value="application/x-java-applet;version=1.4" />
    <param name="scriptable" value="false" />
    <param name="modes" value="freemind.modes.browsemode.BrowseMode" />
    <param name="browsemode_initial_map" value="<?php echo $urlMindMapFile?>" />
    <param name="initial_mode" value="Browse" />
    <param name="selection_method" value="selection_method_direct" />
  </applet>
</div