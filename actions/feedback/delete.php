<?php
/**
 * Elgg Feedback plugin
 * Feedback interface for Elgg sites
 * 
 * @package Feedback
 */

$guid = (int) get_input('guid');
$feedback = get_entity($guid);

$valid = elgg_instanceof($feedback, 'object', 'feedback');
$can_admin = feedback_can_admin_feedback($feedback);
if ($can_admin) {
	$ia = elgg_set_ignore_access(true);
}
if (!($valid && $can_admin && $feedback->delete())) {
	if ($can_admin) {
		elgg_set_ignore_access($ia);
	}
	system_message(elgg_echo('feedback:delete:fail'));
	forward(REFERER);
}

if ($can_admin) {
	elgg_set_ignore_access($ia);
}

system_message(elgg_echo('feedback:delete:success'));
forward('feedback/all');
