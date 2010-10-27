<?php
// wcf imports
require_once(WCF_DIR.'lib/data/DatabaseObject.class.php');
require_once(WCF_DIR.'lib/page/util/module/ModuleManager.class.php');

/**
 * Implements an object that represents a page
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 */
class DynamicPage extends DatabaseObject {
	protected $sqlJoins = '';
	protected $sqlSelects = '';
	protected $sqlGroupBy = '';
	
	/**
	 * Reads a page row from database
	 * @param	integer	$pageID
	 * @param	array	$row
	 */
	public function __construct($pageID, $row = null) {
		$this->sqlSelects .= 'page.*'; 
		
		// create sql conditions
		$sqlCondition = '';
		
		if ($pageID !== null) {
			$sqlCondition .=  "page.pageID = ".$pageID;
		}
		
		// execute sql statement
		if (!empty($sqlCondition)) {
			$sql = "SELECT 	".$this->sqlSelects."
				FROM 	wcf".WCF_N."_page page
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
		
		if (!$this->pageID)
			$this->data['pageID'] = 0;
		else
			$this->data['moduleManager'] = new ModuleManager($this->pageID);
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
	 * Returnes the module manager for this page
	 */
	public function getModuleManager() {
		return $this->moduleManager;
	}
}
?>