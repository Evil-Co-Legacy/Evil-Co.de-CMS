<?php
// wcf imports
require_once(WCF_DIR.'lib/page/util/module/AbstractModule.class.php');

/**
 * Allows to add custom PHP-Code to page
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.php
 */
class PHPModule extends AbstractModule {
	
	/**
	 * @see	AbstractModule::$templateName
	 */
	public $templateName = 'phpPageModule';
	
	/**
	 * Contains HTML-Code for outputs
	 * @var	string
	 */
	public $content = '';
	
	/**
	 * @see	Module::readData()
	 */
	public function readData() {
		parent::readData();
		
		eval($this->getOptions()->getGroup('general')->getOption('code')->getValue());
	}
}
?>