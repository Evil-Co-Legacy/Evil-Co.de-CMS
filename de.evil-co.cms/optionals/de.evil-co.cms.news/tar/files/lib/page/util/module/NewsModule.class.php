<?php
// wcf imports
require_once(WCF_DIR.'lib/page/util/module/AbstractModule.class.php');

/**
 * Implements a module class that provides a news interface
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.news
 */
class NewsModule extends AbstractModule {
	
	/**
	 * @see	AbstractModule::$templateName
	 */
	public $templateName = 'newsPageModule';
	
	/**
	 * Contains all news items
	 * @var array<NewsItem>
	 */
	public $newsItems = array();
	
	/**
	 * @see	AbstractModule::readData()
	 */
	public function readData() {
		parent::readData();

		// read cache
		WCF::getCache()->addResource('newsItemsPageModule-'.$this->instanceID, WCF_DIR.'cache/cache.newsItemsPageModule-'.$this->instanceID.'.php', WCF_DIR.'lib/system/cache/CacheBuilderNewsPageModule.class.php');
		$this->newsItems = WCF::getCache()->get('newsItemsPageModule-'.$this->instanceID);
	}
}
?>