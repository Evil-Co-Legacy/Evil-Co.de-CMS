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
	 * Creates a new ModuleManager instance with all modules for page $pageName
	 * @param	string	$pageName
	 */
	public function __construct($pageID) {
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
}
?>