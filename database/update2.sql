-- alter learnprogress by one column
	ALTER TABLE `answers` ADD `ref_a_id` int(11);

-- update schema version number
	INSERT INTO `schema_version` (`version`, `when`) VALUES ('2', NOW() );
