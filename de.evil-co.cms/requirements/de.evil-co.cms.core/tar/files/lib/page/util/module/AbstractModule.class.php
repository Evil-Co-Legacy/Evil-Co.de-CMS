<?php
// wcf imports
require_once(WCF_DIR.'lib/page/util/module/Module.class.php');
require_once(WCF_DIR.'lib/system/event/EventHandler.class.php');

/**
 * This class implements the default functions and variables for modules
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 */
abstract class AbstractModule implements Module {
	/**
	 * @see Module::$templateName
	 */
	public $templateName = '';
	
	/**
	 * @see Module::$neededPermissions
	 */
	public $neededPermissions = '';
	
	/**
	 * @see Module::$stylesheet
	 */
	public $stylesheet = '';
	
	/**
	 * @see Module::$additionalHeadContents
	 */
	public $additionalHeadContents = '';
	
	/**
	 * Contains the pageID of the parent page
	 * @var integer
	 */
	protected $pageID = 0;
	
	/**
	 * @see Module::__construct()
	 */
	public function __construct($pageID) {
		$this->pageID = $pageID;
	}
	
	/**
	 * @see Module::readParameters()
	 */
	public function readParameters() {
		// call readParameters event
		EventHandler::fireAction($this, 'readParameters');
	}
	
	/**
	 * @see Module::readData()
	 */
	public function readData() {
		// call readData event
		EventHandler::fireAction($this, 'readData');
	}
	
	/**
	 * @see Module::assignVariables()
	 */
	public function assignVariables() {
		// call assignVariables event
		EventHandler::fireAction($this, 'assignVariables');
	}
	
	/**
	 * @see Module::checkPermissions()
	 */
	public function checkPermissions() {
		// call checkPermissions event
		EventHandler::fireAction($this, 'checkPermissions');
		
		// check needed permissions
		return WCF::getUser()->getPermission($this->neededPermissions);
	}
	
	/**
	 * @see Module::display()
	 */
	public function display() {
		return $this->templateName;
	}
	
	/**
	 * @see Module::__get()
	 */
	public function __get($variable) {
		if (isset($this->data[$variable])) return $this->data[$variable];
		return null;
	}
}
?>