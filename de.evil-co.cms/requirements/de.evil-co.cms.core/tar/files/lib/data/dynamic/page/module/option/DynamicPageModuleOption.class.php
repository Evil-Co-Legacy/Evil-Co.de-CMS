<?php
// wcf imports
require_once(WCF_DIR.'lib/data/DatabaseObject.class.php');

/**
 * This class represents a option row
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.core
 */
class DynamicPageModuleOption extends DatabaseObject {
	protected $sqlSelects = '';
	protected $sqlGroupBy = '';
	
	/**
	 * Reads a option row from database
	 * @param	integer	$optionID
	 * @param	array	$row
	 */
	public function __construct($optionID, $row = null) {
		$this->sqlSelects .= '*'; 
		
		// create sql conditions
		$sqlCondition = '';
		
		if ($optionID !== null) {
			$sqlCondition .=  "optionID = ".$optionID;
		}
		
		// execute sql statement
		if (!empty($sqlCondition)) {
			$sql = "SELECT 	".$this->sqlSelects."
				FROM 	wcf".WCF_N."_page_module_option
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
		
		if (!$this->optionID) $this->data['optionID'] = 0;
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