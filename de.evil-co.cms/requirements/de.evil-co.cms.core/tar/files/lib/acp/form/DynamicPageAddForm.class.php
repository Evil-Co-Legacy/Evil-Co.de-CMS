<?php
// wcf imports
require_once(WCF_DIR.'lib/acp/form/ACPForm.class.php');
require_once(WCF_DIR.'lib/data/host/Host.class.php');
require_once(WCF_DIR.'lib/data/dynamic/page/DynamicPageEditor.class.php');

/**
 * Implements a form that adds a new page
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms
 */
class DynamicPageAddForm extends ACPForm {
	
	/**
	 * @see	Page::$templateName
	 */
	public $templateName = 'dynamicPageAdd';
	
	/**
	 * @see Page::$neededPermissions
	 */
	public $neededPermissions = 'admin.content.cms.canAddPages';
	
	/**
	 * Contains the title for the new row
	 * @var	string
	 */
	public $title = '';
	
	/**
	 * If this is set to true spiders would not index it
	 * @var	boolean
	 */
	public $allowSpidersToIndexThisPage = true;
	
	/**
	 * Contains additional head-tag contents
	 * @var	string
	 */
	public $additionalHeadContent = '';
	
	/**
	 * If this is set to true a new menu entry will created
	 * @var	boolean
	 */
	public $createMenuItem = true;
	
	/**
	 * Contains the position for the new menu item
	 * @var	string
	 */
	public $menuItemPosition = 'header';
	
	/**
	 * If this is set to false only users with a special permission can access this page in frontend
	 * @var	boolean
	 */
	public $isPublic = false;
	
	/**
	 * If this is set to true this page will used as fallback
	 * @var	boolean
	 */
	public $isDefaultPage = false;
	
	/**
	 * Contains the ID of the parent host element
	 * @var	integer
	 */
	public $hostID = 0;
	
	/**
	 * Contains the object that represents the parent host row
	 * @var	Host
	 */
	public $host = null;
	
	/**
	 * Contains the sortOrder for the new menu item
	 * @var	integer
	 */
	public $menuItemSortOrder = 0;
	
	/**
	 * Contains the small icon for the new menu item
	 * @var	string
	 */
	public $menuItemIconS = '';
	
	/**
	 * Contains the medium icon for the new menu item
	 * @var	string
	 */
	public $menuItemIconM = '';
	
	/**
	 * Contains the title for the new menu item
	 * @var	string
	 */
	public $menuItemTitle = '';
	
	/**
	 * Contains the new Page object
	 * @var	DynamicPageEditor
	 */
	public $newPage = null;
	
	/**
	 * @see	Page::$action
	 */
	public $action = 'add';
	
	/**
	 * @see	Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['hostID'])) $this->hostID = intval($_REQUEST['hostID']);
		
		// create host object
		$this->host = new Host($this->hostID);
		
		// validate host
		if (!$this->host->hostID) throw new IllegalLinkException;
	}
	
	/**
	 * @see	Form::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		if (isset($_REQUEST['title'])) $this->title = StringUtil::trim($_REQUEST['title']);
		if (isset($_REQUEST['allowSpidersToIndexThisPage'])) $this->allowSpidersToIndexThisPage = (bool) intval($_REQUEST['allowSpidersToIndexThisPage']);
		if (isset($_REQUEST['additionalHeadContent'])) $this->additionalHeadContent = StringUtil::trim($_REQUEST['additionalHeadContent']);
		if (isset($_REQUEST['createMenuItem'])) $this->createMenuItem = (bool) intval($_REQUEST['createMenuItem']);
		if (isset($_REQUEST['menuItemPosition'])) $this->menuItemPosition = StringUtil::trim($_REQUEST['menuItemPosition']);
		if (isset($_REQUEST['menuItemIconS'])) $this->menuItemIconS = StringUtil::trim($_REQUEST['menuItemIconS']);
		if (isset($_REQUEST['menuItemIconM'])) $this->menuItemIconM = StringUtil::trim($_REQUEST['menuItemIconM']);
		if (isset($_REQUEST['menuItemTitle'])) $this->menuItemTitle = StringUtil::trim($_REQUEST['menuItemTitle']);
		if (isset($_REQUEST['menuItemSortOrder'])) $this->menuItemSortOrder = intval($_REQUEST['menuItemSortOrder']);
		if (isset($_REQUEST['isPublic'])) $this->isPublic = (bool) intval($_REQUEST['isPublic']);
		if (isset($_REQUEST['isDefaultPage'])) $this->isDefaultPage = (bool) intval($_REQUEST['isDefaultPage']);
	}
	
	/**
	 * @see	Form::validate()
	 */
	public function validate() {
		parent::validate();
		
		// validate title
		if (empty($this->title)) throw new UserInputException('title', 'empty');
		if (!DynamicPageEditor::isAvailable($this->title, $this->hostID) and $this->action == 'add') throw new UserInputException('title', 'notAvailable');
		
		// validate menu entry position
		switch($this->menuItemPosition) {
			case 'header':
			case 'footer': break;
			default:
				$this->menuItemPosition = 'header';
				break;
		}
		
		// validate menu item options
		if ($this->createMenuItem) {
			// validate menu item icon s
			if (empty($this->menuItemIconS) and $this->menuItemPosition == 'footer') throw new UserInputException('menuItemIconS');
			
			// validate menu item icon m
			if (empty($this->menuItemIconM) and $this->menuItemPosition == 'header') throw new UserInputException('menuItemIconM');
		}
	}
	
