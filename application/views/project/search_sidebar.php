<?php if (isset($tag_names) && is_array($tag_names) && count($tag_names)) { ?>
<div class="sidebarBlock">
  <h2><?php echo lang('tags') ?></h2>
  <div class="blockContent">
    <p><?php echo lang('tags used on projects') ?>:</p>
    <ul class="listWithDetails">
    <?php foreach ($tag_names as $tag_name) { ?>
      <li><a href="<?php echo active_project()->getTagUrl($tag_name) ?>"><?php echo clean($tag_name) ?></a> <span class="desc"> - <?php echo lang('number of tagged objects', active_project()->countObjectsByTag($tag_name)) ?></span></li>
    <?php } // foreach ?>
    </ul>
  </div>
</div>
<?php } // if ?>