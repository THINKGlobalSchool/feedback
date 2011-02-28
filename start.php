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

elgg_register_event_handler('init','system','feedback_init');

function feedback_init() {
	define("FEEDBACK_STATUS_SUBMITTED", 0);
	define("FEEDBACK_STATUS_ACKNOWLEDGED", 1);
	define("FEEDBACK_STATUS_RESOLVED", 2);
	define("FEEDBACK_STATUS_INPROGRESS", 3);
	define("FEEDBACK_STATUS_DUPLICATE", 4);
	
	// Set up library
	elgg_register_library('elgg:feedback', elgg_get_plugins_path() . 'feedback/lib/feedback.php');
	elgg_load_library('elgg:feedback');
	
	// page handler        
	elgg_register_page_handler('feedback','feedback_page_handler');
          
	// extend the view
	elgg_extend_view('page/elements/footer', 'feedback/feedback');

	// extend the site CSS
	elgg_extend_view('css/screen','feedback/css');			                 

	// Event handler for submenus
	elgg_register_event_handler('pagesetup','system','feedback_submenus');

	// Set up url handler
	elgg_register_entity_url_handler('object', 'feedback', 'feedback_url');

	elgg_register_plugin_hook_handler('entity:annotate', 'object', 'feedback_annotate_comments');

	// Register actions
	$action_base = elgg_get_plugins_path() . "feedback/actions/feedback";
	elgg_register_action("feedback/delete", "$action_base/delete.php");
	elgg_register_action("feedback/setstatus","$action_base/setstatus.php", 'admin');	
}

function feedback_submenus() {
	if (elgg_get_context() == 'feedback') {
		
		elgg_register_menu_item('page', ElggMenuItem::factory(array(
										'name'=> 'feedback:submenu:allfeedback',
										'text' => elgg_echo("feedback:submenu:allfeedback"), 
										'href' => elgg_get_site_url() . 'pg/feedback/all'))
		);
		
		elgg_register_menu_item('page', ElggMenuItem::factory(array(
										'name'=> 'feedback:submenu:yourfeedback',
										'text' => elgg_echo("feedback:submenu:yourfeedback"), 
										'href' => elgg_get_site_url() . 'pg/feedback/'))
		);
	}
}
/**
 * Populates the ->getUrl() method for feedback
 *
 * @param ElggEntity entity
 * @return string url
 */
function feedback_url($entity) {
	$title = elgg_get_friendly_title($entity->title);
	return elgg_get_site_url() . "pg/feedback/view/{$entity->guid}/$title";
}

/**
 * Dispatches feedback pages
 * URLs take the form of
 *  All feedback:       pg/feedback/all
 *  View feedback:       pg/feedback/view/<guid>/<title>
 *
 * Title is ignored
 *
 * @param array $page
 * @return NULL
 */
function feedback_page_handler($page) {	
	elgg_push_breadcrumb(elgg_echo('feedback:title:allfeedback'), elgg_get_site_url() . "pg/feedback/all");	
	
	if ($page[0] && !empty($page[0])) {
		switch ($page[0]) {
			case "view" :		
   				set_input('feedback_guid', $page[1]);				
				include(elgg_get_plugins_path() . "feedback/pages/view.php");
				break;	
			case "all" :
				include elgg_get_plugins_path() . 'feedback/pages/feedback.php';
				break;
			default:
				include elgg_get_plugins_path() . 'feedback/pages/yourfeedback.php';
				break;				
		}
	} else {
		include elgg_get_plugins_path() . 'feedback/pages/yourfeedback.php';
	}
	
	return true;
}

/**
 * Hook into the framework and provide comments on feedback entities.
 * @TODO Not sure if this is necessary anymore...
 * @param unknown_type $hook
 * @param unknown_type $entity_type
 * @param unknown_type $returnvalue
 * @param unknown_type $params
 * @return unknown
 */
function feedback_annotate_comments($hook, $entity_type, $returnvalue, $params) {
	$entity = $params['entity'];
	$full = $params['full'];
	
	if (elgg_instanceof($entity, 'object', 'feedback')) {
		// Display comments
		return elgg_view_comments($entity);
	}
}
