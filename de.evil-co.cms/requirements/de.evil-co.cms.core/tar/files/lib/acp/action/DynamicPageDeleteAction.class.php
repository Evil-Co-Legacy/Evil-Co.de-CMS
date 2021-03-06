<?php
// wcf imports
require_once(WCF_DIR.'lib/action/AbstractAction.class.php');
require_once(WCF_DIR.'lib/data/dynamic/page/DynamicPageEditor.class.php');

/**
 * Implements an action that deletes the given dynamic page
 *
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.core
 */
class DynamicPageDeleteAction extends AbstractAction {
	
	/**
	 * Contains the id of the page that should removed
	 *
	 * @var	integer
	 */
	public $pageID = 0;
	
	/**
	 * Contains the object that represents the row that should removed
	 *
	 * @var	DynamicPageEditor
	 */
	public $page = null;
	
	/**
	 * @see	Action::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		// check permissions
		WCF::getUser()->checkPermission('admin.content.cms.canEditPages');
		
		if (isset($_REQUEST['pageID'])) $this->pageID = intval($_REQUEST['pageID']);
		
		// create page object
		$this->page = new DynamicPageEditor($this->pageID);
		
		// validate
		if (!$this->page->pageID) throw new IllegalLinkException;
	}
	
	/**
	 * @see	Action::execute()
	 */
	public function execute() {
		parent::execute();
		
		// remove entries
		DynamicPageEditor::remove($this->pageID);
		$this->page->moduleManager->remove();
		
		// clear cache
		DynamicPageEditor::clearCache($this->pageID, $this->page->hostID);
		
		// page menu entry
		if ($this->page->menuItemID) {
			require_once(WCF_DIR.'lib/data/page/menu/PageMenuItemEditor.class.php');
			
			// create editor object
			$menuItem = new PageMenuItemEditor($this->page->menuItemID);
			
			// remove item
			$menuItem->remove();
			
			// clear cache
			PageMenuItemEditor::clearCache();
		}
		
		// send redirect headers
		if (!isset($_REQUEST['ajax'])) HeaderUtil::redirect('index.php?page=DynamicPageList&hostID='.$this->page->hostID.'&packageID='.PACKAGE_ID.SID_ARG_2ND_NOT_ENCODED);
		
		// call event
		$this->executed();
	}
}
?>