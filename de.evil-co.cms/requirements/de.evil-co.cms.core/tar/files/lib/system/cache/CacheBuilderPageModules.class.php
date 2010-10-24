<?php
// wcf imports
require_once(WCF_DIR.'lib/system/cache/CacheBuilder.class.php');

/**
 * Caches all page modules for a page
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 */
class CacheBuilderPageModules implements CacheBuilder {
	
	/**
	 * @see CacheBuilder::getData()
	 */
	public function getData($cacheResource) {
		list($cache, $pageID, $packageID) = explode('-', $cacheResource['cache']);
		
		$sql = "SELECT
					module.*
				FROM
					wcf".WCF_N."_page_module AS module
				LEFT JOIN
					wcf".WCF_N."_package_dependency AS package_dependency
				ON
					module.packageID = package_dependency.dependency
				LEFT JOIN
					wcf".WCF_N."_page_module_custom AS module_custom
				ON
					module.moduleID = module_custom.moduleTemplateID
				LEFT JOIN
					wcf".WCF_N."_page_module_to_page AS module_page
				ON
					module_custom.moduleID = module_page.moduleID
				WHERE
					module_page.pageID = ".$pageID."
				AND
					module_page.isVisible = 1
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