<?php
// wcf imports
require_once(WCF_DIR.'lib/page/AbstractPage.class.php');
require_once(WCF_DIR.'lib/page/util/DynamicPageManager.class.php');

/**
 * Implements the homepage that redirects to our default page
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 */
class IndexPage extends AbstractPage {
	
	/**
	 * Redirects a user to the default page
	 */
	public function show() {
		$pageManager = new DynamicPageManager();
		
		HeaderUtil::redirect("index.php?page=CMS&pageID=".$pageManager->getDefaultPage()->getPageID().SID_ARG_2ND_NOT_ENCODED);
	}
}
?>