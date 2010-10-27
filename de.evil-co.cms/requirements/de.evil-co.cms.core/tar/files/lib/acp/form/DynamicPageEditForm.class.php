<?php
// wcf imports
require_once(WCF_DIR.'lib/acp/form/DynamicPageAddForm.class.php');

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
	 * @see Page::readParameters()
	 */
	public function readParameters() {
		ACPForm::readParameters();
		
		if (isset($_REQUEST['pageID'])) $this->pageID = intval($_REQUEST['pageID']);
		
		// create page object
		$this->page = new DynamicPageEditor($this->pageID);
		
		// validate
		if (!$this->page->pageID) throw new IllegalLinkException;
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
			'page'				=>		$this->page
		));
	}
}
?>