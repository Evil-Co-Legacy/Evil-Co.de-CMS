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
}
?>