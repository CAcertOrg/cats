--- create new table to record the database version
	CREATE TABLE IF NOT EXISTS `schema_version` (
		`id` int(11) PRIMARY KEY auto_increment,
		`version` int(11) NOT NULL UNIQUE,
		`when` datetime NOT NULL
	) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci

--- alter learnprogress by one column
	ALTER TABLE `learnprogress` ADD `passed` int(11) NOT NULL DEFAULT '0';

--- update new column passed with -1
	UPDATE `learnprogress` SET `passed`=-1

--- update schema version number
	INSERT INTO `schema_version`
		(`version`, `when`) VALUES
		('1'      , NOW() );