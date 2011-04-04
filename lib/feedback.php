<?php
/**
 * Feedback helper functions
 * 
 * @package Feedback
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

/** 
* Helper function to get a list of available statuses
*
* @return array
*/
function get_status_types() {
	return array(
		FEEDBACK_STATUS_SUBMITTED => elgg_echo("submitted"), 
	 	FEEDBACK_STATUS_ACKNOWLEDGED => elgg_echo("acknowledged"), 
	 	FEEDBACK_STATUS_RESOLVED => elgg_echo("resolved"),
	 	FEEDBACK_STATUS_INPROGRESS => elgg_echo("inprogress"), 
	 	FEEDBACK_STATUS_DUPLICATE => elgg_echo("duplicate")
	);
}
