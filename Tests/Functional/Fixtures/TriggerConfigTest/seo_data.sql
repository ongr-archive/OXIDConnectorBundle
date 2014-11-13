CREATE TABLE `oxobject2seodata` (
  `OXOBJECTID` CHAR( 32 ) character set latin1 collate latin1_general_ci NOT NULL COMMENT 'Objects id',
  `OXSHOPID` CHAR( 32 ) character set latin1 collate latin1_general_ci NOT NULL default '' COMMENT 'Shop id (oxshops)',
  `OXLANG` INT( 2 ) NOT NULL default '0' COMMENT 'Language id',
  `OXKEYWORDS` TEXT NOT NULL COMMENT 'Keywords',
  `OXDESCRIPTION` TEXT NOT NULL COMMENT 'Description',
  `OXTIMESTAMP` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT 'Timestamp',
  PRIMARY KEY ( `OXOBJECTID` , `OXSHOPID` , `OXLANG` )
) ENGINE = MYISAM  COMMENT 'Seo entries';