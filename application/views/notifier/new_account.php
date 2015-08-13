<?php echo lang('hi john doe', $new_account->getContact()->getDisplayName()) ?>,
<?php echo lang(' user created your account', $new_account->getCreatedBy()->getContact()->getDisplayName()) ?>.
<?php echo "\n"?>
<?php echo lang('Please visit and login with provided Username and Password', externalUrl(ROOT_URL)) ?>:
<?php echo "\n"?>
<?php echo lang('Username') ?>: <?php echo $new_account->getUsername() ?>
<?php echo lang(' Password') ?>: <?php echo $raw_password ?>
<?php echo "\n"?>
<?php echo externalUrl(ROOT_URL) ?>