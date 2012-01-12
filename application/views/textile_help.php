<h2><?php echo lang('textile help') ?></h2>
<p>
<strong>*<?php echo lang('bold') ?>*</strong><br/>
<em>_<?php echo lang('emphasis') ?>_</em><br/>
<code>@<?php echo lang('code') ?>@</code><br/>
*, ** <?php echo lang('unordered list') ?><br/>
#, ## <?php echo lang('ordered list') ?><br/>
"<?php echo lang('link name') ?>":http://url<br/>
!<?php echo lang('image url') ?>!<br/>
<h4>h4. <?php echo lang('header1to6') ?></h4>
<?php echo lang('table') ?><br/>
|A|B|<br/>|C|D|<br/>
<table style='border: 1px solid black !important;'><tr><td style='border: 1px solid black !important;'>A</td><td style='border: 1px solid black !important;'>B</td></tr><tr><td style='border: 1px solid black !important;'>C</td><td style='border: 1px solid black !important;'>D</td></tr></table><br/>
-<del><?php echo lang('deleted text') ?></del>-<br/>
+<ins><?php echo lang('inserted text') ?></ins>+<br/>
<em>_<?php echo lang('emphasis') ?>_</em><br/>
<sup>^<?php echo lang('superscript') ?>^</sup><br/>
<sub>~<?php echo lang('subscript') ?>~</sub><br/>
==<?php echo lang('no textile') ?>==<br/>
<br/>
<h2><i>Plain (parentheses) inserted between block syntax and the closing dot-space indicate classes and ids:</i></h2>
p(hector). paragraph becomes &lt;p class="hector"&gt;paragraph&lt;/p&gt;<br/>
p(#fluid). paragraph becomes &lt;p id="fluid"&gt;paragraph&lt;/p&gt;<br/>
<h2><i>Curly {brackets} insert arbitrary css style</i></h2>
p{line-height:18px}. paragraph -> &lt;p style="line-height:18px"&gt;paragraph&lt;/p&gt;<br/>
h3{color:red}. header 3 becomes &lt;h3 style="color:red"&gt;header 3&lt;/h3&gt;<br/>
<h2><i>Square [brackets] insert language attributes</i></h2>
p[no]. paragraph becomes &lt;p lang="no">paragraph&lt;/p&gt;<br/>
</p>