<?php
// wcf imports
require_once(WCF_DIR.'lib/form/MessageForm.class.php');
require_once(WCF_DIR.'lib/data/dynamic/news/DynamicNewsItemEditor.class.php');
require_once(WCF_DIR.'lib/page/util/module/NewsModule.class.php');

/**
 * Implements a form for creating a news item
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.news
 */
class NewsPageModuleItemAddForm extends MessageForm {
	
	/**
	 * @see AbstractPage::$templateName
	 */
	public $templateName = 'newsPageModuleItemAdd';
	
	/**
	 * Contains the instance ID of the module for that we should create an item
	 * @var	integer
	 */
	public $instanceID = 0;
	
	/**
	 * Contains the instance object of the module for that we should create an item
	 * @var unknown_type
	 */
	public $instance = null;
	
	/**
	 * @see	Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		// read query parameters
		if (isset($_REQUEST['instanceID'])) $this->instanceID = intval($_REQUEST['instanceID']);
		
		// create instance object
		$this->instance = new NewsModule($this->instanceID);
		
		// validate instance object
		if (!$this->instance->instanceID) throw new IllegalLinkException;
	}
	
	/**
	 * @see	Form::save()
	 */
	public function save() {
		parent::save();
		
		// create entry
		$item = DynamicNewsItemEditor::create($this->instanceID, $this->subject, $this->text, $this->enableSmilies, $this->enableHtml, $this->enableBBCodes, 0, '', 0, TIME_NOW, $this->user->userID, $this->user->username, false, true);
		
		// clear cache
		DynamicNewsItemEditor::clearCache($this->instanceID);
		
		// redirect
		if (!empty(WCF::getSession()->lastRequestURI))
			HeaderUtil::redirect(WCF::getSession()->lastRequestURI);
		else
			HeaderUtil::redirect('index.php?page=Index');
	}
	
	/**
	 * @see	Page::assginVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'action'		=>	'add',
			'instanceID'	=>	$this->instanceID
		));
	}
}
?>