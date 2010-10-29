<?php
// wcf imports
require_once(WCF_DIR.'lib/acp/form/ACPForm.class.php');
require_once(WCF_DIR.'lib/data/dynamic/page/DynamicPageEditor.class.php');
require_once(WCF_DIR.'lib/data/dynamic/page/module/template/DynamicPageModuleTemplate.class.php');

/**
 * Implements a form that attaches a new module to the given page
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.core
 */
class DynamicPageModuleAddForm extends ACPForm {
	
	/**
	 * @see	Page::$templateName
	 */
	public $templateName = 'dynamicPageModuleAdd';
	
	/**
	 * @see	Page::$templateName
	 */
	public $neededPermissions = 'admin.content.cms.canEditPages';
	
	/**
	 * Contains the ID of the page row to that a new module should assigned
	 * @var	integer
	 */
	public $pageID = 0;
	
	/**
	 * Contains the object that represents the page row to that a new module should assigned
	 * @var	DynamicPage
	 */
	public $page = null;
	
	/**
	 * Contains the ID of the module that should assigned
	 * @var	integer
	 */
	public $moduleID = 0;
	
	/**
	 * Contains the object that represents the row of the module that should assigned
	 * @var	Module
	 */
	public $module = null;
	
	/**
	 * @see	Page::$action
	 */
	public $action = 'add';
	
	/**
	 * @see	Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['pageID'])) $this->pageID = intval($_REQUEST['pageID']);
		
		// create a new instance of DynamicPage
		$this->page = new DynamicPageEditor($this->pageID);
		
		// validate
		if (!$this->page->pageID) throw new IllegalLinkException;
	}
	
	/**
	 * @see	Form::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		if (isset($_REQUEST['moduleID'])) $this->moduleID = intval($_REQUEST['moduleID']);
	}
	
	/**
	 * @see	Form::validate()
	 */
	public function validate() {
		parent::validate();
		
		// validate moduleID
		if (empty($this->moduleID)) throw new UserInputException('moduleID', 'empty');
		
		// create module object
		$this->module = new DynamicPageModuleTemplate($this->moduleID);
		
		// get dependencies
		$sql = "SELECT
					dependency.dependency
				FROM
					wcf".WCF_N."_package_dependency dependency
				WHERE
					dependency.packageID = ".PACKAGE_ID;
		$result = WCF::getDB()->sendQuery($sql);
		
		$packageIDs = array(PACKAGE_ID);
		
		while($row = WCF::getDB()->fetchArray($result)) {
			$packageIDs[] = $row['dependency'];
		}
		
		// validate module row
		if (!$this->module->moduleID or !in_array($this->module->packageID, $packageIDs)) throw new UserInputException('moduleID', 'invalid');
	}
	
	/**
	 * @see	Form::save()
	 */
	public function save() {
		parent::save();
		
		// assign module
		$instanceID = $this->page->moduleManager->assign($this->moduleID);
		
		// send redirect headers
		HeaderUtil::redirect('index.php?form=DynamicPageModuleEdit&instanceID='.$instanceID.'&packageID='.PACKAGE_ID.SID_ARG_2ND_NOT_ENCODED);
		
		// call event
		$this->executed();
	}
	
	/**
	 * @see Page::show()
	 */
	public function show() {
		// enable acpmenu entry
		WCFACP::getMenu()->setActiveMenuItem('wcf.acp.menu.link.content.host');
		
		parent::show();
	}
	
	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'page'				=>		$this->page,
			'pageID'			=>		$this->pageID,
			'moduleID'			=>		$this->moduleID,
			'module'			=>		$this->module,
			'moduleList'		=>		ModuleManager::getAvailableModules()
		));
	}
}
?>