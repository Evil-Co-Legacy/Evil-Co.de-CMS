<?php
// wcf imports
require_once(WCF_DIR.'lib/acp/package/plugin/AbstractXMLPackageInstallationPlugin.class.php');

/**
 * Implements a class for the page module package installation plugin (PiP)
 * @author		Johannes Donath
 * @copyright	2010 Punksoft
 * @package		de.evil-co.cms
 * @subpackage	de.evil-co.cms.core
 * @version		1.0.0
 */
class PageModulePackageInstallationPlugin extends AbstractXMLPackageInstallationPlugin {
	public $tagName = 'pagemodule';
	public $tableName = 'page_module';

    /**
     * @see PackageInstallationPlugin::install()
     */
    public function install() {
		parent::install();
	
		if (!$xml = $this->getXML()) {
			return;
		}
	
		// Create an array with the data blocks (import or delete) from the xml file.
		$validateServerXML = $xml->getElementTree('data');
	
		// Loop through the array and install or uninstall items.
		foreach ($validateServerXML['children'] as $key => $block) {
		    if (count($block['children'])) {
				// Handle the import instructions
				if ($block['name'] == 'import') {
				    // Loop through items and create or update them.
				    foreach ($block['children'] as $module) {
						// Extract item properties.
						foreach ($module['children'] as $child) {
						    if (!isset($child['cdata'])) continue;
						    $module[$child['name']] = $child['cdata'];
						}
			
						// default values
						$fileName = '';
			
						// get values
						if (isset($module['filename'])) $fileName = $module['filename'];
			
						if (empty($fileName)) {
						    throw new SystemException("Required 'filename' attribute is missing", 13023);
						}
			
						$sql = "INSERT INTO
									wcf".WCF_N."_page_module(packageID, fileName)
								VALUES (".$this->installation->getPackageID().",
										'".escapeString($fileName)."')";
						WCF::getDB()->sendQuery($sql);
					}
				}
		
				// Handle the delete instructions.
				else if ($block['name'] == 'delete' && $this->installation->getAction() == 'update') {
				    // Loop through items and delete them.
				    $nameArray = array();
				    foreach ($block['children'] as $module) {
						// Extract item properties.
						foreach ($module['children'] as $child) {
						    if (!isset($child['cdata'])) continue;
						    $module[$child['name']] = $child['cdata'];
						}
				
						if (empty($module['filename'])) {
						    throw new SystemException("Required 'filename' attribute is missing", 13023);
						}
						
						$nameArray[] = $module['typename'];
				    }
				    
				    if (count($nameArray)) {
						$sql = "DELETE FROM
							    	wcf".WCF_N."_page_module
								WHERE
							    	packageID = ".$this->installation->getPackageID()."
								AND
							    	fileName IN ('".implode("','", array_map('escapeString', $nameArray))."')";
						WCF::getDB()->sendQuery($sql);
				    }
				}
			}
    	}
    }
}
?>