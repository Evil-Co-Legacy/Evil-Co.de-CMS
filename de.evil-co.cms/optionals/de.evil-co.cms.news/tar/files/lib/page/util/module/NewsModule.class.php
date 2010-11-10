<?php
// wcf imports
require_once(WCF_DIR.'lib/page/util/module/AbstractModule.class.php');
require_once(WCF_DIR.'lib/data/message/sidebar/MessageSidebarFactory.class.php');

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
	 * Contains the sidebar factory for all items of this instance
	 * @var	MessageSidebarFactory
	 */
	public $sidebarFactory = null;
	
	/**
	 * @see	AbstractModule::readData()
	 */
	public function readData() {
		parent::readData();
		
		// init sidebar factory
		$this->sidebarFactory = new MessageSidebarFactory($this);

		// read cache
		WCF::getCache()->addResource('newsItemsPageModule-'.$this->instanceID, WCF_DIR.'cache/cache.newsItemsPageModule-'.$this->instanceID.'.php', WCF_DIR.'lib/system/cache/CacheBuilderNewsPageModule.class.php');
		$this->newsItems = WCF::getCache()->get('newsItemsPageModule-'.$this->instanceID);
		
		// add items to sidebar factory
		foreach($this->newsItems as $item) {
			$this->sidebarFactory->create($item);
		}
	}
}
?>