<?php
// wcf imports
require_once(WCF_DIR.'lib/data/DatabaseObject.class.php');

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
	public function __construct($hostID, $row = null, $host = null) {
		$this->sqlSelects .= 'host.*'; 
		
		// create sql conditions
		$sqlCondition = '';
		
		if ($hostID !== null) {
			$sqlCondition .=  "host.hostID = ".$pageID;
		}
		
		if ($host !== null) {
			if (!empty($sqlCondition)) $sqlCondition .= " AND ";
			$sqlCondition .= "host.hostname = ".$host;
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
	
	
}
?>