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
		list($cache, $pageID, $packageID) = explode('-', $cacheResource['cache']);
		
		$sql = "SELECT
					module.*
				FROM
					wcf".WCF_N."_page_module module,
					wcf".WCF_N."_package_dependency package_dependency
				JOIN
					wcf".WCF_N."_page_module_own module_own
				ON
					module.moduleID = page_module_own.moduleTemplateID
				JOIN
					wcf".WCF_N."_page_module_to_page module_page
				ON
					module_own.moduleID = module_page.moduleID
				WHERE
					module_page.pageID = ".$pageID."
				AND
					page_module.isVisble = 1
				AND
					page_module.packageID = package_dependency.dependency
				AND
					package_dependency.packageID = ".$packageID."
				ORDER BY
					module_page.sortOrder ASC";
		$result = WCF::getDB()->sendQuery($sql);
		
		$data = array();
		
		while($row = WCF::getDB()->fetchArray($result)) {
			$data[] = $row;
		}
		
		return $data;
	}
}
?>