<?php
require_once(WCF_DIR.'lib/system/event/EventListener.class.php');

/**
 * Implements a event listener that removes menu entries that aren't from the loaded host
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 */
class DynamicPageMenuListener implements EventListener {
	
	/**
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		foreach($eventObj->menuItems as $key => $item) {
			// remove menu items from other hosts
			if ($item['hostID'] != CMSCore::getHostID() and $item['hostID'] != 0) unset($eventObj->menuItems[$key]);
		}
	}
}
?>