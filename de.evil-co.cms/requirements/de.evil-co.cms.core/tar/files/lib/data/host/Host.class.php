<?php
// wcf imports
require_once(WCF_DIR.'lib/data/DatabaseObject.class.php');

/**
 * Represents a host row
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.core
 */
class Host extends DatabaseObject {
	protected $sqlJoins = '';
	protected $sqlSelects = '';
	protected $sqlGroupBy = '';
	
	/**
	 * Reads a host row from database
	 * @param	integer	$hostID
	 * @param	array	$row
	 * @param	string	$host
	 */
	public function __construct($hostID, $row = null, $host = null, $languageCode = null) {
		$this->sqlSelects .= 'host.*'; 
		
		// create sql conditions
		$sqlCondition = '';
		
		if ($hostID !== null) {
			$sqlCondition .=  "host.hostID = ".$hostID;
		}
		
		if ($host !== null) {
			if (!empty($sqlCondition)) $sqlCondition .= " AND ";
			$sqlCondition .= "host.hostname = '".escapeString($host)."'";
		}
		
		if ($languageCode !== null) {
			if (!empty($sqlCondition)) $sqlCondition .= " AND ";
			$sqlCondition .= "host.languageCode = '".escapeString($languageCode)."'";
		}
		
		// execute sql statement
		if (!empty($sqlCondition)) {
			$sql = "SELECT 	".$this->sqlSelects."
				FROM 	wcf".WCF_N."_host host
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
		
		if (!$this->hostID) $this->data['hostID'] = 0;
		
		if ($this->hostID) {
			// change var types
			$this->isFallback = (bool) $this->isFallback;
			$this->isDisabled = (bool) $this->isDisabled;
		}
	}
	
	/**
	 * Returnes a HostEditor for this host row
	 */
	public function getEditor() {
		require_once(WCF_DIR.'lib/data/host/HostEditor.class.php');
		return new HostEditor(null, $this->data);
	}
	
	/**
	 * Returnes the title (Only used in administration and in title tags) of this host row
	 */
	public function getTitle() {
		return $this->title;
	}
	
	/**
	 * Returnes the hostname of this host row
	 */
	public function getHostname() {
		return $this->hostname;
	}
	
	/**
	 * Returnes the language code of this host row
	 */
	public function getLanguageCode() {
		return $this->languageCode;
	}
	
	/**
	 * Returnes all menu item IDs of this host
	 */
	public function getMenuItemIDs() {
		WCF::getCache()->addResource('hostMenuItemIDs-'.$this->hostID, WCF_DIR.'cache/cache.hostMenuItemIDs-'.$this->hostID.'.php', WCF_DIR.'lib/system/cache/CacheBuilderDynamicPageMenuItemIDs.class.php');
		return WCF::getCache()->get('hostMenuItemIDs-'.$this->hostID);
	}
	
	/**
	 * Removes the menu item ID cache for this host
	 */
	public function removeMenuItemIDCache() {
		WCF::getCache()->clear(WCF_DIR.'cache/', 'cache.hostmenuItemIDs-'.$this->hostID.'.php');
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