DROP TABLE IF EXISTS `wcf1_host`;
CREATE TABLE `wcf1_host` (
	`hostID` INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
	`title` VARCHAR (255) NULL,
	`hostname` VARCHAR (255) NOT NULL,
	`isDisabled` TINYINT (1) NOT NULL DEFAULT '0',
	`isFallback` TINYINT (1) NOT NULL DEFAULT '0',
	`languageCode` VARCHAR (20) NULL,
	`packageID` INT NOT NULL
);

DROP TABLE IF EXISTS `wcf1_page`;
CREATE TABLE `wcf1_page` (
	`pageID` INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
	`title` TEXT NOT NULL DEFAULT '',
	`allowSpidersToIndexThisPage` TINYINT (1) NOT NULL DEFAULT '1',
	`additionalHeadContent` TEXT NOT NULL DEFAULT '',
	`menuItemID` INT NOT NULL DEFAULT '0',
	`isPublic` TINYINT (1) NOT NULL DEFAULT '1',
	`isDefaultPage` TINYINT (1) NOT NULL DEFAULT '0',
	`hostID` INT NOT NULL
);

DROP TABLE IF EXISTS `wcf1_page_module`;
CREATE TABLE `wcf1_page_module` (
	`moduleID` INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
	`packageID` INT NOT NULL DEFAULT '0',
	`file` TEXT NOT NULL,
--	`customModule` INT NULL DEFAULT NULL
);

--DROP TABLE IF EXISTS `wcf1_page_module_custom`;
--CREATE TABLE `wcf1_page_module_custom` (
--	`moduleID` INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
--	`moduleTemplateID` INT NOT NULL DEFAULT '0',
--	`name` VARCHAR (255) NOT NULL,
--	`settings` TEXT NOT NULL,
--	`allowedGroups` TEXT NOT NULL
--);

DROP TABLE IF EXISTS `wcf1_page_module_to_page`;
CREATE TABLE `wcf1_page_module_to_page` (
	`moduleID` INT NOT NULL,
	`pageID` INT NOT NULL,
	`isVisible` TINYINT (1) NOT NULL DEFAULT '1',
	`sortOrder` INT NOT NULL
);