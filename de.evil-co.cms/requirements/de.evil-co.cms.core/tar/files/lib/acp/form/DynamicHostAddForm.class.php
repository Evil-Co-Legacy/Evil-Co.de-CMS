<?php
// wcf imports
require_once(WCF_DIR.'lib/acp/form/ACPForm.class.php');
require_once(WCF_DIR.'lib/data/host/HostEditor.class.php');

/**
 * Implements a form that adds a new host to database
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms
 */
class DynamicHostAddForm extends ACPForm {
	
	/**
	 * @see Page::$templateName
	 */
	public $templateName = 'dynamicHostAdd';
	
	/**
	 * @see	Page::$action
	 */
	public $action = 'add';
	
	/**
	 * @see	Page::$neededPermissions
	 */
	public $neededPermissions = 'admin.content.cms.canAddHosts';
	
	/**
	 * Contains the title for the new host
	 * @var	string
	 */
	public $title = '';
	
	/**
	 * Contains the hostname for the new host
	 * @var	string
	 */
	public $hostname = '';
	
	/**
	 * This is set to true if all pages in this host should displayed if no hostname matches
	 * @var	boolean
	 */
	public $isFallback = false;
	
	/**
	 * Contains the language code for the new host
	 * @var	string
	 */
	public $languageCode = '';
	
	/**
	 * @see	Form::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		if (isset($_REQUEST['title'])) $this->title = StringUtil::trim($_REQUEST['title']);
		if (isset($_REQUEST['hostname'])) $this->hostname = StringUtil::trim($_REQUEST['hostname']);
		if (isset($_REQUEST['isFallback'])) $this->isFallback = (bool) intval($_REQUEST['isFallback']);
		if (isset($_REQUEST['languageCode'])) $this->languageCode = StringUtil::trim($_REQUEST['languageCode']);
	}
	
	/**
	 * @see	Form::validate()
	 */
	public function validate() {
		parent::validate();
		
		// validate title
		if (empty($this->title)) throw new UserInputException('title');
		
		// validate hostname
		if (empty($this->hostname)) throw new UserInputException('hostname', 'empty');
		if (!preg_match('~(.*)\.(.*)~', $this->hostname)) throw new UserInputException('hostname', 'invalid'); // Basic domain name check for DAUs
		
		// validate language code
		if (empty($this->languageCode)) throw new UserInputException('languageCode');
	}
	
	/**
	 * @see	Form::save()
	 */
	public function save() {
		parent::save();
		
		// create host
		HostEditor::create($this->title, $this->hostname, false, $this->isFallback, $this->languageCode);
		
		// reset fields
		$this->title = $this->hostname = $this->languageCode = '';
		$this->isFallback = false;
		
		// display success field
		WCF::getTPL()->assign('success', true);
		
		// call event
		$this->saved();
	}
	
	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'title'			=>	$this->title,
			'hostname'		=>	$this->hostname,
			'isFallback'	=>	$this->isFallback,
			'languageCode'	=>	$this->languageCode
		));
	}
}
?>