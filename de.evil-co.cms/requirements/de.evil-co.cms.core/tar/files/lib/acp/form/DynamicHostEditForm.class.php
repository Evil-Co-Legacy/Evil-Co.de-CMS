<?php
// wcf imports
require_once(WCF_DIR.'lib/acp/form/DynamicHostAddForm.class.php');

/**
 * Implements a form that edits a host row
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 */
class DynamicHostEditForm extends DynamicHostAddForm {
	
	/**
	 * @see	Page::$action
	 */
	public $action = "edit";
	
	/**
	 * Contains the ID of the host row that should edited
	 * @var	integer
	 */
	public $hostID = 0;
	
	/**
	 * Contains the object that represents the row that should edited
	 * @var	Host
	 */
	public $host = null;
	
	/**
	 * @see	Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['hostID'])) $this->hostID = intval($_REQUEST['hostID']);
		
		// create host object
		$this->host = new HostEditor($this->hostID);
		
		// validate host
		if (!$this->host->hostID) throw new IllegalLinkException;
	}
	
	/**
	 * @see	Page::readData()
	 */
	public function readData() {
		parent::readData();
		
		// load form values
		$this->title = $this->host->title;
		$this->hostname = $this->host->hostname;
		$this->isFallback = $this->host->isFallback;
		$this->languageCode = $this->host->languageCode;
	}
	
	/**
	 * @see	Form::save()
	 */
	public function save() {
		ACPForm::save();
		
		// read form data
		$this->host->title = $this->title;
		$this->host->hostname = $this->hostname;
		$this->host->isFallback = $this->isFallback;
		$this->host->languageCode = $this->languageCode;
		
		// save
		$this->host->update();
		
		// show success message
		WCF::getTPL()->assign('success', true);
		
		// call event
		$this->saved();
	}
	
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'host'			=>	$this->host,
			'hostID'		=>	$this->hostID
		));
	}
}
?>