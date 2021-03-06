<?php
// wcf imports
require_once(WCF_DIR.'lib/page/MultipleLinkPage.class.php');
require_once(WCF_DIR.'lib/data/dynamic/page/DynamicPage.class.php');
require_once(WCF_DIR.'lib/data/host/Host.class.php');

/**
 * Lists all pages
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.core
 */
class DynamicPageListPage extends MultipleLinkPage {
	/**
	 * @see Page::$templateName
	 */
	public $templateName = 'dynamicPageList';
	
	/**
	 * @see	Page::$neededPermissions
	 */
	public $neededPermissions = 'admin.content.cms.canListPages';
	
	/**
	 * @see MultipleLinkPage::$itemsPerPage
	 */
	public $itemsPerPage = 50;
	
	/**
	 * Contains all pages
	 * @var array
	 */
	public $pageList = array();
	
	/**
	 * Contains the hostID of all pages that should appear in list
	 * @var	integer
	 */
	public $hostID = 0;
	
	/**
	 * Contains an instance of type Host
	 * @var	Host
	 */
	public $host = null;
	
	/**
	 * @see	Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		// read query arguments
		if (isset($_REQUEST['hostID'])) $this->hostID = intval($_REQUEST['hostID']);
		
		// read host
		$this->host = new Host($this->hostID);
		
		// validate host
		if (!$this->host->hostID) throw new IllegalLinkException;
	}
	
	/**
	 * @see Page::readData()
	 */
	public function readData() {
		parent::readData();
		
		// read pages for the given host
		$this->readPages();
	}
	
	/**
	 * @see Page::show()
	 */
	public function show() {
		// enable acpmenu entry
		WCFACP::getMenu()->setActiveMenuItem('wcf.acp.menu.link.content.host.list');
		
		parent::show();
	}
	
	/**
	 * @see MultipleLinkPage::countItems()
	 */
	public function countItems() {
		parent::countItems();
		
		$sql = "SELECT	COUNT(*) AS count
			FROM	wcf".WCF_N."_page
			WHERE
				hostID = ".$this->host->hostID;
		$row = WCF::getDB()->getFirstRow($sql);
		return $row['count'];
	}
	
	/**
	 * @see Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'pageList' 		=>		$this->pageList,
			'host'			=>		$this->host,
			'hostID'		=>		$this->hostID
		));
	}
	
	/**
	 * Reads all pages form database
	 */
	protected function readPages() {
		$sql = "SELECT
					*
				FROM
					wcf".WCF_N."_page
				WHERE
					hostID = ".$this->host->hostID."
				ORDER BY
					title ASC";
		$result = WCF::getDB()->sendQuery($sql, $this->itemsPerPage, ($this->pageNo - 1) * $this->itemsPerPage);
		
		while($row = WCF::getDB()->fetchArray($result)) {
			$this->pageList[] = new DynamicPage(null, $row);
		}
	}
}
?>