<?php
// wcf imports
require_once(WCF_DIR.'lib/system/cache/CacheBuilder.class.php');

/**
 * Caches all page modules for a page
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.core
 */
class CacheBuilderPageModules implements CacheBuilder {
	
	/**
	 * @see CacheBuilder::getData()
	 */
	public function getData($cacheResource) {
		list($cache, $pageID, $packageID) = explode('-', $cacheResource['cache']);
		
		$sql = "SELECT
					modules.*,
					page_module.instanceID AS instanceID
				FROM
					wcf".WCF_N."_page_module modules
				LEFT JOIN
					wcf".WCF_N."_package_dependency dependency
				ON
					dependency.dependency = modules.packageID
				LEFT JOIN
					wcf".WCF_N."_page_module_to_page page_module
				ON
					page_module.moduleID = modules.moduleID
				WHERE
					page_module.pageID = ".$pageID."
				AND
					dependency.packageID = ".$packageID."
				ORDER BY
					page_module.sortOrder ASC";
		$result = WCF::getDB()->sendQuery($sql);
		
		$data = array();
		
		while($row = WCF::getDB()->fetchArray($result)) {
			$data[] = $row;
		}
		
		foreach($data as $key => $element) {
			$data[$key]['instanceNumber'] = $data[$key]['instanceCount'] = 1;
			foreach($data as $key2 => $element2) {
				if ($element2['moduleID'] == $element['moduleID'] and $element2['instanceID'] != $element['instanceID']) {
					$data[$key]['instanceCount']++;
					if ($element2['instanceID'] < $element['instanceID']) $data[$key]['instanceNumber']++;
				}
				
			}
		}
		
		return $data;
	}
}
?>