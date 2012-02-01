<?php
/**
 * Elgg Feedback plugin
 * Feedback interface for Elgg sites
 *
 * @package Feedback
 *
 * @todo It looks like users should be notified if they status is changed? This doesn't seem to be
 * implemented in the original plugin.
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

	// Register Feedback CSS
	$f_css = elgg_get_simplecache_url('css', 'feedback/css');
	elgg_register_simplecache_view('css/feedback/css');
	elgg_register_css('elgg.feedback', $f_css);
	elgg_load_css('elgg.feedback');
	
	// Extend main JS
	elgg_extend_view('js/elgg', 'js/feedback');

	// Add menus
	
	// secondary filter menu
	$status_id = get_input('feedback_status_id', 'any');
	// always have any
	elgg_register_menu_item('feedback-status', array(
		'name' => 'any',
		'text' => elgg_echo("feedback:status:any"),
		'href' => '/feedback',
		'selected' => ($status_id === 'any'),
		'priority' => 1
	));
	
	$statuses = feedback_get_status_types();
	$i = 2;
	foreach ($statuses as $id => $status) {
		elgg_register_menu_item('feedback-status', array(
			'name' => $id,
			'text' => $status,
			'href' => elgg_http_add_url_query_elements(current_page_url(), array('feedback_status_id' => $id)),
			'selected' => ($status_id === $id),
			'priority' => $i
		));
		
		$i++;
	}

	// the status, mood, about menu on the full view
	elgg_register_plugin_hook_handler('register', 'menu:feedback-admin', 'feedback_entity_menu_setup');

	// remove edit, add delete for authorized users
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'feedback_customize_entity_menu');

	// Set up url handler
	elgg_register_entity_url_handler('object', 'feedback', 'feedback_url');

	// Register actions
	$action_base = elgg_get_plugins_path() . 'feedback/actions/feedback';

	if (elgg_get_plugin_setting('disablepublic', 'feedback') === 1) {
		$access = 'logged_in';
	} else {
		$access = 'public';
	}

	elgg_register_action("feedback/add", "$action_base/add.php", $access);
	elgg_register_action("feedback/delete", "$action_base/delete.php", 'logged_in');
	elgg_register_action("feedback/set_status", "$action_base/set_status.php", 'logged_in');

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

	elgg_push_context('feedback');
	$pages = dirname(__FILE__) . '/pages/feedback';
	
	switch ($page[0]) {
		case 'view' :
			$guid = elgg_extract(1, $page, null);
			set_input('guid', $guid);
			include("$pages/view.php");
			break;

		case 'friends':
			include("$pages/friends.php");
			break;

		case 'owner':
			include("$pages/owner.php");
			break;

		case "all" :
		default:
			include("$pages/all.php");
			break;
	}

	elgg_pop_context();
	
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
	
	$users = feedback_get_feedback_admin_user_entities();

	if ($users) {
		foreach ($users as $user) {
			$site = elgg_get_site_entity();
			$subj = elgg_echo('feedback:email:subject', array($object->id));
			$body = elgg_echo('feedback:email:body', array($object->txt));
			notify_user($user->getGUID(), $site->getGUID(), $subj, $body);
		}
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
		$value[] = ElggMenuItem::factory(array(
			'name' => 'status',
			'href' => false,
			'text' => elgg_view('feedback/admin_bar_items/status', $params),
			'priority' => 10
		));


		$value[] = ElggMenuItem::factory(array(
			'name' => 'mood',
			'href' => false,
			'text' => elgg_view('feedback/admin_bar_items/mood', $params),
			'priority' => 20
		));

		$value[] = ElggMenuItem::factory(array(
			'name' => 'about',
			'href' => false,
			'text' => elgg_view('feedback/admin_bar_items/about', $params),
			'priority' => 30
		));
	}

	return $value;
}

/**
 * Removes the edit links for feedback and adds the delete link using with the special permissions.
 *
 * @param unknown_type $hook
 * @param unknown_type $type
 * @param unknown_type $return
 * @param unknown_type $params
 */
function feedback_customize_entity_menu($hook, $type, $return, $params) {
	$entity = $params['entity'];

	// don't display edit link for polls
	if (elgg_instanceof($entity, 'object', 'feedback')) {
		foreach ($return as $i => $menu) {
			// remove both, but add delete after
			if ($menu->getName() == 'edit' || $menu->getName() == 'delete') {
				unset ($return[$i]);
			}
		}

		// readd delete link if able to edit
		if (feedback_can_admin_feedback($entity)) {
			$options = array(
				'name' => 'delete',
				'text' => elgg_view_icon('delete'),
				'title' => elgg_echo('delete:this'),
				'href' => "action/{$params['handler']}/delete?guid={$entity->getGUID()}",
				'confirm' => elgg_echo('deleteconfirm'),
				'priority' => 300,
			);

			$return[] = ElggMenuItem::factory($options);
		}
	}

	return $return;
}
