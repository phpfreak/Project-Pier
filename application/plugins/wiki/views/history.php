<?php

  set_page_title(lang('wiki page history', $cur_revision->getName()));
  project_tabbed_navigation(PROJECT_TAB_WIKI);
  project_crumbs(array(
		array(lang('wiki'), get_url('wiki')),
		array($cur_revision->getName(), $page->getViewUrl()),
		array(lang('view page history'))));

$can_edit = $page->canEdit(logged_user());

?>
<?php if (isset($revisions) && is_array($revisions) && count($revisions)) { ?>
<div id="wikiPageRevisions">
  <div id="wikiPageRevisionsPaginationTop"><?php echo advanced_pagination($pagination, get_url('wiki', 'history', array('id' => $page->getId(), 'page' => '#PAGE#'))) ?></div>
  <form action="<?php echo get_url(null, null, null, null, false) ?>" >
  <?php //Adding hidden fields because the form is sending data in query string and overrides params in form action ?>
  <?php echo input_field('c', 'wiki', array('type' => 'hidden')) ?>
  <?php echo input_field('a', 'diff', array('type' => 'hidden')) ?>
  <?php echo input_field('active_project', $page->getProjectId(), array('type' => 'hidden')) ?>
  <?php echo input_field('id', $page->getId(), array('type' => 'hidden')) ?>
<table>
<tr>
	<th><?php echo lang('wiki page revision') ?></th>
	<th><?php echo lang('wiki log message') ?></th>
	<th><?php echo lang('wiki page created on') ?></th>
	<th><?php echo lang('author') ?></th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th><?php echo lang('revert') ?></th></tr>
<?php 
$iteration = 1;
foreach ($revisions as $revision) { ?>
<tr>
	<td><a href="<?php echo $revision->getViewUrl() ?>"><?php echo $revision->getRevision() ?></a></td>
	<td><?php echo $revision->getLogMessage() ?></td>
	<td><?php echo format_datetime($revision->getCreatedOn()) ?></td>
	<td><a href="<?php echo $revision->getCreatedBy()->getCardUrl() ?>"><?php echo $revision->getCreatedBy()->getUsername() ?></a></td>
	<td><?php echo radio_field('rev1', ($iteration == 2), array('value' => $revision->getRevision())) ?></td>
	<td><?php echo radio_field('rev2', ($iteration == 1), array('value' => $revision->getRevision())) ?></td>
	<?php if($can_edit): ?>
	<td>
		<?php if($cur_revision->getRevision() != $revision->getRevision()) : ?>
		<a href="<?php echo $revision->getRevertUrl(); ?>"><?php echo lang('revert') ?></a>
		<?php else: ?>
		&nbsp;
		<?php endif; ?>
	</td>
	<?php endif; ?>
</tr>
<?php 
++$iteration;
} // foreach ?>
</table>

<?php echo submit_button('Compare') ?>
</form>
  <div id="wikiPageRevisionsPaginationBottom"><?php echo advanced_pagination($pagination, get_url('wiki', 'history', array('id' =>$page->getId(), 'page' => '#PAGE#'))) ?></div>
</div>
<?php } else { ?>
<p><?php echo lang('wiki page revisions dnx') ?></p>
<?php } // if ?>