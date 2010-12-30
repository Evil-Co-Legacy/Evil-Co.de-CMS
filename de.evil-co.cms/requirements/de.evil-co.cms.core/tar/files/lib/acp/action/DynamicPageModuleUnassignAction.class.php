<?php
// wcf imports
require_once(WCF_DIR.'lib/action/AbstractAction.class.php');

/**
 * Implements an action that allows to sort modules via javascript
 *
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.core
 */
class DynamicPageModuleUnassignAction extends AbstractAction {
	
	/**
	 * Contains the instance ID that should deleted
	 *
	 * @var	integer
	 */
	public $instanceID = 0;
	
	/**
	 * @see	Action::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		// check permissions
		WCF::getUser()->checkPermission('admin.content.cms.canEditPages');
		
		if (isset($_REQUEST['instanceID'])) $this->instanceID = intval($_REQUEST['instanceID']);
	}
	
	/**
	 * @see	Action::execute()
	 */
	public function execute() {
		parent::execute();
		
		$sql = "SELECT
					pageID
				FROM
					wcf".WCF_N."_page_module_to_page
				WHERE
					instanceID = ".$this->instanceID;
		$page = WCF::getDB()->getFirstRow($sql);
		
		$sql = "DELETE FROM
					wcf".WCF_N."_page_module_to_page
				WHERE
					instanceID = ".$this->instanceID;
		WCF::getDB()->sendQuery($sql);
		
		// clear cache
		WCF::getCache()->clear(WCF_DIR.'cache/', 'cache.pageModules-'.$page['pageID'].'-'.PACKAGE_ID.'.php');
		
		// send redirect headers
		HeaderUtil::redirect('index.php?form=DynamicPageEdit&pageID='.$page['pageID'].'&packageID='.PACKAGE_ID.SID_ARG_2ND_NOT_ENCODED);
		
		// call event
		$this->executed();
	}
}
?>