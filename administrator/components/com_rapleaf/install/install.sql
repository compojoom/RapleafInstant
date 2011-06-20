CREATE TABLE IF NOT EXISTS `#__rapleaf_users` (
	`rapleaf_user_id` bigint(20) unsigned NOT NULL auto_increment,
	`user_id` bigint(20) unsigned NOT NULL,
	`age` VARCHAR(255) NULL,
	`gender` TINYINT(1) NOT NULL DEFAULT '0',
	`location` VARCHAR(255) NULL,
	`household_income` VARCHAR(255) NULL,
	`children` TINYINT(1) NOT NULL DEFAULT '0',
	`marital_status` VARCHAR(255) NULL,
	`home_market_value` VARCHAR(255) NULL,
	`home_owner_status` VARCHAR(255) NULL,
	`home_property_type` VARCHAR(255) NULL,
	`length_of_residence` VARCHAR(255) NULL,
	`education` VARCHAR(255) NULL,
	`occupation` VARCHAR(255) NULL,
	`json` TEXT,
	PRIMARY KEY ( `rapleaf_user_id` ),
	UNIQUE KEY `joomlauser` (`user_id`)
)  ENGINE=MyISAM  DEFAULT CHARSET=utf8;
