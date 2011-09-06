<?php
  $style='';
  if (isset($_SESSION['memostate']) && $_SESSION['memostate'] == 'max') $style = 'style="display:block;"';
?>
<div id="memo">
<div class="header"><?php echo lang('memo')?></div>
<div class="content" <?php echo $style ?>><textarea id="memotext" onblur="post('<?php echo externalUrl(get_url('user','saveprojectnote'));?>', this.value);" rows="15" cols="20"><?php echo logged_user()->getProjectNote(active_project());?></textarea></div>
</div>