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
	 * Contains a list of all dirs
	 */
	public $dirObjects = array();
	
	/**
	 * @see	Page::readData()
	 */
	public function readData() {
		parent::readData();

		// validate
		if (!is_dir(CMS_DIR.'cms_files/') or !is_readable(CMS_DIR.'cms_files')) throw new NamedUserException(WCF::getLanguage()->get('cms.filemanager.invalidDir'));
		
		$directory = DirectoryUtil::getInstance(CMS_DIR.'cms_files/');
		$this->fileList = $directory->getFilesObj();
		
		foreach($this->fileList as $fileInfo) {
			if ($fileInfo->isDir()) $this->dirObjects[$fileInfo->getPathname()] = new RecursiveDirectoryIterator(FileUtil::addTrailingSlash($fileInfo->getPathname()));
		}
		print_r($this->dirObjects);
		
		// display warning if no htaccess file exists
		if (!file_exists(CMS_DIR.'cms_files/.htaccess')) WCF::getTPL()->assign('displayNoHtaccessWarning');
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
			'fileList'		=>	$this->fileList,
			'dirObjects'	=>	$this->dirObjects
		));
	}
}
?>