<div class="filesOrderAndPagination">
  <div class="filesOrder">
    <span><?php echo lang('order by') ?>:</span> 
<?php
  $order_by_name_url = $current_folder instanceof ProjectFolder ? $current_folder->getBrowseUrl(ProjectFiles::ORDER_BY_NAME) : ProjectFiles::getIndexUrl(ProjectFiles::ORDER_BY_NAME);
  $order_by_posttime_url = $current_folder instanceof ProjectFolder ? $current_folder->getBrowseUrl(ProjectFiles::ORDER_BY_POSTTIME) : ProjectFiles::getIndexUrl(ProjectFiles::ORDER_BY_POSTTIME);
  $order_by_folder_url = $current_folder instanceof ProjectFolder ? $current_folder->getBrowseUrl(ProjectFiles::ORDER_BY_FOLDER) : ProjectFiles::getIndexUrl(ProjectFiles::ORDER_BY_FOLDER);
?>
<?php if (!($current_folder instanceof ProjectFolder)) { ?><a href="<?php echo $order_by_folder_url ?>"<?php if ($order == ProjectFiles::ORDER_BY_FOLDER) { ?> class="selected"<?php } ?>><?php echo lang('order by folder') ?></a> | <?php } ?><a href="<?php echo $order_by_name_url ?>"<?php if ($order == ProjectFiles::ORDER_BY_NAME) { ?> class="selected"<?php } ?>><?php echo lang('order by filename') ?></a> | <a href="<?php echo $order_by_posttime_url ?>"<?php if ($order == ProjectFiles::ORDER_BY_POSTTIME) { ?> class="selected"<?php } ?>><?php echo lang('order by posttime') ?></a>
  </div>
  <div class="filesPagination">
<?php if ($pagination instanceof DataPagination) { ?>
<?php echo advanced_pagination($pagination, $current_folder instanceof ProjectFolder ? $current_folder->getBrowseUrl($order, "#PAGE#") : ProjectFiles::getIndexUrl($order, '#PAGE#')) ?>
<?php } // if ?>
  </div>
</div>