<?php
// wcf imports
require_once(WCF_DIR.'lib/data/dynamic/page/DynamicPage.class.php');
require_once(WCF_DIR.'lib/page/util/DynamicHostManager.class.php');

/**
 * Provides functions for basic page management
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 */
class DynamicPageManager {
	/**
	 * Contains an array with all pages
	 * @var array
	 */
	protected $pages = array();
	
	/**
	 * Contains the default page (homepage)
	 * @var Object
	 */
	protected $defaultPage = null;
	
	/**
	 * Contains the current host
	 * @var Object
	 */
	protected $host = null;
	
	/**
	 * Contains the current host manager
	 * @var Object
	 */
	protected $hostManager = null;
	
	/**
	 * Creates a new instance of this class
	 */
	public function __construct() {
		// init host manager
		$this->initDynamicHostManager();
		
		// get host
		$this->host = $this->hostManager->getHost();
		
		// load cache
		$this->loadCache();
		
		// catch errors that can occour if a user modifies the database manualy
		if (!$this->defaultPage) throw new SystemException("No default page specified!");
	}
	
	/**
	 * Creates a new DynamicHostManager object
	 */
	protected function initDynamicHostManager() {
		$this->hostManager = new DynamicHostManager();
	}
	
	/**
	 * Returnes all pages
	 */
	public function getPages() {
		return $this->pages;
	}
	
	/**
	 * Returnes the current default page
	 */
	public function getDefaultPage() {
		return $this->defaultPage;
	}
	
	/**
	 * Loads the cache into all required variables
	 */
	protected function loadCache() {
		$this->pages = $this->getCache();
		
		foreach($this->pages as $key => $page) {
			if ($page->isDefaultPage) $this->defaultPage = &$this->pages[$key];
		}
	}
	
	/**
	 * Returnes the content of current cache file (or reloads it)
	 */
	public function getCache() {
		WCF::getCache()->addResource('dynamicPages-'.$this->host->hostID, WCF_DIR.'cache/cache.dynamicPages.php', WCF_DIR.'lib/system/CacheBuilderDynamicPages.class.php');
		return WCF::getCache()->get('dynamicPages-'.$this->host->hostID);
	}
}
?>