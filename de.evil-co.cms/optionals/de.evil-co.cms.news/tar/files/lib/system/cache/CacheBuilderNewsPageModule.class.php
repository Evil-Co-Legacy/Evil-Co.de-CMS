<?php
// wcf imports
require_once(WCF_DIR.'lib/system/cache/CacheBuilder.class.php');
require_once(WCF_DIR.'lib/data/dynamic/news/ViewableDynamicNewsItem.class.php');

/**
 * Caches all news items for a instance
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.news
 */
class CacheBuilderNewsPageModule implements CacheBuilder {
	
	/**
	 * @see CacheBuilder::getData()
	 */
	public function getData($cacheResource) {
		list($cache, $instanceID) = explode('-', $cacheResource['cache']);
		
		$sql = "SELECT
					*
				FROM
					wcf".WCF_N."_page_module_news_item
				WHERE
					instanceID = ".$instanceID."
				ORDER BY
					timestamp DESC";
		$result = WCF::getDB()->sendQuery($sql);
		
		$data = array();
		
		while($row = WCF::getDB()->fetchArray($result)) {
			$data[] = new ViewableDynamicNewsItem(null, $row);
		}
		
		return $data;
	}
}
?>