<?php

  //set_page_title($user->isNew() ? lang('add user') : lang('edit user'));
  //add_stylesheet_to_page('radio.css');

?>
<script type="text/javascript" src="/pp088/public/assets/javascript/nativeradio/swfobject.js"></script>
<div id="flashcontent1">
	<p>
    	<strong>Sorry this site have a flash based native radio and needed adobe flash 10+ support. </strong><br />
	    <a href="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash">Download Flash here.</a>
    </p>
</div>
	
<script type="text/javascript">
	// <![CDATA[
	
	var so = new SWFObject("/pp088/public/assets/javascript/nativeradio/nativeradio2small.swf", "nativeradio2small", "200", "50", "10", "#cccccc");
	so.addParam("scale", "noscale");
	so.addVariable("swfcolor", "B89E7A");
	so.addVariable("swfwidth", "200");
	so.addVariable("swfradiochannel", "D I G I T A L - I  M P O R T E D - Silky Sexy Deep House");
	so.addVariable("swfstreamurl", "scfire-dtc-aa01.stream.aol.com:80/stream/1007");
	so.addVariable("swfpause", "0");
	so.write("flashcontent1");
	

  if (document.all) {
    self.resizeTo(552, 320);
  } else {
    self.resizeTo(540, 285);
  }

	// ]]>
</script>
