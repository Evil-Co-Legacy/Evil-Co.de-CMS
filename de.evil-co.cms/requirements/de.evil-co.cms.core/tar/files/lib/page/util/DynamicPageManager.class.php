<?php
// wcf imports
require_once(WCF_DIR.'lib/data/page/Page.class.php');

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
	 * Creates a new instance of this class
	 */
	public function __construct() {
		$this->loadCache();
		
		// catch errors that can occour if a user modifies the database manualy
		if (!$this->defaultPage) throw new SystemException("No default page specified!");
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
		WCF::getCache()->addResource('dynamicPages', WCF_DIR.'cache/cache.dynamicPages.php', WCF_DIR.'lib/system/CacheBuilderDynamicPages.class.php');
		return WCF::getCache()->get('dynamicPages');
	}
}
?>