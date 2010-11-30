DROP TABLE IF EXISTS `cms1_1_statistic_host`;
CREATE TABLE `cms1_1_statistic_host` (
	`hostID` INT NOT NULL,
	`requestCount` INT NOT NULL DEFAULT '0'
);

DROP TABLE IF EXISTS `cms1_1_statistic_page`;
CREATE TABLE `cms1_1_statistic_page` (
	`pageID` INT NOT NULL,
	`requestCount` INT NOT NULL DEFAULT '0'
);

DROP TABLE IF EXISTS `cms1_1_statistic_known`;
CREATE TABLE `cms1_1_statistic_known` (
	`sessionID` char (40) NOT NULL,
	`hostID` INT NULL,
	`pageID` INT NULL,
	`timestamp` INT NOT NULL
);

DROP TABLE IF EXISTS `cms1_1_statistic_referer`;
CREATE TABLE `cms1_1_statistic_referer` (
	`refererID` INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
	`hostID` INT NOT NULL
 	`url` TEXT NOT NULL,
	`count` INT NOT NULL DEFAULT '0',
);

DROP TABLE IF EXISTS `cms1_1_statistic_referer_host`;
CREATE TABLE `cms1_1_statistic_referer_host` (
	`hostID` INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
	`hostname` TEXT NOT NULL,
	`count` INT NOT NULL DEFAULT '0'
);

DROP TABLE IF EXISTS `cms1_1_statistic_browser`;
CREATE TABLE `cms1_1_statistic_browser` (
	`browserID` INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
	`browserName` VARCHAR (255) NOT NULL,
	`userAgentString` VARCHAR (255) NOT NULL,
	`count` INT NOT NULL DEFAULT '0',
	`checkOrder` INT NOT NULL DEFAULT '0',
	`isFallback` TINYINT (1) NOT NULL DEFAULT '0'
);

INSERT INTO `cms1_1_statistic_browser` (`browserID`, `browserName`, `userAgentString`, `count`, `checkOrder`, `isFallback`)
VALUES
	(NULL, 'msie', 'msie', 0, 1, 0),
	(NULL, 'firefox', 'firefox', 0, 2, 0),
	(NULL, 'chrome', 'chrome', 0, 3, 0),
	(NULL, 'safari', 'safari', 0, 4, 0),
	(NULL, 'opera', 'opera' 0, 5, 0),
	(NULL, 'konqueror', 'konqueror', 0, 6, 0),
	(NULL, 'netscape', 'netscape', 0, 7, 0),
	(NULL, 'gecko', 'gecko', 0, 8, 0),
	(NULL, 'other', 'thisIsASenselessEasterEggInThisLittlePlugin', 0, 9, 1);

