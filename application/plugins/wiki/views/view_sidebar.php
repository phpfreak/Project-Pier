<div class="sidebarBlock">
  <h2><?php echo $sidebar_revision->getName() ?></h2>
  <div class="blockContent">
    <?php echo do_textile(wiki_links($sidebar_revision->getContent())) ?>
    <?php if(!$sidebar_page->isNew() && $sidebar_page->canEdit(logged_user())): ?><p><a href="<?php echo $sidebar_page->getEditUrl() ?>"><?php echo lang('edit') ?></a></p><?php endif; ?>
  </div>
</div>
<?php if(isset($sidebar_links) && count($sidebar_links)): ?>
<div class="sidebarBlock">
  <h2><?php echo lang('wiki all pages') ?></h2>
  <ul>
    <?php foreach ($sidebar_links as $spage) { ?>
    <?php   $parent = $spage->getParent(); ?>
    <?php   if ($parent instanceof WikiPage) { ?>
      <li><a href="<?php echo $spage->getViewUrl() ?>"><?php echo $spage->getObjectName() ?></a> (<a href="<?php echo $parent->getViewUrl() ?>"><?php echo $parent->getObjectName() ?></a>)</li>
    <?php   } else { ?>
      <li><a href="<?php echo $spage->getViewUrl() ?>"><?php echo $spage->getObjectName() ?></a></li>
    <?php   } // if  ?>
    <?php } // foreach ?>
  </ul>
</div>
<?php endif; ?>