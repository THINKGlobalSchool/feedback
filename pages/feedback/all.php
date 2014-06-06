<?php
/**
 * All feedback
 * 
 * @package Feedback
 */

$title = elgg_echo('feedback:title:all');

feedback_push_status_breadcrumb(false);

// show the filter input
$content = elgg_view('feedback/status_filter');

// this is a bit different--We always show the full view in the lists here.
$content .= feedback_list_feedback_entities(null, array('full_view' => true));

$body .= elgg_view_layout('content', array(
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);