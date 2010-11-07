<?php 
// wcf imports
require_once(WCF_DIR.'lib/system/cache/CacheBuilder.class.php');
require_once(WCF_DIR.'lib/page/util/module/InstanceableModule.class.php');

/**
 * Caches all commits for a github page module
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.github
 */
class CacheBuilderGithubPageModule implements CacheBuilder {
	
	/**
	 * @see CacheBuilder::getData()
	 */
	public function getData($cacheResource) {
		list($cache, $instanceID) = explode('-', $cacheResource['cache']);
		
		// create array (0 => commits, 1 => api errors)
		$data = array(0 => array(), 1 => '');
		
		// create instance
		$instance = new InstanceableModule($instanceID);
		
		// create api url
		$apiUrl = 'http://github.com/api/v2/xml/commits/list/'.$instance->getOptions()->getGroup('general')->getOption('username')->getValue().'/'.$instance->getOptions()->getGroup('general')->getOption('repository')->getValue().'/'.$instance->getOptions()->getGroup('general')->getOption('branch')->getValue();

		// download xml
		$filename = FileUtil::downloadFileFromHttp($apiUrl);
		
		// create new xml instance
		$xml = new XML($filename);
		
		// load tree
		$commitXML = $xml->getElementTree('commits');
		
		// check for errors
		if (isset($commitXML['children'][0]) and $commitXML['children'][0]['name'] == 'error') {
			$data[1] = $commitXML['children'][0]['cdata'];
			return $data;
		}
		
		// all ok .. loop througt array
		foreach($commitXML['children'] as $commit) {
			// create commit array
			$tmp = array('url' => 'https://github.com', 'id' => '', 'message' => '', 'author' => '', 'authorEmail' => '', 'date' => 0);
			
			// create information array
			$tmpInfo = array();
			
			// loop througt children
			foreach($commit['children'] as $child) {
				if ($child['name'] == 'commiter') {
					// create array for information
					$tmpInfo['commiter'] = array();
					
					// loop througt children
					foreach($child['children'] as $cChild) {
						// no cdata field found ... exit
						if (!isset($cChild['cdata'])) continue;
						
						// write value
						$tmpInfo['commiter'][$cChild['name']] = $cChild['cdata'];
					}
				}
				
				// no cdata field found ... exit
				if (!isset($child['cdata'])) continue;
				
				// write value
				$tmpInfo[$child['name']] = $child['cdata'];
			}
			
			// write values
			$tmp['url'] .= $tmpInfo['url'];
			$tmp['id'] = $tmpInfo['id'];
			$tmp['message'] = $tmpInfo['message'];
			$tmp['author'] = $tmpInfo['commiter']['name'];
			$tmp['authorEmail'] = $tmpInfo['commiter']['email'];
			$tmp['date'] = strtotime($tmpInfo['committed-date']);
			
			// write tmp array
			$data[0][] = $tmp;
			
			// remove old tmp array
			unset($tmp);
		}
		
		// return parsed commits
		return $data;
	}
}
?>