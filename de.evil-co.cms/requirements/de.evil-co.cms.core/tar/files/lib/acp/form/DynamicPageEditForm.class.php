<?php
// wcf imports
require_once(WCF_DIR.'lib/acp/form/DynamicPageAddForm.class.php');
require_once(WCF_DIR.'lib/data/page/menu/PageMenuItemEditor.class.php');

/**
 * Implements a form that provides a edit form to update pages
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.core
 */
class DynamicPageEditForm extends DynamicPageAddForm {
	
	/**
	 * @see	Page::$action
	 */
	public $action = 'edit';
	
	/**
	 * Contains the ID of the page row that should updated
	 * @var	integer
	 */
	public $pageID = 0;
	
	/**
	 * Contains the object that represents the page row that should updated
	 * @var	DynamicPageEditor
	 */
	public $page = null;
	
	/**
	 * Contains the object that represents the menu entry row for this page
	 * @var	PageMenuItem
	 */
	public $menuEntry = null;
	
	/**
	 * @see DynamicPageAddForm::$createMenuItem
	 */
	public $createMenuItem = false;
	
	/**
	 * @see Page::readParameters()
	 */
	public function readParameters() {
		ACPForm::readParameters();
		
		if (isset($_REQUEST['pageID'])) $this->pageID = intval($_REQUEST['pageID']);
		
		// create page object
		$this->page = new DynamicPageEditor($this->pageID);
		
		// validate
		if (!$this->page->pageID) throw new IllegalLinkException;
		
		// menu entry
		if ($this->page->menuItemID) {
			$this->menuEntry = new PageMenuItemEditor($this->page->menuItemID);
			
			// read variables
			$this->menuItemSortOrder = $this->menuEntry->showOrder;
			$this->menuItemIconS = $this->menuEntry->menuItemIconS;
			$this->menuItemIconM = $this->menuEntry->menuItemIconM;
			$this->menuItemTitle = WCF::getLanguage()->get($this->menuEntry->menuItem);
			$this->menuItemPosition = $this->menuEntry->menuPosition;
		}
	}
	
	/**
	 * @see	Page::readData()
	 */
	public function readData() {
		parent::readData();
		
		// read variables
		$this->title = $this->page->title;
		$this->allowSpidersToIndexThisPage = $this->page->allowSpidersToIndexThisPage;
		$this->additionalHeadContent = $this->page->additionalHeadContent;
		$this->isPublic = $this->page->isPublic;
		$this->isDefaultPage = $this->page->isDefaultPage;
	}
	
	/**
	 * @see Form::validate()
	 */
	public function validate() {
		parent::validate();
		
		if ($this->createMenuItem and $this->menuEntry !== null) $this->createMenuItem = false;
	}
	
	/**
	 * @see Form::save()
	 */
	public function save() {
		ACPForm::save();
		
		// read variables
		$this->page->title = $this->title;
		$this->page->allowSpidersToIndexThisPage = $this->allowSpidersToIndexThisPage;
		$this->page->additionalHeadContent = $this->additionalHeadContent;
		$this->page->isPublic = $this->isPublic;
		$this->page->isDefaultPage = $this->isDefaultPage;
		
		// update
		$this->page->update();
		
		// handle isDefaultPage checkbox
		if ($this->isDefaultPage) {
			$sql = "UPDATE
						wcf".WCF_N."_page
					SET
						isDefaultPage = 0
					WHERE
						pageID NOT IN (".$this->page->pageID.")";
			WCF::getDB()->sendQuery($sql);
		}
		
		DynamicPageEditor::clearCache($this->page->pageID, $this->page->hostID);
		
		if ($this->menuEntry !== null) {
			// create language variable name
			$lang = 'wcf.header.menu.host'.$this->page->hostID.'.page'.$this->pageID;
			
			// get menu entry title
			$title = (empty($this->menuItemTitle) ? $this->title : $this->menuItemTitle);
			
			// update menu entry
			$this->menuEntry->update($lang, $this->menuEntry->menuItemLink, $this->menuItemIconS, $this->menuItemIconM, $this->menuItemSortOrder, $this->menuItemPosition);
			
			// update language
			require_once(WCF_DIR.'lib/system/language/LanguageEditor.class.php');
			$language = new LanguageEditor(WCF::getLanguage()->getLanguageID());
			$language->updateItems(array($lang => $title));
			
			// clear cache
			PageMenuItemEditor::clearCache();
		}
		
		if ($this->createMenuItem) {
			// build language var
			$lang = 'wcf.header.menu.host'.$this->page->hostID.'.page'.$item->pageID;
			$title = (empty($this->menuItemTitle) ? $this->title : $this->menuItemTitle);
			
			// create menu item
			$menuItem = PageMenuItemEditor::create($lang, 'index.php?page=CMS&pageID='.$this->pageID, $this->menuItemIconS, $this->menuItemIconM, $this->menuItemSortOrder, $this->menuItemPosition);
			$menuItemID = $menuItem->menuItemID;
			
			// clear cache
			PageMenuItemEditor::clearCache();
			
			// create language var
			require_once(WCF_DIR.'lib/system/language/LanguageEditor.class.php');
			
			// save language variable
			$language = new LanguageEditor(WCF::getLanguage()->getLanguageID());
			$language->updateItems(array($lang => $title));
			
			// include host
			require_once(WCF_DIR.'lib/data/host/Host.class.php');
			
			// remove menu item ID cache
			Host::removeMenuItemIDCache();
		}
		
		// show success message
		WCF::getTPL()->assign('success', true);
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
			'pageID'			=>		$this->pageID,
			'page'				=>		$this->page,
		));
		
		// modify style for additional button in containerIcon div
		WCF::getTPL()->append('specialStyles', '<style type="text/css">#moduleList .containerHead .containerIcon { width: 90px !important; } #moduleList .containerHead { cursor: move; }</style>');
	}
}
?>