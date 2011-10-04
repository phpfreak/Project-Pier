<?php
  set_page_title(lang('edit logo'));
  project_crumbs(lang('edit logo'));
?>
<?php $this->includeTemplate(get_template_path('project/pageactions')); ?>

<form action="<?php echo $project->getEditLogoUrl() ?>" method="post" enctype="multipart/form-data">

<?php tpl_display(get_template_path('form_errors')) ?>
  
  <fieldset>
    <legend><?php echo lang('current logo') ?></legend>
<?php if ($project->hasLogo()) { ?>
    <img src="<?php echo $project->getLogoUrl() ?>" alt="<?php echo clean($project->getName()) ?> logo" />
    <p><a href="<?php echo $project->getDeleteLogoUrl() ?>" onclick="return confirm('<?php echo lang('confirm delete logo') ?>')"><?php echo lang('delete logo') ?></a></p>
<?php } else { ?>
    <?php echo lang('no current logo') ?>
<?php } // if ?>
  </fieldset>
  
  <div>
    <?php echo label_tag(lang('new logo'), 'projectFormLogo', true) ?>
    <?php echo file_field('new_logo', null, array('id' => 'projectFormLogo')) ?>
<?php if ($project->hasLogo()) { ?>
    <p class="desc"><?php echo lang('new logo notice') ?></p>
<?php } // if ?>
  </div>
  
  <?php echo submit_button(lang('upload')) ?> <a href="<?php echo $project->getOverviewUrl() ?>"><?php echo lang('cancel') ?></a>
  
</form>