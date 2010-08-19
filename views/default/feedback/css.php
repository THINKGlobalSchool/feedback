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

a#feedBackTogglerLink {
	background-image:url(<?php echo $vars['url']; ?>mod/feedback/_graphics/feedback_sprite.png);
	height: 117px;
	width: 34px;
}

.closed {
	background-position: -34px 0px;

}

.open {
	background-position: 0px 0px;
}

#feedbackWrapper {
	position: fixed;
	top: 213px;
	left: 0px;
	width: 450px;
	z-index:1; 
}

#feedBackToggler {
	float: left;
}

#feedBackContent {
	width: 400px;
	display: none;
	overflow: hidden;
	float: left;
	border: solid #ccc 1px;
	background-color: #ffffe0;
	/*margin-left: 28px;*/
	position: absolute;
	left: 25px;
	z-index: 1;
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

#feedback_comment {
	-moz-border-radius:6px 6px 6px 6px;
	-webkit-border-radius: 6px 6px 6px 6px;
	width: 590px; 
	border:1px solid lightgrey;
	padding: 10px;
	margin-top:4px;
}

#feedback_comments_parent {
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


#feedback_icon {
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

.feedback_status {
	float:left;
	width:30%;
	font-size:90%;
}

.feedback_status form {
	display: inline;
}

.feedback_mood {
	float:left;
	width:25%;
	font-size:90%;
}

.feedback_about {
	float:left;
	width:20%;
	font-size:90%;
}

.feedback_controls {
	float:left;
	width:20%;
	text-align:right;
}

.feedback_metadata {
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
	background: url(<?php echo $vars['url']; ?>mod/feedback/images/feedback_river.gif) no-repeat left -1px;
}

.river_object_feedback_update {
	background: url(<?php echo $vars['url']; ?>mod/feedback/images/feedback_river.gif) no-repeat left -1px;
}
.river_object_feedback_comment {
	background: url(<?php echo $vars['url']; ?>mod/feedback/images/feedback_river.gif) no-repeat left -1px;
}

