<?php
// wcf imports
require_once(WCF_DIR.'lib/data/page/Page.class.php');

class PageEditor extends Page {
	
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