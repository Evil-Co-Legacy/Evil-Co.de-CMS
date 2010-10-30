<?php
// wcf imports
require_once(WCF_DIR.'lib/page/AbstractModulePage.class.php');
require_once(WCF_DIR.'lib/data/dynamic/page/DynamicPage.class.php');

/**
 * Implements a page for custom pages
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 */
class CMSPage extends AbstractModulePage {
	public $templateName = 'cms';
	
	/**
	 * Contains the page object
	 * @var Page
	 */
	public $page = null;
	
	/**
	 * @see Page::readParameters()
	 */
	public function readParameters() {
		// read pageID parameter
		if (isset($_REQUEST['pageID'])) $this->pageID = intval($_REQUEST['pageID']);
		
		// read page cache
		WCF::getCache()->addResource('page-'.$this->pageID, WCF_DIR.'cache/page-'.$this->pageID.'.php', WCF_DIR.'lib/system/cache/CacheBuilderPage.class.php');
		$this->page = WCF::getCache()->get('page-'.$this->pageID);
		
		// validate
		if (!$this->page->pageID) throw new IllegalLinkException();
		
		// throw permission denied exception if the page isn't plublic ;-)
		if (!WCF::getUser()->getPermission('admin.system.page.canSeePrivatePages') && !$this->page->isPublic) throw new PermissionDeniedException;
		
		// call parent class' function (execute module functions)
		parent::readParameters();
	}
	
	public function show() {
		if ($this->page->menuItemID) {
			// page menu
			require_once(WCF_DIR.'lib/page/util/menu/PageMenu.class.php');
			PageMenu::setActiveMenuItem('wcf.cms.header.menu.host'.$this->page->hostID.'.page'.$this->page->pageID);
		}
		
		
		parent::show();
	}
	
	/**
	 * @see Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array('page' => $this->page));
	}
}
?>