	/**
	 * @see	Form::save()
	 */
	public function save() {
		parent::save();
		
		$menuItemID = 0;
		
		// create dynamic page
		$item = DynamicPageEditor::create($this->title, $this->allowSpidersToIndexThisPage, $this->additionalHeadContent, $menuItemID, $this->isPublic, $this->isDefaultPage, $this->hostID);
		DynamicPageEditor::clearCache($item->pageID, $this->hostID);
		
		// create menu item
		if ($this->createMenuItem) {
			require_once(WCF_DIR.'lib/data/page/menu/PageMenuItemEditor.class.php');
			
			// build language var
			$lang = 'wcf.header.menu.host'.$this->hostID.'.page'.$item->pageID;
			$title = (empty($this->menuItemTitle) ? $this->title : $this->menuItemTitle);
			
			// create menu item
			$menuItem = PageMenuItemEditor::create($lang, 'index.php?page=CMS&pageID='.$item->pageID, $this->menuItemIconS, $this->menuItemIconM, $this->menuItemSortOrder, $this->menuItemPosition);
			$menuItemID = $menuItem->menuItemID;
			
			// clear cache
			PageMenuItemEditor::clearCache();
			
			// enable or disable entry
			$menuItem->enable($this->isPublic);
			
			// create language var
			require_once(WCF_DIR.'lib/system/language/LanguageEditor.class.php');
			
			// save language variable
			$language = new LanguageEditor($this->host->languageID);
			$language->updateItems(array($lang => $title));
			
			// include host
			require_once(WCF_DIR.'lib/data/host/Host.class.php');
			
			// remove menu item ID cache
			Host::removeMenuItemIDCache();
		}
		
		// update menu item id
		$item->menuItemID = $menuItemID;
		$item->update();
		
		// write to property
		$this->newPage = $item;
		
		// send redirect headers
		HeaderUtil::redirect('index.php?form=DynamicPageEdit&pageID='.$item->pageID.'&packageID='.PACKAGE_ID.'&created=1'.SID_ARG_2ND_NOT_ENCODED);
		
		// call event
		$this->saved();
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
			'title'							=>		$this->title,
			'allowSpidersToIndexThisPage'	=>		$this->allowSpidersToIndexThisPage,
			'additionalHeadContent'			=>		$this->additionalHeadContent,
			'isPublic'						=>		$this->isPublic,
			'isDefaultPage'					=>		$this->isDefaultPage,
			'menuItemTitle'					=>		$this->menuItemTitle,
			'menuItemIconS'					=>		$this->menuItemIconS,
			'menuItemIconM'					=>		$this->menuItemIconM,
			'menuItemSortOrder'				=>		$this->menuItemSortOrder,
			'menuItemPosition'				=>		$this->menuItemPosition,
			'host'							=>		$this->host,
			'hostID'						=>		$this->hostID,
			'createMenuItem'				=>		$this->createMenuItem
		));
	}
}
?>