<?php
// wcf imports
require_once(WCF_DIR.'lib/data/dynamic/page/index/DynamicPageIndexItem.class.php');

/**
 * Represents an indexed item and provides methods to edit, create or delete items
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.core
 */
class DynamicPageIndexItemEditor extends DynamicPageIndexItem {
	
	/**
	 * Creates a new index item
	 * @param	integer	$pageID
	 * @param	integer	$instanceID
	 * @param	integer	$moduleID
	 * @param	string	$content
	 */
	public static function create($pageID, $instanceID, $moduleID, $content) {
		$sql = "INSERT INTO
					wcf".WCF_N."_page_index (`pageID`, `instanceID`, `moduleID`, `content`)
				VALUES
					(".$pageID.",
					 ".$instanceID.",
					 ".$moduleID.",
					 '".escapeString($content)."');";
		WCF::getDB()->sendQuery($sql);
		
		return new DynamicPageIndexItemEditor(WCF::getDB()->getInsertID());
	}
	
	/**
	 * Modifies the current item
	 * @param	string	$content
	 */
	public function update($content) {
		$sql = "UPDATE
					wcf".WCF_N."_page_index
				SET
					content = '".escapeString($content)."'
				WHERE
					itemID = ".$this->itemID;
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Removes one or more item rows
	 * @param	mixed	$itemID
	 */
	public static function remove($itemID) {
		$sql = "DELETE FROM
					wcf".WCF_N."_page_index
				WHERE
					itemID ".(is_array($itemID) ? "IN (".implode(',', $itemID).")" : "= ".$itemID);
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Clears the state and index cache for an instance
	 * @param	integer	$instanceID
	 */
	public static function clearInstanceCache($instanceID) {
		$sql = "DELETE FROM
					wcf".WCF_N."_page_index
				WHERE
					instanceID = ".$instanceID;
		WCF::getDB()->sendQuery($sql);
		
		$sql = "DELETE FROM
					wcf".WCF_N."_page_index_state
				WHERE
					instanceID = ".$instanceID;
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Clears the state and index cache for a module
	 * @param	integer	$moduleID
	 */
	public static function clearModuleCache($moduleID) {
		$sql = "DELETE FROM
					wcf".WCF_N."_page_index
				WHERE
					moduleID = ".$moduleID;
		WCF::getDB()->sendQuery($sql);
		
		$sql = "DELETE FROM
					wcf".WCF_N."_page_index_state
				WHERE
					moduleID = ".$moduleID;
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Clears the state and index cache for a page
	 * @param	integer	$pageID
	 */
	public static function clearPageCache($pageID) {
		$sql = "DELETE FROM
					wcf".WCF_N."_page_index
				WHERE
					pageID = ".$pageID;
		WCF::getDB()->sendQuery($sql);
		
		$sql = "DELETE FROM
					wcf".WCF_N."_page_index_state
				WHERE
					pageID = ".$pageID;
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Marks a module instance as indexed
	 * @param	integer	$pageID
	 * @param	integer	$instanceID
	 * @param	integer	$moduleID
	 * @param	integer	$itemID
	 * @param	integer	$timestamp
	 */
	public static function mark($pageID, $instanceID, $moduleID, $itemID, $timestamp = TIME_NOW) {
		$sql = "INSERT INTO
					wcf".WCF_N."_index_state (pageID, instanceID, moduleID, itemID, timestamp)
				VALUES
					(".$pageID.",
					 ".$instanceiD.",
					 ".$moduleID.",
					 ".$itemID.",
					 ".$timestamp.")";
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Returnes true if the index needs a rebuild
	 * @param	integer	$instanceID
	 */
	public static function needsRebuild($instanceID) {
		$sql = "SELECT
					timestamp,
					needsRebuild
				FROM
					wcf".WCF_N."_index_state
				WHERE
					instanceID = ".$instanceID;
		$row = WCF::getDB()->getFirstRow($sql);
		
		// check needsRebuild field (Can set by modules)
		if ($row['needsRebuild'] == 1) return true;
		
		// check for disabled auto rebuild
		if (CMS_INDEX_AUTOREBUILD == 0) return false;
		
		// get seconds for rebuild
		$seconds = (CMS_INDEX_AUTOREBUILD * 60);
		
		// check for needed auto rebuild
		if (($row['timestamp'] + $seconds) <= TIME_NOW) return true;
		
		// no rebuild needed
		return false;
	}
}
?>