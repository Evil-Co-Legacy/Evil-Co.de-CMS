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
			
			// add to known hosts
			$sql = "INSERT INTO
						cms".CMS_N."_statistic_known (sessionID, hostID, timestamp)
					VALUES
						('".escapeString(WCF::getSession()->sessionID)."', ".CMSCore::getActiveHost()->getHostID().", ".TIME_NOW.")";
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
			
			// add to known pages
			$sql = "INSERT INTO
						cms".CMS_N."_statistic_known (sessionID, pageID, timestamp)
					VALUES
						('".escapeString(WCF::getSession()->sessionID)."', ".$eventObj->pageID.", ".TIME_NOW.")";
			WCF::getDB()->sendQuery($sql);
		}
		
		if (isset($_SERVER['HTTP_REFERER']) and !strpos($_SERVER['HTTP_REFERER'], $_SERVER['SERVER_NAME'], 0) and !empty($_SERVER['HTTP_REFERER'])) {
			$url = parse_url($_SERVER['HTTP_REFERER']);
			
			$sql = "SELECT
						*
					FROM
						cms".CMS_N."_statistic_referer_host
					WHERE
						hostname = '".escapeString($url['host'])."'";
			$row = WCF::getDB()->getFirstRow($sql);
			
			if (WCF::getDB()->countRows()) {
				$hostID = $row['hostID'];
				
				$sql = "UPDATE
							cms".CMS_N."_statistic_referer_host
						SET
							count = count + 1
						WHERE
							hostname = '".escapeString($url['host'])."'";
				WCF::getDB()->sendQuery($sql);
			} else {
				$sql = "INSERT INTO
							cms".CMS_N."_statistic_referer_host (hostname, count)
						VALUES
							('".escapeString($url['host'])."', 1)";
				WCF::getDB()->sendQuery($sql);
				
				$hostID = WCF::getDB()->getInsertID();
			}
			
			$sql = "SELECT
						*
					FROM
						cms".CMS_N."_statistic_referer
					WHERE
						url = '".escapeString($_SERVER['HTTP_REFERER'])."'";
			$row = WCF::getDB()->getFirstRow($sql);
			
			if (WCF::getDB()->countRows()) {
				$sql = "UPDATE
							cms".CMS_N."_statistic_referer
						SET
							count = count + 1
						WHERE
							url = '".escapeString($_SERVER['HTTP_REFERER'])."'";
				WCF::getDB()->sendQuery($sql);
			} else {	
				$sql = "INSERT INTO
							cms".CMS_N."_statistic_referer (url, count, hostID)
						VALUES
							('".escapeString($_SERVER['HTTP_REFERER'])."', 1, ".$hostID.")";
				WCF::getDB()->sendQuery($sql);
			}
		}
	}
}
?>