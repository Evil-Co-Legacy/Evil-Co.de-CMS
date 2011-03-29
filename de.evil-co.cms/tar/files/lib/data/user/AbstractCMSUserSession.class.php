<?php
// wcf imports
require_once(WCF_DIR.'lib/system/session/UserSession.class.php');

/**
 * @author		Johannes Donath
 * @copyright		2010 DEVel Fusion
 * @package		de.evil-co.pdb
 * @license		GNU Lesser Public License <http://www.gnu.org/licenses/lgpl.txt>
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
