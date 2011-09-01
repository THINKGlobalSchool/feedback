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

?>

a.elgg-feedback {
	position: fixed;
	top: 175px;
	left: 0px;
	z-index:1;
	background-image: url(<?php echo $vars['url']; ?>mod/feedback/graphics/feedback_sprite.png);
	height: 117px;
	width: 34px;
	background-position: -34px 0px;
}

a.elgg-feedback.elgg-state-active {
	background-position: 0px 0px;
}

a.elgg-feedback span {
	display: none;
}

.elgg-feedback-wrapper {
	width: 400px;
	position: fixed;
	/* Required for jquery bug http://bugs.jquery.com/ticket/8316 */
	top: 125px;
	left: -1000px;
}

.elgg-feedback-wrapper textarea {
	height: 75px;
}

.elgg-feedback-wrapper .elgg-ajax-loader {
	display: block;
	vertical-align: middle;
	height: 100%;
}

.elgg-feedback-entity-wrapper .elgg-toggler:after{
	content: '↓';
}

.elgg-feedback-entity-wrapper .elgg-state-active:after{
	content: '↑';
}

.elgg-menu-feedback-admin {
	border: 1px solid #ccc;
	background: #eee;
	border-radius: 4px;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	padding: 5px;
}

.elgg-menu-feedback-admin li {
	display: inline;
	margin-right: 90px;
}

.elgg-feedback-wrapper-old {
	width: 400px;
	overflow: hidden;
	position: absolute;
	left: -1000;
	float: left;
	border: solid #ccc 1px;
	background-color: #eeeeee;
	box-shadow: 5px 5px 13px #333;
	-moz-box-shadow: 5px 5px 13px #333;
	-webkit-box-shadow: 5px 5px 13px #333;
}

.open {
	background-position: 0px 0px;
}

#feedBackToggler {
	float: left;
}


#feedbackError {
	color: #ff0000;
}

#feedbackSuccess {
	color: #00bb00;
	font-weight: bold;
}

.feedbackLabel {
}

.feedbackText {
	width:350px;  
}

.feedbackTextbox {
	width:350px;  
	height:75px;
}
 
.captcha {
	padding:10px;
}
.captcha-left {
	float:left;
	border:1px solid #0000ff;
}
.captcha-middle {
	float:left;
}
.captcha-right {
	float:left;
}
.captcha-input-text {
	width:100px;
}

form#updatestatus {
	display: inline;
}

#feedback-comment {
	-moz-border-radius:6px 6px 6px 6px;
	-webkit-border-radius: 6px 6px 6px 6px;
	width: 590px; 
	border:1px solid lightgrey;
	padding: 10px;
	margin-top:4px;
}

#feedback-comments-parent {
	width: 100% !important;
}

table.mceLayout {
	width: 100% !important;
}

#feedbackvote {
	display: block; 
	height: 35px;'>
}

#feedbackvote img {
	vertical-align: middle;
}

#feedbackvote span {
	font-weight: bold;
}


#feedback-icon {
	float: left; 
	padding-right: 10px;
}

#feedbackinfo {
	border-bottom:1px dotted #CCCCCC;
	padding-bottom: 4px;
	margin-top: 8px;
}

#feedbackinfo .listingstrapline {
	margin: 0 0 0 0px;
	padding:0;
	color: #aaa;
	line-height:1em;
	
}

.feedback-status {
	float:left;
	width:30%;
	font-size:90%;
}

.feedback-status form {
	display: inline;
}

.feedback-mood {
	float:left;
	width:25%;
	font-size:90%;
}

.feedback-about {
	float:left;
	width:20%;
	font-size:90%;
}

.feedback-controls {
	float:left;
	width:20%;
	text-align:right;
}

.feedback-metadata {
	padding:5px;
	height: 16px;
	background: #EEEEEE;
	border: 1px solid #D4DAE6;
	margin: 0 0 0 0px;
	-moz-border-radius:5px 5px 5px 5px;
	-webkit-border-radius: 5px 5px 5px 5px;
}

/* River */
.river_object_feedback_create {
	background: url(<?php echo $vars['url']; ?>mod/feedback/graphics/feedback_river.gif) no-repeat left -1px;
}

.river_object_feedback_update {
	background: url(<?php echo $vars['url']; ?>mod/feedback/graphics/feedback_river.gif) no-repeat left -1px;
}
.river_object_feedback_comment {
	background: url(<?php echo $vars['url']; ?>mod/feedback/graphics/feedback_river.gif) no-repeat left -1px;
}

