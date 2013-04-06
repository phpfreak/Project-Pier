<?php 

  // Set page title and set crumbs to index
  set_page_title(lang('projects'));
  administration_tabbed_navigation(ADMINISTRATION_TAB_PROJECTS);
  administration_crumbs(lang('projects'));
  
  if (Project::canAdd(logged_user())) {
    add_page_action(lang('add project'), get_url('project', 'add'));
    add_page_action(lang('copy project'), get_url('project', 'copy'));
  } // if

?>
<?php if (isset($projects) && is_array($projects) && count($projects)) { ?>
<table id="projects">
  <tr>
    <th class="short"></th>
    <th><?php echo lang('name') ?></th>
    <th><?php echo lang('options') ?></th>
  </tr>

<?php foreach ($projects as $project) { ?>
  <tr>
    <td class="middle">
<?php if ($project->canChangeStatus(logged_user())) { ?>
<?php echo checkbox_link($project->isActive() ? $project->getCompleteUrl() : $project->getOpenUrl(), !$project->isActive(), $project->isActive() ? lang('mark project as finished') : lang('mark project as active')) ?>
<?php } else { ?>
<img src="<?php echo $project->isActive() ? icon_url('not-checked.jpg') : icon_url('checked.jpg') ?>" alt="" title="<?php echo $project->isActive() ? lang('active project') : lang('finished project') ?>" />
<?php } // if ?>
    </td>
    <td class="long middle"><a href="<?php echo $project->getOverviewUrl() ?>"><?php echo clean($project->getName()) ?></a></td>
<?php
  $options = array();
  if ($project->canEdit(logged_user())) {
    $options[] = '<a href="' . $project->getEditUrl() .'">' . lang('edit') . '</a>';
  }
  if ($project->canDelete(logged_user())) {
    $options[] = '<a href="' . $project->getDeleteUrl() . '">' . lang('delete') . '</a>';
  }
?>
    <td class="middle"><?php echo implode(' | ', $options) ?></td>
  </tr>
<?php } // foreach ?>
</table>
<?php } else { ?>
<?php echo lang('no projects owned by company') ?>
<?php } // if ?>