<?php

/**
 * Represents a list of options groups
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.core
 */
class ModuleOptionGroupList {
	
	/**
	 * Contains a list of all groups
	 * @var	array
	 */
	protected $optionGroups = array();
	
	/**
	 * Creates a new instance of ModuleOptionGroupList
	 * @param	array	$optionGroups
	 */
	public function __construct($optionGroups) {
		$this->optionGroups = $optionGroups;
	}
	
	/**
	 * Returnes all option groups
	 */
	public function getOptionGroups() {
		return $this->optionGroups;
	}
	
	/**
	 * Returnes the group with name $name
	 * @param	string	$name
	 */
	public function getGroup($name) {
		foreach($this->optionGroups as $key => $group) {
			if ($this->optionGroups[$key]->getName() == $name) $group = &$this->optionGroups[$key];
		}
		if (isset($group)) return $group;
		return false;
	}
}
?>