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
if (!($valid && $feedback->canEdit() && $feedback->delete())) {
	system_message(elgg_echo('feedback:delete:fail'));
	forward(REFERER);
}

system_message(elgg_echo('feedback:delete:success'));
forward('feedback/all');
