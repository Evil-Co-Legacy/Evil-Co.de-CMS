<?php
// wcf imports
require_once(WCF_DIR.'lib/action/AbstractDynamicNewsItemAction.class.php');

class NewsPageModuleItemDeleteAction extends AbstractDynamicNewsItemAction {
	
	/**
	 * @see	Action::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		// check permissions
		if ($this->item->authorID != WCF::getUser()->userID) WCF::getUser()->checkPermission('user.cms.news.canDeleteItems');
	}
	
	/**
	 * @see	Action::execute()
	 */
	public function execute() {
		parent::execute();
		
		// remove item
		DynamicNewsItemEditor::remove($this->itemID);
		
		// clear cache
		DynamicNewsItemEditor::clearCache($this->item->instanceID);
		
		// redirect
		if (!empty(WCF::getSession()->lastRequestURI))
			HeaderUtil::redirect(WCF::getSession()->lastRequestURI);
		else
			HeaderUtil::redirect('index.php?page=Index');
		
		// call event
		$this->executed();
	}
}
?>