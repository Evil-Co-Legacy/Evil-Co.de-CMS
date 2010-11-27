<?php
// wcf imports
require_once(WCF_DIR.'lib/data/DatabaseObject.class.php');

/**
 * Represents an indexed item
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.core
 */
class DynamicPageIndexItem extends DatabaseObject {
	protected $sqlJoins = '';
	protected $sqlSelects = '';
	protected $sqlGroupBy = '';
	
	/**
	 * Reads a page row from database
	 * @param	integer	$itemID
	 * @param	array	$row
	 */
	public function __construct($itemID, $row = null) {
		$this->sqlSelects .= 'index.*'; 
		
		// create sql conditions
		$sqlCondition = '';
		
		if ($pageID !== null) {
			$sqlCondition .=  "index.itemID = ".$itemID;
		}
		
		// execute sql statement
		if (!empty($sqlCondition)) {
			$sql = "SELECT 	".$this->sqlSelects."
				FROM 	wcf".WCF_N."_page_index index
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
		
		if (!$this->itemID)	$this->data['itemID'] = 0;
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
		
		throw new SystemException("method '".$name."' does not exist in class ".get_class($this));
	}
}
?>