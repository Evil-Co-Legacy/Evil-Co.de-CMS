<?php
// wcf imports
require_once(WCF_DIR.'lib/page/util/module/AbstractModule.class.php');

/**
 * Implements a module class that provides a page article
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.core
 */
class ArticleModule extends AbstractModule {
	
	/**
	 * @see AbstractModule::$templateName
	 */
	public $templateName = 'articlePageModule';
	
	/**
	 * @see Module::readData()
	 */
	public function readData() {
		parent::readData();
		
		// parse text
		require_once(WCF_DIR.'lib/data/message/bbcode/MessageParser.class.php');
		$parser = MessageParser::getInstance();
					
		$this->getOptions()->getGroup('general')->getOption('content')->setValue($parser->parse($this->getOptions()->getGroup('general')->getOption('content')->getValue(), true, false, true));
	}
}
?>