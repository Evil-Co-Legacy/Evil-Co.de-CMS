<?php
// wcf imports
require_once(WCF_DIR.'lib/page/AbstractPage.class.php');

/**
 * Lists all files in CMS_DIR/cms_files
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.fileManager
 */
class FilemanagerListPage extends AbstractPage {
	
	/**
	 * @see AbstractPage::$templateName
	 */
	public $templateName = 'filemanagerList';
	
	/**
	 * Contains a list of all files in CMS_DIR/cms_files
	 * @var	RecursiveDirectoryIterator
	 */
	public $fileList = null;
	
	/**
	 * @see	Page::readData()
	 */
	public function readData() {
		parent::readData();

		// validate
		if (!is_dir(CMS_DIR.'cms_files/') or !is_readable(CMS_DIR.'cms_files')) throw new NamedUserException(WCF::getLanguage()->get('cms.filemanager.invalidDir'));
		
		$directory = DirectoryUtil::getInstance(CMS_DIR.'cms_files/');
		$this->fileList = $directory->getFilesObj();
	}
	
	/**
	 * @see Page::show()
	 */
	public function show() {
		// activate menu item
		WCFACP::getMenu()->setActiveMenuItem('wcf.acp.menu.link.content.filemanager.list');
		
		parent::show();
	}
	
	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'fileList'		=>	$this->fileList
		));
	}
}
?>