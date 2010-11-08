<?php
// wcf imports
require_once(WCF_DIR.'lib/data/dynamic/news/DynamicNewsItem.class.php');

/**
 * Represents news item row and provides functions for creating, updateting and removing
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.news
 */
class DynamicNewsItemEditor extends DynamicNewsItem {
	
	/**
	 * Creates a new news item
	 * @param	integer	$instanceID
	 * @param	string	$subject
	 * @param	string	$text
	 * @param	boolean	$enableSmileys
	 * @param	boolean	$enableHtml
	 * @param	boolean	$enableBBCodes
	 * @param	integer	$lastEdit
	 * @param	string	$lastEditor
	 * @param	integer	$editCount
	 * @param	integer	$timestamp
	 * @param	integer	$authorID
	 * @param	string	$username
	 * @param	boolean	$isPublic
	 * @param	boolean	$isDeleted
	 */
	public static function create($instanceID, $subject, $text, $enableSmileys = true, $enableHtml = false, $enableBBCodes = true, $lastEdit = 0, $lastEditor = '', $editCount = 0, $timestamp = 0, $authorID = 0, $username = '', $isPublic = true, $isDeleted = false) {
		$sql = "INSERT INTO
					wcf".WCF_N."_page_module_news_item (instanceID,
														subject,
														text,
														enableSmileys,
														enableHtml,
														enableBBCodes,
														lastEdit,
														lastEditor,
														editCount,
														timestamp,
														authorID,
														username,
														isPublic,
														isDeleted)
				VALUES
					(".$instanceID.",
					 '".escapeString($subject)."',
					 '".escapeString($text)."',
					 ".($enableSmileys ? 1 : 0).",
					 ".($enableHtml ? 1 : 0).",
					 ".($enableBBCodes ? 1 : 0).",
					 ".$lastEdit.",
					 '".escapeString($lastEditor)."',
					 ".$editCount.",
					 ".$timestamp.",
					 ".$authorID.",
					 '".escapeString($username)."',
					 ".($isPublic ? 1 : 0).",
					 ".($isDeleted ? 1 : 0).")";
		WCF::getDB()->sendQuery($sql);
		
		return new DynamicNewsItemEditor(WCF::getDB()->getInsertID());
	}
	
	/**
	 * Updates a news item
	 * @param	string	$subject
	 * @param	string	$text
	 * @param	boolean	$enableSmileys
	 * @param	boolean	$enableHtml
	 * @param	boolean	$enableBBCodes
	 * @param	integer	$lastEdit
	 * @param	string	$lastEditor
	 * @param	integer	$editCount
	 * @param	integer	$timestamp
	 * @param	integer	$authorID
	 * @param	string	$username
	 * @param	boolean	$isPublic
	 * @param	boolean	$isDeleted
	 */
	public function update($subject, $text, $enableSmileys = true, $enableHtml = false, $enableBBCodes = true, $lastEdit = 0, $lastEditor = '', $editCount = 0, $timestamp = 0, $authorID = 0, $username = '', $isPublic = true, $isDeleted = false) {
		$sql = "UPDATE
					wcf".WCF_N."_page_module_news_item
				SET
					subject = '".escapeString($subject)."',
					text = '".escapeString($text)."',
					enableSmileys = ".($enableSmileys ? 1 : 0).",
					enableHtml = ".($enableHtml ? 1 : 0).",
					enableBBCodes = ".($enableBBCodes ? 1 : 0).",
					lastEdit = ".$lastEdit.",
					lastEditor = '".escapeString($lastEditor)."',
					editCount = ".$editCount.",
					timestamp = ".$timestamp.",
					authorID = ".$authorID.",
					username = '".escapeString($username)."',
					isPublic = ".($isPublic ? 1 : 0).",
					isDeleted = ".($isDeleted ? 1 : 0)."
				WHERE
					itemID = ".$this->itemID;
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Removes one or more item rows
	 * @param	mixed	$itemID
	 */
	public function remove($itemID) {
		$sql = "DELETE FROM
					wcf".WCF_N."_page_module_news_item
				WHERE
					itemID ".(is_array($itemID) ? "IN (".implode(',', $itemID).")" : "= ".$itemID);
		WCF::getDB()->sendQuery($sql);
	}
}
?>