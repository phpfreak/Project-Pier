<div id="userbox">
  <?php echo lang('welcome back', clean($_userbox_user->getDisplayName())) ?> (<a href="<?php echo get_url('access', 'logout') ?>" onclick="return confirm('<?php echo lang('confirm logout') ?>')"><?php echo lang('logout') ?></a>),
  <ul>
    <li><a href="<?php echo logged_user()->getAccountUrl() ?>"><?php echo lang('account') ?></a> <?php echo render_icon('bullet_drop_down.gif', '', array('id' => 'account_more_icon', 'class' => 'PopupMenuWidgetAttachTo', 'title' => lang('enable javascript'))) ?></li>
<?php if (isset($_userbox_projects) && is_array($_userbox_projects) && count($_userbox_projects)) { ?>
    <li><a href="<?php echo get_url('dashboard', 'my_projects') ?>"><?php echo lang('projects') ?></a> <?php echo render_icon('bullet_drop_down.gif', '', array('id' => 'projects_more_icon', 'class' => 'PopupMenuWidgetAttachTo', 'title' => lang('enable javascript'))) ?></li>
<?php } // if ?>
<?php if (logged_user()->isAdministrator()) { ?>
    <li><a href="<?php echo get_url('administration') ?>"><?php echo lang('administration') ?></a> <?php echo render_icon('bullet_drop_down.gif', '', array('id' => 'administration_more_icon', 'class' => 'PopupMenuWidgetAttachTo', 'title' => lang('enable javascript'))) ?></li>
<?php } // if ?>
  </ul>
  
  <div class="PopupMenuWidgetDiv" id="account_more_menu">
    <p><?php echo lang('account') ?>:</p>
    <ul>
      <li><a href="<?php echo logged_user()->getEditProfileUrl() ?>"><?php echo lang('update profile') ?></a></li>
      <li><a href="<?php echo logged_user()->getEditPasswordUrl() ?>"><?php echo lang('change password') ?></a></li>
      <li><a href="<?php echo logged_user()->getUpdateAvatarUrl() ?>"><?php echo lang('update avatar') ?></a></li>
    </ul>
    <p><?php echo lang('more') ?>:</p>
    <ul>
      <li><a href="<?php echo get_url('dashboard', 'my_projects') ?>"><?php echo lang('my projects') ?></a></li>
      <li><a href="<?php echo get_url('dashboard', 'my_tasks') ?>"><?php echo lang('my tasks') ?></a></li>
    </ul>
  </div>
  <script type="text/javascript">
    var account_drop_down = new App.widgets.UserBoxMenu('account_more_icon', 'account_more_menu');
    account_drop_down.build();
  </script>
  
<?php if (isset($_userbox_projects) && is_array($_userbox_projects) && count($_userbox_projects)) { ?>
  <div class="PopupMenuWidgetDiv" id="projects_more_menu">
    <p><?php echo lang('projects') ?>:</p>
    <ul>
<?php foreach ($_userbox_projects as $_userbox_project) { ?>
      <li><a href="<?php echo $_userbox_project->getOverviewUrl() ?>"><?php echo clean($_userbox_project->getName()) ?></a></li>
<?php } // if ?>
    </ul>
  </div>
  <script type="text/javascript">
    var projects_drop_down = new App.widgets.UserBoxMenu('projects_more_icon', 'projects_more_menu');
    projects_drop_down.build();
  </script>
<?php } // if ?>
  
<?php if (logged_user()->isAdministrator()) { ?>
  <div class="PopupMenuWidgetDiv" id="administration_more_menu">
    <p><?php echo lang('administration') ?>:</p>
    <ul>
      <li><a href="<?php echo get_url('administration', 'company') ?>"><?php echo lang('company') ?></a></li>
      <li><a href="<?php echo get_url('administration', 'members') ?>"><?php echo lang('members') ?></a></li>
      <li><a href="<?php echo get_url('administration', 'clients') ?>"><?php echo lang('clients') ?></a></li>
      <li><a href="<?php echo get_url('administration', 'projects') ?>"><?php echo lang('projects') ?></a></li>
      <li><a href="<?php echo get_url('administration', 'configuration') ?>"><?php echo lang('configuration') ?></a></li>
      <li><a href="<?php echo get_url('administration', 'tools') ?>"><?php echo lang('administration tools') ?></a></li>
      <li><a href="<?php echo get_url('administration', 'upgrade') ?>"><?php echo lang('upgrade') ?></a></li>
    </ul>
  </div>
  <script type="text/javascript">
    var administration_drop_down = new App.widgets.UserBoxMenu('administration_more_icon', 'administration_more_menu');
    administration_drop_down.build();
  </script>
<?php } // if ?>
</div>
