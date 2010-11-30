<?php
/**
 * This file adds all existing pages and hosts to statistics table
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.statistics
 */

// create needed variables
$hosts = $pages = array();
$parentPackage = $this->installation->getPackage()->getParentPackageID();

// read existing hosts from database
$sql = "SELECT
			*
		FROM
			wcf".WCF_N."_host
		WHERE
			packageID = ".$parentPackage;
$result = WCF::getDB()->sendQuery($sql);

while($row = WCF::getDB()->fetchArray($result)) {
	$hosts[] = "(".$row['hostID'].", 0)";
}

// create hosts in statistics database
$sql = "INSERT INTO
			cms".CMS_N."_statistic_host (hostID, requestCount)
		VALUES
			".implode(',', $hosts);
WCF::getDB()->sendQuery($sql);

// read existing pages from database
$sql = "SELECT
			*
		FROM
			wcf".WCF_N."_page
		WHERE
			packageID = ".$parentPackage;

while($row = WCF::getDB()->fetchArray($result)) {
	$pages[] = "(".$row['pageID'].", 0)";
}

// create pages in statistics database
$sql = "INSERT INTO
			cms".CMS_N."_statistic_page (pageID, requestCount)
		VALUES
			".implode(',', $pages);
WCF::getDB()->sendQuery($sql);
?>