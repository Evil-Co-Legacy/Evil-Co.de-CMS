/**
 * Github Page Module Script
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.cms.github
 */

var githubPageModule = {
	
	/**
	 * Loads data for the given instance into the given containerID
	 * @param	string	containerID
	 * @param	integer	instanceID
	 * @param	string	loadingText
	 */
	init			:		function(containerID, instanceID, loadingText) {
		$j('#' + containerID).html('<p class="success">' + loadingText + '</p>');
		
		$j.ajax({
			url: 'index.php?page=GithubModule&instanceID=' + instanceID + SID_ARG_2ND, 
			success: function(data) {
				$j('#' + containerID).html(data);
			}
		});
	}
};