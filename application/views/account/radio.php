<?php

  set_page_title(lang('radio'));
  add_stylesheet_to_page('radio.css');

?>
<script type="text/javascript" src="<?php echo get_javascript_url('/nativeradio/swfobject.js'); ?>"></script>
<div id="flashcontent1">No flash, no radio<br />
<a href="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash">Download Flash</a>
</div>
<script type="text/javascript">
// <![CDATA[

  var so = new SWFObject("<?php echo get_javascript_url('nativeradio/nativeradio2small.swf'); ?>", "nativeradio2small", "200", "50", "10", "#cccccc");
  so.addParam("scale", "noscale");
  so.addVariable("swfcolor", "333333");
  so.addVariable("swfwidth", "200");
  so.addVariable("swfradiochannel", "TrackFM.nl");
  so.addVariable("swfstreamurl", "http://stream.trackfm.nl:8000/medium");
  so.addVariable("swfpause", "0");
  so.write("flashcontent1");

  if (document.all) {
    self.resizeTo(215+12, 145+35);
  } else {
    self.resizeTo(215, 145);
  }
  self.moveTo(0,0);

// ]]>
</script>
<?php echo select_project(); ?>
