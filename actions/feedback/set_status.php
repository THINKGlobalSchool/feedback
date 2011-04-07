<?php
/**
 * Feedback - Set resource request status action
 * 
 * @package Feedback
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

// get input
$guid = get_input('guid');
$status_id = get_input('status_id');
$feedback = get_entity($guid);
$can_admin = feedback_can_admin_feedback($feedback);
// returns false if can't find it
$valid_status = feedback_get_friendly_status($status_id);

if (elgg_instanceof($feedback, 'object', 'feedback') && $can_admin && $valid_status) {
	if (false === ($feedback->status = $status_id)) {
		register_error(elgg_echo("feedback:error:status"));
		forward(REFERER);
	}

	if (elgg_get_plugin_setting('enableriver', 'feedback')) {
		add_to_river('river/object/feedback/update', 'update', elgg_get_logged_in_user_guid(), $feedback->getGUID());
	}
	
	system_message(elgg_echo('feedback:edit:success'));
	forward(REFERER);
} else {
	register_error(elgg_echo('feedback:error:status'));
}