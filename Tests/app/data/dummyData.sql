USE `ongr_oxid_test`;

#
# Table structure for table `oxcontents`
#
INSERT INTO `oxcontents` (`OXID`, `OXLOADID`, `OXSNIPPET`, `OXTYPE`, `OXACTIVE`, `OXPOSITION`, `OXTITLE`, `OXCONTENT`, `OXFOLDER`) VALUES
('8709e45f31a86909e9f999222e80b1d0', 'oxstdfooter', 1, 2, 0, 'position1', 'TITLE OF CONTENT ONE', 'CONTENT ONE', 'CMSFOLDER_STANDARD'),
('ad542e49bff479009.64538090', 'oxadminorderemail', 0, 1, 1, 'position2', 'Title of content two', '<div>Content two</div>', 'CMSFOLDER_EMAILS');

#
# Data for table `oxcategories`
#
INSERT INTO `oxcategories` (`OXID`, `OXPARENTID`, `OXLEFT`, `OXRIGHT`, `OXROOTID`, `OXSORT`, `OXACTIVE`, `OXHIDDEN`, `OXSHOPID`, `OXTITLE`, `OXDESC`) VALUES
('fada9485f003c731b7fad08b873214e0', 'fad2d80baf7aca6ac54e819e066f24aa', 4, 5, '30e44ab83fdee7564.23264141', 3010101, 1, 1, 0, 'BestCategory', 'Description 1'),
('0f41a4463b227c437f6e6bf57b1697c4', 'fada9485f003c731b7fad08b873214e0', 6, 7, '943a9ba3050e78b443c16e043ae60ef3', 103, 0, 0, 'oxbaseshop2', 'Trapeze', 'Description 2');

#
# Data for table `oxmanufacturers`
#
INSERT INTO `oxmanufacturers` (`OXID`, `OXSHOPID`, `OXACTIVE`, `OXICON`, `OXTITLE`, `OXSHORTDESC`, `OXTITLE_1`, `OXSHORTDESC_1`, `OXTITLE_2`, `OXSHORTDESC_2`, `OXTITLE_3`, `OXSHORTDESC_3`, `OXSHOWSUFFIX`) VALUES
('90a8a18dd0cf0e7aec5238f30e1c6106', 0, 1, 'naish_1_mico.jpg', 'Naish', '', 'Naish', '', '', '', '', '', 0);

#
# Data for table `oxartextends`
#
INSERT INTO `oxartextends` (`OXID`, `OXLONGDESC`, `OXTAGS`) VALUES
('6b6a6aedca3e438e98d51f0a5d586c0b', 'Product number two description for testing from extension', 'tag');

#
# Data for table `oxvendor`
#
INSERT INTO `oxvendor` (`OXID`, `OXTITLE`) VALUES
('6b6a6aedca3e438e98d51f0a5d12hjk', 'Vendor Title for PRODUCT TWO');

#
# Data for table `oxobject2seodata`
#
INSERT INTO `oxobject2seodata` (`OXOBJECTID`, `OXKEYWORDS`, `OXSHOPID`, `OXLANG`, `OXDESCRIPTION`) VALUES
('6b698c33118caee4ca0882c33f513d2f', 'testKeywords For Product 1 in language 1', 0, 1, 'testDescription For Product 1 in language 1'),
('6b698c33118caee4ca0882c33f513d2f', 'testKeywords For Product 1 in language 0', 1, 0, 'testDescription For Product 1 in language 0'),
('6b6a6aedca3e438e98d51f0a5d586c0b', 'testKeywords For Product 2 in language 0', 1, 0, 'testDescription For Product 2 in language 0');

#
# Data for table `oxobject2category`
#
INSERT INTO `oxobject2category` (`OXID`, `OXOBJECTID`, `OXCATNID`) VALUES
('sb6a6aedca3e438e98d51f0a5d12hja', '6b6a6aedca3e438e98d51f0a5d586c0b', 'fada9485f003c731b7fad08b873214e0'),
('ghjg6aedca3e438e9gfhfgha5d1fghh', '6b698c33118caee4ca0882c33f513d2f', 'non-existant');

#
# Data for table `oxarticles`
#
INSERT INTO `oxarticles` (`OXID`, `OXACTIVE`, `OXARTNUM`, `OXMPN`, `OXTITLE`, `OXSHORTDESC`, `OXPRICE`, `OXTPRICE`, `OXSORT`, `OXVENDORID`, `OXPARENTID`, `OXMANUFACTURERID`, `OXSTOCK`, `OXSTOCKFLAG`) VALUES
('6b698c33118caee4ca0882c33f513d2f', 1, '85-8573-846-1-4-3', 'F53sf45', 'PRODUCT NO. 1', 'Product number one for testing', 25.5, 36.7, 6, 'no-vendor', '', 'non-existant-manufacturer', 5, 1),
('6b6a6aedca3e438e98d51f0a5d586c0b', 0, '0702-85-853-9-2', 'F16fd56', 'PRODUCT NO. 2', 'Product number two for testing', 46.6, 35.7, 8, '6b6a6aedca3e438e98d51f0a5d12hjk', '6b698c33118caee4ca0882c33f513d2f', '90a8a18dd0cf0e7aec5238f30e1c6106', 2, 3);


#
# Data for table `oxseo`
#
INSERT INTO `oxseo` (`OXOBJECTID`, `OXIDENT`, `OXSHOPID`, `OXLANG`, `OXSTDURL`, `OXSEOURL`, `OXTYPE`, `OXFIXED`, `OXEXPIRED`, `OXPARAMS`) VALUES
('6b698c33118caee4ca0882c33f513d2f', '023abc17c853f9bccc201c5afd549a92', 1, 0, 'index.php?cl=account_wishlist', 'test/url/for/product1/number/one', 'static', 0, 0, 'product1Key'),
('6b698c33118caee4ca0882c33f513d2f', '02b4c1e4049b1baffba090c95a7edbf7', 0, 1, 'index.php?cl=invite', 'test/url/for/product1/number/two', 'static', 0, 0, 'product2Key');

#
# Data for table `oxseohistory`
#
INSERT INTO `oxseohistory` (`OXOBJECTID`, `OXIDENT`, `OXSHOPID`, `OXLANG`, `OXHITS`) VALUES
('6b698c33118caee4ca0882c33f513d2f', '8b831f739c5d16cf4571b14a76006528', 1, 0, 565),
('6b698c33118caee4ca0882c33f513d2f', 'b0b4d221756c80afdad8904c0b91b877', 0, 1, 2036);

#
# Data for table `oxcategory2attribute`
#
INSERT INTO `oxcategory2attribute` (`OXID`, `OXOBJECTID`, `OXATTRID`, `OXSORT`) VALUES
('6b698c33118caee4ca0882c33f513do', 'fada9485f003c731b7fad08b873214e0', '6b698c33118caee4ca0882c33f12sddf', 1);

#
# Data for table `oxattribute`
#
INSERT INTO `oxattribute` (`OXID`,  `OXTITLE`) VALUES
('6b698c33118caee4ca0882c33f12sddf', 'testAttribute');
