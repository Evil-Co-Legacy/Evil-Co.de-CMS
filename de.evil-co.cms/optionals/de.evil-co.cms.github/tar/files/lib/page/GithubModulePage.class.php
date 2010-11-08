<?php 
// wcf imports
require_once(WCF_DIR.'lib/page/AbstractPage.class.php');
require_once(WCF_DIR.'lib/page/util/module/GithubModule.class.php');

/**
 * Implements a module page that lists github commits
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.github
 */
class GithubModulePage extends AbstractPage {
	
	/**
	 * @see	AbstractPage::$templateName
	 */
	public $templateName = 'githubPageModuleContent';
	
	/**
	 * Contains the module instance
	 * @var	GithubModule
	 */
	public $moduleInstance = null;
	
	/**
	 * Contains the instance ID of this module instance
	 * @var	integer
	 */
	public $instanceID = 0;
	
	/**
	 * @see	Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		// read query parameters
		if (isset($_REQUEST['instanceID'])) $this->instanceID = intval($_REQUEST['instanceID']);
		
		// create module instance
		$this->moduleInstance = new GithubModule($this->instanceID);
		
		// validate
		if (!$this->moduleInstance->instanceID) throw new IllegalLinkException;
	}
	
	/**
	 * @see	Page:.readData()
	 */
	public function readData() {
		parent::readData();
		
		// call module functions
		$this->readCommits();
	}
	
	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'module'		=>		$this->moduleInstance
		));
	}
}
?>