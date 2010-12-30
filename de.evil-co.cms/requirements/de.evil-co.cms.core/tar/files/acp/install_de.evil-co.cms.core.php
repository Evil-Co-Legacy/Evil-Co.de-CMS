<?php
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
			packageID = ".$packageID;
WCF::getDB()->sendQuery($sql);
?>