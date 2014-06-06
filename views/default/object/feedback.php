<?php
/**
 * Elgg Feedback plugin object view
 */

$full = elgg_extract('full_view', $vars, false);
$feedback = elgg_extract('entity', $vars, false);
$comments_open = elgg_extract('comments_open', $vars, false);

if (!$feedback) {
	return true;
}

$owner = $feedback->getOwnerEntity();
$owner_icon = elgg_view_entity_icon($owner, 'tiny');

$owner_link = elgg_view('output/url', array(
	'href' => "feedback/owner/$owner->username",
	'text' => $owner->name,
));

$author_text = elgg_echo('byline', array($owner_link));
$date = elgg_view_friendly_time($feedback->time_created);

$comments_count = (int) $feedback->countComments();
$text = elgg_echo("comments") . " ($comments_count)";
$comments_active = ($comments_open) ? 'elgg-state-active' : '';
$comments_link = elgg_view('output/url', array(
	'href' => '#comments-' . $feedback->getGUID(),
	'text' => $text,
	'class' => "$comments_active",
	'rel' => 'toggle',
));

// gotta wrap this in an extra div for the animation.
$comments_class = ($comments_open) ? '' : ' class="hidden"';
$comments = "<div id=\"comments-$feedback->guid\" $comments_class>" . elgg_view_comments($feedback, true) . '</div>';

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'feedback',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date $categories $comments_link";

if ($full && !elgg_in_context('gallery')) {
	$description = elgg_view('output/longtext', array('value' => $feedback->txt));
	if (feedback_can_admin_feedback($feedback)) {
		$menu = elgg_view_menu('feedback-admin', array(
			'entity' => $feedback,
			'sort_by' => 'priority'
		));
	} else {
		$menu = '';
	}

	$content = <<<HTML
$menu
$description
$comments
HTML;

	$params = array(
		'entity' => $feedback,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
		'content' => $content
	);

	$list_body = elgg_view('object/elements/summary', $params);
	echo elgg_view_image_block($owner_icon, $list_body, array('class' => 'elgg-feedback-entity-wrapper'));
} else {
	$params = array(
		'entity' => $feedback,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
	);

	$body = elgg_view('object/elements/summary', $params);
	$body .= 'this aowhefioawehf';
	
	echo elgg_view_image_block($owner_icon, $body);
}