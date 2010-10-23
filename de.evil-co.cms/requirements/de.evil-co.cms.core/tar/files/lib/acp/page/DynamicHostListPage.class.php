<?php
// wcf imports
require_once(WCF_DIR.'lib/page/SortablePage.class.php');
require_once(WCF_DIR.'lib/data/host/Host.class.php');

/**
 * Lists all pages
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.core
 */
class DynamicPageListPage extends AbstractPage {
	/**
	 * @see Page::$templateName
	 */
	public $templateName = 'dynamicHostList';
	
	/**
	 * @see	Page::$neededPermissions
	 */
	public $neededPermissions = 'admin.content.cms.canListHosts';
	
	/**
	 * Contains all hosts
	 * @var array
	 */
	public $hosts = array();
	
	/**
	 * @see Page::readData()
	 */
	public function readData() {
		parent::readData();
		
		// read hosts from database
		$this->readHosts();
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
	 * @see Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign('hosts', $this->hosts);
	}
	
	/**
	 * Reads all pages form database
	 */
	protected function readHosts() {
		$sql = "SELECT
					hostID,
					IFNULL(title,hostname) AS title
				FROM
					wcf".WCF_N."_host
				ORDER BY
					IFNULL(title,hostname) ASC";
		$result = WCF::getDB()->sendQuery($sql);
		
		while($row = WCF::getDB()->fetchArray($result)) {
			$this->hosts[] = new Host(null, $row);
		}
	}
}
?>