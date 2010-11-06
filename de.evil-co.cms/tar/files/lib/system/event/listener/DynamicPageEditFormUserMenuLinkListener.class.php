<?php
require_once(WCF_DIR.'lib/system/event/EventListener.class.php');

/**
 * Implements a event listener that adds a menu entry to user panel on DynamicPageEditForm
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 */
class DynamicPageEditFormUserMenuLinkListener implements EventListener {
	
	/**
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		WCF::getTPL()->append('additionalHeaderButtons', '<li><a href="'.RELATIVE_CMS_DIR.'index.php?page=CMS&pageID='.$eventObj->pageID.'"><img src="'.RELATIVE_CMS_DIR.'icon/indexS.png" alt="" /> <span>'.WCF::getLanguage()->get('cms.acp.pagePreview').'</span></a></li>');
	}
}
?>