<?php
// wcf imports
require_once(WCF_DIR.'lib/action/AbstractAction.class.php');
require_once(WCF_DIR.'lib/data/dynamic/page/DynamicPage.class.php');

/**
 * Implements an action that allows to sort modules via javascript
 *
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.core
 */
class DynamicPageModuleSortAction extends AbstractAction {
	
	/**
	 * Contains the ID of the page row
	 *
	 * @var	integer
	 */
	public $pageID = 0;
	
	/**
	 * Contains the object that represents the page row
	 *
	 * @var	DynamicPage
	 */
	public $page = null;
	
	/**
	 * Contans the position of modules
	 *
	 * @var	string
	 */
	public $position = 'center';
	
	/**
	 * Contains the module list
	 *
	 * @var	array
	 */
	public $moduleList = array();
	
	/**
	 * @see	Action::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		// check permissions
		WCF::getUser()->checkPermission('admin.content.cms.canEditPages');
		
		// validate moduleList parameter
		if (!isset($_REQUEST['data'])) throw new IllegalLinkException;
		
		// read pageID parameter
		if (isset($_REQUEST['pageID'])) $this->pageID = intval($_REQUEST['pageID']);
		
		// read module position
		if (isset($_REQUEST['position'])) $this->position = StringUtil::trim($_REQUEST['position']);
		
		// validate position
		switch($this->position) {
			case 'top':
			case 'right':
			case 'center':
			case 'left':
			case 'bottom': break;
			default:
				$this->position = 'center';
				break;
		}
		
		// create page object
		$this->page = new DynamicPage($this->pageID);
		
		// validate page
		if (!$this->page->pageID) throw new IllegalLinkException;
		
		// parse parameter
		parse_str($_REQUEST['data']);
		
		// validate
		if (!isset($moduleList)) throw new IllegalLinkException;
		
		$this->moduleList = $moduleList;
	}
	
	/**
	 * @see	Action::execute()
	 */
	public function execute() {
		parent::execute();
		
		foreach($this->moduleList as $key => $instanceID) {
			$sql = "UPDATE
						wcf".WCF_N."_page_module_to_page
					SET
						sortOrder = ".intval($key).",
						position = '".escapeString($this->position)."'
					WHERE
						instanceID = ".intval($instanceID);
			WCF::getDB()->sendQuery($sql);
		}
		
		// remove cache
		WCF::getCache()->clear(WCF_DIR.'cache/', 'cache.pageModules-'.$this->pageID.'-'.PACKAGE_ID.'.php');
		
		// fire executed event
		$this->executed();
	}
}
?>