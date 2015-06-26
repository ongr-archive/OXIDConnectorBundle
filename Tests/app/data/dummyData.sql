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
INSERT INTO `oxseo` (`OXOBJECTID`, `OXIDENT`, `OXSHOPID`, `OXLANG`, `OXSTDURL`, `OXSEOURL`, `OXTYPE`, `OXFIXED`, `OXEXPIRED`, `OXPARAMS`, `OXTIMESTAMP`) VALUES
('6b698c33118caee4ca0882c33f513d2f', '0767edaa8b366a6d4ef3bd584ac48176', 0, 0, 'index.php?cl=details&amp;anid=058de8224773a1d5fd54d523f0c823e0&amp;cnid=0f4f08358666c54b4fde3d83d2b7ef04', 'Test/Product/1', 'oxarticle', 0, 0, '0f4f08358666c54b4fde3d83d2b7ef04', '2015-06-23 08:24:12'),
('6b698c33118caee4ca0882c33f513d2f', 'c815781a787b8af1ee1ca1cdb0397dc7', 0, 1, 'index.php?cl=details&amp;anid=058de8224773a1d5fd54d523f0c823e0&amp;cnid=0f4f08358666c54b4fde3d83d2b7ef04', 'en/Test/Product/1', 'oxarticle', 0, 0, '0f4f08358666c54b4fde3d83d2b7ef04', '2015-06-23 08:19:00'),
('6b6a6aedca3e438e98d51f0a5d586c0b', '0767edaa8b366a6d4ef3bd584ac48177', 0, 0, 'index.php?cl=details&amp;anid=058de8224773a1d5fd54d523f0c823e0&amp;cnid=0f4f08358666c54b4fde3d83d2b7ef04', 'Test/Product/2', 'oxarticle', 0, 0, '0f4f08358666c54b4fde3d83d2b7ef04', '2015-06-23 08:24:12'),
('6b6a6aedca3e438e98d51f0a5d586c0b', 'c815781a787b8af1ee1ca1cdb0397dc8', 0, 1, 'index.php?cl=details&amp;anid=058de8224773a1d5fd54d523f0c823e0&amp;cnid=0f4f08358666c54b4fde3d83d2b7ef04', 'en/Test/Product/2', 'oxarticle', 0, 0, '0f4f08358666c54b4fde3d83d2b7ef04', '2015-06-23 08:19:00'),

('8709e45f31a86909e9f999222e80b1d0', '0767edaa8b366a6d4ef3bd584ac48178', 0, 0, 'index.php?cl=details&amp;anid=058de8224773a1d5fd54d523f0c823e0&amp;cnid=0f4f08358666c54b4fde3d83d2b7ef04', 'Test/Content/1', 'oxcontent', 0, 0, '0f4f08358666c54b4fde3d83d2b7ef04', '2015-06-23 08:24:12'),
('8709e45f31a86909e9f999222e80b1d0', 'c815781a787b8af1ee1ca1cdb0397dc9', 0, 1, 'index.php?cl=details&amp;anid=058de8224773a1d5fd54d523f0c823e0&amp;cnid=0f4f08358666c54b4fde3d83d2b7ef04', 'en/Test/Content/1', 'oxcontent', 0, 0, '0f4f08358666c54b4fde3d83d2b7ef04', '2015-06-23 08:19:00'),
('ad542e49bff479009.64538090', '0767edaa8b366a6d4ef3bd584ac48170', 0, 0, 'index.php?cl=details&amp;anid=058de8224773a1d5fd54d523f0c823e0&amp;cnid=0f4f08358666c54b4fde3d83d2b7ef04', 'Test/Content/2', 'oxcontent', 0, 0, '0f4f08358666c54b4fde3d83d2b7ef04', '2015-06-23 08:24:12'),
('ad542e49bff479009.64538090', 'c815781a787b8af1ee1ca1cdb0397dca', 0, 1, 'index.php?cl=details&amp;anid=058de8224773a1d5fd54d523f0c823e0&amp;cnid=0f4f08358666c54b4fde3d83d2b7ef04', 'en/Test/Content/2', 'oxcontent', 0, 0, '0f4f08358666c54b4fde3d83d2b7ef04', '2015-06-23 08:19:00'),

('fada9485f003c731b7fad08b873214e0', '0767edaa8b366a6d4ef3bd584ac48186', 0, 0, 'index.php?cl=details&amp;anid=058de8224773a1d5fd54d523f0c823e0&amp;cnid=0f4f08358666c54b4fde3d83d2b7ef04', 'Test/Category/1', 'oxcategory', 0, 0, '0f4f08358666c54b4fde3d83d2b7ef04', '2015-06-23 08:24:12'),
('fada9485f003c731b7fad08b873214e0', 'c815781a787b8af1ee1ca1cdb0397dd7', 0, 1, 'index.php?cl=details&amp;anid=058de8224773a1d5fd54d523f0c823e0&amp;cnid=0f4f08358666c54b4fde3d83d2b7ef04', 'en/Test/Category/1', 'oxcategory', 0, 0, '0f4f08358666c54b4fde3d83d2b7ef04', '2015-06-23 08:19:00'),
('0f41a4463b227c437f6e6bf57b1697c4', '0767edaa8b366a6d4ef3bd584ac49177', 0, 0, 'index.php?cl=details&amp;anid=058de8224773a1d5fd54d523f0c823e0&amp;cnid=0f4f08358666c54b4fde3d83d2b7ef04', 'Test/Category/2', 'oxcategory', 0, 0, '0f4f08358666c54b4fde3d83d2b7ef04', '2015-06-23 08:24:12'),
('0f41a4463b227c437f6e6bf57b1697c4', 'c815781a787b8af1ee1ca1cdb0497dc8', 0, 1, 'index.php?cl=details&amp;anid=058de8224773a1d5fd54d523f0c823e0&amp;cnid=0f4f08358666c54b4fde3d83d2b7ef04', 'en/Test/Category/2', 'oxcategory', 0, 0, '0f4f08358666c54b4fde3d83d2b7ef04', '2015-06-23 08:19:00');

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
