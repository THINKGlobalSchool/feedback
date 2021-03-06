<?php
/**
 * Feedback owner page
 */


$owner = elgg_get_page_owner_entity();
if (get_input('feedback_status_id', 'any') === 'any') {
	$link = "feedback/owner/$owner->ysernamename";
} else {
	$link = null;
}
elgg_push_breadcrumb($owner->name, $link);
feedback_push_status_breadcrumb(false);

$title = elgg_echo('feedback:title:owner', array($owner->name));

// show the status filter menu.
$content = elgg_view('feedback/status_filter');

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