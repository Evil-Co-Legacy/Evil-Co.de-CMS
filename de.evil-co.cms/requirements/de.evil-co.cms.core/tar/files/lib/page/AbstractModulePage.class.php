<?php
// wcf imports
require_once(WCF_DIR.'lib/page/AbstractPage.class.php');
require_once(WCF_DIR.'lib/page/util/module/ModuleManager.class.php');

/**
 * Provides an abstract class that contains modules
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 */
abstract class AbstractModulePage extends AbstractPage {
	public $modules = null;
	public $pageID = 0;
	
	/**
	 * @see Page::readData()
	 */
	public function readData() {
		parent::readData();
		
		$this->modules->readData();
	}
	
	/**
	 * @see Page::readParamaters()
	 */
	public function readParameters() {
		$this->modules = new ModuleManager($this->pageID);
		
		parent::readParameters();
		
		$this->modules->readParameters();
	}
	
	/**
	 * @see Page::readParameters()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		$this->modules->assignVariables();
		
		WCF::getTPL()->assign(array('modules' => $this->modules->getModuleInstances()));
	}
}
?>