<div class="filesOrderAndPagination">
  <div class="filesOrder">
    <span><?php echo lang('order by') ?>:</span> 
<?php
  $order_by_name_url = $current_folder instanceof ProjectFolder ? $current_folder->getBrowseUrl(ProjectFiles::ORDER_BY_NAME) : ProjectFiles::getIndexUrl(ProjectFiles::ORDER_BY_NAME);
  $order_by_posttime_url = $current_folder instanceof ProjectFolder ? $current_folder->getBrowseUrl(ProjectFiles::ORDER_BY_POSTTIME) : ProjectFiles::getIndexUrl(ProjectFiles::ORDER_BY_POSTTIME);
?>
<?php if ($order == ProjectFiles::ORDER_BY_NAME) { ?>
    <a href="<?php echo $order_by_name_url ?>" class="selected"><?php echo lang('order by filename') ?></a> | <a href="<?php echo $order_by_posttime_url ?>"><?php echo lang('order by posttime') ?></a>
<?php } else { ?>
    <a href="<?php echo $order_by_name_url ?>"><?php echo lang('order by filename') ?></a> | <a href="<?php echo $order_by_posttime_url ?>" class="selected"><?php echo lang('order by posttime') ?></a>
<?php } // if ?>
  </div>
  <div class="filesPagination">
<?php if ($pagination instanceof DataPagination) { ?>
<?php echo advanced_pagination($pagination, $current_folder instanceof ProjectFolder ? $current_folder->getBrowseUrl($order, "#PAGE#") : ProjectFiles::getIndexUrl($order, '#PAGE#')) ?>
<?php } // if ?>
  </div>
</div>
