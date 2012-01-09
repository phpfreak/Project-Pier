<?php 

  if ($project->isNew()) {
    set_page_title(lang('add project'));
    dashboard_tabbed_navigation();
    project_crumbs(lang('add project'));
  } else {
    set_page_title(lang('edit project'));
    project_crumbs(lang('edit project'));
    $this->includeTemplate(get_template_path('project/pageactions'));
  } // if
  
?>
<?php if ($project->isNew()) { ?>
<form action="<?php echo get_url('project', 'add') ?>" method="post">
<?php } else { ?>
<form action="<?php echo $project->getEditUrl($redirect_to) ?>" method="post">
<?php } // if ?>

<?php tpl_display(get_template_path('form_errors')) ?>

  <div>
    <?php echo label_tag(lang('name'), 'projectFormName', true) ?>
    <?php echo text_field('project[name]', array_var($project_data, 'name'), array('class' => 'long', 'id' => 'projectFormName')) ?>
  </div>

  <div>
    <?php echo label_tag(lang('parent project'), 'projectSource', true) ?>
    <?php echo select_project('project[parent_id]', '', array_var($project_data, 'parent_id'), array('id' => 'projectFormParentId')) ?>
  </div>

  <div>
    <?php echo label_tag(lang('priority'), 'projectFormPriority') ?>
    <?php echo input_field('project[priority]', array_var($project_data, 'priority'), array('class' => 'short', 'id' => 'projectFormPriority')) ?>
  </div>
    
  <div>
    <?php echo label_tag(lang('description'), 'projectFormDescription') ?>
    <?php echo textarea_field('project[description]', array_var($project_data, 'description'), array('id' => 'projectFormDescription')) ?>
  </div>
  
  <div>
    <?php echo label_tag(lang('show project desciption in overview')) ?>
    <?php echo yes_no_widget('project[show_description_in_overview]', 'projectFormShowDescriptionInOverview', array_var($project_data, 'show_description_in_overview'), lang('yes'), lang('no')) ?>
  </div>
<?php if ($project->isNew() && (config_option('enable_efqm')=='yes')) { ?>
  <div>
    <?php echo label_tag(lang('efqm project')) ?>
    <?php echo yes_no_widget('project[efqm_project]', 'projectFormEfqmProject', array_var($project_data, 'efqm_project'), lang('yes'), lang('no')) ?>
  </div>
<?php } // if ?>

