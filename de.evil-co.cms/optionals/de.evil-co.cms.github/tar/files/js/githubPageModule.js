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
		new Ajax.Request('index.php?page=GithubModule&instanceID=' + instanceID + SID_ARG_2ND, { onSuccess: function(data) {
			$(containerID).innerHTML = data;
		}});
	}
};