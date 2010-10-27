<?php

/**
 * Manages all modules for the specified pageID
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 */
class ModuleManager {
	
	/**
	 * Contains all modules
	 * @var array
	 */
	protected $modules = array();
	
	/**
	 * Contains the ID of the page
	 * @var	integer
	 */
	protected $pageID = 0;
	
	/**
	 * Creates a new ModuleManager instance with all modules for page $pageName
	 * @param	string	$pageName
	 */
	public function __construct($pageID) {
		// write variables
		$this->pageID = $pageID;
		
		// load page module cache
		WCF::getCache()->addResource('pageModules-'.$pageID.'-'.PACKAGE_ID, WCF_DIR.'cache/cache.pageModules-'.$pageID.'-'.PACKAGE_ID.'.php', WCF_DIR.'lib/system/cache/CacheBuilderPageModules.class.php');
		$modules = WCF::getCache()->get('pageModules-'.$pageID.'-'.PACKAGE_ID);
		
		// init modules
		foreach($modules as $module) {
			require_once(WCF_DIR.$module['file']);
			$className = basename($module['file'], '.class.php');
			$this->modules[] = new $className($pageID);
		}
	}
	
	/**
	 * Calls the readParameters() function of all modules
	 */
	public function readParameters() {
		$this->moduleCall('readParameters');
	}
	
	/**
	 * Calls the readData() function of all modules
	 */
	public function readData() {
		$this->moduleCall('readData');
	}
	
	/**
	 * Calls the assignVariables() function of all modules
	 */
	public function assignVariables() {
		$this->moduleCall('assignVariables');
	}
	
	/**
	 * Calls the specified function on all module instances
	 * @param	string	$functionName
	 */
	protected function moduleCall($functionName) {
		for($i = 0; $i < count($this->modules); $i++) {
			$this->modules[$i]->{$functionName}();
		}
	}
	
	/**
	 * Returnes a list of all modules
	 */
	public function getModuleInstances() {
		$modules = array();
		
		for($i = 0; $i < count($this->modules); $i++) {
			$modules[] = &$this->modules[$i];
		}
		
		return $modules;
	}
	
	/**
	 * Assignes a module to a page
	 * @param	integer	$moduleID
	 * @param	boolean	$isVisible
	 * @param	integer	$sortOrder
	 */
	public function assign($moduleID, $isVisible = false, $sortOrder = 0) {
		$sql = "INSERT INTO
					wcf".WCF_N."_page_module_to_page (moduleID, pageID, isVisible, sortOrder)
				VALUES
					(".$moduleID.", ".$this->pageID.", ".($isVisible ? 1 : 0).", ".$sortOrder.")";
		WCF::getDB()->sendQuery($sql);
		
		if ($sortOrder == 0) {
			$sql = "UPDATE
						wcf".WCF_N."_page_module_to_page
					SET
						sortOrder = (MAX(sortOrder) + 1)
					WHERE
						moduleID = ".$moduleID."
					AND
						pageID = ".$this->pageID;
			WCF::getDB()->sendQuery($sql);
		}
		
		// remove cache
		WCF::getCache()->clear(WCF_DIR.'cache/', 'cache.pageModules-'.$this->pageID.'-'.PACKAGE_ID.'.php');
	}
	
	/**
	 * Removes all entries for the parent page
	 */
	public function remove() {
		// delete to_page table entries
		$sql = "DELETE FROM
					wcf".WCF_N."_page_module_to_page
				WHERE
					pageID = ".$this->pageID;
		WCF::getDB()->sendQuery($sql);
		
		// remove cache
		WCF::getCache()->clear(WCF_DIR.'cache/', 'cache.pageModules-'.$this->pageID.'-'.PACKAGE_ID.'.php');
	}
	
	/**
	 * Returnes all available modules
	 */
	public static function getAvailableModules() {
		WCF::getCache()->addResource('availablePageModules-'.PACKAGE_ID, WCF_DIR.'cache/cache.availablePageModules-'.PACKAGE_ID.'.php', WCF_DIR.'lib/system/cache/CacheBuilderAvailablePageModules.class.php');
		return WCF::getCache()->get('availablePageModules-'.PACKAGE_ID);
	}
}
?>