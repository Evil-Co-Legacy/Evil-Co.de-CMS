<?php
// wcf imports
require_once(WCF_DIR.'lib/data/dynamic/page/DynamicPage.class.php');

/**
 * Represents a dynamic page row and provides functions to add, update and edit rows
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms
 */
class DynamicPageEditor extends DynamicPage {
	
	/**
	 * Creates a new page
	 * @param	string	$title
	 * @param	boolean	$allowSpidersToIndexThisPage
	 * @param	string	$additionalHeadContent
	 * @param	integer	$menuItemID
	 * @param	boolean	$isPublic
	 * @param	boolean	$isDefaultPage
	 */
	public static function create($title, $allowSpidersToIndexThisPage = true, $additionalHeadContent = '', $menuItemID = 0, $isPublic = true, $isDefaultPage = false, $hostID = 0) {
		$sql = "INSERT INTO
					wcf".WCF_N."_page (title, allowSpidersToIndexThisPage, additionalHeadContent, menuItemID, isPublic, isDefaultPage, hostID)
				VALUES ('".escapeString($title)."',
						".($allowSpidersToIndexThisPage ? 1 : 0).",
						'".escapeString($additionalHeadContent)."',
						".$menuItemID.",
						".($isPublic ? 1 : 0).",
						".($isDefaultPage ? 1 : 0).",
						".$hostID.")";
		WCF::getDB()->sendQuery($sql);
		
		$page = new DynamicPageEditor(WCF::getDB()->getInsertID());
		
		if ($isDefaultPage) {
			$sql = "UPDATE
						wcf".WCF_N."_page
					SET
						isDefaultPage = 0
					WHERE
						pageID NOT IN (".$page->pageID.")";
			WCF::getDB()->sendQuery($sql);
		}
		
		return $page;
	}
	
	/**
	 * Writes variables of this class to database
	 */
	public function update() {
		$sqlUpdate = "";
		
		if (!empty($this->title)) {
			$sqlUpdate .= "title = '".escapeString($this->title)."'";
		}
		
		if (!empty($sqlUpdate)) $sqlUpdate .= ",";
		$sqlUpdate .= "allowSpidersToIndexThisPage = ".($this->allowSpidersToIndexThisPage ? 1 : 0);
		
		$sqlUpdate .= ",additionalHeadContent = '".escapeString($this->additionalHeadContent)."'";
		
		$sqlUpdate .= ",menuItemID = ".$this->menuItemID;
		
		$sqlUpdate .= ",isPublic = ".($this->isPublic ? 1 : 0);
		
		$sqlUpdate .= ",isDefaultPage = ".($this->isDefaultPage ? 1 : 0);
		
		$sql = "UPDATE
					wcf".WCF_N."_page
				SET
					".$sqlUpdate."
				WHERE
					pageID = ".$this->pageID;
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Removes the entry/entries with the given pageID(s)
	 * @param	mixed	$pageID
	 */
	public static function remove($pageID) {
		$sql = "DELETE FROM
					wcf".WCF_N."_page
				WHERE
					pageID ".(is_array($pageID) ? 'IN ('.implode(',', $pageID).')' : '= '.$pageID);
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Removes all page entries with given hostID
	 * @param	mixed	$hostID
	 */
	public static function removeFromHost($hostID) {
		$sql = "DELETE FROM
					wcf".WCF_N."_page
				WHERE
					pageID ".(is_array($hostID) ? "IN (".implode(',', $hostID).")" : "= ".$hostID);
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Returnes true if a page title is available
	 * @param	string	$title
	 * @param	integer	$hostID
	 */
	public static function isAvailable($title, $hostID) {
		$sql = "SELECT
					COUNT(*) AS count
				FROM
					wcf".WCF_N."_page
				WHERE
					title = '".escapeString($title)."'
				AND
					hostID = ".$hostID;
		$result = WCF::getDB()->getFirstRow($sql);
		
		if ($result['count'] > 0) return false;
		
		return true;
	}
	
	/**
	 * Removes the cache for the given page
	 */
	public static function clearCache($pageID, $hostID) {
		// TODO: Implement
	}
}
?>