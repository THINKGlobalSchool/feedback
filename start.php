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

register_elgg_event_handler('init','system','feedback_init');

function feedback_init() {
	define("FEEDBACK_STATUS_SUBMITTED", 0);
	define("FEEDBACK_STATUS_ACKNOWLEDGED", 1);
	define("FEEDBACK_STATUS_RESOLVED", 2);
	define("FEEDBACK_STATUS_INPROGRESS", 3);
	define("FEEDBACK_STATUS_DUPLICATE", 4);

	// Include lib
	include elgg_get_plugin_path() . 'feedback/lib/feedback.php';
	
	// page handler        
	register_page_handler('feedback','feedback_page_handler');
          
	// extend the view
	elgg_extend_view('page_elements/footer', 'page_elements/feedback');

	// extend the site CSS
	elgg_extend_view('css/screen','feedback/css');			                 

	// Event handler for submenus
	register_elgg_event_handler('pagesetup','system','feedback_submenus');

	// Set up url handler
	register_entity_url_handler('feedback_url','object', 'feedback');

	register_plugin_hook('entity:annotate', 'object', 'feedback_annotate_comments');

	// Register actions
	$action_base = elgg_get_plugin_path() . "feedback/actions/feedback";
	elgg_register_action("feedback/delete", "$action_base/delete.php");
	elgg_register_action("feedback/setstatus","$action_base/setstatus.php", 'admin');	
}

function feedback_submenus() {
	if (get_context() == 'feedback') {
		add_submenu_item(elgg_echo('feedback:submenu:allfeedback'), elgg_get_site_url() . 'pg/feedback/all');
		add_submenu_item(elgg_echo('feedback:submenu:yourfeedback'), elgg_get_site_url() . 'pg/feedback/');
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
				include(elgg_get_plugin_path() . "feedback/pages/view.php");
				break;	
			case "all" :
				include elgg_get_plugin_path() . 'feedback/pages/feedback.php';
				break;
			default:
				include elgg_get_plugin_path() . 'feedback/pages/yourfeedback.php';
				break;				
		}
	} else {
		include elgg_get_plugin_path() . 'feedback/pages/yourfeedback.php';
	}
	
	return true;
}

/**
 * Hook into the framework and provide comments on todo entities.
 *
 * @param unknown_type $hook
 * @param unknown_type $entity_type
 * @param unknown_type $returnvalue
 * @param unknown_type $params
 * @return unknown
 */
function feedback_annotate_comments($hook, $entity_type, $returnvalue, $params) {
	$entity = $params['entity'];
	$full = $params['full'];
	
	if (
		($entity instanceof ElggEntity) &&	// Is the right type 
		($entity->getSubtype() == 'feedback') &&  // Is the right subtype
		($full) // This is the full view
	){
		// Display comments
		return elgg_view_comments($entity);
	}
}
