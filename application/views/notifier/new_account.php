<?php echo lang('hi john doe', $new_account->getContact()->getDisplayName()) ?>,
<?php echo lang('user created your account', $new_account->getCreatedBy()->getContact()->getDisplayName()) ?>.
<?php echo lang('visit and login', externalUrl(ROOT_URL)) ?>:
<?php echo lang('username') ?>: <?php echo $new_account->getUsername() ?>
<?php echo lang('password') ?>: <?php echo $raw_password ?>
--
<?php echo externalUrl(ROOT_URL) ?>