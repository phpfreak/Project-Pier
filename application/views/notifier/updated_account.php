<?php echo lang('hi john doe', $updated_account->getContact()->getDisplayName()) ?>,

<?php echo lang('user updated your account', $updated_account->getUpdatedBy()->getContact()->getDisplayName()) ?>. <?php echo lang('visit and login', externalUrl(ROOT_URL)) ?>:
<?php echo lang('username') ?>: <?php echo $updated_account->getUsername() ?> 
<?php if (trim($raw_password) != '') { ?>
<?php echo lang('password') ?>: <?php echo $raw_password ?>
<?php } else { ?>
<?php echo lang('password unchanged') ?>
<?php } // if?>

--
<?php echo externalUrl(ROOT_URL) ?>