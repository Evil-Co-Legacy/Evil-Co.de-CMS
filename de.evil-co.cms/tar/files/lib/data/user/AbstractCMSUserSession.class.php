<?php
// wcf imports
require_once(WCF_DIR.'lib/system/session/UserSession.class.php');

/**
 * This class implements a user session
 * @author akkarin
 */
class AbstractCMSUserSession extends UserSession {
	
	/**
	 * Contains a list of outstanding notifications
	 * @var	array
	 */
	protected $outstandingNotifications = null;
	
	/**
	 * Contains a list of outstanding invitations
	 * @var	array
	 */
	protected $invitations = null;
	
	/**
	 * @see	PM::getOutstandingNotifications()
	 */
	public function getOutstandingNotifications() {
		return array();
	}
	
	/**
	 * @see	PM::getOutstandingNotifications()
	 */
	public function getInvitations() {
		return array();
	}
	
	/**
	 * Returnes the avatar of the current user
	 */
	public function getAvatar() {
		return null;
	}
}
?>
