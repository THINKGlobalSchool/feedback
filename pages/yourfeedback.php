<?php
/**
 * Elgg Feedback plugin
 * Feedback interface for Elgg sites
 * 
 * @package Feedback
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Prashant Juvekar
 * @copyright Prashant Juvekar
 * @link http://www.linkedin.com/in/prashantjuvekar
 */

require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/engine/start.php');

// Logged in users only 
gatekeeper();

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
$page_owner = page_owner_entity();
if (!$page_owner) {
	$page_owner_guid = get_loggedin_userid();
	if ($page_owner_guid)
		set_page_owner($page_owner_guid);
}

// Breadcrumbs
elgg_push_breadcrumb(elgg_echo('feedback:owned_feedback'), elgg_get_site_url() . "pg/feedback");

// Start content
$content .= elgg_view('navigation/breadcrumbs');
$content .= elgg_view_title(elgg_echo('feedback:title'));
$content .= elgg_view('feedback/feedback_nav', array('selected' => 'mine'));
$content .= elgg_view("feedback/filter_nav", array("page" => "pg/feedback", "status" => $status));
$feedback_list = '';

$context = get_context();
set_context('search');

if ($is_status) {
	$feedback_list = list_entities_from_metadata('status', $status, 'object', 'feedback', page_owner(), $limit, false, false);

} else {		
	$feedback_list = elgg_list_entities(array('container_guid' => page_owner(), 'type' => 'object', 'subtype' => 'feedback', 'limit' => $limit, 'offset' => $offset, 'full_view' => FALSE, 'status' => $status));
//	$feedback_list = elgg_list_entities(array('types' => 'object', 'subtypes' => 'rubric', 'limit' => $limit, 'offset' => $offset, 'full_view' => FALSE));
} 


	
set_context($context);

if (strlen($feedback_list) > 1) {
	$content .= $feedback_list;
} else {
	$content .=  elgg_view('feedback/noresults');
}

echo elgg_view_page(
	elgg_echo('feedback:title:yourfeedback'),
	elgg_view_layout('one_column_with_sidebar',$content,'')
);
