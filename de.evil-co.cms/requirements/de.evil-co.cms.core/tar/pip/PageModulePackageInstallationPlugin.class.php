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
		$XML = $xml->getElementTree('data');
	
		// Loop through the array and install or uninstall items.
		foreach ($XML['children'] as $key => $block) {
		    if (count($block['children'])) {
				// Handle the import instructions
				if ($block['name'] == 'import') {
				    // Loop through items and create or update them.
				    foreach ($block['children'] as $module) {
				    	$moduleInformation = $moduleOptions = $moduleOptionGroups = array();
				    	
						// Extract item properties.
						foreach ($module['children'] as $child) {
							if ($child['name'] == 'options') {
								foreach($child['children'] as $option) {
									$newOption = array('name' => '', 'optiontype' => '', 'defaultvalue' => '', 'cssclass' => '', 'group' => '', 'displaydescription' => true, 'fields' => '');
									
									// Extract option properties.
									foreach($option['children'] as $optionVar) {
										if (!isset($optionVar['cdata'])) continue;
										
										$newOption[$optionVar['name']] = $optionVar['cdata'];
									}
									
									// write option to options array
									$moduleOptions[] = $newOption;
									
									// remove temp array
									unset($newOption);
								}
								
								// exit loop
								continue;
							}
							
							if ($child['name'] == 'optiongroups') {
								foreach($child['children'] as $option) {
									$newOptionGroup = array('name' => '');
									
									// Extract option group properties.
									foreach($option['children'] as $optionVar) {
										if (!isset($optionVar['cdata'])) continue;
										
										$newOptionGroup[$optionVar['name']] = $optionVar['cdata'];
									}
									
									// write option group to option group array
									$moduleOptionGroups[] = $newOptionGroup;
									
									// remove temp array
									unset($newOptionGroup);
								}
								
								// exit loop
								continue;
							}
							
						    if (!isset($child['cdata'])) continue;
						    $moduleInformation[$child['name']] = $child['cdata'];
						}
			
						// default values
						$name = $file = '';
			
						// get values
						if (isset($moduleInformation['name'])) $name = $moduleInformation['name'];
						if (isset($moduleInformation['file'])) $file = $moduleInformation['file'];
			
						// validate xml input
						if (empty($name)) throw new SystemException("Required 'name' tag is missing", 13023);
						if (empty($file)) throw new SystemException("Required 'file' tag is missing", 13023);
			
						// include template editor
						require_once(WCF_DIR.'lib/data/dynamic/page/module/template/DynamicPageModuleTemplateEditor.class.php');
						
						// create module template
						$template = DynamicPageModuleTemplateEditor::create($name, $file, $this->installation->getPackageID());
						
						// clear cache
						DynamicPageModuleTemplateEditor::clearCache();
						
						// include group editor
						require_once(WCF_DIR.'lib/data/dynamic/page/module/option/group/DynamicPageModuleOptionGroupEditor.class.php');
						
						// create module option groups
						foreach($moduleOptionGroups as $group) {
							// validate group xml
							if (empty($group['name'])) throw new SystemException("Required 'name' tag is missing", 13023);
							
							// create group
							DynamicPageModuleOptionGroupEditor::create($group['name'], $template->moduleID);
						}
						
						// include option editor
						require_once(WCF_DIR.'lib/data/dynamic/page/module/option/DynamicPageModuleOptionEditor.class.php');
						
						// create module options
						foreach($moduleOptions as $option) {
							// validate option xml
							if (empty($option['name'])) throw new SystemException("Required 'name' tag is missing", 13023);
							if (empty($option['optiontype'])) throw new SystemException("Required 'optiontype' tag is missing", 13023);
							if (empty($option['group'])) throw new SystemException("Required 'group' tag is missing", 13023);
							
							// convert fields
							$option['displaydescription'] = (bool) intval($option['displaydescription']);
							
							// validate group
							if (($groupID = DynamicPageModuleOptionGroup::isValidGroup($option['group'], $template->moduleID)) === false) throw new SystemException("Unknown module option group '".$option['group']."'");
							
							// create option
							DynamicPageModuleOptionEditor::create($option['name'], $option['optiontype'], $option['defaultvalue'], $option['cssclass'], $option['displaydescription'], $option['fields'], $groupID, $template->moduleID);
						}
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
				
						// validate input
						if (empty($module['name'])) throw new SystemException("Required 'name' attribute is missing", 13023);
						
						$nameArray[] = $module['name'];
				    }
				    
				    if (count($nameArray)) {
				    	$sql = "SELECT
				    				moduleID
				    			FROM
				    				wcf".WCF_N."_page_module
				    			WHERE
				    				packageID = ".$this->installation->getPackageID()."
				    			AND
				    				name IN ('".implode("','", array_map('escapeString', $nameArray))."')";
				    	$result = WCF::getDB()->sendQuery($sql);
				    	
				    	// create needed variables
				    	$moduleIDs = array();
				    	
				    	// loop through modules
				    	while($row = WCF::getDB()->fetchArray($result)) {
				    		$moduleIDs[] = $row['moduleID'];
				    	}
				    	
				    	// remove options
				    	$sql = "DELETE FROM
				    				wcf".WCF_N."_page_module_option
				    			WHERE
				    				moduleID IN (".implode(',', $moduleIDs).")";
				    	WCF::getDB()->sendQuery($sql);
				    	
				    	// remove option groups
				    	$sql = "DELETE FROM
				    				wcf".WCF_N."_gpage_module_option_group
				    			WHERE
				    				moduleID IN (".implode(',', $moduleIDs).")";
				    	WCF::getDB()->sendQuery($sql); 
				    	
				    	// remove modules
						$sql = "DELETE FROM
							    	wcf".WCF_N."_page_module
								WHERE
				    				moduleID IN (".implode(',', $moduleIDs).")";
						WCF::getDB()->sendQuery($sql);
						
						// include template editor
						require_once(WCF_DIR.'lib/data/dynamic/page/module/template/DynamicPageModuleTemplateEditor.class.php');
						
						// clear cache
						DynamicPageModuleTemplateEditor::clearCache();
						
						// include dynamic page editor
						require_once(WCF_DIR.'lib/data/dynamic/page/DynamicPageEditor.class.php');
						
						// clear cache
						DynamicPageEditor::clearCache('*', '*');
				    }
				}
			}
    	}
    }
}
?>