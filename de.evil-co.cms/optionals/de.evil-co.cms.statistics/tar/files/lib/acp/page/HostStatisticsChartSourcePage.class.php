<?php
// wcf imports
require_once(WCF_DIR.'lib/page/AbstractOpenFlashChartSourcePage.class.php');

/**
 * Reads data from database and formates it for charts
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 */
class HostStatisticsChartSourcePage extends AbstractOpenFlashChartSourcePage {
	
	/**
	 * Contains the type of chart
	 * @var	string
	 */
	public $type = 'pie';
	
	/**
	 * @see	Page::readData()
	 */
	public function readData() {
		parent::readData();
		
		// create chart object
		$this->data = new OpenFlashChart(WCF::getLanguage()->get('cms.acp.statistics.chart.host.title'));
		
		// create element
		$element = new OpenFlashChartElement($this->type);
		
		// set special options
		$element->tip = WCF::getLanguage()->get('cms.acp.statistics.chart.host.tip');
		
		// read data from db
		$sql = "SELECT
					stats.requestCount AS requestCount,
					host.title AS title
				FROM
					cms".CMS_N."_statistic_host stats
				LEFT JOIN
					wcf".WCF_N."_host host
				ON
					stats.hostID = host.hostID";
		$result = WCF::getDB()->sendQuery($sql);
		
		$items = array();
		
		// get available colours
		$colours = array();
		
		while($row = WCF::getDB()->fetchArray($result)) {
			$colours[] = "#".substr(sha1($row['title']), 0, 6);
			$items[] = $row;
		}
		
		// add colours to element
		$element->colours = $colours;
		
		// load data
		foreach($items as $row) {
			switch($this->type) {
				case 'pie':
					$element->addValue(intval($row['requestCount']), $row['title']);
					break;
			}
		}
		
		// add element to chart
		$this->data->addElement($element);
	}
}
?>