<?php
require_once(WCF_DIR.'lib/system/event/EventListener.class.php');

/**
 * Implements a event listener that adds the pm link to user panel
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.commercial.pm
 */
class PMLinkListener implements EventListener {
	
	/**
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		if (MODULE_PM == 1 and WCF::getUser()->getPermission('user.pm.canUsePm') and WCF::getUser()->userID > 0) {
			WCF::getTPL()->append('additionalUserMenuItems', '<li'.(WCF::getUser()->pmUnreadCount ? ' class="new"' : '').' id="userMenuPm"><a href="index.php?page=PMList'.SID_ARG_2ND.'"><img src="'.StyleManager::getStyle()->getIconPath('pm'.(WCF::getUser()->pmUnreadCount ? 'Full' : 'Empty').'S.png').'" alt="" /> <span>'.WCF::getLanguage()->get('cms.header.userMenu.pm').(WCF::getUser()->pmUnreadCount ? '('.WCF::getUser()->pmUnreadCount.')' : '').'</span></a>'.(WCF::getUser()->pmTotalCount >= WCF::getUser()->getPermission('user.pm.maxPm') ? ' <span class="pmBoxFull">'.WCF::getLanguage()->get('wcf.pm.userMenu.mailboxIsFull') : '').'</span></li>');
		}
	}
}
?>