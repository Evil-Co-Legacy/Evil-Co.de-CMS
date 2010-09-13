<?php
// wcf imports
require_once(WCF_DIR.'lib/page/SortablePage.class.php');
require_once(WCF_DIR.'lib/data/dynamicPage/DynamicPage.class.php');

/**
 * Lists all pages
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 */
class DynamicPageListPage extends SortablePage {
	/**
	 * @see Page::$templateName
	 */
	public $templateName = 'dynamicPageList';
	
	/**
	 * @see MultipleLinkPage::$itemsPerPage
	 */
	public $itemsPerPage = 50;
	
	/**
	 * @see SortablePage::$defaultSortField
	 */
	public $defaultSortField = 'title';
	
	/**
	 * @see SortablePage::$defaultSortOrder
	 */
	public $defaultSortOrder = 'ASC';
	
	/**
	 * Contains all pages
	 * @var array
	 */
	public $pages = array();
	
	/**
	 * @see Page::readData()
	 */
	public function readData() {
		parent::readData();
		
		$this->readPages();
	}
	
	/**
	 * @see Page::show()
	 */
	public function show() {
		// enable acpmenu entry
		WCFACP::getMenu()->setActiveMenuItem('wcf.acp.menu.link.dynamicPage.view');
		
		parent::show();
	}
	
	/**
	 * @see MultipleLinkPage::countItems()
	 */
	public function countItems() {
		parent::countItems();
		
		$sql = "SELECT	COUNT(*) AS count
			FROM	wcf".WCF_N."_page";
		$row = WCF::getDB()->getFirstRow($sql);
		return $row['count'];
	}
	
	/**
	 * @see SortablePage::validateSortField()
	 */
	public function validateSortField() {
		parent::validateSortField();
		
		switch ($this->sortField) {
			case 'pageID':
			case 'title': break;
			default: $this->sortField = $this->defaultSortField;
		}
	}
	
	/**
	 * @see Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign('pages', $this->pages);
	}
	
	/**
	 * Reads all pages form database
	 */
	protected function readPages() {
		$sql = "SELECT
					*
				FROM
					wcf".WCF_N."_page
				ORDER BY
					".$this->sortField." ".$this->sortOrder;
		$result = WCF::getDB()->sendQuery($sql, $this->itemsPerPage, ($this->pageNo - 1) * $this->itemsPerPage);
		
		while($row = WCF::getDB()->fetchArray($result)) {
			$this->pages[] = new DynamicPage(null, $row);
		}
	}
}
?>