<?php
require_once(WCF_DIR.'lib/system/event/EventListener.class.php');

/**
 * Implements a event listener that adds zero values to database
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.statistics
 */
class CMSACPStatisticsListener implements EventListener {
	
	/**
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		switch($className) {
			case 'DynamicHostAddForm':
				$sql = "INSERT INTO
							cms".CMS_N."_statistic_host (hostID, requestCount)
						VALUES
							(".$eventObj->newHost->hostID.", 0)";
				WCF::getDB()->sendQuery($sql);
				break;
			case 'DynamicPageAddForm':
				$sql = "INSERT INTO
							cms".CMS_N."_statistic_page (pageID, requestCount)
						VALUES
							(".$eventObj->newPage->pageID.", 0)";
				WCF::getDB()->sendQuery($sql);
				break;
		}
	}
}
?>