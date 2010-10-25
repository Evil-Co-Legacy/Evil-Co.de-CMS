<?php

/**
 * This class defines some basic functions for modules
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 */
interface Module {
	/**
	 * Defines the template that should displayed
	 * @var string
	 */
	// public $templateName;
	
	/**
	 * Defines needed permission(s)
	 * @var mixed (string/array)
	 */
	// public $neededPermissions;
	
	/**
	 * Defines custom stylesheet files that should included
	 * @var string
	 */
	// public $stylesheet;
	
	/**
	 * Defines custom head contents that should show up in html code
	 * @var string
	 */
	// public $additionalHeadContents;
	
	/**
	 * Creates a new Module object
	 * @param	integer	$pageID
	 */
	public function __construct($pageID);
	
	/**
	 * Reads parameters from url (or other sources)
	 */
	public function readParameters();
	
	/**
	 * Reads data for module
	 */
	public function readData();
	
	/**
	 * Assignes variables to template
	 */
	public function assignVariables();
	
	/**
	 * Checks needed permissions
	 */
	public function checkPermissions();
	
	/**
	 * Returnes the template name
	 */
	public function display();
	
	/**
	 * Returnes the content of $variable
	 * @param	string	$variable
	 */
	public function __get($variable);
}
?>