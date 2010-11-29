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
	 * @see	Page::show()
	 */
	public function show() {
		// check module option
		if (!MODULE_CMSSTATISTICS) throw new IllegalLinkException;
		
		// enable menu entry
		WCFACP::getMenu()->setActiveMenuItem('cf.acp.menu.link.content.host.statistics');
		
		parent::show();
	}
}
?>