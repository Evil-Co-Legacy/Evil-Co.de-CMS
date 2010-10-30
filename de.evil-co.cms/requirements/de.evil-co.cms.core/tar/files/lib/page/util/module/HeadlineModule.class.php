<?php
// wcf imports
require_once(WCF_DIR.'lib/page/util/module/AbstractModule.class.php');

/**
 * Implements a module class that provides a page article that puts out a headline tag (hX)
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 */
class HeadlineModule extends AbstractModule {
	
	/**
	 * @see AbstractModule::$templateName
	 */
	public $templateName = 'headlinePageModule';
}
?>