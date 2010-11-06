<?php
// wcf imports
require_once(WCF_DIR.'lib/system/cache/CacheBuilder.class.php');

/**
 * Caches all page menu item IDs
 * Thanks to Woltlab for this fucking workaround -.-
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.core
 */
class CacheBuilderDynamicPagemenuItemIDs implements CacheBuilder {
	
	/**
	 * @see CacheBuilder::getData()
	 */
	public function getData($cacheResource) {
		list($cache, $hostID) = explode('-', $cacheResource['cache']);
		
		$sql = "SELECT
					menuItemID
				FROM
					wcf".WCF_N."_page
				WHERE
					hostID = ".$hostID;
		$result = WCF::getDB()->sendQuery($sql);
		
		$menuItemIDs = array();
		
		while($row = WCF::getDB()->fetchArray($result)) {
			$menuItemIDs[] = $row['menuItemID'];
		}
		
		return $menuItemIDs;
	}
}
?>