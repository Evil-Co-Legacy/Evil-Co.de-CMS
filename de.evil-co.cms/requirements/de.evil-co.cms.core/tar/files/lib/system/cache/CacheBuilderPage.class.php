<?php
// wcf imports
require_once(WCF_DIR.'lib/system/cache/CacheBuilder.class.php');
require_once(WCF_DIR.'lib/data/page/Page.class.php');

/**
 * Caches a page
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 */
class CacheBuilderPage extends CacheBuilder {
	
	/**
	 * @see CacheBuilder::getData()
	 */
	public function getData($cacheResource) {
		list($cache, $pageID) = explode('-', $cacheResource['cache']);
		
		return new Page($pageID);
	}
}
?>