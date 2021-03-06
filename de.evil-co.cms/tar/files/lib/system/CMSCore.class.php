<?php
require_once(WCF_DIR.'lib/page/util/menu/PageMenuContainer.class.php');
require_once(WCF_DIR.'lib/page/util/menu/UserCPMenuContainer.class.php');
require_once(WCF_DIR.'lib/page/util/menu/UserProfileMenuContainer.class.php');
require_once(WCF_DIR.'lib/system/style/StyleManager.class.php');

// im to lazy to fix this options in my test versions ...

/**
 * Core class of CMS
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms
 */
class CMSCore extends WCF implements PageMenuContainer, UserCPMenuContainer, UserProfileMenuContainer {
	
	/**
	 * Contains the current PageMenu instance
	 * @var	PageMenu
	 */
	protected static $pageMenuObj = null;
	
	/**
	 * Contains the current UserCP
	 * @var	UserCP
	 */
	protected static $userCPMenuObj = null;
	
	/**
	 * Contains the current UserProfileMenu
	 * @var	UserProfileMenu
	 */
	protected static $userProfileMenuObj = null;
	
	/**
	 * Defines all pages that are available during offline mode
	 * @var unknown_type
	 */
	public static $availablePagesDuringOfflineMode = array(
		'page' => array('Captcha', 'LegalNotice'),
		'form' => array('UserLogin'),
		'action' => array('UserLogout'));
	
	/**
	 * Contains the ID of the current active host id
	 * @var	integer
	 */
	protected static $activeHostID = 0;
	
	/**
	 * Contains the current HostManager
	 * @var	HostManager
	 */
	protected static $hostManagerObj = null;
	
	/**
	 * Contains the current active Host
	 * @var	Host
	 */
	protected static $activeHost = null;
	
	/**
	 * @see WCF::__construct()
	 */
	public function __construct() {
		parent::__construct();
		
		// call custom construct methods
		$this->initHostManager();
	}

	/**
	 * @see WCF::initTPL()
	 */
	protected function initTPL() {
		// init style to get template pack id
		$this->initStyle();

		// little dirty fix for XSLT mode
		if (XSLT) ob_start(array('CMSCore', 'editSourceOutput'));
		
		global $packageDirs;
		require_once(WCF_DIR.'lib/system/template/StructuredTemplate.class.php');
		self::$tplObj = new StructuredTemplate(self::getStyle()->templatePackID, self::getLanguage()->getLanguageID(), ArrayUtil::appendSuffix($packageDirs, 'templates/'));
		$this->assignDefaultTemplateVariables();

		// init cronjobs
		$this->initCronjobs();

		// check offline mode
		if (OFFLINE && !self::getUser()->getPermission('user.cms.canViewCMSOffline')) {
			$showOfflineError = true;
			foreach (self::$availablePagesDuringOfflineMode as $type => $names) {
				if (isset($_REQUEST[$type])) {
					foreach ($names as $name) {
						if ($_REQUEST[$type] == $name) {
							$showOfflineError = false;
							break 2;
						}
					}

				}

				break;

			}

			if ($showOfflineError) {
				self::getTPL()->display('offline');
				exit;
			}
		}

		// user ban
		if (self::getUser()->banned && (!isset($_REQUEST['page']) || $_REQUEST['page'] != 'LegalNotice')) {
			require_once(WCF_DIR.'lib/system/exception/PermissionDeniedException.class.php');
			throw new PermissionDeniedException();
		}
	}

	/**
	 * Initialises the cronjobs.
	 */
	protected function initCronjobs() {
		self::getTPL()->assign('executeCronjobs', WCF::getCache()->get('cronjobs-'.PACKAGE_ID, 'nextExec') < TIME_NOW);
	}

	/**
	 * @see WCF::loadDefaultCacheResources()
	 */
	protected function loadDefaultCacheResources() { 
		parent::loadDefaultCacheResources();
		$this->loadDefaultCMSCacheResources();
	}

	/**
	 * Loads default cache resources of auction system.
	 * Can be called statically from other applications or plugins.
	 */
	public static function loadDefaultCMSCacheResources() {
		WCF::getCache()->addResource('pageLocations-'.PACKAGE_ID, WCF_DIR.'cache/cache.pageLocations-'.PACKAGE_ID.'.php', WCF_DIR.'lib/system/cache/CacheBuilderPageLocations.class.php');
		WCF::getCache()->addResource('bbcodes', WCF_DIR.'cache/cache.bbcodes.php', WCF_DIR.'lib/system/cache/CacheBuilderBBCodes.class.php');
		WCF::getCache()->addResource('smileys', WCF_DIR.'cache/cache.smileys.php', WCF_DIR.'lib/system/cache/CacheBuilderSmileys.class.php');
		WCF::getCache()->addResource('cronjobs-'.PACKAGE_ID, WCF_DIR.'cache/cache.cronjobs-'.PACKAGE_ID.'.php', WCF_DIR.'lib/system/cache/CacheBuilderCronjobs.class.php');
		WCF::getCache()->addResource('help-'.PACKAGE_ID, WCF_DIR.'cache/cache.help-'.PACKAGE_ID.'.php', WCF_DIR.'lib/system/cache/CacheBuilderHelp.class.php');
	}

