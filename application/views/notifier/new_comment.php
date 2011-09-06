<?php 
echo lang('do not reply warning')."\n";
echo lang('new comment posted', $new_comment->getObject()->getObjectName());
if ((!defined('SHOW_COMMENT_BODY')) or (SHOW_COMMENT_BODY == true)) {
  echo "\n----------------\n";
  echo $new_comment->getText();
  echo "\n----------------\n";
}
echo lang('view new comment').":\n";
echo str_replace('&amp;', '&', externalUrl($new_comment->getViewUrl()))."\n";
echo lang('company') ?>: <?php echo owner_company()->getName()."\n";
echo lang('project') ?>: <?php echo $new_comment->getProject()->getName()."\n"; 
echo lang('author') ?>: <?php echo $new_comment->getCreatedByDisplayName()."\n";
echo lang('login').': '.externalUrl(ROOT_URL);
?>