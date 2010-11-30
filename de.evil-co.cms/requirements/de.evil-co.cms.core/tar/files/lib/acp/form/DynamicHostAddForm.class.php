<?php
// wcf imports
require_once(WCF_DIR.'lib/acp/form/ACPForm.class.php');
require_once(WCF_DIR.'lib/data/host/HostEditor.class.php');
require_once(WCF_DIR.'lib/system/language/Language.class.php');

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
	public $languageID = 0;
	
	/**
	 * Contains all available languages
	 * @var	array
	 */
	public $availableLanguages = array();
	
	/**
	 * Contains the new host object
	 * @var	HostEditor
	 */
	public $newHost = null;
	
	/**
	 * @see	Page::readData()
	 */
	public function readData() {
		parent::readData();
		
		$this->availableLanguages = WCF::getLanguage()->getAvailableLanguageCodes();
		$this->languageID = WCF::getLanguage()->getLanguageID();
	}
	
	/**
	 * @see	Form::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		if (isset($_REQUEST['title'])) $this->title = StringUtil::trim($_REQUEST['title']);
		if (isset($_REQUEST['hostname'])) $this->hostname = StringUtil::trim($_REQUEST['hostname']);
		if (isset($_REQUEST['isFallback'])) $this->isFallback = (bool) intval($_REQUEST['isFallback']);
		if (isset($_REQUEST['languageID'])) $this->languageID = intval($_REQUEST['languageID']);
	}
	
	/**
	 * @see	Form::validate()
	 */
	public function validate() {
		parent::validate();
		
		// validate title
		if (empty($this->title)) throw new UserInputException('title');
		
		// validate languageID
		if (!isset($this->availableLanguages[$this->languageID])) throw new UserInputException('languageID', 'invalid');
		
		// validate hostname
		if (empty($this->hostname)) throw new UserInputException('hostname', 'empty');
		if (!preg_match('~(.*)\.(.*)~', $this->hostname) and $this->hostname != 'localhost') throw new UserInputException('hostname', 'invalid'); // Basic domain name check for DAUs
	}
	
	/**
	 * @see	Form::save()
	 */
	public function save() {
		parent::save();
		
		// create host
		$this->newHost = HostEditor::create($this->title, $this->hostname, false, $this->isFallback, $this->languageID);
		
		// reset fields
		$this->title = $this->hostname = '';
		$this->languageID = 0;
		$this->isFallback = false;
		
		// display success field
		WCF::getTPL()->assign('success', true);
		
		// remove cache
		HostEditor::clearCache();
		
		// call event
		$this->saved();
	}
	
	/**
	 * @see Page::show()
	 */
	public function show() {
		// enable acpmenu entry
		WCFACP::getMenu()->setActiveMenuItem('wcf.acp.menu.link.content.host.add');
		
		parent::show();
	}
	
	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'title'					=>	$this->title,
			'hostname'				=>	$this->hostname,
			'isFallback'			=>	$this->isFallback,
			'languageID'			=>	$this->languageID,
			'availableLanguages'	=>	$this->availableLanguages
		));
	}
}
?>