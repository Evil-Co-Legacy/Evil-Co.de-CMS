<?php
// wcf imports
require_once(WCF_DIR.'lib/form/NewsPageModuleItemAddForm.class.php');

/**
 * Implements a form for creating a news item
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.news
 */
class NewsModuleItemEditForm extends NewsPageModuleItemAddForm {
	
	/**
	 * Contains the item ID of the item that should edited
	 * @var	integer
	 */
	public $itemID = 0;
	
	/**
	 * Contains the editor object for the item that should edited
	 * @var	DynamicNewsItemEditor
	 */
	public $item = null;
	
	/**
	 * @see	Page::readParameters()
	 */
	public function readParameters() {
		MessageForm::readParameters();
		
		// read query arguments
		if (isset($_REQUEST['itemID'])) $this->itemID = intval($_REQUEST['itemID']);
		
		// create item object
		$this->item = new DynamicNewsItemEditor($this->itemID);
		
		// validate item
		if (!$this->item->itemID) throw new IllegalLinkException;
		
		// check permissions
		if ($this->item->authorID == 0 or $this->item->authorID != WCF::getUser()->userID) WCF::getUser()->checkPermission('user.cms.news.canEditItems');
	}
	
	/**
	 * @see	Page::readData()
	 */
	public function readData() {
		MessageForm::readData();
		
		// read variables from object
		$this->subject = $this->item->subject;
		$this->text = $this->item->text;
		$this->enableSmilies = $this->item->enableSmilies;
		$this->enableHtml = $this->item->enableHtml;
		$this->enableBBCodes = $this->item->enableBBCodes;
	}
	
	/**
	 * @see	Form::save()
	 */
	public function save() {
		MessageForm::save();
		
		// update item
		$this->item->update($this->subject, $this->text, $this->enableSmilies, $this->enableHtml, $this->enableBBCodes, TIME_NOW, $this->username, ($this->item->editCount + 1), $this->item->timestamp, $this->item->authorID, $this->item->username, $this->item->isPublic, $this->item->isDeleted);
		
		// clear cache
		DynamicNewsItemEditor::clearCache($this->item->instanceID);
		
		// redirect
		if (!empty(WCF::getSession()->lastRequestURI))
			HeaderUtil::redirect(WCF::getSession()->lastRequestURI.'#newsPageModule'.$this->item->instanceID.'Item'.$item->itemID);
		else
			HeaderUtil::redirect('index.php?page=Index');
	}
	
	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		MessageForm::assignVariables();
		
		WCF::getTPL()->assign(array(
			'itemID'		=>	$this->itemID,
			'item'			=>	$this->item,
			'action'		=>	'edit'
		));
	}
}
?>