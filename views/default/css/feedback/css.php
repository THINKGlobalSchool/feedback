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
/** <style> /**/
/** iPhone/iPad Rules **/
@media all and (device-width: 768px) and (device-height: 1024px) and (orientation:portrait) {
  a.elgg-feedback { display: none !important; } /* css rules for ipad portrait */
}
@media all and (device-width: 768px) and (device-height: 1024px) and (orientation:landscape) {
  a.elgg-feedback { display: none !important; } /* css rules for ipad landscape */
}
@media all and (max-device-width: 480px) and (orientation:portrait) {
  a.elgg-feedback { display: none !important; } /* css rules for ipad portrait */
}
@media all and (max-device-width: 480px) and (orientation:landscape) {
  a.elgg-feedback { display: none !important; } /* css rules for ipad landscape */
}


a.elgg-feedback {
	position: fixed;
	top: 175px;
	left: 0px;
	z-index:1;
	height: 117px;
	width: 34px;
	background-position: -34px 0px;
	background-color: #424242;
	box-shadow: 0px 0px 6px #333333;
	display: none;
}

a.elgg-feedback.elgg-state-active {

}

a.elgg-feedback span {
	position: relative;
	text-transform: uppercase;
	top: 65%;
	display: block;
	color: #FFFFFF;
	-webkit-transform: rotate(-90deg);
	-moz-transform: rotate(-90deg);
	-ms-transform: rotate(-90deg);
	-o-transform: rotate(-90deg);
	transform: rotate(-90deg);

	/* also accepts left, right, top, bottom coordinates; not required, but a good idea for styling */
	-webkit-transform-origin: 50% 50%;
	-moz-transform-origin: 50% 50%;
	-ms-transform-origin: 50% 50%;
	-o-transform-origin: 50% 50%;
	transform-origin: 50% 50%;

	/* Should be unset in IE9+ I think. */
	filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
}

#elgg-feedback-wrapper {
	width: 400px;
	position: fixed;
	/* Required for jquery bug http://bugs.jquery.com/ticket/8316 */
	top: 125px;
	left: -1000px;
}

#elgg-feedback-wrapper h3 > span {
	float: right;
	font-size: 0.8em;
}

#elgg-feedback-wrapper textarea {
	height: 75px;
}

#elgg-feedback-wrapper .elgg-ajax-loader {
	display: block;
	vertical-align: middle;
	height: 100%;
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
