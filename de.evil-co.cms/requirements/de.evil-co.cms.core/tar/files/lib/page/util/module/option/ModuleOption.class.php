<?php

/**
 * This class represents a module option
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.core
 */
class ModuleOption {
	
	/**
	 * Contains the name of this option
	 * @var	string
	 */
	protected $name = '';
	
	/**
	 * Contains the type of this option
	 * @var	string
	 */
	protected $type = 'text';
	
	/**
	 * Contains the value of this option
	 * @var	mixed
	 */
	protected $value = null;
	
	/**
	 * Contains the css class of this option
	 * @var	string
	 */
	protected $cssClass = null;
	
	/**
	 * Creates a new instance of ModuleOptions
	 * @param	string	$name
	 * @param	string	$type
	 * @param	string	$value
	 * @param	string	$cssClass
	 */
	public function __construct($name, $type, $value = null, $cssClass = null) {
		$this->name = $name;
		$this->type = $type;
		$this->value = $value;
		$this->cssClass = $cssClass;
	}
	
	/**
	 * Returnes the name of this option
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * Returnes the type of this option
	 */
	public function getType() {
		return $this->type;
	}
	
	/**
	 * Returnes the value of this option
	 */
	public function getValue() {
		return $this->value;
	}
	
	/**
	 * Returnes the css class for this option
	 */
	public function getCssClass() {
		return $this->cssClass;
	}
}
?>