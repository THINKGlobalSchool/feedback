<?php
/**
 * Feedback English strings
 * 
 * @package Feedback
 */

return array(

	'item:object:feedback' => 'Feedback',
	'feedback:label' => 'Feedback',
	'feedback:title' => 'Feedback',
	'feedback:title:owner' => '%s\'s feedback',
	'feedback:title:friends' => '%s\'s friends\' feedback',

	'feedback:message' => 'Love it? Hate it? Want to suggest new features or report a bug? We would love to hear from you.',
	'feedback:search_note' => 'Note: Feedback is viewable by all logged in users. Before posting, take a look at the '
		. '<a href="%s">feedback</a> that has already been posted to prevent duplicate issues/suggestions.',
	
	'feedback:default:id' => 'Name and/or Email',
	'feedback:default:txt' => 'Let us know what you think!',
	'feedback:default:txt:err' => 'No feedback message has been provided.\nWe value your suggestions and criticisms.\nPlease enter your message and press Send.',
	'feedback:default:title' => 'Title',
	'feedback:default:title:err' => 'No title has been provided, please enter a title for your feedback.',

	'feedback:captcha:blank' => 'No captcha input provided',
	
	'feedback:submit_msg' => 'Submitting...',
	
	'feedback:submit:error' => 'Could not submit feedback!',
	'feedback:error:status' => 'There was an error updating the status',
	'feedback:submit:success' => 'Feedback submitted successfully. Thank you!',
	'feedback:edit:success' => 'Feedback successfully edited',
	
	'feedback:admin:menu' => 'Feedback',
	'feedback:admin:title' => 'All Site Feedback',
	
	'feedback:title:yourfeedback' => "Your Feedback",
	'feedback:title:allfeedback' => 'All Site Feedback',
	
	'feedback:title:mine' => 'My Feedback',
	'feedback:title:all' => 'All Feedback',
	
	'feedback:update:submit' => 'Submit',
	'feedback:update:confirm' => 'Are you sure you want to update?',
	'feedback:update:like' => "Feelin' It",
	'feedback:update:dislike' => "Not Feelin' It",
	'feedback:update:success' => 'Feedback was updated successfully',
	'feedback:update:failure' => 'There was an error updating the feedback',
			
	'feedback:delete:success' => 'Feedback was deleted successfully',
	'feedback:delete:fail' => 'Could not delete feedback',
	
	'feedback:mood:' => 'None',
	'feedback:mood:angry' => 'Angry',
	'feedback:mood:neutral' => 'Neutral',
	'feedback:mood:happy' => 'Happy',

	'feedback:status' => 'Status',
	'feedback:status:any' => 'Any',
	'feedback:status:submitted' => 'Submitted',
	'feedback:status:acknowledged' => 'Acknowledged',
	'feedback:status:resolvedaction' => 'Resolved with Action',
	'feedback:status:resolvednoaction' => 'Resolved without Action',
	'feedback:status:resolved' => 'Resolved',		
	'feedback:status:in_progress'	=>	'In Progress',
	'feedback:status:duplicate' =>	'Duplicate',

	'feedback:comments'	=> 'Comments',
	'feedback:comments:new' => 'New Comment',

	'feedback:about:' => 'None',
	'feedback:about:bug_report' => 'Bug Report',
	'feedback:about:content' => 'Content',
	'feedback:about:suggestions' => 'Suggestions',
	'feedback:about:compliment' => 'Compliment',
	'feedback:about:other' => 'Other',
	
	'feedback:list:mood' => 'Mood',
	'feedback:list:about' => 'About',
	'feedback:list:page' => 'Submit Page',
	'feedback:list:from' => 'From',
	'feedback:list:title' => 'Title', 
	
	'feedback:email:subject' => 'Received feedback from %s',
	'feedback:email:body' => '%s',
	'feedback:email:updatedsubject' => "Your feedback has been updated!",
	'feedback:email:updatedbody' => 'Your feedback has been updated, check out your feedback here: %s',
	
	'river:create:object:feedback' => '%s added feedback titled %s',
	'river:update:object:feedback' => '%s updated feedback titled %s',

	'river:commented:object:feedback' => 'feedback',
	
	'river:comment:object:feedback' => '%s commented on the feedback %s',
	
	/* Spiced up text for the river */
	// @todo I don't think this shows up anywhere now.
	'feedback:river:comment:like' => "%s is feelin' the feedback titled %s",
	'feedback:river:comment:dislike' => "%s is not feelin' the feedback titled %s",
	'feedback:river:comment' => "%s posted a comment on feedback titled %s",
	
	'feedback:viewtitle' => 'View Feedback',
	
	'feedback:noresults' => 'No Results', 
	
	'feedback:strapline' => 'From %s %s',
	
	'feedback:settings:disablepublic' => 'Visible to only logged in users', 
	'feedback:settings:riverdisplay' => 'Show new feedback and updates on river',
	'feedback:settings:admin_users' => 'Usernames listed here will be able to change the status of or delete feedback.',
);