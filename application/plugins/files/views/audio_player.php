<?php $extension = $file->getFileType() instanceof FileType ? $file->getFileType()->getExtension() : 'm4a'; ?>
<script type="text/javascript">
$(function(){
 $("#jplayer_<?php echo $player_counter; ?>")
  .jPlayer({
    solution: "flash, html",
    ready: function () {
     $(this).jPlayer("setMedia", {
      <?php echo $extension; ?>: "<?php echo externalUrl($file->getDownloadUrl() . '&inline=1'); ?>",
     });
    },
    swfPath: "<?php echo externalUrl(get_javascript_url('jplayer')); ?>",
    supplied: "<?php echo $extension; ?>"
  })
  .bind($.jPlayer.event.play, function() { // Using a jPlayer event to avoid both jPlayers playing together.
    $(this).jPlayer("pauseOthers");
  });
});
</script>
<div class="jp-audio">
 <div class="jp-type-single">
   <div id="jplayer_<?php echo $player_counter; ?>" class="jp-jplayer"></div>
   <div id="jp_interface_<?php echo $player_counter; ?>" class="jp-interface">
    <div class="jp-audio-play"></div>
    <ul class="jp-controls">
     <li><a href="javascript:void(0)" class="jp-play" tabindex="<?php echo $player_counter; ?>">play</a></li>
     <li><a href="javascript:void(0)" class="jp-pause" tabindex="<?php echo $player_counter; ?>">pause</a></li>
     <li><a href="javascript:void(0)" class="jp-stop" tabindex="<?php echo $player_counter; ?>">stop</a></li>
     <li><a href="javascript:void(0)" class="jp-mute" tabindex="<?php echo $player_counter; ?>">mute</a></li>
     <li><a href="javascript:void(0)" class="jp-unmute" tabindex="<?php echo $player_counter; ?>">unmute</a></li>
    </ul>
    <div class="jp-progress">
     <div class="jp-seek-bar">
      <div class="jp-play-bar"></div>
     </div>
    </div>
    <div class="jp-volume-bar">
     <div class="jp-volume-bar-value"></div>
    </div>
    <div class="jp-current-time"></div>
    <div class="jp-duration"></div>
   </div>
  </div>
 </div>
</div>