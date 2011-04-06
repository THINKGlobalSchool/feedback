<?php
/**
 * Single feedback
 *
 * @package Feedback
 */

$feedback = get_entity(get_input('guid'));

$page_owner = elgg_get_page_owner_entity();

$crumbs_title = $page_owner->name;
elgg_push_breadcrumb($crumbs_title, "feedback/owner/$page_owner->username");

$title = $feedback->title;

elgg_push_breadcrumb($title);

$content = elgg_view_entity($feedback, array('full_view' => true, 'comments_open' => true));
// comments handled in the view.

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
	'header' => '',
));

echo elgg_view_page($title, $body);
