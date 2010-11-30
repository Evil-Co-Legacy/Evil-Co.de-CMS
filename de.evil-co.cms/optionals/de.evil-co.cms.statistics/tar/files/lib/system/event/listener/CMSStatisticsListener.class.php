<?php
require_once(WCF_DIR.'lib/system/event/EventListener.class.php');

/**
 * Implements a event listener that manages cms statistics
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.statistics
 */
class CMSStatisticsListener implements EventListener {
	
	/**
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		// create needed variables
		$knownHostIDs = $knownPageIDs = array();
		
		// read known page and host IDs
		$sql = "SELECT
					*
				FROM
					cms".CMS_N."_statistic_known
				WHERE
					sessionID = '".escapeString(WCF::getSession()->sessionID)."'";
		$result = WCF::getDB()->sendQuery($sql);
		
		while($row = WCF::getDB()->fetchArray($result)) {
			if (intval($row['pageID'])) $knownPageIDs[] = intval($row['pageID']);
			if (intval($row['hostID'])) $knownHostIDs[] = intval($row['hostID']);
		}
		
		// handle hosts
		if (!in_array(CMSCore::getActiveHost()->getHostID(), $knownHostIDs)) {
			// update count for host if this user isn't known
			$sql = "UPDATE
						cms".CMS_N."_statistic_host
					SET
						requestCount = requestCount + 1
					WHERE
						hostID = ".CMSCore::getActiveHost()->getHostID();
			WCF::getDB()->sendQuery($sql);
		}
		
		// handle pages
		if (!in_array($eventObj->pageID, $knownPageIDs)) {
			// update count for page if this user isn't known
			$sql = "UPDATE
						cms".CMS_N."_statistic_page
					SET
						requestCount = requestCount + 1
					WHERE
						pageID = ".$eventObj->pageID;
			WCF::getDB()->sendQuery($sql);
		}
	}
}
?>