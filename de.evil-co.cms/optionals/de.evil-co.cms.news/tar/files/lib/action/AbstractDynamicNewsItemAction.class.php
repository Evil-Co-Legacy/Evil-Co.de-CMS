<?php
// wcf imports
require_once(WCF_DIR.'lib/action/AbstractAction.class.php');
require_once(WCF_DIR.'lib/data/dynamic/news/DynamicNewsItemEditor.class.php');

/**
 * Implements a abstract class that provides a default action for modifying items
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.news
 */
abstract class AbstractDynamicNewsItemAction {
	
	/**
	 * Contains the id of the item row
	 * @var	integer
	 */
	public $itemID = 0;
	
	/**
	 * Contains the DynamicNewsItemEditor
	 * @var DynamicNewsItemEditor
	 */
	public $item = null;
	
	/**
	 * Contains all needed permissions
	 * @var	mixed
	 */
	public $neededPermissions = '';
	
	/**
	 * @see	Action::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		// read parameters
		if (isset($_REQUEST['itemID'])) $this->itemID = intval($_REQUEST['itemID']);
		
		// create object
		$this->item = new DynamicNewsItemEditor($this->itemID);
		
		// validate
		if (!$this->item->itemID) throw new IllegalLinkException;
		
		// check permissions
		if (!empty($this->neededPermissions)) WCF::getUser()->checkPermission($this->neededPermissions);
	}
}
?>