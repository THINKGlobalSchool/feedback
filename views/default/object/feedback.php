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
	'class' => "elgg-toggler $comments_active"
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















return true;

$icon = elgg_view(
		'graphics/icon', array(
		'entity' => $vars['entity'],
		'size' => 'small',
	)
);

$id = $vars['entity']->id;
$guid = $vars['entity']->guid;

$time_created = $vars['entity']->time_created;
$owner_guid = $vars['entity']->owner_guid;
$owner = get_entity($owner_guid);

// Create Labels/Content
$mood_label = elgg_echo('feedback:list:mood');
$mood_content = elgg_echo("feedback:mood:" . $vars['entity']->mood);

$about_label = elgg_echo('feedback:list:about');
$about_content = elgg_echo("feedback:about:" . $vars['entity']->about);

$status_label = elgg_echo('feedback:status');
$status_content = elgg_echo("feedback:status:" . $vars['entity']->status);

$feedback_content = elgg_view('output/longtext', array('value' => $vars['entity']->txt));

// Admin only content
if (elgg_is_admin_logged_in()) {
	$controls .= elgg_view("output/confirmlink",array('onclick' => 'return false;', 'href' => $vars['url'] . 'action/feedback/delete?guid=' . $vars['entity']->guid, 'text' => elgg_echo('delete'), 'confirm' => elgg_echo('deleteconfirm'),));
	$status_content = elgg_view('forms/feedback/setstatus', $vars);
}

$comment_count = $vars['entity']->countComments();

$comment_info = "Comments ($comment_count)<br /><br />";			
			
// Edit form div
if (!$vars['full']) {
	$edit_form .= "<div id='feedback_edit_$guid' style='display: " .  (($vars['full']) ? "block" : "none") . "; width: 100%;'>";
	$edit_form .= elgg_view_comments($vars['entity']);
	$edit_form .= "</div>";
	
	$comment_info = "<a href='#' onclick=\"feedback_toggle_comments($guid); return false;\">Comments ($comment_count)<span id='arrow_$guid' style='font-size: 14px;'>" . (($vars['full']) ? "&uarr;" : "&darr;"). "</span></a><br /><br />";			
}
	
// Check for external feedback (possible its not internal)
if ($owner) {
	$strapline .= sprintf(elgg_echo("feedback:strapline"),
			"<a href=\"" . $owner->getURL() . "\">" . $owner->name ."</a>",
				date("F j, Y",$time_created)
	);
} else {
	$strapline .= sprintf(elgg_echo("feedback:strapline"),
			 	$id,
				date("F j, Y",$time_created)
	);
}
	
// Build content
$content = <<<EOT
	<div id='feedbackinfo'>
		<div id='feedback-icon'>$icon</div>
		<p class="entity_title" style='margin-bottom:2px;'><a href='{$vars['entity']->getURL()}/'>{$vars['entity']->title}</a></p>
		<p class="entity_subtext">
			$strapline<br />
			$comment_info
		</p>
		<div style='clear:both;'></div>
		<div class='feedback-metadata'>
			<div class='feedback-status'>
				<div style='float: left; padding-right: 5px;'><b>$status_label: </b></div>
				<div style='float: le	ft;'>$status_content</div>
			</div>
			<div class='feedback-mood'>
				<b>$mood_label:</b>
				&nbsp;$mood_content
			</div>
			<div class='feedback-about'>
				<b>$about_label:</b>
				&nbsp;$about_content
			</div>
			<div class='feedback-controls'>
				$controls
			</div>
		</div>
		<div style='clear:both'></div>
		<div>
			<br />
			$feedback_content
		</div>
	<br />
EOT;

echo $content . $edit_form . "</div>";
