<?php
  set_page_title($tool->getDisplayName());
  administration_tabbed_navigation(ADMINISTRATION_TAB_TOOLS);
  administration_crumbs(array(
    array(lang('administration tools'), get_url('administration', 'tools')),
    array($tool->getDisplayName())
  ));
?>
<div class="advancedPagination">
<a href="<?php echo get_url('administration', 'browse_log', array( 'pos' => 0, 'dir' => '' )); ?>"><?php echo lang('pagination first'); ?></a>
<a href="<?php echo get_url('administration', 'browse_log', array( 'pos' => $pos - 4096, 'dir' => 'up' )); ?>"><?php echo lang('pagination previous'); ?></a>
<?php echo " " . lang('pagination current page', $pos) . " "; ?>
<a href="<?php echo get_url('administration', 'browse_log', array( 'pos' => $pos, 'dir' => '' )); ?>"><?php echo lang('pagination next'); ?></a>
<a href="<?php echo get_url('administration', 'browse_log', array( 'pos' => -1, 'dir' => 'up' )); ?>"><?php echo lang('pagination last'); ?></a></div>
<?php
foreach ($lines as $line) {
  if (trim($line)) {
    echo "$line<br>";
  }
}
?>