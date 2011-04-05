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

return true;








$js = <<<EOT
	<script type="text/javascript">
		function feedback_toggle_comments(guid) {
			$('#feedback_edit_' + guid).toggle(200); 
			if ($('span#arrow_' + guid).text() == '↓') {
				$('span#arrow_' + guid).text('↑');
			} else if ($('span#arrow_' + guid).text() == '↑') {
				$('span#arrow_' + guid).text('↓');
			}
		}
	</script>
EOT;

$title = elgg_echo('feedback:admin:title');

// Check for and validate status	
$status = get_input('status');

if (in_array($status, get_status_types())) {
	$is_status = true;	
} else {
	$is_status = false;
}

$order	= get_input('o');
$limit = get_input("limit", 10);
$offset = get_input("offset", 0);

// if username or owner_guid was not set as input variable, we need to set page owner
// Get the current page's owner
$page_owner = elgg_get_page_owner_entity();
if (!$page_owner) {
	$page_owner_guid = elgg_get_logged_in_user_guid();

	if ($page_owner_guid) {
		elgg_set_page_owner_guid($page_owner_guid);
	}
}

$content = elgg_view_menu('polls-status', array(
	'sort_by' => 'priority',
	// recycle the menu filter css
	'class' => 'elgg-menu-hz elgg-menu-filter elgg-menu-filter-default'
));
$content .= polls_get_page_content_list();

if ($is_status) {
	//$feedback_list = list_entities_from_metadata('status', $status, 'object', 'feedback', 0, $limit, false, false);
	
	$feedback_list = elgg_list_entities_from_metadata(array(
				'type' => 'object',
				'subtype' => 'feedback',
				'metadata_names' => array('status'),
				'metadata_values' => array($status),
				'limit' => $limit
	));

} else {		
	$feedback_list = elgg_list_entities(array('type' => 'object', 'subtype' => 'feedback', 'limit' => $limit, 'offset' => $offset, 'full_view' => FALSE, 'status' => $status));
} 

elgg_set_context($context);

if (strlen($feedback_list) > 1) {
	$content .= $feedback_list;
} else {
	$content .=  elgg_view('feedback/noresults');
}

$params = array(
	'buttons' => '',
	'content' => $content,
	'title' => $title,
	'filter' => '',
);
$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
