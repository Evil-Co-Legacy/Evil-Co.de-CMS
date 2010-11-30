<?php
// wcf imports
require_once(WCF_DIR.'lib/data/cronjobs/Cronjob.class.php');

/**
 * Removes all known sessionIDs
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.statistics
 */
class CMSStatisticsResetCronjob implements Cronjob {
	
	/**
	 * @see Cronjob::execute()
	 */
	public function execute($data) {
		$sql = "DELETE FROM
					cms".CMS_N."_statistic_known
				WHERE
					timestamp <= ".(TIME_NOW - 3600);
		WCF::getDB()->sendQuery($sql);
	}
}
?>