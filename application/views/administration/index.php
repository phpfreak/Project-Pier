<?php 

  // Set page title and set crumbs to index
  set_page_title(lang('administration'));
  administration_tabbed_navigation();
  administration_crumbs(lang('index'));

?>
<div class="hint">
  <div class="header"><?php echo lang('welcome to administration') ?></div>
  <div class="content">
    <?php echo lang('welcome to administration info') ?>
    <ul>
      <li><a href="<?php echo get_url('administration', 'company') ?>"><?php echo lang('company') ?></a></li>
      <li><a href="<?php echo get_url('administration', 'members') ?>"><?php echo lang('members') ?></a> (<a href="<?php echo owner_company()->getAddUserUrl() ?>"><?php echo lang('add user') ?></a>)</li>
      <li><a href="<?php echo get_url('administration', 'clients') ?>"><?php echo lang('clients') ?></a> (<a href="<?php echo get_url('company', 'add_client') ?>"><?php echo lang('add client') ?></a>)</li>
      <li><a href="<?php echo get_url('administration', 'projects') ?>"><?php echo lang('projects') ?></a> (<a href="<?php echo get_url('project', 'add') ?>"><?php echo lang('add project') ?></a>)</li>
      <li><a href="<?php echo get_url('administration', 'configuration') ?>"><?php echo lang('configuration') ?></a></li>
      <li><a href="<?php echo get_url('administration', 'upgrade') ?>"><?php echo lang('upgrade') ?></a></li>
    </ul>
  </div>
</div>
