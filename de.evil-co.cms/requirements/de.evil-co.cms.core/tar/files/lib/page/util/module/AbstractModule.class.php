<?php
// wcf imports
require_once(WCF_DIR.'lib/page/util/module/Module.class.php');
require_once(WCF_DIR.'lib/system/event/EventHandler.class.php');

/**
 * This class implements the default functions and variables for modules
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.core
 */
abstract class AbstractModule extends DatabaseObject implements Module {
	/**
	 * @see Module::$templateName
	 */
	public $templateName = '';
	
	/**
	 * Contains the name of the template that should displayed in page edit form
	 */
	public $acpTemplateName = '';
	
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
	 * Contains all sql joins
	 * @var	string
	 */
	protected $sqlJoins = '';
	
	/**
	 * Contains all sql selects
	 * @var	string
	 */
	protected $sqlSelects = '';
	
	/**
	 * Contains the group by clouse
	 * @var	string
	 */
	protected $sqlGroupBy = '';
	
	/**
	 * @see Module::__construct()
	 */
	public function __construct($pageID, $moduleID, $row = null) {
		$this->sqlSelects .= 'module.*,
							  page_module.name AS name';
		$this->sqlJoins .= "LEFT JOIN
								wcf".WCF_N."_page_module page_module
							ON
								page_module.moduleID = module.moduleID";
		
		// create sql conditions
		$sqlCondition = '';
		
		if ($pageID !== null and $moduleID !== null) {
			$sqlCondition .=  "module.pageID = ".$pageID." AND module.moduleID = ".$moduleID;
		}
		
		// execute sql statement
		if (!empty($sqlCondition)) {
			$sql = "SELECT 	".$this->sqlSelects."
				FROM 	wcf".WCF_N."_page_module_to_page module
					".$this->sqlJoins."
				WHERE 	".$sqlCondition.
					$this->sqlGroupBy;
			$row = WCF::getDB()->getFirstRow($sql);
		}
		
		// handle result set
		parent::__construct($row);
	}
	
	/**
	 * @see DatabaseObject::handleData()
	 */
	protected function handleData($data) {
		parent::handleData($data);
		
		if (!$this->pageID or !$this->moduleID) {
			$this->data['pageID'] = 0;
			$this->data['moduleID'] = 0;
		} else {
			$this->data['options'] = unserialize($this->data['options']);
		}
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
	 * @see Module::getTemplateName()
	 */
	public function getTemplateName() {
		return $this->templateName;
	}
	
	/**
	 * @see	Module::getACPTemplateName()
	 */
	public function getACPTemplateName() {
		return $this->acpTemplateName;
	}
	
	/**
	 * Wrapper for get class (Such as getPageID())
	 * @param	string	$name
	 * @param	array	$args
	 */
	public function __call($name, $args) {
		if (substr($name, 0, 3) == 'get') {
			$variable = substr($name, 3);
			$variable = strtolower($variable{0}).substr($variable, 1);
			return $this->{$variable};
		}
		
		throw new SystemException("method '".$name."' does not exist in class Page");
	}
}
?>