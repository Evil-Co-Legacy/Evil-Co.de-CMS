<?php

/**
 * Represents an option group of a module
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.core
 */
class ModuleOptionGroup {
	
	/**
	 * Contains the name of this group
	 * @var	string
	 */
	protected $name = '';
	
	/**
	 * Contains all options of this group
	 * @var	array
	 */
	protected $options = array();

	/**
	 * Creates a new instance of ModuleOptionGroup
	 * @param	string	$name
	 * @param	array	$options
	 */
	public function __construct($name, $options) {
		$this->name = $name;
		$this->options = $options;
	}
	
	/**
	 * Returnes the name of this group
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * Returnes all options of this group
	 */
	public function getOptions() {
		return $this->options;
	}
	
	/**
	 * Returnes the option with name $name
	 * @param	string	$name
	 */
	public function getOption($name) {
		foreach($this->options as $key => $option) {
			if ($this->options[$key]->getName() == $name) return &$this->options[$key];
		}
		return false;
	}
}
?>