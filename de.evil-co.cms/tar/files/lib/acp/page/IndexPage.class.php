<?php
// wcf imports
require_once(WCF_DIR.'lib/page/AbstractPage.class.php');
require_once(WCF_DIR.'lib/acp/package/PackageInstallationQueue.class.php');
require_once(WCF_DIR.'lib/data/feed/FeedReaderSource.class.php');

/**
 * Implements a start page for cms application
 * @author		Johannes Donath (Some code taken from Infinite Database by Sebastian Oettl)
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms
 */
class IndexPage extends AbstractPage {
	
	/**
	 * @see	Page::$templateName
	 */
	public $templateName = 'index';
	
	/**
	 * Contains server's os
	 * @var	string
	 */
	public $os = '';
	
	/**
	 * Contains webserver's version string
	 * @var	string
	 */
	public $webserver = '';
	
	/**
	 * Contains sql server's version string
	 * @var	string
	 */
	public $sqlVersion = '';
	
	/**
	 * Contains type of sql server (e.g. 'MySQL')
	 * @var	string
	 */
	public $sqlType = '';
	
	/**
	 * Contains server's load
	 * @var	string
	 */
	public $load = '';
	
	/**
	 * Contains all rss news
	 * @var	array
	 */
	public $news = array();
	
	/**
	 * Contains all available package updates
	 * @var	array
	 */
	public $updates = array();
	
	/**
	 * @see Page::readData()
	 */
	public function readData() {
		parent::readData();
		
		// get server's os
		$this->os = PHP_OS;
		
		// get webserver's version string if exists
		if (isset($_SERVER['SERVER_SOFTWARE'])) $this->webserver = $_SERVER['SERVER_SOFTWARE'];
		
		// get sql server's version string
		$this->sqlVersion = WCF::getDB()->getVersion();
		
		// get sql type
		$this->sqlType = WCF::getDB()->getDBType();
		
		// read updates
		$this->readUpdates();
		
		// read news
		$this->readNews();
		
		// get load
		$this->readLoad();
		
		// show warning box if the user hadn't set permissions
		if (in_array(4, WCF::getUser()->getGroupIDs()) and (!WCF::getUser()->getPermission('admin.content.cms.canListHosts'))) WCF::getTPL()->assign('noPermissions', true);
	}
	
	/**
	 * Gets a list of available updates.
	 */	
	protected function readUpdates() {	
		if (WCF::getUser()->getPermission('admin.system.package.canUpdatePackage')) {
			require_once(WCF_DIR.'lib/acp/package/update/PackageUpdate.class.php');
			$this->updates = PackageUpdate::getAvailableUpdates();
		}
	}
	
	/**
	 * Gets a list of available news.
	 */	
	protected function readNews() {
		$this->news = FeedReaderSource::getEntries(5);
		foreach ($this->news as $key => $news) {
			$this->news[$key]['description'] = preg_replace('/href="(.*?)"/e', '\'href="'.RELATIVE_WCF_DIR.'acp/dereferrer.php?url=\'.rawurlencode(\'$1\').\'" class="externalURL"\'', $news['description']);

			// kick woltlab news
			if (preg_match('/woltlab.(com|de)/i', $this->news[$key]['link'])) {
				unset($this->news[$key]);	
			}
		}
	}
	
	/**
	 * Gets the current server load.
	 */
	protected function readLoad() {
		if ($uptime = @exec("uptime")) {
			if (preg_match("/averages?: ([0-9\.]+,?[\s]+[0-9\.]+,?[\s]+[0-9\.]+)/", $uptime, $match)) {
				$this->load = $match[1];
			}
		}
	}
	
	/**
	 * @see Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'os' => $this->os,
			'webserver' => $this->webserver,
			'sqlVersion' => $this->sqlVersion,
			'sqlType' => $this->sqlType,
			'load' => $this->load,
			'news' => $this->news,
			'updates' => $this->updates,
			'dbName' => WCF::getDB()->getDatabaseName(),
			'cacheSource' => get_class(WCF::getCache()->getCacheSource())
		));
	}
}
?>