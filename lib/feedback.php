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
function feedback_get_status_friendly_name($status_id) {
	$types = feedback_get_status_types();
	return elgg_extract($status_id, $types, false);
}

/**
 *
 * @param type $container_guid
 * @return string html to display
 */
function feedback_list_feedback_entities($container_guid = ELGG_ENTITIES_ANY_VALUE, array $extra_options =  array()) {
	// get entities
	$options = array(
		'type' => 'object',
		'subtype' => 'feedback',
		'limit' => $limit,
		'container_guid' => $container_guid
	);

	$status_id = get_input('feedback_status_id', 'all');

	// check invalid statuses
	$valid_status = feedback_get_status_friendly_name($status_id);

	if ($valid_status && $status_id != 'all') {
		$options['metadata_name_value_pair'] = array('status' => $status_id);
	}

	$options = array_merge($options, $extra_options);

	$content = elgg_list_entities_from_metadata($options);
	if (!$content) {
		$content = '<h3 class="center">' . elgg_echo('feedback:noresults') . '</h3>';
	}

	return $content;
}