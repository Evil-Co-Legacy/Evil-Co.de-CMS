<?php
// wcf imports
require_once(WCF_DIR.'lib/data/dynamic/page/module/option/group/DynamicPageModuleOptionGroup.class.php');

/**
 * This class represents a option group row and provides functions to edit, create or delete rows
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.core
 */
class DynamicPageModuleOptionGroupEditor extends DynamicPageModuleOptionGroup {
	
	/**
	 * Creates a new option group
	 * @param	string	$name
	 * @param	integer	$moduleID
	 */
	public static function create($name, $moduleID) {
		$sql = "INSERT INTO
					wcf".WCF_N."_page_module_option_group (moduleID, name)
				VALUES
					(".$moduleID.",
					 '".escapeString($name)."')";
		WCF::getDB()->sendQuery($sql);
		
		return new DynamicPageModuleOptionGroupEditor(WCF::getDB()->getInsertID());
	}
	
	/**
	 * Removes one or more rows from database
	 * @param	mixed	$moduleID
	 */
	public static function remove($moduleID) {
		$sql = "DELETE FROM
					wcf".WCF_N."_page_module_option_group
				WHERE
					moduleID ".(is_array($moduleID) ? "IN (".implode(',', $moduleID).")" : "= ".$moduleID);
		WCF::getDB()->sendQuery($sql);
	}
}
?>