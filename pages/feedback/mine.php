<?php
/**
 * User feedback
 *
 * @package Feedback
 */

$title = elgg_echo('feedback:title:all');

// show the secondary filter menu.
$content = elgg_view_menu('feedback-status', array(
	'sort_by' => 'priority',
	// recycle the menu filter css
	'class' => 'elgg-menu-hz elgg-menu-filter elgg-menu-filter-default'
));

$options = array(
	'type' => 'object',
	'subtype' => 'feedback',
	'limit' => $limit
);

$status = get_input('feedback_status', 'all');

if ($status != 'all') {
	$options['metadata_name_value_pair'] = array('status' => $status);
}

$content = elgg_list_entities_from_metadata($options);

$body .= elgg_view_layout('content', array(
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'buttons' => false
));

echo elgg_view_page($title, $body);

return true;
