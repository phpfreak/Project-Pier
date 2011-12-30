<?php

  set_page_title(lang('tags'));
  project_tabbed_navigation('tags');
  project_crumbs(array(
    array(lang('tags'), get_url('project', 'tags')),
    array($tag)
  ));

?>
<?php if (isset($tagged_objects) && is_array($tagged_objects) && count($tagged_objects)) { ?>
<p><?php echo lang('total objects tagged with', $total_tagged_objects, clean($tag)) ?>:</p>

<?php if (isset($tagged_objects['messages']) && is_array($tagged_objects['messages']) && count($tagged_objects['messages'])) { ?>
<h2><?php echo lang('messages') ?></h2>
<ul>
<?php foreach ($tagged_objects['messages'] as $message) { ?>
  <li><a href="<?php echo $message->getViewUrl() ?>"><?php echo clean($message->getTitle()) ?></a>
<?php if ($message->getCreatedBy() instanceof User) { ?>
  <span class="desc">- <?php echo lang('posted on by', format_date($message->getUpdatedOn()), $message->getCreatedByCardUrl(), clean($message->getCreatedByDisplayName())) ?></span>
<?php } // if ?>
  </li>
<?php } // foreach?>
</ul>
<?php } // if ?>

<?php if (isset($tagged_objects['milestones']) && is_array($tagged_objects['milestones']) && count($tagged_objects['milestones'])) { ?>
<h2><?php echo lang('milestones') ?></h2>
<ul>
<?php foreach ($tagged_objects['milestones'] as $milestone) { ?>
  <li>
    <a href="<?php echo $milestone->getViewUrl() ?>"><?php echo clean($milestone->getName()) ?></a>
<?php if ($milestone->getAssignedTo() instanceof ApplicationDataObject) { ?>
    <span class="desc">- <?php echo lang('milestone assigned to', clean($milestone->getAssignedTo()->getObjectName())) ?></span>
<?php } // if ?>
<?php if ($milestone->isCompleted()) { ?>
    <img src="<?php echo icon_url('ok.gif') ?>" alt="<?php echo lang('completed milestone') ?>" title="<?php echo lang('completed milestone') ?>" />
<?php } ?>
  </li>
<?php } // foreach?>
</ul>
<?php } // if ?>

<?php if (isset($tagged_objects['task_lists']) && is_array($tagged_objects['task_lists']) && count($tagged_objects['task_lists'])) { ?>
<h2><?php echo lang('task lists') ?></h2>
<ul>
<?php foreach ($tagged_objects['task_lists'] as $task_list) { ?>
  <li>
    <a href="<?php echo $task_list->getViewUrl() ?>"><?php echo clean($task_list->getName()) ?></a>
<?php if ($task_list->isCompleted()) { ?>
    <img src="<?php echo icon_url('ok.gif') ?>" alt="<?php echo lang('completed task list') ?>" title="<?php echo lang('completed task list') ?>" />
<?php } ?>
  </li>
<?php } // foreach?>
</ul>
<?php } // if ?>

<?php if (isset($tagged_objects['files']) && is_array($tagged_objects['files']) && count($tagged_objects['files'])) { ?>
<h2><?php echo lang('files') ?></h2>
<ul>
<?php foreach ($tagged_objects['files'] as $file) { ?>
  <li><a href="<?php echo $file->getDetailsUrl() ?>"><?php echo clean($file->getFilename()) ?></a> <span class="desc">(<?php echo format_filesize($file->getFilesize()) ?>)</span></li>
<?php } // foreach?>
</ul>
<?php } // if ?>

<?php if (isset($tagged_objects['wiki']) && is_array($tagged_objects['wiki']) && count($tagged_objects['wiki'])) { ?>
<h2><?php echo lang('wiki') ?></h2>
<ul>
<?php foreach ($tagged_objects['wiki'] as $wiki_page) { ?>
<?php $rev = $wiki_page->getLatestRevision(); ?>
  <li><a href="<?php echo $rev->getViewUrl() ?>"><?php echo clean($rev->getName()) ?></a> <span class="desc">- <?php echo lang('posted on by', format_date($rev->getCreatedOn()), $rev->getCreatedByCardUrl(), clean($rev->getCreatedByDisplayName())) ?></span></li>
<?php } // foreach?>
</ul>
<?php } // if ?>

<?php if (isset($tagged_objects['links']) && is_array($tagged_objects['links']) && count($tagged_objects['links'])) { ?>
<h2><?php echo lang('links') ?></h2>
<ul>
<?php foreach ($tagged_objects['links'] as $link) { ?>
  <li><a href="<?php echo $link->getObjectUrl() ?>"><?php echo clean($link->getObjectName()) ?></a> <span class="desc">- <?php echo lang('posted on by', format_date($link->getCreatedOn()), $link->getCreatedByCardUrl(), clean($link->getCreatedByDisplayName())) ?></span></li>
<?php } // foreach?>
</ul>
<?php } // if ?>

<?php } else { ?>
<p><?php echo lang('no objects tagged with', clean($tag)) ?></p>
<?php } // if ?>