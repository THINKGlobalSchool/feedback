<?php
/**
 * Feedback created river view
 * 
 * @package Feedback
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

$performed_by = get_entity($vars['item']->subject_guid); 
$object = get_entity($vars['item']->object_guid);
$url = $object->getURL();

$url = "<a href=\"{$performed_by->getURL()}\">{$performed_by->name}</a>";
$contents = strip_tags($object->txt); //strip tags from the contents to stop large images etc blowing out the river view
$contents = elgg_view('output/longtext', array('value' => $contents));
$string = sprintf(elgg_echo("feedback:river:created"),$url) . " ";
$string .= elgg_echo("feedback:river:create") . " <a href=\"" . $object->getURL() . "\">" . $object->title  .  "</a>";
$string .= "<div class=\"river_content_display\">";


if(strlen($contents) > 200) {
       	$string .= substr($contents, 0, strpos($contents, ' ', 200)) . "...";
   }else{
    $string .= $contents;
   }
$string .= "</div>";
$string .= " <span class='entity_subtext'>" . friendly_time($object->time_created);
if (isloggedin()){
	$string .= "<a class='river_comment_form_button link'>Comment</a>";
	$string .= elgg_view('likes/forms/link', array('entity' => $object));
}
$string .= "</span>";
echo $string;
