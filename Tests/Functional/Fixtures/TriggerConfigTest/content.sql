CREATE TABLE `oxcontents` (
  `OXID` INT NOT NULL AUTO_INCREMENT,
  `OXLOADID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `OXSNIPPET` tinyint(1) NOT NULL,
  `OXTYPE` smallint(6) NOT NULL,
  `OXACTIVE` tinyint(1) NOT NULL,
  `OXPOSITION` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `OXTITLE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `OXCONTENT` longtext COLLATE utf8_unicode_ci NOT NULL,
  `OXFOLDER` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`OXID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

