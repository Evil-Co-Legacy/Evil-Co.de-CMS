<?php
// wcf imports
require_once(WCF_DIR.'lib/page/util/module/AbstractModule.class.php');

/**
 * Implements a module class that provides a users online list for dynamic pages
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.usersOnlineList
 */
class UsersOnlineListModule extends AbstractModule {
	
	/**
	 * @see	AbstractModule::$templateName
	 */
	public $templateName = 'usersOnlineListPageModule';
	
	/**
	 * @see	Module::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		if (MODULE_USERS_ONLINE) {
			require_once(WCF_DIR.'lib/data/user/usersOnline/UsersOnlineList.class.php');
			$usersOnlineList = new UsersOnlineList('', true);
			$usersOnlineList->renderOnlineList();
		}
	}
}
?>