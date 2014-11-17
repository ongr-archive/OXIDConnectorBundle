CREATE TABLE `oxseo` (
  `OXOBJECTID` char(32) character set latin1 collate latin1_general_ci NOT NULL default '' COMMENT 'Object id',
  `OXIDENT`    char(32) character set latin1 collate latin1_general_ci NOT NULL default '' COMMENT 'Hashed seo url (md5)',
  `OXSHOPID`   char(32) character set latin1 collate latin1_general_ci NOT NULL default '' COMMENT 'Shop id (multilanguage)',
  `OXLANG`     int(2) NOT NULL default 0 COMMENT 'Language id',
  `OXSTDURL`   varchar(2048) NOT NULL COMMENT 'Primary url, not seo encoded',
  `OXSEOURL`   varchar(2048) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL COMMENT 'Old seo url',
  `OXTYPE`     enum('static', 'oxarticle', 'oxcategory', 'oxvendor', 'oxcontent', 'dynamic', 'oxmanufacturer') NOT NULL COMMENT 'Record type',
  `OXFIXED`    TINYINT(1) NOT NULL default 0 COMMENT 'Fixed',
  `OXEXPIRED` tinyint(1) NOT NULL default '0' COMMENT 'Expired',
  `OXPARAMS` char(32) NOT NULL default '' COMMENT 'Params',
  `OXTIMESTAMP` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT 'Timestamp'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
