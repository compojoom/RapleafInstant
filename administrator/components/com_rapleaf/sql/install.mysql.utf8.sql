CREATE TABLE IF NOT EXISTS `#__rapleaf_reports` (
  `rapleaf_report_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `report` longtext NOT NULL,
  PRIMARY KEY (`rapleaf_report_id`),
  UNIQUE KEY `rapleaf_report_id` (`rapleaf_report_id`)
);


CREATE TABLE IF NOT EXISTS `#__rapleaf_users` (
  `rapleaf_user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `age` varchar(255) DEFAULT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT '0',
  `location` varchar(255) DEFAULT NULL,
  `household_income` varchar(255) DEFAULT NULL,
  `children` tinyint(1) NOT NULL DEFAULT '0',
  `marital_status` varchar(255) DEFAULT NULL,
  `home_market_value` varchar(255) DEFAULT NULL,
  `home_owner_status` varchar(255) DEFAULT NULL,
  `home_property_type` varchar(255) DEFAULT NULL,
  `length_of_residence` varchar(255) DEFAULT NULL,
  `education` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `json` text,
  PRIMARY KEY (`rapleaf_user_id`),
  UNIQUE KEY `joomlauser` (`user_id`)
);