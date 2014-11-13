CREATE TABLE `oxarticles` (
  `OXID` INT NOT NULL AUTO_INCREMENT,
  `OXACTIVE` tinyint(1) NOT NULL,
  `OXARTNUM` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `OXMPN` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `OXTITLE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `OXSHORTDESC` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `OXPRICE` double NOT NULL,
  `OXTPRICE` double NOT NULL,
  `OXSORT` int(11) NOT NULL,
  `OXSTOCK` double NOT NULL,
  `OXSTOCKFLAG` int(11) NOT NULL,
  `OXVENDORID` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `OXPARENTID` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `OXMANUFACTURERID` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`OXID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
