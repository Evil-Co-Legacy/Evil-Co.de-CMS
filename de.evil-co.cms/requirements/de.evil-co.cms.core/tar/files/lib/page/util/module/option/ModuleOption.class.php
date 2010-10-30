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
	 * If this is set to false option's description will not appear
	 * @var	boolean
	 */
	protected $displayDescription = true;
	
	/**
	 * Contains all fields of this option (This is only used for selects)
	 * @var	array
	 */
	protected $fields = array();
	
	/**
	 * Creates a new instance of ModuleOptions
	 * @param	string	$name
	 * @param	string	$type
	 * @param	string	$value
	 * @param	string	$cssClass
	 */
	public function __construct($name, $type, $value = null, $cssClass = null, $displayDescription = true, $fields = '') {
		$this->name = $name;
		$this->type = $type;
		$this->value = $value;
		$this->cssClass = $cssClass;
		
		// get fields
		foreach(explode(';', $fields) as $field) {
			list($fieldName, $fieldValue) = explode(':', $field);
			$this->fields[] = array('name' => $fieldName, 'value' => $fieldValue);
		}
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
	
	/**
	 * Returnes the value of display description
	 */
	public function getDisplayDescription() {
		return $this->displayDescription;
	}
	
	/**
	 * Returnes all fields of this option (This field is only used for select fields)
	 */
	public function getFields() {
		return $this->fields;
	}
	
	/**
	 * Sets the value of this option
	 * @param	mixed	$value
	 */
	public function setValue($value) {
		$this->value = $value;
	}
}
?>