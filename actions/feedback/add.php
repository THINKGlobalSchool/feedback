<?php
/**
 * Elgg Feedback plugin
 * Feedback interface for Elgg sites
 * 
 * @package Feedback
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Prashant Juvekar
 * @copyright Prashant Juvekar
 * @link http://www.linkedin.com/in/prashantjuvekar
 */

elgg_make_sticky_form('feedback');

$feedback = new ElggObject();
$feedback->subtype = "feedback";

// Set the feedback's content
$feedback->page = get_input('page');
$feedback->mood = get_input('mood');
$feedback->about = get_input('about');
$user = elgg_get_logged_in_user_entity();
if ($user) {
	$id = "$user->name ($user->email)";
} else {
	$id = get_input('id');
}
$feedback->id = $id;
// @todo This should really use description
$feedback->txt = get_input('description');
$feedback->title = get_input('title');
$feedback->status = FEEDBACK_STATUS_SUBMITTED;

$feedback->access_id = ACCESS_LOGGED_IN;

// make sure the title and txt aren't the defaults
$title_default = elgg_echo('feedback:default:title');
$description_default = elgg_echo('feedback:default:txt');

if ($title_default == $feedback->title || $description_default == $feedback->txt) {
	register_error(elgg_echo('feedback:submit:error'));
	if (elgg_is_xhr()) {
		echo elgg_view_form('feedback/add');
	}
	forward(REFERRER);
}

if (!$feedback->save()) {
	register_error(elgg_echo('feedback:submit:error'));
	if (elgg_is_xhr()) {
		echo elgg_view_form('feedback/add');
	}
	forward(REFERRER);
}

elgg_clear_sticky_form('feedback');

// Success message
system_message(elgg_echo("feedback:submit:success"));

// show the form again in case they want more.
if (elgg_is_xhr()) {
	echo elgg_view_form('feedback/add');
}

// add to river if setting is enabled
if (elgg_get_plugin_setting('enableriver', 'feedback')) {
	add_to_river('river/object/feedback/create', 'create', elgg_get_logged_in_user_guid(), $feedback->getGUID());
}

forward(REFERRER);