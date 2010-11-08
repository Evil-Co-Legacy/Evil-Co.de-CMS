<?php
// wcf imports
require_once(WCF_DIR.'lib/data/DatabaseObject.class.php');

/**
 * Represents news item row
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.news
 */
class DynamicNewsItem extends DatabaseObject {
	protected $sqlJoins = '';
	protected $sqlSelects = '';
	protected $sqlGroupBy = '';
	
	/**
	 * Reads a item row from database
	 * @param	integer	$itemID
	 * @param	array	$row
	 */
	public function __construct($itemID, $row = null) {
		$this->sqlSelects .= 'news.*'; 
		
		// create sql conditions
		$sqlCondition = '';
		
		if ($itemID !== null) {
			$sqlCondition .=  "news.itemID = ".$itemID;
		}
		
		// execute sql statement
		if (!empty($sqlCondition)) {
			$sql = "SELECT 	".$this->sqlSelects."
				FROM 	wcf".WCF_N."_page_module_news_item news
					".$this->sqlJoins."
				WHERE 	".$sqlCondition.
					$this->sqlGroupBy;
			$row = WCF::getDB()->getFirstRow($sql);
		}
		
		// handle result set
		parent::__construct($row);
	}
	
	/**
	 * @see	DatabaseObject::handleData()
	 */
	protected function handleData($data) {
		parent::handleData($data);
		
		if (!$this->itemID) $this->data['itemID'] = 0;
	}
	
	/**
	 * Wrapper for get class (Such as getPageID())
	 * @param	string	$name
	 * @param	array	$args
	 */
	public function __call($name, $args) {
		if (substr($name, 0, 3) == 'get') {
			$variable = substr($name, 3);
			$variable = strtolower($variable{0}).substr($variable, 1);
			return $this->{$variable};
		}
		
		throw new SystemException("method '".$name."' does not exist in class Page");
	}
}
?>