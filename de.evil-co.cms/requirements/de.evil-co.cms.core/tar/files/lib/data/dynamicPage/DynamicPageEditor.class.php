<?php
// wcf imports
require_once(WCF_DIR.'lib/data/dynamicPage/DynamicPage.class.php');

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
	public static function create($title, $allowSpidersToIndexThisPage = true, $additionalHeadContent = '', $menuItemID = 0, $isPublic = true, $isDefaultPage = false) {
		$sql = "INSERT INTO
					wcf".WCF_N."_page (title, allowSpidersToIndexThisPage, additionalHeadContent, menuItemID, isPublic, isDefaultPage)
				VALUES ('".escapeString($title)."',
						".$allowSpidersToIndexThisPage."
						'".escapeString($additionalHeadContent)."',
						".$menuItemID.",
						".$isPublic.",
						".$isDefaultPage.")";
		WCF::getDB()->sendQuery($sql);
		
		$page = new Page(WCF::getDB()->getInsertID());
		
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
		$sqlUpdate .= "allowSpidersToIndexThisPage = ".$this->allowSpidersToIndexThisPage;
		
		$sqlUpdate .= ",additionalHeadContent = '".escapeString($this->additionalHeadContent);
		
		$sqlUpdate .= ",menuItemID = ".$this->menuItemID;
		
		$sqlUpdate .= ",isPublic = ".$this->isPublic;
		
		$sqlUpdate .= ",isDefaultPage = ".$this->isDefaultPage;
		
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
}
?>