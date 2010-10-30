<?php
// define module IDs that should updated
$moduleIDs = array(1, 2, 3);

// get packageID
$sql = "SELECT
			packageID
		FROM
			wcf".WCF_N."_package
		WHERE
			package = 'de.evil-co.cms.core'";
$package = WCF::getDB()->getFirstRow($sql);
$packageID = $package['packageID'];

// update modules
$sql = "UPDATE
			wcf".WCF_N."_page_module
		SET
			packageID = ".$packageID."
		WHERE
			moduleID IN (".implode(',', $moduleIDs).")";
WCF::getDB()->sendQuery($sql);

// remove this file
@unlink(__FILE__);
?>