<?php
/**
 * Feedback friends page
 */


$owner = elgg_get_page_owner_entity();
elgg_push_breadcrumb($owner->name, "feedback/owner/$owner->username");

if (get_input('feedback_status_id', 'any') === 'any') {
	$link = "feedback/friends/$owner->username";
} else {
	$link = null;
}

elgg_push_breadcrumb(elgg_echo('friends'), $link);
feedback_push_status_breadcrumb(false);

$title = elgg_echo('feedback:title:friends', array($owner->name));

// @todo inefficient
$friends = $owner->getFriends(null, 9999);
$friend_guids = array();
foreach ($friends as $friend) {
	$friend_guids[] = $friend->getGUID();
}


// show the secondary filter menu.
$content = elgg_view_menu('feedback-status', array(
	'sort_by' => 'priority',
	// recycle the menu filter css
	'class' => 'elgg-menu-hz elgg-menu-filter elgg-menu-filter-default'
));

if ($friend_guids) {
	// this is a bit different--We always show the full view in the lists here.
	$content .= feedback_list_feedback_entities($friend_guids, array('full_view' => true));
} else {
	$content .= elgg_view('feedback/noresults');
}

$options = array(
	'content' => $content,
	'title' => $title,
);

$options['filter_context'] = 'friends';


$body .= elgg_view_layout('content', $options);

echo elgg_view_page($title, $body);