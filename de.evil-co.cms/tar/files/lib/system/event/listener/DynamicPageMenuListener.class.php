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
		if (CMSCore::getActiveHost() !== null) {
			foreach($eventObj->menuItems as $key => $item) {
				// remove menu items from other hosts
				if (!in_array($item['menuItemID'], CMSCore::getActiveHost()->getMenuItemIDs())) unset($eventObj->menuItems[$key]);
			}
		}
	}
}
?>