<?php
/**
 * All feedback
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

// this is a bit different--We always show the full view in the lists here.
$content .= feedback_list_feedback_entities(null, array('full_view' => true));

$body .= elgg_view_layout('content', array(
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'buttons' => false,
));

echo elgg_view_page($title, $body);