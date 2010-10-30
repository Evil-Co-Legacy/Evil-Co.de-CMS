<?php
// wcf imports
require_once(WCF_DIR.'lib/page/util/module/AbstractModule.class.php');

/**
 * Implements a module class that provides a page article that puts out a message box
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.core
 */
class MessageboxModule extends AbstractModule {
	
	/**
	 * @see AbstractModule::$templateName
	 */
	public $templateName = 'messageboxPageModule';
}
?>