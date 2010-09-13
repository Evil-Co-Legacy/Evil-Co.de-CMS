<?php
// wcf imports
require_once(WCF_DIR.'lib/system/cache/CacheBuilder.class.php');
require_once(WCF_DIR.'lib/data/page/Page.class.php');

/**
 * Caches all pages
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 */
class CacheBuilderDynamicPages extends CacheBuilder {
	
	/**
	 * @see CacheBuilder::getData()
	 */
	public function getData($cacheResource) {
		$sql = "SELECT
					*
				FROM
					wcf".WCF_N."_page";
		$result = WCF::getDB()->sendQuery($sql);
		
		$data = array();
		
		while($row = WCF::getDB()->fetchArray($result)) {
			$data[] = new Page(null, $row);
		}
		
		return $data;
	}
}
?>