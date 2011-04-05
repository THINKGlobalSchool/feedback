<?php
/**
 * Elgg Feedback plugin
 * Feedback interface for Elgg sites
 *
 * @package Feedback
 *
 * @todo Where to forward after changing status?
 * @todo Allow editing feedback by users?
 * @todo Single entity view? (feedback/view/<guid>)
 * @todo Test notifications
 * @todo owned and friends pages
 */

elgg_register_event_handler('init','system','feedback_init');

function feedback_init() {
	define("FEEDBACK_STATUS_SUBMITTED", 0);
	define("FEEDBACK_STATUS_ACKNOWLEDGED", 1);
	define("FEEDBACK_STATUS_RESOLVED", 2);
	define("FEEDBACK_STATUS_IN_PROGRESS", 3);
	define("FEEDBACK_STATUS_DUPLICATE", 4);
	
	// Set up library
	elgg_register_library('elgg:feedback', elgg_get_plugins_path() . 'feedback/lib/feedback.php');
	elgg_load_library('elgg:feedback');
	
	// page handler        
	elgg_register_page_handler('feedback', 'feedback_page_handler');
          
	// extend the analytics view.. seems to be the only working place as 
	// the page/elements/footer is now inside the layout
	elgg_extend_view('footer/analytics', 'feedback/feedback');

	// extend the site CSS and js
	elgg_extend_view('css/elgg', 'feedback/css');
	elgg_extend_view('js/elgg', 'js/feedback');

	// Add menus
	// page menu (sidebar)
	// @todo not implemented.
	elgg_register_plugin_hook_handler('register', 'menu:page', 'feedback_page_menu_setup');
	
	// secondary filter menu

	// always have all
	elgg_register_menu_item('feedback-status', array(
		'name' => $status,
		'text' => elgg_echo("feedback:status:$status"),
		'href' => elgg_http_add_url_query_elements(current_page_url(), array('feedback_status' => $status)),
		'selected' => (get_input('feedback_status', 'any') == $status),
		'priority' => 1
	));
	$statuses = feedback_get_status_types();
	$i = 2;
	foreach ($statuses as $id => $status) {
		elgg_register_menu_item('feedback-status', array(
			'name' => $id,
			'text' => $status,
			'href' => elgg_http_add_url_query_elements(current_page_url(), array('feedback_status_id' => $id)),
			'selected' => (get_input('feedback_status_id', 'any') == $id),
			'priority' => $i
		));
		
		$i++;
	}

	// the status, mood, about menu on the full view
	elgg_register_plugin_hook_handler('register', 'menu:feedback-admin', 'feedback_entity_menu_setup');

	// Set up url handler
	elgg_register_entity_url_handler('object', 'feedback', 'feedback_url');

	// Register actions
	$action_base = dirname(__FILE__) . '/actions/feedback';

	if (elgg_get_plugin_setting('disablepublic', 'feedback') === 1) {
		$access = 'logged_in';
	} else {
		$access = 'public';
	}

	elgg_register_action("feedback/add", "$action_base/add.php", $access);
	elgg_register_action("feedback/delete", "$action_base/delete.php", 'logged_in');
	elgg_register_action("feedback/set_status","$action_base/set_status.php", 'admin');

	// only add the captcha if not logged in because you can send feedback when logged out.
	if (!elgg_is_logged_in()) {
		elgg_register_plugin_hook_handler('actionlist', 'captcha', 'feedback_captcha_actions');
	}

	// send notifications
	elgg_register_event_handler('create', 'object', 'feedback_send_notifications');
}

/**
 * Populates the ->getUrl() method for feedback
 *
 * @param ElggEntity entity
 * @return string url
 */
function feedback_url($entity) {
	$title = elgg_get_friendly_title($entity->title);
	return elgg_get_site_url() . "feedback/view/{$entity->guid}/$title";
}

/**
 * Dispatches feedback pages
 * URLs take the form of
 *  All feedback:        feedback/all
 *  User feedback:       feedback/owner/username
 *  View feedback:       feedback/view/<guid>/<title>
 *
 * Title is ignored
 *
 * @param array $page
 * @return NULL
 */
function feedback_page_handler($page) {
	if (elgg_get_plugin_setting('disablepublic', 'feedback') === 1) {
		gatekeeper();
	}

	elgg_push_breadcrumb(elgg_echo('feedback:title'), 'feedback/all');

	if (!isset($page[0])) {
		$page[0] = 'all';
	}

	$pages = dirname(__FILE__) . '/pages/feedback';
	
	switch ($page[0]) {
		case "view" :
			$guid = elgg_extract(1, $page, null);
			set_input('guid', $guid);
			include("$pages/view.php");
			break;

		case 'owner':
			include("$pages/owner.php");
			break;

		case "all" :
		default:
			include("$pages/all.php");
			break;
	}
	
	return true;
}

/**
 * Adds the feedback actions to the captcha lists
 *
 * @param type $hook
 * @param type $type
 * @param type $return
 * @param type $params
 */
function feedback_captcha_actions($hook, $type, $return, $params) {
	$return[] = 'feedback/add';
	return $return;
}

/**
 * Sends out notifications when new feedback objects are created.
 *
 * This is better than in the action because it's loosely coupled and DRY--
 * You could have another plugin create feedback objects and still have notifications
 * work this way without having to duplicate the notification code in the other plugin.
 * 
 * @param type $event
 * @param type $type
 * @param type $object
 */
function feedback_send_notifications($event, $type, $object) {
	if (!elgg_instanceof($object, 'object', 'feedback')) {
		return null;
	}
	
	$user_guids = array();
	for ($idx = 1; $idx <= 5; $idx++) {
		$name = elgg_get_plugin_setting('user_' . $idx, 'feedback');
		$user = get_user_by_username($name);
		
		if ($user) {
			$user_guids[] = $user->guid;
		}
	}

	if (count($user_guids) > 0) {
		$site = elgg_get_site_entity();
		$subj = elgg_echo('feedback:email:subject', array($object->id));
		$body = elgg_echo('feedback:email:body', array($object->txt));
		notify_user($user_guids, $site->getGUID(), $subj, $body);
	}

	return null;
}

/**
 * Adds the menu items for the horizontal menu on the feedback entities.
 *
 * @param type $hook
 * @param type $type
 * @param type $value
 * @param type $params
 * @return type
 */
function feedback_entity_menu_setup($hook, $type, $value, $params) {
	$entity = elgg_extract('entity', $params);

	if ($entity) {

		$id = 'feedback-' . $entity->getGUID();
		$content = "<label class=\"mrs\" for=\"$id\">" . elgg_echo('feedback:status') . ':</label>';
		$content .= elgg_view('input/dropdown', array(
			'name' => 'status',
			'value' => $entity->status,
			'options_values' => feedback_get_status_types(),
			'id' => $id
		));
		$value[] = ElggMenuItem::factory(array(
			'name' => 'status',
			'href' => false,
			'text' => $content,
			'priority' => 10
		));

		$content = '<label class="mrs">' . elgg_echo('feedback:list:mood') . ':</label>';
		$content .= elgg_echo("feedback:mood:$entity->mood");
		$value[] = ElggMenuItem::factory(array(
			'name' => 'mood',
			'href' => false,
			'text' => $content,
			'priority' => 20
		));

		$content = '<label class="mrs">' . elgg_echo('feedback:list:about') . ':</label>';
		$content .= elgg_echo("feedback:about:$entity->about");
		$value[] = ElggMenuItem::factory(array(
			'name' => 'about',
			'href' => false,
			'text' => $content,
			'priority' => 30
		));
	}

	return $value;
}