<?php if (!$project->isNew()) { ?>
  <hr/>
  <div id="pageAttachments">
  <?php
  $counter = 0;
  ?>
  <div class="attachmentActions">
    <!-- TODO make these links less hard-coded -->
    <!-- TODO make a helper for these links -->
    <a href="<?php echo get_url('page_attachment', 'add_attachment', array('page_name'=>'project_overview', 'rel_object_manager'=>'', 'order'=>$counter, 'redirect_to'=>get_url('project','edit',null,null,true)), null, true); ?>"><?php echo lang('add text snippet') ?></a> |
    <a href="<?php echo get_url('page_attachment', 'add_attachment', array('page_name'=>'project_overview', 'rel_object_manager'=>'Contacts', 'order'=>$counter, 'redirect_to'=>get_url('project','edit',null,null,true)), null, true); ?>"><?php echo lang('add contact') ?></a> |
    <a href="<?php echo get_url('page_attachment', 'add_attachment', array('page_name'=>'project_overview', 'rel_object_manager'=>'Companies', 'order'=>$counter, 'redirect_to'=>get_url('project','edit',null,null,true)), null, true); ?>"><?php echo lang('add company') ?></a> |
<?php if (plugin_active('files')) { ?>
    <a href="<?php echo get_url('page_attachment', 'add_attachment', array('page_name'=>'project_overview', 'rel_object_manager'=>'ProjectFiles', 'order'=>$counter, 'redirect_to'=>get_url('project','edit',null,null,true)), null, true); ?>"><?php echo lang('add file') ?></a> |
<?php } ?>
    <a href="<?php echo get_url('page_attachment', 'add_attachment', array('page_name'=>'project_overview', 'rel_object_manager'=>'ProjectMessages', 'order'=>$counter, 'redirect_to'=>get_url('project','edit',null,null,true)), null, true); ?>"><?php echo lang('add message') ?></a> |
    <a href="<?php echo get_url('page_attachment', 'add_attachment', array('page_name'=>'project_overview', 'rel_object_manager'=>'ProjectMilestones', 'order'=>$counter, 'redirect_to'=>get_url('project','edit',null,null,true)), null, true); ?>"><?php echo lang('add milestone') ?></a> |
<?php if (plugin_active('tickets')) { ?>
    <a href="<?php echo get_url('page_attachment', 'add_attachment', array('page_name'=>'project_overview', 'rel_object_manager'=>'ProjectTickets', 'order'=>$counter, 'redirect_to'=>get_url('project','edit',null,null,true)), null, true); ?>"><?php echo lang('add ticket') ?></a>
<?php } ?>
  </div>
  
<?php
if (is_array($page_attachments) && count($page_attachments)) {
  foreach ($page_attachments as $page_attachment) {
    $counter++;
    ?>
    <div class="pageAttachment <?php echo $counter%2 ? 'odd':'even'; ?>">
      <?php echo label_tag(lang($page_attachment->getObjectLangName()), 'project[page_attachments]['.$page_attachment->getId().'][label]', false, array('class'=>'checkbox')); ?>
      <?php echo $page_attachment->render('project[page_attachments]['.$page_attachment->getId().'][text]'); ?>
      <?php echo $page_attachment->renderControl('project[page_attachments]['.$page_attachment->getId().'][rel_object_id]'); ?>
      <?php echo text_field('project[page_attachments]['.$page_attachment->getId().'][order]', $page_attachment->getOrder(), array('class' => 'short pageAttachmentOrder')) ?>
      <span class="pageAttachmentDeleteBlock">
      <?php echo label_tag(lang('delete'), 'project[page_attachments]['.$page_attachment->getId().'][delete]', false, array('class'=>'checkbox'));?>
      <?php echo checkbox_field('project[page_attachments]['.$page_attachment->getId().'][delete]', false, array('class'=>'checkbox pageAttachmentDelete', 'id' => 'project[page_attachments]['.$page_attachment->getId().'][delete]')); ?>
      <input type="hidden" name="<?php echo 'project[page_attachments]['.$page_attachment->getId().'][rel_object_manager]'; ?>" value="<?php echo $page_attachment->getRelObjectManager(); ?>"/>
      </span>
      <div class="clear"></div>
    </div>
    <div class="attachmentActions">
      <!-- TODO make these links less hard-coded -->
      <!-- TODO make a helper for these links -->
      <a href="<?php echo get_url('page_attachment', 'add_attachment', array('page_name'=>'project_overview', 'rel_object_manager'=>'', 'order'=>$counter, 'redirect_to'=>get_url('project','edit',null,null,true)), null, true); ?>"><?php echo lang('add text snippet') ?></a> |
      <a href="<?php echo get_url('page_attachment', 'add_attachment', array('page_name'=>'project_overview', 'rel_object_manager'=>'Contacts', 'order'=>$counter, 'redirect_to'=>get_url('project','edit',null,null,true)), null, true); ?>"><?php echo lang('add contact') ?></a> |
      <a href="<?php echo get_url('page_attachment', 'add_attachment', array('page_name'=>'project_overview', 'rel_object_manager'=>'Companies', 'order'=>$counter, 'redirect_to'=>get_url('project','edit',null,null,true)), null, true); ?>"><?php echo lang('add company') ?></a> |
<?php if (plugin_active('files')) { ?>
      <a href="<?php echo get_url('page_attachment', 'add_attachment', array('page_name'=>'project_overview', 'rel_object_manager'=>'ProjectFiles', 'order'=>$counter, 'redirect_to'=>get_url('project','edit',null,null,true)), null, true); ?>"><?php echo lang('add file') ?></a> |
<?php } ?>
      <a href="<?php echo get_url('page_attachment', 'add_attachment', array('page_name'=>'project_overview', 'rel_object_manager'=>'ProjectMessages', 'order'=>$counter, 'redirect_to'=>get_url('project','edit',null,null,true)), null, true); ?>"><?php echo lang('add message') ?></a> |
      <a href="<?php echo get_url('page_attachment', 'add_attachment', array('page_name'=>'project_overview', 'rel_object_manager'=>'ProjectMilestones', 'order'=>$counter, 'redirect_to'=>get_url('project','edit',null,null,true)), null, true); ?>"><?php echo lang('add milestone') ?></a> |
<?php if (plugin_active('tickets')) { ?>
      <a href="<?php echo get_url('page_attachment', 'add_attachment', array('page_name'=>'project_overview', 'rel_object_manager'=>'ProjectTickets', 'order'=>$counter, 'redirect_to'=>get_url('project','edit',null,null,true)), null, true); ?>"><?php echo lang('add ticket') ?></a>
<?php } ?>
    </div>
<?php  } // foreach
} // if ?>
  </div>
  <hr/>
<?php } // if ?>
  
  <?php echo submit_button($project->isNew() ? lang('add project') : lang('edit project')) ?> <a href="<?php echo $project->getOverviewUrl() ?>"><?php echo lang('cancel') ?></a>
</form>