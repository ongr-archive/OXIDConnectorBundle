UPDATE `oxarticles` SET
  `OXTITLE` = 'The same title for all!',
  `OXSHORTDESC` = 'The same desc for all!';

INSERT INTO `oxarticles` (OXID) VALUES ('id0');
INSERT INTO `oxarticles` (OXID) VALUES ('id1');
INSERT INTO `oxarticles` (OXID) VALUES ('id2');

UPDATE `oxarticles` SET OXTITLE='Product 1' WHERE OXID='id0';
UPDATE `oxarticles` SET OXTITLE='Product 2' WHERE OXID='id1';
UPDATE `oxarticles` SET OXTITLE='Product 3' WHERE OXID='id2';