	/**
	 * Initialises the page header menu.
	 */
	protected static function initPageMenu() {
		require_once(WCF_DIR.'lib/page/util/menu/PageMenu.class.php');
		self::$pageMenuObj = new PageMenu();
		if (PageMenu::getActiveMenuItem() == '') PageMenu::setActiveMenuItem('www.header.menu.index');
	}

	/**
	 * Initialises the user cp menu.
	 */
	protected static function initUserCPMenu() {
		require_once(WCF_DIR.'lib/page/util/menu/UserCPMenu.class.php');
		self::$userCPMenuObj = UserCPMenu::getInstance();
	}

	/**
	 * Initialises the user profile menu.
	 */
	protected static function initUserProfileMenu() {
		require_once(WCF_DIR.'lib/page/util/menu/UserProfileMenu.class.php');
		self::$userProfileMenuObj = UserProfileMenu::getInstance();
	}

	/**
	 * @see WCF::getOptionsFilename()
	 */
	protected function getOptionsFilename() {
		return CMS_DIR.'options.inc.php';
	}

	/**
	 * Initialises the style system.
	 */
	protected function initStyle() {
		if (isset($_GET['styleID'])) {
			self::getSession()->setStyleID(intval($_GET['styleID']));
		}
		
		StyleManager::changeStyle(self::getSession()->getStyleID());
	}

	/**
	 * @see PageMenuContainer::getPageMenu()
	 */
	public static final function getPageMenu() {
		if (self::$pageMenuObj === null) {
			self::initPageMenu();
		}
		
		return self::$pageMenuObj;
	}

	/**
	 * @see UserCPMenuContainer::getUserCPMenu()
	 */
	public static final function getUserCPMenu() {
		if (self::$userCPMenuObj === null) {
			self::initUserCPMenu();
		}

		return self::$userCPMenuObj;
	}

	/**
	 * @see UserProfileMenuContainer::getUserProfileMenu()
	 */
	public static final function getUserProfileMenu() {
		if (self::$userProfileMenuObj === null) {
			self::initUserProfileMenu();
		}

		return self::$userProfileMenuObj;
	}

	/**
	 * Returns the active style object.
	 * 
	 * @return	ActiveStyle
	 */
	public static final function getStyle() {
		return StyleManager::getStyle();
	}

	/**
	 * @see WCF::initSession()
	 */
	protected function initSession() {
		require_once(CMS_DIR.'lib/system/session/CMSSessionFactory.class.php');
		$factory = new CMSSessionFactory();
		self::$sessionObj = $factory->get();
		self::$userObj = self::getSession()->getUser();
	}
	
	/**
	 * Returnes all current servers
	 */
	public static function getServerList() {
		return self::$serverList;
	}

	/**
	 * @see	WCF::assignDefaultTemplateVariables()
	 */
	protected function assignDefaultTemplateVariables() {
		parent::assignDefaultTemplateVariables();
		
		self::getTPL()->registerPrefilter('icon');
		self::getTPL()->assign(array(
			'timezone' => DateUtil::getTimezone(),
			'stylePickerOptions' => (SHOW_STYLE_CHOOSER ? StyleManager::getAvailableStyles() : array())
		));
	}
	
	/**
	 * Returnes the hostID
	 */
	public static function getHostID() {
		return self::$activeHostID;
	}
	
	/**
	 * Creates a new instance of DynamicHostManager
	 */
	protected function initHostManager() {
		require_once(WCF_DIR.'lib/page/util/DynamicHostManager.class.php');
		self::$hostManagerObj = new DynamicHostManager();
		self::$activeHost = self::$hostManagerObj->getHost();
		self::$activeHostID = self::$activeHost->hostID;
	}
	
	/**
	 * Returnes the DynamicHostManager instance
	 */
	public static function getHostManager() {
		return self::$hostManagerObj;
	}
	
	/**
	 * Returnes the active host
	 */
	public static function getActiveHost() {
		return self::$activeHost;
	}
	
	/**
	 * Fixes the output in XSLT mode
	 */
	public static function editSourceOutput($output) {
		@header('Content-Type: text/xml; charset='.CHARSET); // I hope that this isn't needed
		return (str_replace("</html>", "</page>", $output));
	}
}
?>