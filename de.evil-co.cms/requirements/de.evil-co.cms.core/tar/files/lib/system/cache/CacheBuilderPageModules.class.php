<?php
// wcf imports
require_once(WCF_DIR.'lib/system/cache/CacheBuilder.class.php');

/**
 * Caches all page modules for a page
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 */
class CacheBuilderPageModules extends CacheBuilder {
	
	/**
	 * @see CacheBuilder::getData()
	 */
	public function getData($cacheResource) {
		list($cache, $pageID) = explode('-', $cacheResource['cache']);
		
		$sql = "SELECT
					module.*
				FROM
					wcf".WCF_N."_page_module module
				JOIN
					wcf".WCF_N."_page_module_to_page page_module
				ON
					module.moduleID = page_module.moduleID
				WHERE
					page_module.pageID = ".$pageID."
				AND
					page_module.isVisble = 1";
		$result = WCF::getDB()->sendQuery($sql);
		
		$data = array();
		
		while($row = WCF::getDB()->fetchArray($result)) {
			$data[] = $row;
		}
		
		return $data;
	}
}
?>