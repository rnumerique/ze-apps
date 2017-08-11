ALTER TABLE `zeapps_groups` CHANGE `name` `label` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `zeapps_groups` CHANGE `right_list` `rights` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `zeapps_groups` CHANGE `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00';
ALTER TABLE `zeapps_groups` CHANGE `updated_at` `updated_at` TIMESTAMP NOT NULL;
ALTER TABLE `zeapps_groups` ADD `deleted_at` TIMESTAMP NULL DEFAULT NULL AFTER `updated_at`;

ALTER TABLE `zeapps_modules` CHANGE `name` `label` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
CREATE TABLE `zeapps_module_rights` (
  `id` int(10) unsigned NOT NULL,
  `id_module` int(10) unsigned NOT NULL,
  `rights` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `zeapps_module_rights`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `zeapps_module_rights`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;

ALTER TABLE `zeapps_users`
  DROP `groups_list`;

ALTER TABLE `zeapps_users` CHANGE `right_list` `rights` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

CREATE TABLE `zeapps_user_groups` (
  `id` int(10) unsigned NOT NULL,
  `id_user` int(10) unsigned NOT NULL,
  `id_group` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `zeapps_user_groups`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `zeapps_user_groups`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;