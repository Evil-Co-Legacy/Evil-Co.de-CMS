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
}
?>