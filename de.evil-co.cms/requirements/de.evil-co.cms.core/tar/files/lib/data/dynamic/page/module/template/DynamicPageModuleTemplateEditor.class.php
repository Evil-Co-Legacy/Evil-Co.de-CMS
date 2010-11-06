<?php
// wcf imports
require_once(WCF_DIR.'lib/data/dynamic/page/module/template/DynamicPageModuleTemplate.class.php');

/**
 * This class represents a module row and provides functions to edit, create or delete rows
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.core
 */
class DynamicPageModuleTemplateEditor extends DynamicPageModuleTemplate {
	
	/**
	 * Creates a new row
	 * @param	string	$name
	 * @param	string	$file
	 * @param	integer	$packageID
	 */
	public static function create($name, $file, $packageID = 0) {
		$sql = "INSERT INTO
					wcf".WCF_N."_page_module (name, file, packageID)
				VALUES
					('".escapeString($name)."',
					 '".escapeString($file)."',
					 ".$packageID.")";
		WCF::getDB()->sendQuery($sql);
		
		return new DynamicPageModuleTemplateEditor(WCF::getDB()->getInsertID());
	}
	
	/**
	 * Updates a row
	 * @param	string	$name
	 * @param	string	$file
	 */
	public function update($name, $file) {
		$sql = "UPDATE
					wcf".WCF_N."_page_module
				SET
					name = '".escapeString($name)."',
					file = '".escapeString($file)."',
				WHERE
					moduleID = ".$this->moduleID;
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Removes one or more rows from database
	 * @param	mixed	$moduleID
	 */
	public static function remove($moduleID) {
		$sql = "DELETE FROM
					wcf".WCF_N."_page_module
				WHERE
					moduleID ".(is_array($moduleID) ? "IN (".implode(',', $moduleID).")" : "= ".$moduleID);
		WCF::getDB()->sendQuery($sql);
	}
}
?>