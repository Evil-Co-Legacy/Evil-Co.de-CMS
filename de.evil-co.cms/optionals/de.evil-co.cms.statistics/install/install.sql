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