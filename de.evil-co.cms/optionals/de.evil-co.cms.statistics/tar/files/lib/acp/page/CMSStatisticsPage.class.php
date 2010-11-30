<?php
// wcf imports
require_once(WCF_DIR.'lib/page/AbstractPage.class.php');

/**
 * Shows statistics about cms
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 */
class CMSStatisticsPage extends AbstractPage {
	
	/**
	 * @see AbstractPage::$templateName
	 */
	public $templateName = 'cmsStatistics';
	
	/**
	 * Contains all referer hosts
	 * @var	array
	 */
	public $hosts = array();
	
	/**
	 * @see	Page::readData()
	 */
	public function readData() {
		parent::readData();
		
		$sql = "SELECT
					*
				FROM
					cms".CMS_N."_statistic_referer
				ORDER BY
					url ASC";
		$result = WCF::getDB()->sendQuery($sql);
		
		$refererList = array();
		
		while($row = WCF::getDB()->fetchArray($result)) {
			if (!isset($refererList[$row['hostID']])) $refererList[$row['hostID']] = array();
			$refererList[$row['hostID']][] = $row;
		}
		
		$sql = "SELECT
					*
				FROM
					cms".CMS_N."_statistic_referer_host
				ORDER BY
					hostname ASC";
		$result = WCF::getDB()->sendQuery($sql);
		
		while($row = WCF::getDB()->fetchArray($result)) {
			$row['children'] = (isset($refererList[$row['hostID']]) ? $refererList[$row['hostID']] : array());
			$this->hosts[] = $row; 
		}
	}
	
	/**
	 * @see	Page::show()
	 */
	public function show() {
		// check module option
		if (!MODULE_CMSSTATISTICS) throw new IllegalLinkException;
		
		// enable menu entry
		WCFACP::getMenu()->setActiveMenuItem('wcf.acp.menu.link.content.host.statistics');
		
		parent::show();
	}
	
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'hosts'		=>	$this->hosts
		));
	}
}
?>