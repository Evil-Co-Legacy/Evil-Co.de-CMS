<?php
// wcf imports
require_once(WCF_DIR.'lib/page/util/module/option/ModuleOption.class.php');
require_once(WCF_DIR.'lib/page/util/module/option/group/ModuleOptionGroup.class.php');
require_once(WCF_DIR.'lib/page/util/module/option/group/list/ModuleOptionGroupList.class.php');

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
			if (file_exists(WCF_DIR.$module['file']) and $module['file'] != '') {
				require_once(WCF_DIR.$module['file']);
				$className = basename($module['file'], '.class.php');
				$this->modules[] = new $className(null, $module);
			} else {
				// we'll load a default class if the specified file doesn't exist
				require_once(WCF_DIR.'lib/page/util/module/InstanceableModule.class.php');
				$this->modules[] = new InstanceableModule(null, $module);
			}
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
		// read options
		$sql = "SELECT
					*
				FROM
					wcf".WCF_N."_page_module_option
				WHERE
					moduleID = ".$moduleID;
		$result = WCF::getDB()->sendQuery($sql);
		
		$options = array();
		$optionGroups = array();
		$optionGroupList = null;
		
		while($row = WCF::getDB()->fetchArray($result)) {
			if (!isset($options[$row['groupID']])) $options[$row['groupID']] = array();
			$options[$row['groupID']][] = new ModuleOption($row['name'], $row['optionType'], $row['defaultValue'], $row['cssClass'], ($row['displayDescription'] == 1 ? true : false), $row['fields']);
		}
		
		// read option groups
		$sql = "SELECT
					*
				FROM
					wcf".WCF_N."_page_module_option_group
				WHERE
					moduleID = ".$moduleID;
		$result = WCF::getDB()->sendQuery($sql);
		
		while($row = WCF::getDB()->fetchArray($result)) {
			$optionGroups[] = new ModuleOptionGroup($row['name'], (isset($options[$row['groupID']]) ? $options[$row['groupID']] : array()));
		}
		
		$optionGroupList = new ModuleOptionGroupList($optionGroups);
		
		// create new instance
		$sql = "INSERT INTO
					wcf".WCF_N."_page_module_to_page (moduleID, pageID, isVisible, sortOrder, options)
				VALUES
					(".$moduleID.", ".$this->pageID.", ".($isVisible ? 1 : 0).", ".$sortOrder.", '".escapeString(serialize($optionGroupList))."')";
		WCF::getDB()->sendQuery($sql);
		
		$instanceID = WCF::getDB()->getInsertID();
		
		if ($sortOrder == 0) {
			$sql = "SELECT
						MAX(sortOrder) AS sortOrder
					FROM
						wcf".WCF_N."_page_module_to_page";
			$order = WCF::getDB()->getFirstRow($sql);
			
			$sql = "UPDATE
						wcf".WCF_N."_page_module_to_page
					SET
						sortOrder = ".($order['sortOrder'] + 1)."
					WHERE
						moduleID = ".$moduleID."
					AND
						pageID = ".$this->pageID;
			WCF::getDB()->sendQuery($sql);
		}
		
		// remove cache
		WCF::getCache()->clear(WCF_DIR.'cache/', 'cache.pageModules-'.$this->pageID.'-'.PACKAGE_ID.'.php');
		
		return $instanceID;
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