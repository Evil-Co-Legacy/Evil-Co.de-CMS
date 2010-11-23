<?php
// wcf imports
require_once(WCF_DIR.'lib/page/util/module/AbstractModule.class.php');

/**
 * Integrates a teaser box
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.teaser
 */
class GithubModule extends AbstractModule {
	
	/**
	 * @see	AbstractModule::$templateName
	 */
	public $templateName = 'teaserPageModule';
	
	/**
	 * @see AbstractModule::$acpTemplateName
	 */
	public $acpTemplateName = 'teaserPageModule';
	
	/**
	 * @see AbstractModule::$stylesheet
	 */
	public $stylesheet = 'teaserBox.css';
	
	/**
	 * @see AbstractModule::$additionalheadContents
	 */
	public $additionalHeadContents = '<!--[if lt IE 8]>
											<style type="text/css">
												ul.teaserBoxTeaser li {
													
												}
												ul.teaserBoxNavigation {
													display: none;
												}
												ul.teaserBoxNavigation li.activeTeaser {
													padding-right: 0;
												    padding-left: 10px;
												    margin-left: -10px !important;
												}
												</style>
												<![endif]-->
												<!--[if IE 6]>
												<style type="text/css">
												ul.teaserBoxNavigation li.activeTeaser {
												    padding-left: 10px;
												}
												ul.teaserBoxNavigation li {
													margin-right: -20px;
												}
											</style>
										<![endif]-->';
	
	/**
	 * @see	Module::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->append('specialStyles',
			'<style type="text/css">
			<!--
			#teaser'.$this->instanceID.' .teaserBoxContent, ul.teaserBoxTeaser li a {
				height: '.$this->getOptions()->getGroup('general')->getOption('height')->getValue().'px;
			}
			#teaser'.$this->instanceID.' ul.teaserBoxNavigation li a span {
				color: '.$this->getOptions()->getGroup('general')->getOption('fontcolor')->getValue().';
			}
			#teaser'.$this->instanceID.' ul.teaserBoxNavigation li.activeTeaser a span {
				color: '.$this->getOptions()->getGroup('general')->getOption('fontcolorActive')->getValue().';
			}
			#teaser'.$this->instanceID.' ul.teaserBoxNavigation li.teaserNav {
				background-color: '.$this->getOptions()->getGroup('general')->getOption('backgroundColor')->getValue().';
			}
			#teaser'.$this->instanceID.' ul.teaserBoxNavigation li.activeTeaser {
				background-color: '.$this->getOptions()->getGroup('general')->getOption('backgroundColorActive')->getValue().';
			}
			-->
			</style>'
		);
	}
}
?>