-- fixture data

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT=0;
START TRANSACTION;

TRUNCATE TABLE `category`;
TRUNCATE TABLE `product`;

INSERT INTO `category` (`name`, `created`, `slug`) VALUES
 ('services', NOW(), 'services'),
 ('software', NOW(), 'software'),
 ('wearable', NOW(), 'wearable')
;

INSERT INTO `product` (`name`, `category_id`, `price`, `created`, `slug`) VALUES
 ('T-shirt', 3, 15.99, NOW(), 't-shirt'),
 ('cap', 3, 6.90, NOW(), 'cap'),
 ('pants', 3, 13.99, NOW(), 'pants'),
 ('jacket', 3, 15.99, NOW(), 'jacket'),
 ('setup', 1, 22.99, NOW(), 'setup'),
 ('installation', 1, 22.99, NOW(), 'installation'),
 ('installation and setup', 1, 30.00, NOW(), 'installation-and-setup'),
 ('ubuntu', 2, 2.00, NOW(), 'ubuntu'),
 ('kubuntu', 2, 2.00, NOW(), 'kubuntu'),
 ('xubuntu', 2, 2.00, NOW(), 'xubuntu'),
 ('lubuntu', 2, 2.00, NOW(), 'lubuntu'),
 ('edubuntu', 2, 1.50, NOW(), 'edubuntu')
;

SET FOREIGN_KEY_CHECKS=1;
COMMIT;