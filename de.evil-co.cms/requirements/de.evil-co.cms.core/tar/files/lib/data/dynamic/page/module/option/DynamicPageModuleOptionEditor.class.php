<?php
// wcf imports
require_once(WCF_DIR.'lib/data/dynamic/page/module/option/DynamicPageModuleOption.class.php');

/**
 * This class represents a option row and provides functions to edit, create or delete rows
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.core
 */
class DynamicPageModuleOptionEditor extends DynamicPageModuleOption {
	
	/**
	 * Creates a new module option
	 * @param	string	$name
	 * @param	string	$type
	 * @param	string	$defaultValue
	 * @param	string	$cssClass
	 * @param	boolean	$displayDescription
	 * @param	string	$fields
	 * @param	integer	$groupID
	 * @param	integer	$moduleID
	 */
	public static function create($name, $type, $defaultValue, $cssClass, $displayDescription, $fields, $groupID, $moduleID) {
		$sql = "INSERT INTO
					wcf".WCF_N."_page_module_option (name, optionType, defaultValue, cssClass, displayDescription, fields, groupID, moduleID)
				VALUES
					('".escapeString($name)."',
					 '".escapeString($type)."',
					 '".($type == 'boolean' ? ($defaultValue ? 1 : 0) : escapeString($defaultValue))."',
					 '".escapeString($cssClass)."',
					 ".($displayDescription ? 1 : 0).",
					 '".escapeString($fields)."',
					 ".$groupID.",
					 ".$moduleID.")";
		WCF::getDB()->sendQuery($sql);
		
		return new DynamicPageModuleOptionEditor(WCF::getDB()->getInsertID());
	}
	
	/**
	 * Removes one or more rows
	 * @param	mixed	$moduleID
	 */
	public static function remove($moduleID) {
		$sql = "DELETE FROM
					wcf".WCF_N."_page_module_option
				WHERE
					moduleID ".(is_array($moduleID) ? "IN (".implode(',', $moduleID).")" : "= ".$moduleID);
		WCF::getDB()->sendQuery($sql);
	}
}
?>