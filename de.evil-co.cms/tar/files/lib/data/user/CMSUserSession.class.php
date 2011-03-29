<?php
// wcf imports
require_once(WCF_DIR.'lib/data/user/avatar/Gravatar.class.php');
require_once(WCF_DIR.'lib/data/user/avatar/Avatar.class.php');
require_once(WCF_DIR.'lib/system/event/EventHandler.class.php');

// cms imports
require_once(CMS_DIR.'lib/data/user/AbstractCMSUserSession.class.php');

/**
 * @author		Johannes Donath
 * @copyright		2010 DEVel Fusion
 * @package		de.evil-co.cms
 * @license		GNU Lesser Public License <http://www.gnu.org/licenses/lgpl.txt>
 */
class CMSUserSession extends AbstractCMSUserSession {
	
	/**
	 * @see UserSession::__construct()
	 */
	public function __construct($userID = null, $row = null, $username = null) {
		$this->sqlSelects .= "	avatar.*,
					GROUP_CONCAT(DISTINCT whitelist.whiteUserID ORDER BY whitelist.whiteUserID ASC SEPARATOR ',') AS buddies,
					GROUP_CONCAT(DISTINCT blacklist.blackUserID ORDER BY blacklist.blackUserID ASC SEPARATOR ',') AS ignoredUser,
					(SELECT COUNT(*) FROM wcf".WCF_N."_user_whitelist WHERE whiteUserID = user.userID AND confirmed = 0 AND notified = 0) AS numberOfInvitations,";
		$this->sqlJoins .= "	LEFT JOIN wcf".WCF_N."_user_whitelist whitelist ON (whitelist.userID = user.userID AND whitelist.confirmed = 1)
					LEFT JOIN wcf".WCF_N."_user_blacklist blacklist ON (blacklist.userID = user.userID)
					LEFT JOIN wcf".WCF_N."_avatar avatar ON (avatar.avatarID = user.avatarID) ";
		parent::__construct($userID, $row, $username);
	}
	
	/**
	 * @see User::handleData()
	 */
	protected function handleData($data) {
		parent::handleData($data);
		
		// we'll load the avatar
		if (MODULE_AVATAR == 1 and !$this->disableAvatar and $this->showAvatar) {
			if (MODULE_GRAVATAR == 1 and $this->gravatar) {
				// handle gravatar
				$this->avatar = new Gravatar($this->gravatar);
			} elseif ($this->avatarID) {
				// handle avatar
				$this->avatar = new Avatar(null, $data);
			}
		}
	}
	
	/**
	 * Initialises the user session.
	 */
	public function init() {
		parent::init();

		// reset properties
		$this->invitations = null;
	}
	
	/**
	 * @see	PM::getOutstandingNotifications()
	 */
	public function getOutstandingNotifications() {
		if ($this->outstandingNotifications === null) {
			// fire event
			EventHandler::fireAction($this, 'readOutstandingNotifications');
			
			/* require_once(WCF_DIR.'lib/data/message/pm/PM.class.php');
			$this->outstandingNotifications = PM::getOutstandingNotifications(WCF::getUser()->userID); */
		}
		
		return $this->outstandingNotifications;
	}
	
	/**
	 * @see	PM::getOutstandingNotifications()
	 */
	public function getInvitations() {
		// if we haven't set the invitations variable we'll load all from database
		if ($this->invitations === null) {
			// create needed array
			$this->invitations = array();
			
			// build another query from hell
			$sql = "SELECT
						user_table.userID, user_table.username
					FROM
						wcf".WCF_N."_user_whitelist whitelist
					LEFT JOIN
						wcf".WCF_N."_user user_table
					ON
						(user_table.userID = whitelist.userID)
					WHERE
						whitelist.whiteUserID = ".$this->userID."
					AND
						whitelist.confirmed = 0
					AND
						whitelist.notified = 0
					ORDER BY
						whitelist.time";
			$result = WCF::getDB()->sendQuery($sql);
			
			while ($row = WCF::getDB()->fetchArray($result)) {
				$this->invitations[] = new User(null, $row);
			}
		}
		
		// return invitation array
		return $this->invitations;
	}
	
	/**
	 * @see	AbstractCMSUserSession::getAvatar()
	 */
	public function getAvatar() {
		return $this->avatar;
	}
}
?>