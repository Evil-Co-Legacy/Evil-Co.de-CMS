<?php
// wcf imports
require_once(WCF_DIR.'lib/system/cache/CacheBuilder.class.php');
require_once(WCF_DIR.'lib/data/host/Host.class.class.php');

/**
 * Caches all hosts
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.core
 */
class CacheBuilderHosts extends CacheBuilder {
	
	/**
	 * @see CacheBuilder::getData()
	 */
	public function getData($cacheResource) {
		$data = array();
		
		$sql = "SELECT
					hostID,
					IFNULL(title,hostname) AS title
				FROM
					wcf".WCF_N."_host
				ORDER BY
					IFNULL(title,hostname) ASC";
		$result = WCF::getDB()->sendQuery($sql);
		
		while($row = WCF::getDB()->fetchArray($result)) {
			$data[] = new Host(null, $row);
		}
		
		return $data;
	}
}
?>