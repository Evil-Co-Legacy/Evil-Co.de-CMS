<?php
// wcf imports
require_once(WCF_DIR.'lib/data/host/Host.class.php');

/**
 * Manages all hosts
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 */
class DynamicHostManager {
	/**
	 * Contains all hosts
	 * @var array
	 */
	protected $hosts = array();
	
	/**
	 * Creates a new instance of type DynamicHostManager
	 */
	public function __construct() {
		// load cache
		$this->loadCache();
	}
	
	/**
	 * Returnes the host object for the current request host
	 */
	public function getHost() {
		$host = $_SERVER['HTTP_HOST'];
		
		foreach($this->hosts as $key => $host) {
			if (preg_match('~'.str_replace('~', '\~', $host->hostname).'~', $host)) return $this->hosts[$key];
		}
		
		foreach($this->hosts as $key => $host) {
			if ($host->fallback) return $this->hosts[$key];
		}
		
		throw new NamedUserException(WCF::getLanguage()->get('cms.global.unknownPage'));
	}
	
	/**
	 * Writes content of cache to $hosts
	 */
	protected function loadCache() {
		$this->hosts = self::getCache();
	}
	
	/**
	 * Returnes the content of the current cache file
	 */
	public static function getCache() {
		WCF::getCache()->addResource('hosts', WCF_DIR.'cache/cache.hosts.php', WCF_DIR.'lib/system/cache/CacheBuilderHosts.class.php');
		return WCF::getCache()->get('hosts');
	}
}
?>