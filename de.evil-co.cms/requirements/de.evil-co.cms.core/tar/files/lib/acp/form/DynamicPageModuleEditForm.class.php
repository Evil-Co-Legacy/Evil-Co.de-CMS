<?php
// wcf imports
require_once(WCF_DIR.'lib/acp/form/DynamicPageModuleAddForm.class.php');
require_once(WCF_DIR.'lib/page/util/module/InstanceableModule.class.php');

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
	 * Contains the object that represents this instance
	 * @var	InstanceableModule
	 */
	public $instance = null;
	
	/**
	 * Contains the ModuleOptionGroupList for this module
	 * @var	ModuleOptionGroupList
	 */
	public $optionGroupList = null;
	
	/**
	 * @see	Form::readParameters()
	 */
	public function readParameters() {
		WysiwygCacheloaderForm::readParameters();
		
		// read parameters
		if (isset($_REQUEST['instanceID'])) $this->instanceID = intval($_REQUEST['instanceID']);
		
		// create instance 
		$this->instance = new InstanceableModule($this->instanceID);
		
		// validate instance
		if (!$this->instance->instanceID) throw new IllegalLinkException;
		
		// write group option list
		$this->optionGroupList = $this->instance->options;
		
		// write pageID
		$this->pageID = $this->instance->pageID;
	}
	
	/**
	 * @see	Form::readFormParameters()
	 */
	public function readFormParameters() {
		WysiwygCacheloaderForm::readFormParameters();
		
		// loop through array
		foreach($_POST as $name => $value) {
			if (is_array($value)) {
				foreach($value as $optionName => $optionValue) {
					// validate 
					if ($this->optionGroupList->getGroup($name)->getOption($optionName)->getType() == 'select') {
						$validValues = array();
						foreach($this->optionGroupList->getGroup($name)->getOption($optionName)->getFields() as $field) {
							$validValues[] = $field['value'];
						}
						
						if (!in_array($optionValue, $validValues)) continue;
					}
					
					$this->optionGroupList->setOption($name, $optionName, $optionValue);
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
		WysiwygCacheloaderForm::validate();
	}
	
	/**
	 * @see	Form::save()
	 */
	public function save() {
		WysiwygCacheloaderForm::save();
		
		// save options
		$sql = "UPDATE
					wcf".WCF_N."_page_module_to_page
				SET
					options = '".escapeString(serialize($this->optionGroupList))."'
				WHERE
					instanceID = ".$this->instanceID;
		WCF::getDB()->sendQuery($sql);
		
		// remove cache
		WCF::getCache()->clear(WCF_DIR.'cache/', 'cache.pageModules-'.$this->pageID.'-'.PACKAGE_ID.'.php');
		
		// display success message
		WCF::getTPL()->assign('success', true);
		
		// call event
		$this->saved();
	}
	
	/**
	 * @see	Form::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'options'				=>		$this->optionGroupList,
			'instanceID'			=>		$this->instanceID,
			'instance'				=>		$this->instance
		));
	}
}
?>