<?php
// wcf imports
require_once(WCF_DIR.'lib/data/DatabaseObject.class.php');

/**
 * This class represents a module row
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.core
 */
class DynamicPageModuleTemplate extends DatabaseObject {
	protected $sqlJoins = '';
	protected $sqlSelects = '';
	protected $sqlGroupBy = '';
	
	/**
	 * Reads a module row from database
	 * @param	integer	$moduleID
	 * @param	array	$row
	 */
	public function __construct($moduleID, $row = null) {
		$this->sqlSelects .= 'module.*'; 
		
		// create sql conditions
		$sqlCondition = '';
		
		if ($moduleID !== null) {
			$sqlCondition .=  "module.moduleID = ".$moduleID;
		}
		
		// execute sql statement
		if (!empty($sqlCondition)) {
			$sql = "SELECT 	".$this->sqlSelects."
				FROM 	wcf".WCF_N."_page_module module
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
		
		if (!$this->moduleID) $this->data['moduleID'] = 0;
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
}
?>