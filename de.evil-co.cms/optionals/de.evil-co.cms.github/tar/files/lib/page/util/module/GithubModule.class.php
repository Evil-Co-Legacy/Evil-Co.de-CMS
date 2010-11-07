<?php
// wcf imports
require_once(WCF_DIR.'lib/page/util/module/AbstractModule.class.php');

/**
 * Implements a module class that lists github commits
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.github
 */
class GithubModule extends AbstractModule {
	
	/**
	 * @see	AbstractModule::$templateName
	 */
	public $templateName = 'githubPageModule';
	
	/**
	 * @see AbstractModule::$acpTemplateName
	 */
	public $acpTemplateName = 'githubPageModule';

	/**
	 * Contains commits
	 * @var	array
	 */
	public $commits = array();
	
	/**
	 * Contains the API url
	 * @var	string
	 */
	public $apiUrl = '';
	
	/**
	 * Contains api errors
	 * @var	string
	 */
	public $apiError = '';
	
	public $noJS = false;
	
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['noJS'])) $this->noJS = true;
	}
	
	/**
	 * @see	AbstractModule::readData()
	 */
	public function readData() {
		parent::readData();
		
		if (!$this->noJS) {
			// add additional head contents
			$this->additionalHeadContents = '<script type="text/javascript" src="'.RELATIVE_WCF_DIR.'js/githubPageModule.js"></script>';
		} else {
			// generate api url
			$this->generateAPIUrl($this->getOptions()->getGroup('general')->getOption('username')->getValue(), $this->getOptions()->getGroup('general')->getOption('repository')->getValue(), $this->getOptions()->getGroup('general')->getOption('branch')->getValue());
			
			// read commits from api
			$this->readCommits();
		}
	}
	
	/**
	 * Generates the api url
	 * @param	string	$username
	 * @param	string	$repository
	 * @param	string	$branch
	 */
	public function generateAPIUrl($username, $repository, $branch = 'master') {
		$this->apiUrl = 'http://github.com/api/v2/xml/commits/list/'.$username.'/'.$repository.'/'.$branch;
	}
	
	/**
	 * Reads all commits from API
	 */
	public function readCommits() {
		// read cache (10 min cache)
		WCF::getCache()->addResource('githubPageModule-'.$this->instanceID, WCF_DIR.'cache/cache.githubPageModule-'.$this->instanceID.'.php', WCF_DIR.'lib/system/cache/CacheBuilderGithubPageModule.class.php', 0, 600);
		list($this->commits, $this->apiError) = WCF::getCache()->get('githubPageModule-'.$this->instanceID);
	}
}
?>