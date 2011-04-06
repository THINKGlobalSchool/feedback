<?php
/**
 * Feedback friends page
 */


$owner = elgg_get_page_owner_entity();
elgg_push_breadcrumb($owner->name);
elgg_push_breadcrumb(elgg_echo('friends'));

$title = elgg_echo('feedback:title:friends');

// @todo inefficient
$friends = $owner->getFriends(null, 9999);
$friend_guids = array();
foreach ($friends as $friend) {
	$friend_guids[] = $friend->getGUID();
}

var_dump($friends_guids);

// show the secondary filter menu.
$content = elgg_view_menu('feedback-status', array(
	'sort_by' => 'priority',
	// recycle the menu filter css
	'class' => 'elgg-menu-hz elgg-menu-filter elgg-menu-filter-default'
));

// this is a bit different--We always show the full view in the lists here.
$content .= feedback_list_feedback_entities($friend_guids, array('full_view' => true));

$options = array(
	'content' => $content,
	'title' => $title,
);

$options['filter_context'] = 'friends';


$body .= elgg_view_layout('content', $options);

echo elgg_view_page($title, $body);