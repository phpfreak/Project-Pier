<div class="sidebarBlock">
  <h2><?php echo lang('folders') ?></h2>
  <div class="blockContent" id="sxidebarFolderList">
    <ul>
<?php if ($current_folder instanceof ProjectFolder) { ?>
<?php $current_folder_id = $current_folder->getId(); ?>
      <li><a href="<?php echo ProjectFiles::getIndexUrl($order, $page) ?>"><?php echo lang('all files') ?></a></li>
<?php } else { ?>
<?php $current_folder_id = null; ?>
      <li><a href="<?php echo ProjectFiles::getIndexUrl($order, $page) ?>" class="selected"><?php echo lang('all files') ?></a></li>
<?php } // if ?>
    </ul>
<?php trace(__FILE__,'folders') ?>
<?php echo render_folder_tree( null, 0, active_project(), $current_folder_id ); ?><br/>
<?php if (ProjectFolder::canAdd(logged_user(), active_project())) { ?>
    <div><a href="<?php echo get_url('files', 'add_folder') ?>"><?php echo lang('add folder') ?></a></div>
<?php } // if ?>
  </div>
</div>
<?php trace(__FILE__,'important files') ?>
<?php if (isset($important_files) && is_array($important_files) && count($important_files)) { ?>
<div class="sidebarBlock">
  <h2><?php echo lang('important files') ?></h2>
  <div class="blockContent">
    <ul>
<?php foreach ($important_files as $important_file) { ?>
      <li><a href="<?php echo $important_file->getDetailsUrl() ?>"><?php echo clean($important_file->getFilename()) ?></a><br /><span class="desc"><?php echo lang('revisions on file', $important_file->countRevisions()) ?></span></li>
<?php } // foreach ?>
    </ul>
  </div>
</div>
<?php } // if ?>