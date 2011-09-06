<?php if (isset($folders) && is_array($folders) && count($folders)) { ?>
<div class="sidebarBlock">
  <h2><?php echo lang('folders') ?></h2>
  <div class="blockContent" id="sidebarFolderList">
    <ul>
<?php if ($current_folder instanceof ProjectFolder) { ?>
      <li><a href="<?php echo ProjectFiles::getIndexUrl($order, $page) ?>"><?php echo lang('all files') ?></a></li>
<?php } else { ?>
      <li><a href="<?php echo ProjectFiles::getIndexUrl($order, $page) ?>" class="selected"><?php echo lang('all files') ?></a></li>
<?php } // if ?>
<?php trace(__FILE__,'folders') ?>
<?php foreach ($folders as $folder) { ?>
<?php if (($current_folder instanceof ProjectFolder) && ($current_folder->getId() == $folder->getId())) { ?>
      <li><a href="<?php echo $folder->getBrowseUrl($order) ?>" class="selected"><?php echo clean($folder->getName()) ?></a> <?php if ($folder->canEdit(logged_user())) { ?><a href="<?php echo $folder->getEditUrl() ?>" class="blank" title="<?php echo lang('edit folder') ?>"><img src="<?php echo icon_url('edit.gif') ?>" alt="" /></a><?php } // if ?> <?php if ($folder->canDelete(logged_user())) { ?><a href="<?php echo $folder->getDeleteUrl() ?>" class="blank" title="<?php echo lang('delete folder') ?>"><img src="<?php echo icon_url('cancel_gray.gif') ?>" alt="" /></a><?php } // if ?></li>
<?php } else { ?>
      <li><a href="<?php echo $folder->getBrowseUrl($order) ?>"><?php echo clean($folder->getName()) ?></a> <?php if ($folder->canEdit(logged_user())) { ?><a href="<?php echo $folder->getEditUrl() ?>" class="blank" title="<?php echo lang('edit folder') ?>"><img src="<?php echo icon_url('edit.gif') ?>" alt="" /></a><?php } // if ?> <?php if ($folder->canDelete(logged_user())) { ?><a href="<?php echo $folder->getDeleteUrl() ?>" class="blank" title="<?php echo lang('delete folder') ?>"><img src="<?php echo icon_url('cancel_gray.gif') ?>" alt="" /></a><?php } // if ?></li>
<?php } // if ?>
<?php } // foreach ?>
    </ul>
    <p><a href="<?php echo get_url('files', 'add_folder') ?>"><?php echo lang('add folder') ?></a></p>
  </div>
</div>
<?php } // if ?>
<?php trace(__FILE__,'important files') ?>
<?php if (isset($important_files) && is_array($important_files) && count($important_files)) { ?>
<div class="sidebarBlock">
  <h2><?php echo lang('important files') ?></h2>
  <div class="blockContent">
    <ul>
<?php foreach ($important_files as $important_file) { ?>
      <li>
        <a href="<?php echo $important_file->getDetailsUrl() ?>"><?php echo clean($important_file->getFilename()) ?></a><br />
        <span class="desc"><?php echo lang('revisions on file', $important_file->countRevisions()) ?></span>
      </li>
<?php } // foreach ?>
    </ul>
  </div>
</div>
<?php } // if ?>
