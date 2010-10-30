<?php
// wcf imports
require_once(WCF_DIR.'lib/acp/form/DynamicPageModuleAddForm.class.php');

/**
 * Implements a form that edits settings of a module
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.core
 */
class DynamicPageModuleEditForm extends DynamicPageModuleAddForm {
	
	/**
	 * @see	Page::$action
	 */
	public $action = 'edit';
	
	/**
	 * Contains the instance id that should edited
	 * @var	integer
	 */
	public $instanceID = 0;
	
	/**
	 * Contains the ModuleOptionGroupList for this module
	 * @var	ModuleOptionGroupList
	 */
	public $optionGroupList = null;
	
	/**
	 * @see	Form::readParameters()
	 */
	public function readParameters() {
		ACPForm::readParameters();
		
		if (isset($_REQUEST['instanceID'])) $this->instanceID = intval($_REQUEST['instanceID']);
		
		if (!isset($_REQUEST['instanceID'])) throw new IllegalLinkException;
	}
	
	/**
	 * @see Page::readData()
	 */
	public function readData() {
		$sql = "SELECT
					*
				FROM
					wcf".WCF_N."_page_module_to_page
				WHERE
					instanceID = ".$this->instanceID;
		$instance = WCF::getDB()->getFirstRow($sql);
		
		$this->pageID = $instance['pageID'];
		
		// validate row
		if ($instance['instanceID'] != $this->instanceID) throw new IllegalLinkException;
		
		// write options
		$this->optionGroupList = unserialize($instance['options']);
		
		ACPForm::readData();
	}
	
	/**
	 * @see	Form::readFormParameters()
	 */
	public function readFormParameters() {
		ACPForm::readFormParameters();
		
		// loop through array
		foreach($_POST as $name => $value) {
			if (is_array($value)) {
				foreach($value as $optionName => $optionValue) {
					if ($this->optionGroupList->getGroup($name) !== false) {
						if ($this->optionGroupList->getGroup($name)->getOption($optionName) !== false) {
							$group = &$this->optionGroupList->getGroup($name);
							$option = &$group->getOption($optionName);
							$option->setValue($optionValue);
						}
					}
				}
			}
		}
		
		// set not sent boolean values to false
		foreach($this->optionGroupList->getOptionGroups() as $group) {
			$groupName = $group->getName();
			
			foreach($group->getOptions() as $option) {
				$optionName = $option->getName();
				if ($option->getType() == 'boolean') {
					if (!isset($_POST[$groupName][$optionName])) $this->optionGroupList->getGroup($groupName)->getOption($optionName)->setValue(0);
				}
			}
		}
	}
	
	/**
	 * @see	Form::validate()
	 */
	public function validate() {
		ACPForm::validate();
	}
	
	/**
	 * @see	Form::save()
	 */
	public function save() {
		ACPForm::save();
		
		// save options
		$sql = "UPDATE
					wcf".WCF_N."_page_module_to_page
				SET
					options = ".serialize($this->optionGroupList)."
				WHERE
					instanceID = ".$this->instanceID;
		WCF::getDB()->sendQuery($sql);
		
		// remove cache
		WCF::getCache()->clear(WCF_DIR.'cache/', 'cache.pageModules-'.$this->pageID.'-'.PACKAGE_ID.'.php');
		
		// display success message
		WCF::getTPL()->assign('success');
		
		// call event
		$this->executed();
	}
	
	/**
	 * @see	Form::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'options'		=>		$this->optionGroupList,
			'instanceID'	=>		$this->instanceID
		));
	}
}
?>