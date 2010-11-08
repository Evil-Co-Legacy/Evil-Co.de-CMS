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
	 */
	init			:		function(containerID, instanceID) {
		new $j.ajax({
			url: 'index.php?page=GithubModule&instanceID=' + instanceID + SID_ARG_2ND, 
			success: function(data) {
				$(containerID).innerHTML = data;
			}
		});
	}
};