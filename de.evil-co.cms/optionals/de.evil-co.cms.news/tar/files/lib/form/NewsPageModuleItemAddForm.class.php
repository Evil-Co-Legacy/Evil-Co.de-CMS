<?php
// wcf imports
require_once(WCF_DIR.'lib/form/MessageForm.class.php');
require_once(WCF_DIR.'lib/data/attachment/MessageAttachmentListEditor.class.php');
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
	 * @var	DynamicNewsItemEditor
	 */
	public $instance = null;
	
	/**
	 * Contains the attachment list editor
	 * @var	MessageAttachmentListEditor
	 */
	public $attachmentListEditor = null;
	
	/**
	 * @see	MessageForm::$useCaptcha
	 */
	public $useCaptcha = true;
	
	/**
	 * @see	MessageForm:$showPoll;
	 */
	public $showPoll = false;
	
	/**
	 * @see	MessageForm::$showSignatureSetting
	 */
	public $showSignatureSetting = false;
	
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
	 * @see	Form::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		if (isset($_POST['username'])) $this->username = StringUtil::trim($_POST['username']);
	}
	
	/**
	 * @see	Form::submit()
	 */
	public function submit() {
		// call submit event
		EventHandler::fireAction($this, 'submit');
		
		try {
			// attachment handling
			if ($this->showAttachments) $this->attachmentListEditor->handleRequest();
			
			// send message or save as draft
			if ($this->send) {
				$this->validate();
				
				// no errors
				$this->save();
			}
		} catch (UserInputException $e) {
			$this->errorField = $e->getField();
			$this->errorType = $e->getType();
		}
	}
	
	/**
	 * @see	Form::validate()
	 */
	public function validate() {
		parent::validate();
		
		// only for guests
		if (WCF::getUser()->userID == 0) {
			// username
			if (empty($this->username)) {
				throw new UserInputException('username');
			}
			if (!UserUtil::isValidUsername($this->username)) {
				throw new UserInputException('username', 'notValid');
			}
			if (!UserUtil::isAvailableUsername($this->username)) {
				throw new UserInputException('username', 'notAvailable');
			}
			
			WCF::getSession()->setUsername($this->username);
		} else {
			$this->username = WCF::getUser()->username;
		}
	}
	
	/**
	 * @see	Form::save()
	 */
	public function save() {
		parent::save();
		
		// create entry
		$item = DynamicNewsItemEditor::create($this->instanceID, $this->subject, $this->text, $this->enableSmilies, $this->enableHtml, $this->enableBBCodes, 0, '', 0, TIME_NOW, $this->user->userID, $this->user->username, false, true, $this->attachmentListEditor);
		
		// clear cache
		DynamicNewsItemEditor::clearCache($this->instanceID);
		
		// redirect
		if (!empty(WCF::getSession()->lastRequestURI))
			HeaderUtil::redirect(WCF::getSession()->lastRequestURI.'#newsPageModule'.$this->instanceID.'Item'.$item->itemID);
		else
			HeaderUtil::redirect('index.php?page=Index');
	}
	
	/**
	 * @see	Page::show()
	 */
	public function show() {
		if (MODULE_ATTACHMENT != 1) $this->showAttachments = false;
		
		// get attachments editor
		if ($this->attachmentListEditor == null) $this->attachmentListEditor = new MessageAttachmentListEditor(array(), 'newsItem', PACKAGE_ID, WCF::getUser()->getPermission('user.cms.news.maxAttachmentSize'), WCF::getUser()->getPermission('user.cms.news.allowedAttachmentExtensions'), WCF::getUser()->getPermission('user.cms.news.maxAttachmentCount'));
		
		parent::show();
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