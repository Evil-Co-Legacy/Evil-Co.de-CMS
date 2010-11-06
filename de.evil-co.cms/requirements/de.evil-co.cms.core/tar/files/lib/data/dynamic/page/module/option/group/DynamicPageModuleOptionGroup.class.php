<?php
// wcf imports
require_once(WCF_DIR.'lib/data/DatabaseObject.class.php');

/**
 * This class represents a option group row
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.core
 */
class DynamicPageModuleOptionGroup extends DatabaseObject {
	protected $sqlJoins = '';
	protected $sqlSelects = '';
	protected $sqlGroupBy = '';
	
	/**
	 * Reads a option group row from database
	 * @param	integer	$groupID
	 * @param	array	$row
	 */
	public function __construct($groupID, $row = null) {
		$this->sqlSelects .= 'group.*'; 
		
		// create sql conditions
		$sqlCondition = '';
		
		if ($groupID !== null) {
			$sqlCondition .=  "group.groupID = ".$groupID;
		}
		
		// execute sql statement
		if (!empty($sqlCondition)) {
			$sql = "SELECT 	".$this->sqlSelects."
				FROM 	wcf".WCF_N."_page_module_option_group group
					".$this->sqlJoins."
				WHERE 	".$sqlCondition.
					$this->sqlGroupBy;
			$row = WCF::getDB()->getFirstRow($sql);
		}
		
		// handle result set
		parent::__construct($row);
	}
	
	/**
	 * @see DatabaseObject::handleData()
	 */
	protected function handleData($data) {
		parent::handleData($data);
		
		if (!$this->groupID) $this->data['groupID'] = 0;
	}
	
	/**
	 * Wrapper for get class (Such as getPageID())
	 * @param	string	$name
	 * @param	array	$args
	 */
	public function __call($name, $args) {
		if (substr($name, 0, 3) == 'get') {
			$variable = substr($name, 3);
			$variable{0} = strtolower($variable{0});
			return $this->{$variable};
		}
		
		throw new SystemException("method '".$name."' does not exist in class Page");
	}
	
	/**
	 * Returnes true if a group with the given name exists for given module
	 * @param	string	$groupName
	 * @param	integer	$moduleID
	 */
	public static function isValidGroup($groupName, $moduleID) {
		$sql = "SELECT
					*
				FROM
					wcf".WCF_N."_page_module_option_group
				WHERE
					name = '".escapeString($groupName)."'
				AND
					moduleID = ".$moduleID;
		$row = WCF::getDB()->getFirstRow($sql);
		
		if (WCF::getDB()->getNumRows()) return $row['groupID'];
		
		return false;
	}
}
?>