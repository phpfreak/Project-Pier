ALTER TABLE `<?php echo $table_prefix ?>users`
  DROP `company_id`,
  DROP `display_name`,
  DROP `title`,
  DROP `avatar_file`,
  DROP `office_number`,
  DROP `fax_number`,
  DROP `mobile_number`,
  DROP `home_number`;
  
ALTER TABLE `<?php echo $table_prefix ?>users` ADD `updated_by_id` INT(10) UNSIGNED NULL AFTER `updated_on`;
ALTER TABLE `<?php echo $table_prefix ?>companies` ADD `is_favorite` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER  `logo_file`;
RENAME TABLE  `<?php echo $table_prefix ?>user_im_values` TO  `<?php echo $table_prefix ?>contact_im_values`;
ALTER TABLE  `<?php echo $table_prefix ?>contact_im_values` CHANGE `user_id` `contact_id` INT(10) UNSIGNED NOT NULL DEFAULT  '0';