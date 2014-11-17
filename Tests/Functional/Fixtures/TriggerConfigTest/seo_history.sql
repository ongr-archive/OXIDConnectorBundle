CREATE TABLE `oxseohistory` (
  `OXOBJECTID` char(32) character set latin1 collate latin1_general_ci NOT NULL COMMENT 'Object id',
  `OXIDENT` char(32) character set latin1 collate latin1_general_ci NOT NULL COMMENT 'Hashed url (md5)',
  `OXSHOPID` char(32) character set latin1 collate latin1_general_ci NOT NULL default '' COMMENT 'Shop id oxshops',
  `OXLANG` int(2) NOT NULL default '0' COMMENT 'Language id',
  `OXHITS` bigint(20) NOT NULL default '0' COMMENT 'Hits',
  `OXINSERT` timestamp NULL default NULL COMMENT 'Creation time',
  `OXTIMESTAMP` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT 'Timestamp',
  PRIMARY KEY  (`OXIDENT`,`OXSHOPID`,`OXLANG`),
  KEY `search` (`OXOBJECTID`,`OXSHOPID`,`OXLANG`)
) ENGINE=InnoDB COMMENT 'Seo urls history. If url does not exists in oxseo, then checks here and redirects';