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

// Determine if we're hiding the feedback button from the 'public' (only logged in users)
//$hide_from_public = (elgg_get_plugin_setting('disablepublic', 'feedback') === 1);
if (!elgg_is_logged_in()) {
	return true;
}

// no support yet for admin area.
if (elgg_in_context('admin')) {
	return true;
}

// the side link
$feedback = elgg_echo('feedback') . "&nbsp;&#x25BC;";
$link = elgg_view('output/url', array(
	'href' => '#elgg-feedback-wrapper',
	'text' => "<span>$feedback</span>",
	'rel' => 'popup',
	'class' => 'elgg-feedback'
));

echo $link;

// the actual form
$all_feedback = elgg_view('output/url', array(
	'href' => 'feedback/all',
	'text' => elgg_echo('feedback:title:allfeedback')
));

$title = elgg_echo('feedback:title') . "<span class=\"right small\">$all_feedback</span>";
$body = elgg_view_form('feedback/add');
$options = array(
	'id' => 'elgg-feedback-wrapper',
	'class' => 'hidden'
);

echo elgg_view_module('popup', $title, $body, $options);