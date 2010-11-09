<?php
// wcf imports
require_once(WCF_DIR.'lib/data/message/sidebar/MessageSidebarObject.class.php');
require_once(WCF_DIR.'lib/data/user/UserProfile.class.php');
require_once(WCF_DIR.'lib/data/dynamic/news/DynamicNewsItem.class.php');

/**
 * Represents news item row and implements special methods for message sidebars
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.news
 */
class ViewableDynamicNewsItem extends DynamicNewsItem implements MessageSidebarObject {
	
	/**
	 * @see DatabaseObject::handleData()
	 */
	protected function handleData($data) {
		parent::handleData($data);
		$this->user = new UserProfile($this->authorID);
		if ($this->user->userID == 0) $this->user->username = $this->username;
	}
	
	// MessageSidebarObject implementation
	/**
	 * @see MessageSidebarObject::getUser()
	 */
	public function getUser() {
		return $this->user;
	}
	
	/**
	 * @see MessageSidebarObject::getMessageID()
	 */
	public function getMessageID() {
		return $this->itemID;
	}
	
	/**
	 * @see MessageSidebarObject::getMessageType()
	 */
	public function getMessageType() {
		return 'newsItem';
	}
}
?>