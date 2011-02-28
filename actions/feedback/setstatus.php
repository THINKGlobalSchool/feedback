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
$guid = get_input('feedback_guid');
$status = get_input('s');
$full = get_input('full', false);

$feedback = get_entity($guid);

$canedit = isadminloggedin(); 

// Get status array and flip for easy search
$status_array = get_status_types();
$status_flipped = array_flip($status_array);

if ($feedback->getSubtype() == "feedback" && $canedit && in_array($status, $status_flipped)) {
	
	$feedback->status = $status_array[$status];
	
	// Save
	if (!$feedback->save()) {
		register_error(elgg_echo("feedback:error:status"));		
		forward("mod/feedback/feedback.php");
	}

	if (get_plugin_setting('enableriver', 'feedback')) {
		add_to_river('river/object/feedback/update', 'update', elgg_get_logged_in_user_guid(), $feedback->getGUID());
	}	
	
	// Save successful
	system_message(elgg_echo('feedback:edit:success'));
	// Forward
	if ($full) {
			forward("pg/feedback/view/{$feedback->guid}");
	} else {
		forward("pg/feedback/all?status=".$status_array[$status]);
	}
}
	