<?php if (isset($active_projects) && is_array($active_projects) && count($active_projects)) { ?>
<div class="sidebarBlock">
  <h2><?php echo lang('active projects') ?></h2>
  <div class="blockContent">
    <ul>
<?php foreach ($active_projects as $active_project) { ?>
      <li><a href="<?php echo $active_project->getOverviewUrl() ?>"><?php echo clean($active_project->getName()) ?></a></li>
<?php } // foreach ?>
    </ul>
  </div>
</div>
<?php } // if ?>

<?php if (isset($finished_projects) && is_array($finished_projects) && count($finished_projects)) { ?>
<div class="sidebarBlock">
  <h2><?php echo lang('finished projects') ?></h2>
  <div class="blockContent">
    <ul class="listWithDetails">
<?php foreach ($finished_projects as $finished_project) { ?>
      <li>
        <a href="<?php echo $finished_project->getOverviewUrl() ?>"><?php echo clean($finished_project->getName()) ?></a><br />
        <span class="desc">(<?php echo lang('project completed on by', format_date($finished_project->getCompletedOn()), $finished_project->getCompletedByDisplayName()) ?>)</span>
      </li>
<?php } // foreach ?>
    </ul>
  </div>
</div>
<?php } // if ?>