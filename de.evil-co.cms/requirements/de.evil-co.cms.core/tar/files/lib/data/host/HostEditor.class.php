<?php
// wcf imports
require_once(WCF_DIR.'lib/data/host/Host.class.php');

/**
 * Represents a host row and provides functions to create, edit or delete host rows
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms
 */
class HostEditor extends Host {
	
	/**
	 * Creates a new host row
	 * @param	string	$title
	 * @param	string	$hostname
	 * @param	boolean	$isDisabled
	 * @param	boolean	$isFallback
	 * @param	string	$languageCode
	 */
	public static function create($title, $hostname, $isDisabled = false, $isFallback = false, $languageCode = null) {
		if ($isFallback) {
			// remove old fallback
			$sql = "UPDATE
						wcf".WCF_N."_host
					SET
						isFallback = 0
					WHERE
						isFallback = 1";
			WCF::getDB()->sendQuery($sql);
		}
		
		$sql = "INSERT INTO
					wcf".WCF_N."_host (`title`, `hostname`, `isDisabled`, `isFallback`, `languageCode`)
				VALUES
					('".escapeString($title)."', '".escapeString($hostname)."', ".($isDisabled ? 1 : 0).", ".($isFallback ? 1 : 0).", ".($languageCode !== null ? "'".escapeString($languageCode)."'" : "NULL").")";
		WCF::getDB()->sendQuery($sql);
		
		return new Host(WCF::getDB()->getInsertID());
	}
	
	/**
	 * Updates this host row
	 */
	public function update() {
		$sqlUpdate = "";
		
		if (!empty($this->title)) {
			$sqlUpdate .= "title = '".escapeString($this->title)."'";
		}
		
		if (!empty($this->hostname)) {
			if (!empty($sqlUpdate)) $sqlUpdate .= ",";
			$sqlUpdate .= "hostname = '".escapeString($this->hostname)."'";
		}
		
		if (!empty($sqlUpdate)) $sqlUpdate .= ",";
		$sqlUpdate .= "isDisabled = ".($this->isDisabled ? 1 : 0);
		
		$sqlUpdate .= ",isFallback = ".($this->isFallback ? 1 : 0);
		
		$sqlUpdate .= ",languageCode = '".escapeString($this->languageCode)."'";
		
		$sql = "UPDATE
					wcf".WCF_N."_host
				SET
					".$sqlUpdate."
				WHERE
					hostID = ".$this->hostID;
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Removes one or more host rows
	 * @param	mixed	$hostID
	 */
	public static function remove($hostID) {
		$sql = "DELETE FROM
					wcf".WCF_N."_host
				WHERE
					hostID ".(is_array($hostID) ? "IN (".implode(',', $hostID).")" : "= ".$hostID);
		WCF::getDB()->sendQuery($sql);
	}
}
?>