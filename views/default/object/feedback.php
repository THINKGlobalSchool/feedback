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

	if ($vars['full']) {
		set_input("full", true);
	}
	
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
	if (isadminloggedin()) {
		$controls .= elgg_view("output/confirmlink",array('onclick' => 'return false;', 'href' => $vars['url'] . 'action/feedback/delete?guid=' . $vars['entity']->guid, 'text' => elgg_echo('delete'), 'confirm' => elgg_echo('deleteconfirm'),));
		$status_content = elgg_view('feedback/forms/setstatus', $vars);
	}
	
	$comment_count = elgg_count_comments($vars['entity']);

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
		<div id='feedback_icon'>$icon</div>
		<p class="entity_title" style='margin-bottom:2px;'><a href='{$vars[url]}pg/feedback/view/{$vars[entity]->getGUID()}/'>{$vars[entity]->title}</a></p>
		<p class="entity_subtext">
			$strapline<br />
			$comment_info
		</p>
		<div style='clear:both;'></div>
		<div class='feedback_metadata'>
			<div class='feedback_status'>
				<div style='float: left; padding-right: 5px;'><b>$status_label: </b></div>
				<div style='float: le	ft;'>$status_content</div>
			</div>
			<div class='feedback_mood'>
				<b>$mood_label:</b>
				&nbsp;$mood_content
			</div>
			<div class='feedback_about'>
				<b>$about_label:</b>
				&nbsp;$about_content
			</div>
			<div class='feedback_controls'>
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
?>
