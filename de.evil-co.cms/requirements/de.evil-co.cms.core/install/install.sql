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
	`name` VARCHAR (255) NOT NULL,
	`file` TEXT NOT NULL,
--	`customModule` INT NULL DEFAULT NULL
);

INSERT INTO `wcf1_page_module` (`moduleID`, `packageID`, `name`, `file`) VALUES
(1, 1, 'html', 'lib/page/util/module/HTMLModule.class.php'),
(2, 1, 'article', 'lib/page/util/module/ArticleModule.class.php');

DROP TABLE IF EXISTS `wcf1_page_module_option_group`;
CREATE TABLE `wcf1_page_module_option_group` (
	`groupID` INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
	`moduleID` INT NOT NULL,
	`name` VARCHAR (255) NOT NULL
);
INSERT INTO `wcf1_page_module_option_group` (`groupID`, `moduleID`, `name`) VALUES
(1, 1, 'general'),
(2, 2, 'general');
(3, 3, 'general')
	
DROP TABLE IF EXISTS `wcf1_page_module_option`;
CREATE TABLE `wcf1_page_module_option` (
	`optionID` INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
	`moduleID` INT NOT NULL,
	`name` VARCHAR (255) NOT NULL,
	`optionType` ENUM ('boolean', 'text', 'textarea', 'select'),
	`defaultValue` TEXT NOT NULL DEFAULT '',
	`cssClass` VARCHAR(255) NOT NULL DEFAULT '',
	`groupID` INT NOT NULL,
	`displayDescription` TINYINT (1) NOT NULL DEFAULT '1',
	`fields` TEXT NOT NULL
);

INSERT INTO `wcf1_page_module_option` (`optionID`, `moduleID`, `name`, `optionType`, `defaultValue`, `cssClass`, `groupID`) VALUES
(1, 1, 'htmlCode', 'textarea', '', '', 1),
(2, 2, 'content', 'textarea', '', '', '2');

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
	`instanceID` INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
	`moduleID` INT NOT NULL,
	`pageID` INT NOT NULL,
	`isVisible` TINYINT (1) NOT NULL DEFAULT '1',
	`sortOrder` INT NOT NULL,
	`options` TEXT NOT NULL
);