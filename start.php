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

    /*
     * Initialize Plugin
     */
	function feedback_init() {
		
		define("FEEDBACK_STATUS_SUBMITTED", 0);
		define("FEEDBACK_STATUS_ACKNOWLEDGED", 1);
		define("FEEDBACK_STATUS_RESOLVED", 2);
		define("FEEDBACK_STATUS_INPROGRESS", 3);
		define("FEEDBACK_STATUS_DUPLICATE", 4);
	
        global $CONFIG;

		// page handler        
		register_page_handler('feedback','feedback_page_handler');
        
        // load the language translations
        register_translations($CONFIG->pluginspath . "feedback/languages/");
        
        // extend the view
		elgg_extend_view('page_elements/footer', 'page_elements/feedback');
		
		// extend the site CSS
		elgg_extend_view('css','feedback/css');			                 
	
		// Place feedback on the main menu
		//add_menu(elgg_echo('feedback:admin:menu'), $CONFIG->url . "pg/feedback/all");
		
		// Event handler for submenus
		register_elgg_event_handler('pagesetup','system','feedback_submenus');
	
		// Set up url handler
		register_entity_url_handler('feedback_url','object', 'feedback');
		
		register_plugin_hook('entity:annotate', 'object', 'feedback_annotate_comments');
		
		// Register actions
		global $CONFIG;
		register_action("feedback/delete", false, $CONFIG->pluginspath."feedback/actions/delete.php");
		register_action("feedback/update", false, $CONFIG->pluginspath."feedback/actions/update.php");
		register_action("feedback/setstatus", false, $CONFIG->pluginspath."feedback/actions/setstatus.php");
		
	}
	
	function feedback_submenus() {
		global $CONFIG;
		
		if (get_context() == 'feedback') {
			add_submenu_item(elgg_echo('feedback:submenu:allfeedback'), $CONFIG->wwwroot . 'pg/feedback/all');
			add_submenu_item(elgg_echo('feedback:submenu:yourfeedback'), $CONFIG->wwwroot . 'pg/feedback/');
		}
		
	}
	/**
	 * Populates the ->getUrl() method for feedback
	 *
	 * @param ElggEntity entity
	 * @return string url
	 */
	function feedback_url($entity) {
		global $CONFIG;
		
		return $CONFIG->url . "pg/feedback/view/{$entity->guid}/";
	}
	
	/**
	* Rubricbuilder's Page Handler
	* 
	* @param array $page From the page_handler function
	* @return true|false Depending on success
	*
	*/
	function feedback_page_handler($page) {
		global $CONFIG;
		
		elgg_push_breadcrumb(elgg_echo('feedback:title:allfeedback'), "{$CONFIG->site->url}pg/feedback/all");	
		
		if ($page[0] && !empty($page[0])) {
			switch ($page[0]) {
				case "view" :		
	   				set_input('feedback_guid', $page[1]);				
					include($CONFIG->pluginspath . "feedback/pages/view.php");
					break;	
				case "all" :
					
					include $CONFIG->pluginspath . 'feedback/pages/feedback.php';
					break;
				default:
					include $CONFIG->pluginspath . 'feedback/pages/yourfeedback.php';
					break;				
			}
		} else {
			include $CONFIG->pluginspath . 'feedback/pages/yourfeedback.php';
		}
		
		return true;
	}
	
	
	/** 
	* Helper function to get a list of available status'
	*
	* @return array
	*/
	function get_status_types() {
		return array(
						FEEDBACK_STATUS_SUBMITTED => elgg_echo("submitted"), 
					 	FEEDBACK_STATUS_ACKNOWLEDGED => elgg_echo("acknowledged"), 
					 	FEEDBACK_STATUS_RESOLVED => elgg_echo("resolved"),
					 	FEEDBACK_STATUS_INPROGRESS => elgg_echo("inprogress"), 
					 	FEEDBACK_STATUS_DUPLICATE => elgg_echo("duplicate")
					);
	}
	register_elgg_event_handler('init','system','feedback_init');
	
	/**
	* Determine if given user has voted on 
	* given feedback item
	*
	* @param $user_guid
	* @param $feedback_guid
	* @return bool
	*/
	function has_user_voted($user_guid, $feedback_guid) {
		$feedback = get_entity($feedback_guid);
		
		$comments = $feedback->getAnnotations('generic_comment');
		
		if (empty($comments))
			return false;
		 
		foreach ($comments as $comment) {

			if ($comment['owner_guid'] != $user_guid)
			 	continue;
			if (is_array($comment_data = unserialize($comment->value))) {
				if (($comment_data['feedbackvote'] !== 0 && $comment_data['feedback_vote'] != 1)) {
					return true;
				} else { 
					return false;
				}
			} else {
				return false;
			}
		}
		return false;
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
		)
		{
			// Display comments
			return elgg_view_comments($entity);
		}
		
	}
?>