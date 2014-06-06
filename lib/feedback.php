<?php
/**
 * Feedback helper functions
 * 
 * @package Feedback
 * 
 */

/** 
* Helper function to get a list of available statuses
*
* @return array
*/
function feedback_get_status_types() {
	return array(
		FEEDBACK_STATUS_SUBMITTED => elgg_echo('feedback:status:submitted'),
	 	FEEDBACK_STATUS_ACKNOWLEDGED => elgg_echo('feedback:status:acknowledged'),
	 	FEEDBACK_STATUS_RESOLVED => elgg_echo('feedback:status:resolved'),
	 	FEEDBACK_STATUS_IN_PROGRESS => elgg_echo('feedback:status:in_progress'),
	 	FEEDBACK_STATUS_DUPLICATE => elgg_echo('feedback:status:duplicate')
	);
}

/**
 * Returns the ID associated with the status string
 *
 * @param type $status The status string
 *
 * @return int  The status ID
 */
function feedback_get_status_id($status) {
	$types = feedback_get_status_types();
	$types = array_flip($types);
	return elgg_extract($status, $types, false);
}

/**
 * Returns a friendly string for the status id
 *
 * @param int $status_id The status ID
 * @return string The friendy name of the ID
 */
function feedback_get_friendly_status($status_id) {
	$types = feedback_get_status_types();
	return elgg_extract($status_id, $types, false);
}

/**
 * Returns feedback entities. Automatically grabs the status from get_input() and adds breadcrumbs
 *
 * @param type $container_guid
 * @return string html to display
 */
function feedback_list_feedback_entities($container_guid = ELGG_ENTITIES_ANY_VALUE, array $extra_options =  array()) {
	// get entities
	$options = array(
		'type' => 'object',
		'subtype' => 'feedback',
		'limit' => '20',
		'container_guid' => $container_guid
	);

	$status_id = get_input('feedback_status_id', 'all');

	// check invalid statuses
	$valid_status = feedback_get_friendly_status($status_id);

	if ($valid_status && $status_id != 'any') {
		$options['metadata_name_value_pair'] = array('status' => $status_id);
	}

	$options = array_merge($options, $extra_options);

	$content = elgg_list_entities_from_metadata($options);
	if (!$content) {
		$content = '<h3 class="center">' . elgg_echo('feedback:noresults') . '</h3>';
	}

	return $content;
}

/**
 * Detects and adds the correct breadcrumb for the status id
 *
 * @param bool $show_link Show the link to the status?
 * @return bool
 */
function feedback_push_status_breadcrumb($show_link = true) {
	$status_id = get_input('feedback_status_id', 'any');

	if ($status_id == 'any') {
		$title = elgg_echo('feedback:status:any');
		$query = array('feedback_status_id' => 'any');
	} else {
		$friendly_status = feedback_get_friendly_status($status_id);
		if ($friendly_status) {
			$title = $friendly_status;
			$query = array('feedback_status_id' => $status_id);
		}
	}

	if ($show_link) {
		$link = elgg_http_add_url_query_elements($url, $query);
	} else {
		$link = null;
	}

	return elgg_push_breadcrumb($title, $link);
}

/**
 * Checks if a user is able to change feedback attributes.
 *
 * @param mixed $user ElggUser or null for logged in user.
 * @return bool
 */
function feedback_can_admin_feedback(ElggEntity $feedback, $user = null) {
	if (!$user) {
		$user = elgg_get_logged_in_user_entity();
	}

	if (!elgg_instanceof($user, 'user')) {
		return false;
	}

	// always allowed for admin
	if ($user->isAdmin()) {
		return true;
	}

	$admins = feedback_get_feedback_admin_user_entities();

	foreach ($admins as $admin) {
		if ($user->username == $admin->username) {
			return true;
		}
	}
	
	return false;
}

/**
 * Gets an array of all defined feedback admins.
 *
 * @return array
 */
function feedback_get_feedback_admin_user_entities() {
	$users = array();
	$i = 1;
	$username = elgg_get_plugin_setting("user_$i", 'feedback');

	while($username) {
		$user = get_user_by_username($username);
		if ($user) {
			$users[] = $user;
		}

		$i++;
		$username = elgg_get_plugin_setting("user_$i", 'feedback');
	}

	return $users;
}