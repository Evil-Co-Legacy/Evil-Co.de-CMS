DROP TABLE IF EXISTS `wcf1_page_module_news_item`;
CREATE TABLE `wcf1_page_module_news_item` (
	`itemID` INT UNSIGNED AUTO_INCREMENT NOT NULL,
	`instanceID` INT NOT NULL,
	`subject`  VARCHAR (255) NOT NULL,
	`text` VARCHAR (255) NOT NULL,
	`enableSmileys` TINYINT (1) NOT NULL DEFAULT '1',
	`enableHtml` TINYINT (1) NOT NULL DEFAULT '0',
	`enableBBCode` TINYINT (1) NOT NULL,
	`lastEdit` TINYINT (1) NOT NULL DEFAULT '0',
	`lastEditor` VARCHAR (255) NOT NULL,
	`editCount` INT NOT NULL DEFAULT '0',
	`timestamp` INT NOT NULL,
	`authorID` INT NOT NULL,
	`username` VARCHAR (255) NOT NULL,
	`isPublic` TINYINT (1) NOT NULL DEFAULT '1',
	`isDeleted` TINYINT (1) NOT NULL DEFAULT '0'
);