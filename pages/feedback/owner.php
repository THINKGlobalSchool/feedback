<?php
/**
 * Feedback owner page
 */


$owner = elgg_get_page_owner_entity();
elgg_push_breadcrumb($owner->name);

$title = $title = elgg_echo('polls:title:owner');

// show the secondary filter menu.
$content = elgg_view_menu('feedback-status', array(
	'sort_by' => 'priority',
	// recycle the menu filter css
	'class' => 'elgg-menu-hz elgg-menu-filter elgg-menu-filter-default'
));

// this is a bit different--We always show the full view in the lists here.
$content .= feedback_list_feedback_entities($owner->getGUID(), array('full_view' => true));

$options = array(
	'content' => $content,
	'title' => $title,
);

if ($owner->getGUID() == elgg_get_logged_in_user_guid()) {
	$options['filter_context'] = 'mine';
} else {
	$options['filter'] = false;
}

$body .= elgg_view_layout('content', $options);

echo elgg_view_page($title, $body);