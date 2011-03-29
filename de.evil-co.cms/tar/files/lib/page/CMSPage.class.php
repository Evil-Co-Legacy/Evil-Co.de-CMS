<?php
// wcf imports
require_once(WCF_DIR.'lib/page/AbstractModulePage.class.php');
require_once(WCF_DIR.'lib/data/dynamic/page/DynamicPage.class.php');

/**
 * Displays content of a page
 * @author		Johannes Donath
 * @copyright		2011 DEVel Fusion
 * @license		GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 */
class CMSPage extends AbstractModulePage {
	
	/**
	 * @see AbstractPage::$templateName
	 */
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
		WCF::getCache()->addResource('page-'.$this->pageID, WCF_DIR.'cache/cache.page-'.$this->pageID.'.php', WCF_DIR.'lib/system/cache/CacheBuilderPage.class.php');
		$this->page = WCF::getCache()->get('page-'.$this->pageID);
		
		// validate
		if (!$this->page->pageID) throw new IllegalLinkException();
		
		// throw permission denied exception if the page isn't plublic ;-)
		if (!WCF::getUser()->getPermission('admin.system.page.canSeePrivatePages') && !$this->page->isPublic) throw new PermissionDeniedException;
		
		// call parent class' function (execute module functions)
		parent::readParameters();
	}
	
	/**
	 * @see	Page::show()
	 */
	public function show() {
		if ($this->page->menuItemID) {
			// page menu
			require_once(WCF_DIR.'lib/page/util/menu/PageMenu.class.php');
			PageMenu::setActiveMenuItem('wcf.header.menu.host'.$this->page->hostID.'.page'.$this->page->pageID);
		}
		
		
		parent::show();
	}
	
	/**
	 * @see Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'page' => $this->page
		));
	}
}
?>