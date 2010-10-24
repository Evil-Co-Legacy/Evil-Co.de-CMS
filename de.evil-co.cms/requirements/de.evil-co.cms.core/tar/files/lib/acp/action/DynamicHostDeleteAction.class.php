<?php
// wcf imports
require_once(WCF_DIR.'lib/action/AbstractAction.class.php');
require_once(WCF_DIR.'lib/data/host/HostEditor.class.php');
require_once(WCF_DIR.'lib/data/dynamic/page/DynamicPageEditor.class.php');

class DynamicHostDeleteAction extends AbstractAction {
	
	/**
	 * Contains the ID of the host row that should deleted
	 * @var	integer
	 */
	public $hostID = 0;
	
	/**
	 * Contains the object that represents the host row that should deleted
	 * @var	HostEditor
	 */
	public $host = null;
	
	/**
	 * @see	Action::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['hostID'])) $this->hostID = intval($_REQUEST['hostID']);
		
		// create editor object
		$this->host = new HostEditor($this->hostID);
		
		// validate
		if (!$this->host->hostID) throw new IllegalLinkException;
	}
	
	/**
	 * @see	Action::execute()
	 */
	public function execute() {
		parent::execute();
		
		// remove host
		HostEditor::remove($this->hostID);
		DynamicPageEditor::removeFromHost($this->hostID);
		
		// send redirect headers
		HeaderUtil::redirect('index.php?page=DynamicHostList&packageID='.PACKAGE_ID.SID_ARG_2ND_NOT_ENCODED);
		
		// execute event
		$this->executed();
	}
}
?>